<?php

use yii\db\Migration;

/**
 * Class m191213_080541_drop_quiz_name_column_from_quiz_result
 */
class m191213_080541_drop_quiz_name_column_from_quiz_result extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function safeUp()
    {
        $this->dropColumn('result', 'quiz_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191213_080541_drop_quiz_name_column_from_quiz_result cannot be reverted.\n";

        return false;
    }
}
