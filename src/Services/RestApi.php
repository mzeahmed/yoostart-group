<?php

namespace YsGroups\Services;

use YsGroups\Controller\Api\YsGroupPostRestController;

class RestApi
{
    public YsGroupPostRestController $ysGroupPostRestController;

    public function __construct(YsGroupPostRestController $ysGroupPostRestController)
    {
        $this->ysGroupPostRestController = $ysGroupPostRestController;
    }
}
