<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page}}`.
 */
class m250227_150603_create_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'meta_desc' => $this->text(),
            'meta_key' => $this->text(),
            'cannonical' => $this->text(),
            'headline' => $this->string(255)->notNull(),
            'breadcrumps' => $this->string(255)->notNull(),
            'menu_name' => $this->string(255)->notNull(),
            'url_page' => $this->string(255)->notNull()->unique(),
            'content' => $this->text(),
            'shablon' => $this->text()->notNull(),
            'active' => $this->smallInteger()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'sort' => $this->smallInteger()->notNull(),
        ]);

        // Наполнение таблицы данными
        $this->batchInsert(
            '{{%page}}',
            ['id', 'title', 'meta_desc', 'meta_key', 'cannonical', 'headline', 'breadcrumps', 'menu_name', 'url_page', 'content', 'shablon', 'active', 'status', 'sort'],
            [
                [1, 'Главная страница', '', '', NULL, 'Главная страница', 'Главная страница', 'Главная страница', 'home', '<p>Hello, {TEL_1}!</p>\r\n', 'default', 1, 1, 500],
                [2, '404', '', '', NULL, '404', '404', '404', '404', '', 'error', 0, 1, 500],
                [3, 'Спасибо', '', '', NULL, 'Спасибо', 'Спасибо', 'Спасибо', 'spasibo', '', 'thanks', 0, 1, 500],
                [4, 'Политика конфиденциальности', '', '', NULL, 'Политика конфиденциальности', 'Политика конфиденциальности', 'Политика конфиденциальности', 'politika-konfidencialnosti', '', 'politika', 0, 1, 500],
                [5, 'Каталог', '', '', '', 'Каталог', 'Каталог', 'Каталог', 'katalog', '', 'default', 1, 1, 500],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page}}');
    }
}
