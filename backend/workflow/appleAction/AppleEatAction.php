<?php

namespace backend\workflow\appleAction;

use backend\repository\AppleRepository;
use backend\exception\NotWorkflowActionException;
use backend\models\domain\Apple;
use backend\workflow\enums\StatusEnums;

class AppleEatAction extends AbstractAppleAction
{
    public function execute(): ?Apple
    {
        $volume = $this->context['volume'];

        if (!$this->canEatVolume($volume)){
            throw new NotWorkflowActionException('Нельзя столько откусить. От яблока осталось всего ' . ($this->apple->current_volume * 100) . '%');
        }

        if (!$this->canEatInCurrentStatus()){
            throw new NotWorkflowActionException('Нельзя есть яблоко, т.к. оно в статусе - ' . $this->apple->status->name);
        }

        $currentVolume = $this->apple->current_volume - $volume;

        //Если яблоко полностью съедено, то удалить яблоко из набора
        if ($currentVolume == 0){
            $this->deleteApple();
        }else{
            $this->updateVolume($currentVolume);
        }

        return $this->apple;
    }

    /**
     * Откусить можно не больше, чем всего осталось яблока
     *
     * @param $volume
     * @return bool
     */
    protected function canEatVolume($volume): bool
    {
        return $volume <= $this->apple->current_volume;
    }

    /**
     * Откусить можно только если яблоко уже упало, но еще не протухло
     *
     * @return bool
     */
    protected function canEatInCurrentStatus(): bool
    {
        return $this->apple->status->sys_name === StatusEnums::STATE_ON_GROUND;
    }

    protected function deleteApple()
    {
        AppleRepository::deleteApple($this->apple->id);
        $this->apple = null;
    }

    protected function updateVolume($currentVolume)
    {
        $this->apple->current_volume = $currentVolume;
        $this->apple->save();
    }
}