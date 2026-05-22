<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Tests\Unit\Domain\Repository;

use Maispace\MaiCanteen\Domain\Repository\MenuPlanRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

final class MenuPlanRepositoryTest extends TestCase
{
    #[Test]
    public function extendsExtbaseRepository(): void
    {
        self::assertInstanceOf(Repository::class, $this->buildRepository());
    }

    #[Test]
    public function defaultOrderingsSortsByWeekStartAscending(): void
    {
        $repo = $this->buildRepository();
        $orderings = $this->readDefaultOrderings($repo);
        self::assertArrayHasKey('weekStart', $orderings);
        self::assertSame(QueryInterface::ORDER_ASCENDING, $orderings['weekStart']);
    }

    #[Test]
    public function defaultOrderingsHasExactlyOneSortKey(): void
    {
        $repo = $this->buildRepository();
        self::assertCount(1, $this->readDefaultOrderings($repo));
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function buildRepository(): MenuPlanRepository
    {
        return new MenuPlanRepository();
    }

    /**
     * @return array<non-empty-string, 'ASC'|'DESC'>
     */
    private function readDefaultOrderings(MenuPlanRepository $repo): array
    {
        $prop = new \ReflectionProperty(MenuPlanRepository::class, 'defaultOrderings');
        /** @var array<non-empty-string, 'ASC'|'DESC'> $orderings */
        $orderings = $prop->getValue($repo);

        return $orderings;
    }
}
