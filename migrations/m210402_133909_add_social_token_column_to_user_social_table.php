<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_social}}`.
 */
class m210402_133909_add_social_token_column_to_user_social_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_social}}', 'social_token', $this->text());
        $this->addColumn('{{%user_social}}', 'token_status', "ENUM('0', '1')");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_social}}', 'social_token');
        $this->dropColumn('{{%user_social}}', 'token_status');
    }
}
