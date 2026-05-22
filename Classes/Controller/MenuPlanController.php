<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Controller;

use Maispace\MaiBase\Controller\AbstractActionController;
use Maispace\MaiBase\Controller\Traits\AppendDataToPluginVariablesTrait;
use Maispace\MaiBase\Controller\Traits\PageRendererTrait;
use Maispace\MaiCanteen\Domain\Repository\MenuPlanRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Page\PageRenderer;

class MenuPlanController extends AbstractActionController
{
    use AppendDataToPluginVariablesTrait;
    use PageRendererTrait;

    public function __construct(
        private readonly MenuPlanRepository $menuPlanRepository,
    ) {}

    public function injectPageRenderer(PageRenderer $pageRenderer): void
    {
        $this->pageRenderer = $pageRenderer;
    }

    public function injectAssetCollector(AssetCollector $assetCollector): void
    {
        $this->assetCollector = $assetCollector;
    }

    public function weekAction(int $offset = 0): ResponseInterface
    {
        $settings = $this->getSettings();
        $pageUids = $this->resolveStoragePageUids();

        $monday = new \DateTimeImmutable('monday this week');
        if ($offset !== 0) {
            $monday = $monday->modify(sprintf('%+d weeks', $offset));
        }

        $menuPlan = $this->menuPlanRepository->findByWeekStart($monday);

        if ($menuPlan === null && ($settings['showTemplate'] ?? false)) {
            $weekNumber = (int) $monday->format('W');
            $templates = $this->menuPlanRepository->findTemplates()->toArray();
            foreach ($templates as $template) {
                if ($template->getTemplateWeek() === $weekNumber) {
                    $menuPlan = $template;
                    break;
                }
            }
        }

        $upcomingPlans = $this->menuPlanRepository->findCurrentAndUpcoming(
            (int) ($settings['upcomingLimit'] ?? 4),
        );

        $this->addJsFile(
            'mai_canteen',
            'EXT:mai_canteen/Resources/Public/JavaScript/canteen.js',
        );

        $this->view->assignMultiple([
            'menuPlan' => $menuPlan,
            'currentMonday' => $monday,
            'offset' => $offset,
            'upcomingPlans' => $upcomingPlans,
            'settings' => $settings,
            'weekDays' => $this->buildWeekDays($monday),
        ]);

        return $this->htmlResponse();
    }

    public function printAction(int $offset = 0): ResponseInterface
    {
        $monday = new \DateTimeImmutable('monday this week');
        if ($offset !== 0) {
            $monday = $monday->modify(sprintf('%+d weeks', $offset));
        }

        $menuPlan = $this->menuPlanRepository->findByWeekStart($monday);

        $this->view->assignMultiple([
            'menuPlan' => $menuPlan,
            'currentMonday' => $monday,
            'weekDays' => $this->buildWeekDays($monday),
        ]);

        return $this->htmlResponse();
    }

    private function resolveStoragePageUids(): array
    {
        $pages = $this->settings['pages'] ?? '';
        if (empty($pages)) {
            return [];
        }

        return array_filter(
            array_map('intval', explode(',', (string) $pages)),
            static fn(int $uid): bool => $uid > 0,
        );
    }

    private function buildWeekDays(\DateTimeImmutable $monday): array
    {
        $days = [];
        for ($i = 0; $i < 5; $i++) {
            $day = $monday->modify(sprintf('+%d days', $i));
            $days[$i + 1] = [
                'date' => $day,
                'dayNumber' => $i + 1,
                'isToday' => $day->format('Y-m-d') === (new \DateTimeImmutable())->format('Y-m-d'),
            ];
        }

        return $days;
    }
}
