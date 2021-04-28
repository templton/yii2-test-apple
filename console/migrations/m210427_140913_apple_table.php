<?php

use yii\db\Migration;

/**
 * Class m210427_140913_apple_table
 */
class m210427_140913_apple_table extends Migration
{

    const TABLE_APPLE = 'apple';
    const TABLE_COLOR = 'color';
    const TABLE_STATUS = 'status';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_APPLE, [
            'id'=>$this->primaryKey(),
            'fallen_date'=>$this->dateTime()->comment('Время падения на землю'),
            'status_id'=>$this->integer()->comment('Статус яблока'),
            'color_id'=>$this->integer()->comment('Цвет яблока'),
            'current_volume'=>$this->decimal(10,1)->comment('Остаток яблока в процентах')->defaultValue(1),
            'created'=>$this->dateTime()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('idx-'.self::TABLE_APPLE.'-application_id', self::TABLE_APPLE, 'status_id');
        $this->createIndex('idx-'.self::TABLE_APPLE.'-fallen_date', self::TABLE_APPLE, 'fallen_date');

        $this->addForeignKey(
            'fk-'.self::TABLE_APPLE.'-status_id',
            self::TABLE_APPLE,
            'status_id',
            self::TABLE_STATUS,
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-'.self::TABLE_APPLE.'-color_id',
            self::TABLE_APPLE,
            'color_id',
            self::TABLE_COLOR,
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-'.self::TABLE_APPLE.'-status_id' ,self::TABLE_APPLE);
        $this->dropForeignKey('fk-'.self::TABLE_APPLE.'-color_id' ,self::TABLE_APPLE);
        $this->dropIndex('idx-'.self::TABLE_APPLE.'-application_id', self::TABLE_APPLE);
        $this->dropIndex('idx-'.self::TABLE_APPLE.'-fallen_date', self::TABLE_APPLE);
        $this->dropTable(self::TABLE_APPLE);
    }
}
