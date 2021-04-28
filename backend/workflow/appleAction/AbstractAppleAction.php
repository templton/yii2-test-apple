<?php

namespace backend\workflow\appleAction;

use backend\models\domain\Apple;

abstract class AbstractAppleAction implements InterfaceExecutable
{
    protected $apple;

    public function __construct(Apple $apple)
    {
        $this->apple = $apple;
    }
}