<?php

namespace Smile\Blog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface {

    public function install( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'posts'
         */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('posts')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Post ID'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Post Title'
        )->addColumn(
            'image',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Image'
        )->addColumn(
            'description',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Post Description'
        )->addColumn(
            'content',
            Table::TYPE_TEXT,
            '64k',
            [],
            'Post Content'
        )->addColumn(
            'created',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Post Time Created'
        )->addColumn(
            'updated',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Post Time Updated'
        )->addIndex(
            $setup->getIdxName(
                $installer->getTable('posts'),
                ['title', 'image', 'description', 'content'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['title', 'image', 'description', 'content'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'Posts Table'
        );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'post_categories'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('post_categories')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Post Categories ID'
        )->addColumn(
            'post_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true],
            'Post ID'
        )->addColumn(
            'category_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true],
            'Category ID'

        )->addForeignKey(
            $installer->getFkName('post_categories', 'post_id', 'posts', 'id'),
            'post_id',
            $installer->getTable('posts'),
            'id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('post_categories', 'category_id', 'categories', 'id'),
            'category_id',
            $installer->getTable('categories'),
            'id',
            Table::ACTION_CASCADE
        )->setComment(
            'Post Categories'
        );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'categories'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('categories')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Category ID'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Category Title'
        )->addColumn(
            'image',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Category Image'
        )->addColumn(
            'description',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Category Description'
        )->addIndex(
            $installer->getIdxName('categories', ['id']),
            ['id']
        )->addIndex(
            $setup->getIdxName(
                $installer->getTable('categories'),
                ['title', 'image', 'description'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['title', 'image', 'description'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'Categories Table'
        );

        $installer->getConnection()->createTable($table);

        /**
         * Create table 'coments'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('coments')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Coment ID'
        )->addColumn(
            'post_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => true],
            'Post ID'
        )->addColumn(
            'user',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Coment Author'
        )->addColumn(
            'text',
            Table::TYPE_TEXT,
            '64k',
            ['nullable' => true],
            'Text'
        )->addColumn(
            'created',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Coment Time Created'
        )->addColumn(
            'updated',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Coment Time Updated'
        )->addIndex(
            $installer->getIdxName('coments', ['id']),
            ['id']
        )->addIndex(
            $setup->getIdxName(
                $installer->getTable('coments'),
                ['user', 'text'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['user', 'text'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->addForeignKey(
            $installer->getFkName('coments', 'post_id', 'posts', 'id'),
            'post_id',
            $installer->getTable('posts'),
            'id',
            Table::ACTION_CASCADE
        )->setComment(
            'Coments Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}