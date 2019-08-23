<?php

use yii\db\Migration;

/**
 * Class m181005_084042_add_tilda_page_status
 */
class m181005_084042_add_tilda_page_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tilda_pages}}', 'status', $this->integer()->defaultValue(0)->comment('Статус'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tilda_pages}}', 'status');

        return false;
    }
}
