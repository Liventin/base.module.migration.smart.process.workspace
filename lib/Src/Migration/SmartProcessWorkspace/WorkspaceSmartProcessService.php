<?php

namespace Base\Module\Src\Migration\SmartProcessWorkspace;

use Base\Module\Service\LazyService;
use Base\Module\Service\Migration\SmartProcessWorkspace\WorkspaceSmartProcessEntity;
use Base\Module\Service\Migration\SmartProcessWorkspace\WorkspaceSmartProcessService as IWorkspaceSmartProcessService;
use Bitrix\Crm\AutomatedSolution\AutomatedSolutionManager;
use Bitrix\Crm\Service\Container;
use Bitrix\Crm\Service\DynamicTypesMap;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;

#[LazyService(serviceCode: IWorkspaceSmartProcessService::SERVICE_CODE, constructorParams: [])]
class WorkspaceSmartProcessService implements IWorkspaceSmartProcessService
{
    /** @var WorkspaceSmartProcessEntity[] */
    private array $entities = [];
    private ?AutomatedSolutionManager $managerAutomatedSolution = null;
    private ?DynamicTypesMap $dynamicTypesMap = null;
    private ?Container $crmContainer = null;

    /**
     * @throws LoaderException
     */
    public function __construct()
    {
        Loader::requireModule('crm');
    }

    /**
     * @param WorkspaceSmartProcessEntity[] $entities
     * @return $this
     */
    public function setWorkspaceEntities(array $entities): self
    {
        $this->entities = $entities;
        return $this;
    }

    /**
     * @return void
     */
    public function install(): void
    {
        if (empty($this->entities)) {
            return;
        }

        $this->crmContainer = Container::getInstance();
        $this->managerAutomatedSolution = $this->crmContainer->getAutomatedSolutionManager();
        $typeIdsAlreadyInWorkspace = $this->getTypeIdsAlreadyInWorkspace();

        foreach ($this->entities as $entity) {
            $canCreate = true;
            $typeIds = $entity::getTypeIds();
            foreach ($typeIds as $id) {
                if (in_array($id, $typeIdsAlreadyInWorkspace, true)) {
                    $canCreate = false;
                    break;
                }
            }

            if ($canCreate) {
                $this->createWorkSpace($entity::getTitle(), $typeIds);
            }
        }
    }

    /**
     * @return void
     */
    public function reInstall(): void
    {
        $this->install();
    }

    private function getTypeIdsAlreadyInWorkspace(): array
    {
        $result = [];
        foreach ($this->managerAutomatedSolution->getExistingAutomatedSolutions() as $solution) {
            foreach ($solution['TYPE_IDS'] as $id) {
                $result[] = (int)$id;
            }
        }

        return $result;
    }


    /**
     * @param string $title
     * @param array $typeIds
     * @return void
     */
    private function createWorkSpace(string $title, array $typeIds): void
    {
        $addResult = $this->managerAutomatedSolution->addAutomatedSolution(['TITLE' => $title]);

        if (!$addResult->isSuccess()) {
            return;
        }

        $solutionId = (int)$addResult->getData()['fields']['ID'];
        $this->prepareDynamicTypesMap();

        $types = $this->dynamicTypesMap->getBunchOfTypesByIds($typeIds);
        $this->managerAutomatedSolution->setTypeBindingsInAutomatedSolution(
            $types,
            $solutionId,
        );
    }

    private function prepareDynamicTypesMap(): void
    {
        if ($this->dynamicTypesMap === null) {
            $this->dynamicTypesMap = $this->crmContainer->getDynamicTypesMap();
            $this->dynamicTypesMap->load([
                'isLoadStages' => false,
                'isLoadCategories' => false,
            ]);
        }
    }

}