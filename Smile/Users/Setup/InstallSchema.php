<?php

namespace Smile\Users\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface {

    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable('log')
        )->addColumn(
            'user_id',
            Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'User ID'
        )->addColumn(
            'firstname',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'User Firstname'
        )->addColumn(
            'lastname',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'User Lastname'
        )->addColumn(
            'email',
            Table::TYPE_TEXT,
            '255',
            ['nullable' => true],
            'User Email'
        )->addColumn(
            'password',
            Table::TYPE_TEXT,
            '255',
            ['nullable' => true],
            'User Password'
        )->addIndex(
            $setup->getIdxName(
                $installer->getTable('user'),
                ['firstname', 'lastname', 'email', 'password'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['firstname', 'lastname', 'email', 'password'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'Log Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}