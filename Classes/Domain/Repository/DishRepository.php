<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class DishRepository extends Repository
{
    protected $defaultOrderings = [
        'dayOfWeek' => QueryInterface::ORDER_ASCENDING,
        'sortOrder' => QueryInterface::ORDER_ASCENDING,
    ];

    public function findByMenuPlanUid(int $menuPlanUid): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('menuPlan', $menuPlanUid),
        );

        return $query->execute();
    }
}
