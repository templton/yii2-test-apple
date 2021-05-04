<?php

namespace backend\service;

use backend\models\domain\Apple;
use backend\dataProvider\ColorDataProvider;
use backend\repository\AppleRepository;
use backend\exception\AppleNotFoundException;
use backend\workflow\Workflow;
use backend\exception\FieldNotValidException;

class AppleService
{
    /**
     * Создать яблоко с рандомными параметрами
     *
     * @return Apple
     */
    public function createRandomApple(): Apple
    {
        $color = ColorDataProvider::getRandomColor();
        return AppleRepository::createNew($color);
    }

    /**
     * Бросить яблоко на землю
     *
     * @param int $appleId
     * @return Apple
     * @throws AppleNotFoundException
     */
    public function fallApple(int $appleId): Apple
    {
        $apple = $this->findAppleById($appleId);
        $workflow = new Workflow();
        return $workflow->appleFall($apple);
    }

    /**
     * Откусить яблоко
     *
     * @param int $appleId
     * @param $volume
     * @return Apple|null
     * @throws AppleNotFoundException
     * @throws FieldNotValidException
     */
    public function eatApple(int $appleId, $volume):?Apple
    {
        if ($volume<0 || $volume>1){
            throw new FieldNotValidException('volume должно быть в пределах от 0 до 100');
        }

        $apple = $this->findAppleById($appleId);
        $workflow = new Workflow();
        return $workflow->appleEat($apple, $volume);
    }

    public function findAppleById(int $appleId): Apple
    {
        $apple = AppleRepository::findById($appleId);

        if (!$apple){
            throw new AppleNotFoundException('Яблоко с id='.$appleId.' не найдено');
        }

        return $apple;
    }
}