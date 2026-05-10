<?php

declare(strict_types=1);

use Maispace\MaiBase\TableConfigurationArray\FieldConfig\CheckboxConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\DatetimeConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\InputConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\NumberConfig;
use Maispace\MaiBase\TableConfigurationArray\FieldConfig\TextConfig;
use Maispace\MaiBase\TableConfigurationArray\Helper;
use Maispace\MaiBase\TableConfigurationArray\Table;

$lang = Helper::localLangHelperFactory('mai_canteen', 'Default/locallang_tca.xlf');

return (new Table($lang('table.tx_maicanteen_menuplan')))
    ->setSearchFields('title,notes')
    ->setDefaultConfig()
    ->setLabel('title')
    ->setIconFile('EXT:mai_canteen/Resources/Public/Icons/tx_maicanteen_menuplan.svg')
    ->setDefaultSorting('ORDER BY week_start ASC')
    ->addColumn(
        'title',
        $lang('tx_maicanteen_menuplan.title'),
        (new InputConfig())->setSize(50)->setMax(255)->setEval('trim')->setRequired()
    )
    ->addColumn(
        'week_start',
        $lang('tx_maicanteen_menuplan.week_start'),
        (new DatetimeConfig())->setFormat('date')->setRequired()
    )
    ->addColumn(
        'week_end',
        $lang('tx_maicanteen_menuplan.week_end'),
        (new DatetimeConfig())->setFormat('date')
    )
    ->addColumn(
        'is_template',
        $lang('tx_maicanteen_menuplan.is_template'),
        (new CheckboxConfig())->setRenderType('checkboxToggle')
    )
    ->addColumn(
        'template_week',
        $lang('tx_maicanteen_menuplan.template_week'),
        (new NumberConfig())->setRange(0, 53)
    )
    ->addColumn(
        'notes',
        $lang('tx_maicanteen_menuplan.notes'),
        (new TextConfig())->setRows(5)->setCols(50)
    )
    ->addColumn(
        'dishes',
        $lang('tx_maicanteen_menuplan.dishes'),
        [
            'type' => 'inline',
            'foreign_table' => 'tx_maicanteen_dish',
            'foreign_field' => 'menu_plan',
            'foreign_sortby' => 'day_of_week',
            'maxitems' => 50,
            'appearance' => [
                'collapseAll' => false,
                'expandSingle' => true,
                'newRecordLinkAddTitle' => true,
                'enabledControls' => [
                    'dragdrop' => true,
                ],
            ],
        ]
    )
    ->addPalette(
        'week',
        $lang('palette.week'),
        'week_start, week_end'
    )
    ->addPalette(
        'template',
        $lang('palette.template'),
        'is_template, template_week'
    )
    ->addTypeShowItem(
        '0',
        'title, --palette--;;week, notes, dishes,
        --div--;' . $lang('tab.template') . ', --palette--;;template,
        --div--;' . $lang('tab.language') . ', --palette--;;language,
        --div--;' . $lang('tab.access') . ', --palette--;;hidden, --palette--;;access'
    )
    ->getConfig();
