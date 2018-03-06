<?php
namespace Arndtteunissen\ColumnLayout\Hook;

/*
 * This file is part of the package arndtteunissen/column-layout.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Hook into the FlexForm processing to change the flexform data structure according to the current selected grid system.
 *
 * @see FlexFormTools
 */
class ColumnConfigurationGridsystemFlexFormHook implements SingletonInterface
{
    /**
     * Generates a DataStructureIdentifier for the flexform in column configuration field
     *
     * @param array $fieldTca
     * @param string $tableName
     * @param string $fieldName
     * @param array $row
     * @return array
     */
    public function getDataStructureIdentifierPreProcess(array $fieldTca, string $tableName, string $fieldName, array $row): array
    {
        if ($tableName != 'tt_content' || $fieldName != 'tx_column_layout_column_config') {
            return [];
        }

        return [
            'type' => 'tca',
            'tableName' => $tableName,
            'fieldName' => $fieldName,
            'dataStructureKey' => $fieldTca['forceDataStructureKey'] ?? $this->determineCurrentGridSystemKey()
        ];
    }

    /**
     * Returns the configured gridsystem from the extension configuration
     *
     * @return string gridsystem key
     */
    protected function determineCurrentGridSystemKey(): string
    {
        $conf = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['column_layout'];
        if (is_string($conf)) {
            $conf = unserialize($conf);
        }

        return $conf['gridsystem'];
    }
}