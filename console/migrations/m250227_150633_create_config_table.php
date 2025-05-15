<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%config}}`.
 */
class m250227_150633_create_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%config}}', [
            'id' => $this->primaryKey()->unsigned(),
            'param' => $this->string(128)->notNull()->unique(),
            'value' => $this->text()->notNull(),
            'default' => $this->text()->notNull(),
            'label' => $this->string(255)->notNull(),
            'type' => $this->string(128)->notNull()->comment('указания типа значения (например string, text, checkbox)'),
        ]);

        // Наполнение таблицы данными
        $this->batchInsert('{{%config}}', 
            ['id', 'param', 'value', 'default', 'label', 'type'], 
            [
                [1, 'ANOTHER_SCRIPT_END_HEAD', '', '', 'Подключение сторонних скриптов перед тегом </HEAD>', ''],
                [2, 'ANOTHER_SCRIPT_START_BODY', '', '', 'Подключение сторонних скриптов после тега <BODY>', ''],
                [3, 'ANOTHER_SCRIPT_END_BODY', '', '', 'Подключение сторонних скриптов перед тегом </BODY>', ''],
                [4, 'TEL_1', '+7 (999) 999-99-99', '', 'Телефон', 'input'],
                [5, 'PAGE_THANKS', '/spasibo/', '', 'Страница "Спасибо"', 'select.url'],
                [6, 'PAGE_PRIVACY_POLICY', '/politika-konfidencialnosti/', '', 'Страница "Политики конфиденциальности"', 'select.url'],
                [7, 'OG_TITLE', '', '', 'Open Graph Title', ''],
                [8, 'OG_DESCRIPTION', '', '', 'Open Graph Description', ''],
                [9, 'OG_IMAGE', '', '', 'Open Graph Image', ''],
                [10, 'OG_URL', '', '', 'Open Graph Url', ''],
                [11, 'SHOW_OPEN_GRAPH', '1', '0', 'Отображать OpenGraph', 'select.status'],
                [12, 'EMAIL_FROM_ALL_FORM', 'c_l_o_u_d@mail.ru', '', 'Кому будут приходить письма с форм, почту указывать через запятую', ''],
                [13, 'ANOTHER_SCRIPT_START_HEAD', '', '', 'Подключение сторонних скриптов после тега <HEAD>', ''],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%config}}');
    }
}
