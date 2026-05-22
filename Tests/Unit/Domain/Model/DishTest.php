<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Tests\Unit\Domain\Model;

use Maispace\MaiCanteen\Domain\Model\Dish;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class DishTest extends TestCase
{
    // -------------------------------------------------------------------------
    // Default values
    // -------------------------------------------------------------------------

    #[Test]
    public function defaultMenuPlanIsZero(): void
    {
        self::assertSame(0, (new Dish())->getMenuPlan());
    }

    #[Test]
    public function defaultDayOfWeekIsOne(): void
    {
        self::assertSame(1, (new Dish())->getDayOfWeek());
    }

    #[Test]
    public function defaultSortOrderIsZero(): void
    {
        self::assertSame(0, (new Dish())->getSortOrder());
    }

    #[Test]
    public function defaultTitleIsEmpty(): void
    {
        self::assertSame('', (new Dish())->getTitle());
    }

    #[Test]
    public function defaultDescriptionIsEmpty(): void
    {
        self::assertSame('', (new Dish())->getDescription());
    }

    #[Test]
    public function defaultPriceIsEmpty(): void
    {
        self::assertSame('', (new Dish())->getPrice());
    }

    #[Test]
    public function defaultAllergensIsEmpty(): void
    {
        self::assertSame('', (new Dish())->getAllergens());
    }

    #[Test]
    public function defaultAdditivesIsEmpty(): void
    {
        self::assertSame('', (new Dish())->getAdditives());
    }

    #[Test]
    public function defaultIsVegetarianIsFalse(): void
    {
        self::assertFalse((new Dish())->isIsVegetarian());
    }

    #[Test]
    public function defaultIsVeganIsFalse(): void
    {
        self::assertFalse((new Dish())->isIsVegan());
    }

    #[Test]
    public function defaultIsGlutenFreeIsFalse(): void
    {
        self::assertFalse((new Dish())->isIsGlutenFree());
    }

    // -------------------------------------------------------------------------
    // Getter / setter round-trips
    // -------------------------------------------------------------------------

    #[Test]
    public function menuPlanSetGet(): void
    {
        $dish = new Dish();
        $dish->setMenuPlan(42);
        self::assertSame(42, $dish->getMenuPlan());
    }

    #[Test]
    public function dayOfWeekSetGet(): void
    {
        $dish = new Dish();
        $dish->setDayOfWeek(3);
        self::assertSame(3, $dish->getDayOfWeek());
    }

    #[Test]
    public function sortOrderSetGet(): void
    {
        $dish = new Dish();
        $dish->setSortOrder(5);
        self::assertSame(5, $dish->getSortOrder());
    }

    #[Test]
    public function titleSetGet(): void
    {
        $dish = new Dish();
        $dish->setTitle('Spaghetti Bolognese');
        self::assertSame('Spaghetti Bolognese', $dish->getTitle());
    }

    #[Test]
    public function descriptionSetGet(): void
    {
        $dish = new Dish();
        $dish->setDescription('Classic Italian pasta dish.');
        self::assertSame('Classic Italian pasta dish.', $dish->getDescription());
    }

    #[Test]
    public function priceSetGet(): void
    {
        $dish = new Dish();
        $dish->setPrice('4,50 €');
        self::assertSame('4,50 €', $dish->getPrice());
    }

    #[Test]
    public function allergensSetGet(): void
    {
        $dish = new Dish();
        $dish->setAllergens('A, C, G');
        self::assertSame('A, C, G', $dish->getAllergens());
    }

    #[Test]
    public function additivesSetGet(): void
    {
        $dish = new Dish();
        $dish->setAdditives('1, 2');
        self::assertSame('1, 2', $dish->getAdditives());
    }

    #[Test]
    public function isVegetarianSetGet(): void
    {
        $dish = new Dish();
        $dish->setIsVegetarian(true);
        self::assertTrue($dish->isIsVegetarian());
    }

    #[Test]
    public function isVeganSetGet(): void
    {
        $dish = new Dish();
        $dish->setIsVegan(true);
        self::assertTrue($dish->isIsVegan());
    }

    #[Test]
    public function isGlutenFreeSetGet(): void
    {
        $dish = new Dish();
        $dish->setIsGlutenFree(true);
        self::assertTrue($dish->isIsGlutenFree());
    }

    // -------------------------------------------------------------------------
    // getAllergenList()
    // -------------------------------------------------------------------------

    #[Test]
    public function allergenListReturnsEmptyArrayWhenNoAllergens(): void
    {
        self::assertSame([], (new Dish())->getAllergenList());
    }

    #[Test]
    public function allergenListSplitsCommaSeparatedCodes(): void
    {
        $dish = new Dish();
        $dish->setAllergens('A,C,G');
        self::assertSame(['A', 'C', 'G'], array_values($dish->getAllergenList()));
    }

    #[Test]
    public function allergenListTrimsWhitespace(): void
    {
        $dish = new Dish();
        $dish->setAllergens('A, C , G');
        self::assertSame(['A', 'C', 'G'], array_values($dish->getAllergenList()));
    }

    #[Test]
    public function allergenListFiltersEmptyEntries(): void
    {
        $dish = new Dish();
        $dish->setAllergens('A,,C');
        // array_filter removes the empty string produced by splitting ',,'
        $result = array_values($dish->getAllergenList());
        self::assertSame(['A', 'C'], $result);
    }

    // -------------------------------------------------------------------------
    // getAdditiveList()
    // -------------------------------------------------------------------------

    #[Test]
    public function additiveListReturnsEmptyArrayWhenNoAdditives(): void
    {
        self::assertSame([], (new Dish())->getAdditiveList());
    }

    #[Test]
    public function additiveListSplitsCommaSeparatedCodes(): void
    {
        $dish = new Dish();
        $dish->setAdditives('1,2,3');
        self::assertSame(['1', '2', '3'], array_values($dish->getAdditiveList()));
    }

    #[Test]
    public function additiveListTrimsWhitespace(): void
    {
        $dish = new Dish();
        $dish->setAdditives('1, 2 , 3');
        self::assertSame(['1', '2', '3'], array_values($dish->getAdditiveList()));
    }

    // -------------------------------------------------------------------------
    // Independent instance isolation
    // -------------------------------------------------------------------------

    #[Test]
    public function instancesAreIndependent(): void
    {
        $a = new Dish();
        $b = new Dish();
        $a->setTitle('Soup');
        $b->setTitle('Salad');
        self::assertSame('Soup', $a->getTitle());
        self::assertSame('Salad', $b->getTitle());
    }
}
