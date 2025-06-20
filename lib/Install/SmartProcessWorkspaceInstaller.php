<?php

/** @noinspection PhpUnused */

namespace Base\Module\Install;

use Base\Module\Install\Interface\Install;
use Base\Module\Install\Interface\ReInstall;
use Base\Module\Service\Container;
use Base\Module\Service\Migration\SmartProcessWorkspace\WorkspaceSmartProcessEntity;
use Base\Module\Service\Migration\SmartProcessWorkspace\WorkspaceSmartProcessService;
use Base\Module\Service\Tool\ClassList;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

class SmartProcessWorkspaceInstaller implements Install, ReInstall
{
    /**
     * @return array
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     * @throws ReflectionException
     * @throws SystemException
     */
    private function getSmartProcessWorkspaceList(): array
    {
        /** @var ClassList $classList */
        $classList = Container::get(ClassList::SERVICE_CODE);
        return $classList->setSubClassesFilter([WorkspaceSmartProcessEntity::class])->getFromLib('Migration');
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     * @throws ReflectionException
     * @throws SystemException
     */
    public function install(): void
    {
        /** @var WorkspaceSmartProcessService $userFieldService */
        $userFieldService = Container::get(WorkspaceSmartProcessService::SERVICE_CODE);
        $userFieldService->setWorkspaceEntities($this->getSmartProcessWorkspaceList())->install();
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     * @throws ReflectionException
     * @throws SystemException
     */
    public function reInstall(): void
    {
        /** @var WorkspaceSmartProcessService $userFieldService */
        $userFieldService = Container::get(WorkspaceSmartProcessService::SERVICE_CODE);
        $userFieldService->setWorkspaceEntities($this->getSmartProcessWorkspaceList())->reInstall();
    }

    public function getInstallSort(): int
    {
        return 375;
    }

    public function getReInstallSort(): int
    {
        return 375;
    }
}
