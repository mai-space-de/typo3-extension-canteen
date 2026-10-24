<?php

declare(strict_types=1);

$allIcons = 'EXT:mai_base/Resources/Public/Icons/all-icons/';

return [
    'ext-maispace-mai_canteen' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:mai_canteen/Resources/Public/Icons/Extension.svg',
    ],
    'mai-canteen' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => $allIcons . 'food-kitchenware-fork-spoon--fork-spoon-food-dine-cook-utensils-eat-restaurant-dining--Streamline-Core.svg',
    ],
    'mai-canteen-print' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => $allIcons . 'food-kitchenware-serving-dome--cook-tool-dome-kitchen-serving-paltter-dish-tools-food--Streamline-Core.svg',
    ],
    'mai-canteen-dish' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => $allIcons . 'food-kitchenware-serving-dome--cook-tool-dome-kitchen-serving-paltter-dish-tools-food--Streamline-Core.svg',
    ],
    'mai-canteen-menuplan' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => $allIcons . 'food-kitchenware-fork-spoon--fork-spoon-food-dine-cook-utensils-eat-restaurant-dining--Streamline-Core.svg',
    ],
];
