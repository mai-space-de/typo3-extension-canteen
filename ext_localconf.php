<?php

declare(strict_types=1);

defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'MaiCanteen',
    'Week',
    [
        \Maispace\MaiCanteen\Controller\MenuPlanController::class => 'week',
    ],
    [],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'MaiCanteen',
    'Print',
    [
        \Maispace\MaiCanteen\Controller\MenuPlanController::class => 'print',
    ],
    [],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);
