<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Domain\Repository;

use Maispace\MaiCanteen\Domain\Model\MenuPlan;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class MenuPlanRepository extends Repository
{
    protected $defaultOrderings = [
        'weekStart' => QueryInterface::ORDER_ASCENDING,
    ];

    public function findByWeekStart(\DateTimeImmutable $weekStart): ?MenuPlan
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('weekStart', $weekStart->getTimestamp())
        );
        $query->setLimit(1);

        $result = $query->execute();

        return $result->getFirst();
    }

    public function findCurrentAndUpcoming(int $limit = 4): QueryResultInterface
    {
        $now = new \DateTimeImmutable('monday this week');
        $query = $this->createQuery();
        $query->matching(
            $query->greaterThanOrEqual('weekStart', $now->getTimestamp())
        );
        $query->setOrderings(['weekStart' => QueryInterface::ORDER_ASCENDING]);
        $query->setLimit($limit);

        return $query->execute();
    }

    public function findTemplates(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('isTemplate', true)
        );

        return $query->execute();
    }

    public function findFromPages(array $pageUids): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setStoragePageIds($pageUids);

        return $query->execute();
    }
}
