<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_social}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210119_142004_create_user_social_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_social}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'social_net' => $this->string()->notNull(),
            'key' => $this->string()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_social-user_id}}',
            '{{%user_social}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_social-user_id}}',
            '{{%user_social}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_social-user_id}}',
            '{{%user_social}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_social-user_id}}',
            '{{%user_social}}'
        );

        $this->dropTable('{{%user_social}}');
    }
}
