<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Domain\Model;

use Maispace\MaiCanteen\Utility\TagListNormalizer;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Dish extends AbstractEntity
{
    protected int $menuPlan = 0;

    protected int $dayOfWeek = 1;

    protected int $sortOrder = 0;

    protected string $title = '';

    protected string $description = '';

    protected string $price = '';

    #[Validate(['validator' => 'Maispace\MaiCanteen\Validation\Validator\AllergenCodeValidator'])]
    protected string $allergens = '';

    #[Validate(['validator' => 'Maispace\MaiCanteen\Validation\Validator\AdditiveCodeValidator'])]
    protected string $additives = '';

    protected bool $isVegetarian = false;

    protected bool $isVegan = false;

    protected bool $isGlutenFree = false;

    public function getMenuPlan(): int
    {
        return $this->menuPlan;
    }

    public function setMenuPlan(int $menuPlan): void
    {
        $this->menuPlan = $menuPlan;
    }

    public function getDayOfWeek(): int
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(int $dayOfWeek): void
    {
        $this->dayOfWeek = $dayOfWeek;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function getAllergens(): string
    {
        return $this->allergens;
    }

    public function setAllergens(string $allergens): void
    {
        $this->allergens = TagListNormalizer::toCanonicalString($allergens);
    }

    public function getAdditives(): string
    {
        return $this->additives;
    }

    public function setAdditives(string $additives): void
    {
        $this->additives = TagListNormalizer::toCanonicalString($additives);
    }

    public function isIsVegetarian(): bool
    {
        return $this->isVegetarian;
    }

    public function setIsVegetarian(bool $isVegetarian): void
    {
        $this->isVegetarian = $isVegetarian;
    }

    public function isIsVegan(): bool
    {
        return $this->isVegan;
    }

    public function setIsVegan(bool $isVegan): void
    {
        $this->isVegan = $isVegan;
    }

    public function isIsGlutenFree(): bool
    {
        return $this->isGlutenFree;
    }

    public function setIsGlutenFree(bool $isGlutenFree): void
    {
        $this->isGlutenFree = $isGlutenFree;
    }

    /**
     * @return list<string>
     */
    public function getAllergenList(): array
    {
        return TagListNormalizer::toList($this->allergens);
    }

    /**
     * @return list<string>
     */
    public function getAdditiveList(): array
    {
        return TagListNormalizer::toList($this->additives);
    }
}
