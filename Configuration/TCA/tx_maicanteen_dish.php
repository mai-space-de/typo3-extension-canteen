<?php

declare(strict_types=1);

use Maispace\MaiBase\TableConfigurationArray\FieldConfig\CheckboxConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\InputConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\SelectSingleConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\TextConfig;
use Maispace\MaiBase\TableConfigurationArray\Helper;
use Maispace\MaiBase\TableConfigurationArray\Table;

$lang = Helper::localLangHelperFactory('mai_canteen', 'Default/locallang_tca.xlf');

return (new Table($lang('table.tx_maicanteen_dish')))
    ->setSearchFields('title,description,allergens')
    ->setDefaultConfig()
    ->setLabel('title')
    ->setIconFile('EXT:mai_base/Resources/Public/Icons/generic_table.svg')
    ->setDefaultSorting('ORDER BY day_of_week ASC, sort_order ASC')
    ->addColumn(
        'menu_plan',
        $lang('tx_maicanteen_dish.menu_plan'),
        [
            'type' => 'passthrough',
        ]
    )
    ->addColumn(
        'day_of_week',
        $lang('tx_maicanteen_dish.day_of_week'),
        (new SelectSingleConfig())
            ->setItems([
                ['label' => $lang('tx_maicanteen_dish.day_of_week.1'), 'value' => 1],
                ['label' => $lang('tx_maicanteen_dish.day_of_week.2'), 'value' => 2],
                ['label' => $lang('tx_maicanteen_dish.day_of_week.3'), 'value' => 3],
                ['label' => $lang('tx_maicanteen_dish.day_of_week.4'), 'value' => 4],
                ['label' => $lang('tx_maicanteen_dish.day_of_week.5'), 'value' => 5],
            ])
            ->setDefault(1)
            ->setRequired()
    )
    ->addColumn(
        'title',
        $lang('tx_maicanteen_dish.title'),
        (new InputConfig())->setSize(50)->setMax(255)->setEval('trim')->setRequired()
    )
    ->addColumn(
        'description',
        $lang('tx_maicanteen_dish.description'),
        (new TextConfig())->setRows(4)->setCols(50)
    )
    ->addColumn(
        'price',
        $lang('tx_maicanteen_dish.price'),
        (new InputConfig())->setSize(10)->setMax(20)->setEval('trim')
    )
    ->addColumn(
        'allergens',
        $lang('tx_maicanteen_dish.allergens'),
        (new InputConfig())->setSize(50)->setMax(255)->setEval('trim')
    )
    ->addColumn(
        'additives',
        $lang('tx_maicanteen_dish.additives'),
        (new InputConfig())->setSize(50)->setMax(255)->setEval('trim')
    )
    ->addColumn(
        'is_vegetarian',
        $lang('tx_maicanteen_dish.is_vegetarian'),
        (new CheckboxConfig())->setRenderType('checkboxToggle')
    )
    ->addColumn(
        'is_vegan',
        $lang('tx_maicanteen_dish.is_vegan'),
        (new CheckboxConfig())->setRenderType('checkboxToggle')
    )
    ->addColumn(
        'is_gluten_free',
        $lang('tx_maicanteen_dish.is_gluten_free'),
        (new CheckboxConfig())->setRenderType('checkboxToggle')
    )
    ->addPalette(
        'dietary',
        $lang('palette.dietary'),
        'is_vegetarian, is_vegan, is_gluten_free'
    )
    ->addPalette(
        'labeling',
        $lang('palette.labeling'),
        'allergens, additives'
    )
    ->addTypeShowItem(
        '0',
        'day_of_week, title, description, price,
        --div--;' . $lang('tab.labeling') . ', --palette--;;dietary, --palette--;;labeling,
        --div--;' . $lang('tab.language') . ', --palette--;;language,
        --div--;' . $lang('tab.access') . ', --palette--;;hidden, --palette--;;access'
    )
    ->getConfig();
