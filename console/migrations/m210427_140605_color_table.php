<?php

use yii\db\Migration;

/**
 * Class m210427_140605_color_table
 */
class m210427_140605_color_table extends Migration
{

    const TABLE_COLOR = 'color';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_COLOR, [
            'id'=>$this->primaryKey(),
            'name'=>$this->string(100),
            'sys_name'=>$this->string(100)
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('idx-'.self::TABLE_COLOR.'-sys_name', self::TABLE_COLOR, 'sys_name');

        $this->batchInsert(self::TABLE_COLOR, ['name', 'sys_name'], [
            ['Зеленый', 'green'],
            ['Красный', 'red'],
            ['Желтый', 'yellow'],
            ['Серый', 'gray'],
            ['Коричневый', 'brown'],
            ['Черный', 'black'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-'.self::TABLE_COLOR.'-sys_name', self::TABLE_COLOR);
        $this->dropTable(self::TABLE_COLOR);
    }

}
