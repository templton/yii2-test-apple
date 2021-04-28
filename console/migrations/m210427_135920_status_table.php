<?php

use yii\db\Migration;

/**
 * Class m210427_135920_status_table
 */
class m210427_135920_status_table extends Migration
{

    const TABLE_STATUS = 'status';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_STATUS, [
            'id'=>$this->primaryKey(),
            'name'=>$this->string(),
            'sys_name'=>$this->string(100)
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('idx-'.self::TABLE_STATUS.'-sys_name', self::TABLE_STATUS, 'sys_name');

        $this->batchInsert(self::TABLE_STATUS, ['name', 'sys_name'], [
            ['На дереве', 'onTree'],
            ['На земле', 'onGround'],
            ['Испорчено', 'rotten'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-'.self::TABLE_STATUS.'-sys_name', self::TABLE_STATUS);
        $this->dropTable(self::TABLE_STATUS);
    }
}
