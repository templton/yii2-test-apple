<?php

namespace backend\workflow\appleAction;

use backend\exception\NotWorkflowActionException;
use backend\models\domain\Apple;
use backend\workflow\enums\StatusEnums;
use backend\dataProvider\StatusDataProvider;

class AppleFallAction extends AbstractAppleAction
{
    public function execute(): Apple
    {
        if ($this->apple->status->sys_name !== StatusEnums::STATE_ON_TREE){
            throw new NotWorkflowActionException('Яблоко уже на земле.');
        }

        $status = StatusDataProvider::getStatus(StatusEnums::STATE_ON_GROUND);

        $this->apple->fallen_date = date('Y-m-d H:i:s');
        $this->apple->status_id = $status->id;
        $this->apple->save();

        return $this->apple;
    }
}