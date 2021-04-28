<?php

namespace backend\workflow;

use backend\models\domain\Apple;
use backend\workflow\appleAction\AppleFallAction;
use backend\workflow\appleAction\AppleEatAction;

class Workflow
{
    public function appleFall(Apple $apple): Apple
    {
        $action = new AppleFallAction($apple);

        return $action->execute();
    }

    public function appleEat(Apple $apple, $volume): ?Apple
    {
        $action = new AppleEatAction($apple, ['volume' => $volume]);

        $action->execute();

        return $action->getApple();
    }
}