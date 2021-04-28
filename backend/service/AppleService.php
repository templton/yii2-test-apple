<?php

namespace backend\service;

use backend\models\domain\Apple;
use backend\dataProvider\ColorDataProvider;
use backend\repository\AppleRepository;
use backend\exception\AppleNotFoundException;
use backend\workflow\Workflow;

class AppleService
{
    /**
     * Создать яблоко с рандомными параметрами
     *
     * @return Apple
     */
    public function createRandomApple(): Apple
    {
        $color = ColorDataProvider::getInstance()->getRandomColor();
        return AppleRepository::createNew($color);
    }

    /**
     * Бросить яблоко на землю
     *
     * @param int $appleId
     * @return Apple
     */
    public function fallApple(int $appleId): Apple
    {
        $apple = AppleRepository::findById($appleId);

        if (!$apple){
            throw new AppleNotFoundException('Яблоко с id='.$appleId.' не найдено');
        }

        $workflow = new Workflow();
        return $workflow->appleFall($apple);
    }


    /**
     * Откусить от яблока
     *
     * @param $volume decimal Сколько откусить в процентах от 0 до 1
     * @return Apple
     */
    public function eatApple($volume):Apple
    {

    }

    /**
     * Сделать яблоко протухшим
     *
     * @return Apple
     */
    public function setAppleRotten(): Apple
    {

    }

    public static function getInstance(): self
    {
        return new self();
    }
}