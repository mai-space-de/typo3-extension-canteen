<?php

declare(strict_types=1);

namespace Maispace\MaiCanteen\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class MenuPlan extends AbstractEntity
{
    protected string $title = '';

    protected ?\DateTimeImmutable $weekStart = null;

    protected ?\DateTimeImmutable $weekEnd = null;

    protected bool $isTemplate = false;

    protected int $templateWeek = 0;

    protected string $notes = '';

    /**
     * @var ObjectStorage<Dish>
     */
    protected ObjectStorage $dishes;

    public function __construct()
    {
        $this->dishes = new ObjectStorage();
    }

    public function initializeObject(): void
    {
        $this->dishes = new ObjectStorage();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getWeekStart(): ?\DateTimeImmutable
    {
        return $this->weekStart;
    }

    public function setWeekStart(?\DateTimeImmutable $weekStart): void
    {
        $this->weekStart = $weekStart;
    }

    public function getWeekEnd(): ?\DateTimeImmutable
    {
        return $this->weekEnd;
    }

    public function setWeekEnd(?\DateTimeImmutable $weekEnd): void
    {
        $this->weekEnd = $weekEnd;
    }

    public function isIsTemplate(): bool
    {
        return $this->isTemplate;
    }

    public function setIsTemplate(bool $isTemplate): void
    {
        $this->isTemplate = $isTemplate;
    }

    public function getTemplateWeek(): int
    {
        return $this->templateWeek;
    }

    public function setTemplateWeek(int $templateWeek): void
    {
        $this->templateWeek = $templateWeek;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    /**
     * @return ObjectStorage<Dish>
     */
    public function getDishes(): ObjectStorage
    {
        return $this->dishes;
    }

    /**
     * @param ObjectStorage<Dish> $dishes
     */
    public function setDishes(ObjectStorage $dishes): void
    {
        $this->dishes = $dishes;
    }

    /**
     * @return array<int, Dish[]>
     */
    public function getDishesByDay(): array
    {
        $byDay = [];
        foreach ($this->dishes as $dish) {
            $byDay[$dish->getDayOfWeek()][] = $dish;
        }

        ksort($byDay);

        return $byDay;
    }
}
