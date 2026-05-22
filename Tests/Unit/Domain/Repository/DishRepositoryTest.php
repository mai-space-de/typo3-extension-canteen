<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Tests\Unit\Domain\Repository;

use Maispace\MaiCanteen\Domain\Repository\DishRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

final class DishRepositoryTest extends TestCase
{
    #[Test]
    public function extendsExtbaseRepository(): void
    {
        self::assertInstanceOf(Repository::class, $this->buildRepository());
    }

    #[Test]
    public function defaultOrderingsSortsByDayOfWeekAscending(): void
    {
        $repo = $this->buildRepository();
        $orderings = $this->readDefaultOrderings($repo);
        self::assertArrayHasKey('dayOfWeek', $orderings);
        self::assertSame(QueryInterface::ORDER_ASCENDING, $orderings['dayOfWeek']);
    }

    #[Test]
    public function defaultOrderingsSortsBySortOrderAscendingAsSecondKey(): void
    {
        $repo = $this->buildRepository();
        $orderings = $this->readDefaultOrderings($repo);
        self::assertArrayHasKey('sortOrder', $orderings);
        self::assertSame(QueryInterface::ORDER_ASCENDING, $orderings['sortOrder']);
    }

    #[Test]
    public function defaultOrderingsHasExactlyTwoSortKeys(): void
    {
        $repo = $this->buildRepository();
        self::assertCount(2, $this->readDefaultOrderings($repo));
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function buildRepository(): DishRepository
    {
        return new DishRepository();
    }

    /**
     * @return array<non-empty-string, 'ASC'|'DESC'>
     */
    private function readDefaultOrderings(DishRepository $repo): array
    {
        $prop = new \ReflectionProperty(DishRepository::class, 'defaultOrderings');
        /** @var array<non-empty-string, 'ASC'|'DESC'> $orderings */
        $orderings = $prop->getValue($repo);

        return $orderings;
    }
}
