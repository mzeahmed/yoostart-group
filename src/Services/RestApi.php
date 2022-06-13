<?php

namespace YsGroup\Services;

use YsGroup\Controller\Api\YsGroupPostRestEndpoint;

class RestApi
{
    public YsGroupPostRestEndpoint $ysGroupPostRestController;

    public function __construct(YsGroupPostRestEndpoint $ysGroupPostRestController)
    {
        $this->ysGroupPostRestController = $ysGroupPostRestController;
    }
}
