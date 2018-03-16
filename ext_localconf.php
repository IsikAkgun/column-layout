<?php

/*
 * This file is part of the package arndtteunissen/column-layout.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

call_user_func(function ($extKey) {
    // Mod Web>Page layout customizations
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawHeaderHook'][] = \Arndtteunissen\ColumnLayout\Hook\LayoutPreviewHook::class . '->injectStyleSheet';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawFooter'][] = \Arndtteunissen\ColumnLayout\Hook\LayoutPreviewHook::class;

    // Extend FormData processing for flexforms as quickfix
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][\Arndtteunissen\ColumnLayout\Form\FormDataProvider\SaveEffectivePidInDatabaseRow::class] = [
        'depends' => [
            \TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseEffectivePid::class,
            \TYPO3\CMS\Backend\Form\FormDataProvider\PageTsConfig::class
        ]
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][\TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowInitializeNew::class]['depends'][] = \Arndtteunissen\ColumnLayout\Form\FormDataProvider\SaveEffectivePidInDatabaseRow::class;
}, $_EXTKEY);
