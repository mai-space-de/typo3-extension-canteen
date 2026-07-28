<?php

declare(strict_types=1);

defined('TYPO3') or die();

use Maispace\MaiBase\TableConfigurationArray\Helper;

$lang = Helper::localLangHelperFactory('mai_canteen', 'Default/locallang_tca.xlf');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'MaiCanteen',
    'Week',
    $lang('plugin.week.title'),
    'mai-content',
    'maispace_plugins_lists',
    '',
    'FILE:EXT:mai_canteen/Configuration/FlexForms/CanteenPlugin.xml',
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'MaiCanteen',
    'Print',
    $lang('plugin.print.title'),
    'mai-content',
    'maispace_plugins_lists',
    '',
    'FILE:EXT:mai_canteen/Configuration/FlexForms/CanteenPlugin.xml',
);
