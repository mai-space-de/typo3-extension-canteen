<?php

declare(strict_types=1);

defined('TYPO3') or die();

use Maispace\MaiBase\TableConfigurationArray\CType;
use Maispace\MaiBase\TableConfigurationArray\Helper;

$lang = Helper::localLangHelperFactory('mai_canteen', 'Default/locallang_tca.xlf');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'MaiCanteen',
    'Week',
    $lang('plugin.week.title'),
    'ext-maispace-mai_canteen',
    'maispace_feature',
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'MaiCanteen',
    'Print',
    $lang('plugin.print.title'),
    'ext-maispace-mai_canteen',
    'maispace_feature',
);

(new CType('maispace_canteen_week', $lang('ctype.canteen_week'), 'ext-maispace-mai_canteen'))
    ->addDefaultHeaderPalette()
    ->addCustomFields('pi_flexform')
    ->addDefaultLanguageTab()
    ->addDefaultAccessTab()
    ->setGroup('maispace_feature')
    ->register();

(new CType('maispace_canteen_print', $lang('ctype.canteen_print'), 'ext-maispace-mai_canteen'))
    ->addDefaultHeaderPalette()
    ->addCustomFields('pi_flexform')
    ->addDefaultLanguageTab()
    ->addDefaultAccessTab()
    ->setGroup('maispace_feature')
    ->register();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:mai_canteen/Configuration/FlexForms/CanteenPlugin.xml',
    'maispace_canteen_week',
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:mai_canteen/Configuration/FlexForms/CanteenPlugin.xml',
    'maispace_canteen_print',
);
