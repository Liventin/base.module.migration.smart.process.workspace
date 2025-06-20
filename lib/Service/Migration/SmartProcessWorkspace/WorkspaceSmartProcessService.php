<?php

namespace Base\Module\Service\Migration\SmartProcessWorkspace;

interface WorkspaceSmartProcessService
{
    public const SERVICE_CODE = 'base.module.migration.smart.process.workspace.service';

    public function setWorkspaceEntities(array $entities): self;
    public function install(): void;
    public function reInstall(): void;
}