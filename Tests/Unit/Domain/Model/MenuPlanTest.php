<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Tests\Unit\Domain\Model;

use Maispace\MaiCanteen\Domain\Model\Dish;
use Maispace\MaiCanteen\Domain\Model\MenuPlan;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

final class MenuPlanTest extends TestCase
{
    // -------------------------------------------------------------------------
    // Default values
    // -------------------------------------------------------------------------

    #[Test]
    public function defaultTitleIsEmpty(): void
    {
        self::assertSame('', (new MenuPlan())->getTitle());
    }

    #[Test]
    public function defaultWeekStartIsNull(): void
    {
        self::assertNull((new MenuPlan())->getWeekStart());
    }

    #[Test]
    public function defaultWeekEndIsNull(): void
    {
        self::assertNull((new MenuPlan())->getWeekEnd());
    }

    #[Test]
    public function defaultIsTemplateIsFalse(): void
    {
        self::assertFalse((new MenuPlan())->isIsTemplate());
    }

    #[Test]
    public function defaultTemplateWeekIsZero(): void
    {
        self::assertSame(0, (new MenuPlan())->getTemplateWeek());
    }

    #[Test]
    public function defaultNotesIsEmpty(): void
    {
        self::assertSame('', (new MenuPlan())->getNotes());
    }

    #[Test]
    public function constructorInitializesObjectStorage(): void
    {
        $plan = new MenuPlan();
        self::assertInstanceOf(ObjectStorage::class, $plan->getDishes());
    }

    #[Test]
    public function initializeObjectCreatesNewObjectStorage(): void
    {
        $plan = new MenuPlan();
        $originalStorage = $plan->getDishes();
        $plan->initializeObject();
        // A new storage is assigned on each call to initializeObject()
        self::assertInstanceOf(ObjectStorage::class, $plan->getDishes());
        self::assertNotSame($originalStorage, $plan->getDishes());
    }

    // -------------------------------------------------------------------------
    // Getter / setter round-trips
    // -------------------------------------------------------------------------

    #[Test]
    public function titleSetGet(): void
    {
        $plan = new MenuPlan();
        $plan->setTitle('Week 42 Menu');
        self::assertSame('Week 42 Menu', $plan->getTitle());
    }

    #[Test]
    public function weekStartSetGet(): void
    {
        $plan = new MenuPlan();
        $dt = new \DateTimeImmutable('2026-10-12');
        $plan->setWeekStart($dt);
        self::assertSame($dt, $plan->getWeekStart());
    }

    #[Test]
    public function weekStartAcceptsNull(): void
    {
        $plan = new MenuPlan();
        $plan->setWeekStart(new \DateTimeImmutable('2026-01-01'));
        $plan->setWeekStart(null);
        self::assertNull($plan->getWeekStart());
    }

    #[Test]
    public function weekEndSetGet(): void
    {
        $plan = new MenuPlan();
        $dt = new \DateTimeImmutable('2026-10-16');
        $plan->setWeekEnd($dt);
        self::assertSame($dt, $plan->getWeekEnd());
    }

    #[Test]
    public function weekEndAcceptsNull(): void
    {
        $plan = new MenuPlan();
        $plan->setWeekEnd(new \DateTimeImmutable('2026-01-07'));
        $plan->setWeekEnd(null);
        self::assertNull($plan->getWeekEnd());
    }

    #[Test]
    public function isTemplateSetGet(): void
    {
        $plan = new MenuPlan();
        $plan->setIsTemplate(true);
        self::assertTrue($plan->isIsTemplate());
    }

    #[Test]
    public function templateWeekSetGet(): void
    {
        $plan = new MenuPlan();
        $plan->setTemplateWeek(42);
        self::assertSame(42, $plan->getTemplateWeek());
    }

    #[Test]
    public function notesSetGet(): void
    {
        $plan = new MenuPlan();
        $plan->setNotes('Closed on Friday.');
        self::assertSame('Closed on Friday.', $plan->getNotes());
    }

    #[Test]
    public function dishesSetGet(): void
    {
        $plan = new MenuPlan();
        $storage = new ObjectStorage();
        $plan->setDishes($storage);
        self::assertSame($storage, $plan->getDishes());
    }

    // -------------------------------------------------------------------------
    // getDishesByDay()
    // -------------------------------------------------------------------------

    #[Test]
    public function dishesByDayReturnsEmptyArrayWhenNoDishes(): void
    {
        self::assertSame([], (new MenuPlan())->getDishesByDay());
    }

    #[Test]
    public function dishesByDayGroupsDishesCorrectly(): void
    {
        $plan = new MenuPlan();

        $monday = new Dish();
        $monday->setDayOfWeek(1);
        $monday->setTitle('Monday Dish');

        $wednesday = new Dish();
        $wednesday->setDayOfWeek(3);
        $wednesday->setTitle('Wednesday Dish');

        $monday2 = new Dish();
        $monday2->setDayOfWeek(1);
        $monday2->setTitle('Monday Dish 2');

        $storage = new ObjectStorage();
        $storage->attach($monday);
        $storage->attach($wednesday);
        $storage->attach($monday2);
        $plan->setDishes($storage);

        $byDay = $plan->getDishesByDay();

        self::assertArrayHasKey(1, $byDay);
        self::assertArrayHasKey(3, $byDay);
        self::assertCount(2, $byDay[1]);
        self::assertCount(1, $byDay[3]);
    }

    #[Test]
    public function dishesByDaySortsByDayOfWeek(): void
    {
        $plan = new MenuPlan();

        $friday = new Dish();
        $friday->setDayOfWeek(5);

        $monday = new Dish();
        $monday->setDayOfWeek(1);

        $wednesday = new Dish();
        $wednesday->setDayOfWeek(3);

        $storage = new ObjectStorage();
        $storage->attach($friday);
        $storage->attach($monday);
        $storage->attach($wednesday);
        $plan->setDishes($storage);

        $keys = array_keys($plan->getDishesByDay());
        self::assertSame([1, 3, 5], $keys);
    }

    #[Test]
    public function dishesByDayReturnsSingleDayWhenAllDishesOnSameDay(): void
    {
        $plan = new MenuPlan();

        $dish1 = new Dish();
        $dish1->setDayOfWeek(2);

        $dish2 = new Dish();
        $dish2->setDayOfWeek(2);

        $storage = new ObjectStorage();
        $storage->attach($dish1);
        $storage->attach($dish2);
        $plan->setDishes($storage);

        $byDay = $plan->getDishesByDay();
        self::assertCount(1, $byDay);
        self::assertArrayHasKey(2, $byDay);
        self::assertCount(2, $byDay[2]);
    }

    // -------------------------------------------------------------------------
    // Independent instance isolation
    // -------------------------------------------------------------------------

    #[Test]
    public function instancesAreIndependent(): void
    {
        $a = new MenuPlan();
        $b = new MenuPlan();
        $a->setTitle('Plan A');
        $b->setTitle('Plan B');
        self::assertSame('Plan A', $a->getTitle());
        self::assertSame('Plan B', $b->getTitle());
    }

    #[Test]
    public function dishStoragesAreIsolatedBetweenInstances(): void
    {
        $a = new MenuPlan();
        $b = new MenuPlan();

        $dish = new Dish();
        $dish->setTitle('Soup');

        $storageA = new ObjectStorage();
        $storageA->attach($dish);
        $a->setDishes($storageA);

        self::assertCount(1, $a->getDishes());
        self::assertCount(0, $b->getDishes());
    }
}
