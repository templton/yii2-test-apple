<?php

namespace backend\dataProvider;

use backend\models\domain\Status;

class StatusDataProvider
{
    public function getStatus(string $statusSysName): Status
    {
        return Status::find()->where('sys_name=:sys_name', ['sys_name' => $statusSysName])->one();
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
