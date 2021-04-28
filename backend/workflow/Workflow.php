<?php

namespace backend\workflow;

use backend\models\domain\Apple;
use backend\workflow\appleAction\AppleFallAction;

class Workflow
{
    public function appleFall(Apple $apple): Apple
    {
        $action = new AppleFallAction($apple);

        return $action->execute();
    }
}