<?php

defined('B_PROLOG_INCLUDED') || die;

use Base\Module\Src\Migration\SmartProcessWorkspace\WorkspaceSmartProcessService;

return [
    'base.module.migration.smart.process' => [
        'className' => WorkspaceSmartProcessService::class,
        'constructorParams' => [],
    ],
];
