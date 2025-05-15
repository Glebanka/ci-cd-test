<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 */
class m250128_060808_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'object_id' => $this->integer()->notNull(),
            'object_type' => $this->string(255)->notNull(),
            'image_name' => $this->string(255)->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(500),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%images}}');
    }
}
