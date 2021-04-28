<?php

namespace backend\workflow\appleAction;

use backend\models\domain\Apple;

abstract class AbstractAppleAction implements InterfaceExecutable
{
    protected $apple;
    protected $context;

    public function __construct(Apple $apple, $context = [])
    {
        $this->apple = $apple;
        $this->context = $context;
    }

    public function getApple(): ?Apple
    {
        return $this->apple;
    }
}