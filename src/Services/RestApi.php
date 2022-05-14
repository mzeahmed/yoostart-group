<?php

namespace YsGroup\Services;

use YsGroup\Controller\Api\YsGroupPostRestController;

class RestApi
{
    public YsGroupPostRestController $ysGroupPostRestController;

    public function __construct(YsGroupPostRestController $ysGroupPostRestController)
    {
        $this->ysGroupPostRestController = $ysGroupPostRestController;
    }
}
