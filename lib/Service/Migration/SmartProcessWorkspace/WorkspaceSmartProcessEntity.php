<?php

namespace Base\Module\Service\Migration\SmartProcessWorkspace;

interface WorkspaceSmartProcessEntity
{
    public static function getTitle(): string;
    public static function getTypeIds(): array;
}