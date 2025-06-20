# base.module.migration.smart.process.workspace

<table>
<tr>
<td>
<a href="https://github.com/Liventin/base.module">Bitrix Base Module</a>
</td>
</tr>
</table>

install | update

```
"require": {
    "liventin/base.module.migration.smart.process.workspace": "^1.0.0"
}
```
redirect (optional)
```
"extra": {
  "service-redirect": {
    "liventin/base.module.migration.smart.process.workspace": "module.name",
  }
}
```
PhpStorm Live Template
```php
<?php

/** @bxnolanginspection */

namespace ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Migration\DigitalWorkplace;


use ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Service\Container;
use ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Service\Migration\SmartProcessWorkspace\WorkspaceSmartProcessEntity;
use ${MODULE_PROVIDER_CAMMAL_CASE}\\${MODULE_CODE_CAMMAL_CASE}\Service\SmartProcess\SmartProcessService;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

class SmartProcessWorkspaceExample implements WorkspaceSmartProcessEntity
{
    public static function getTitle(): string
    {
        return 'title';
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     * @throws ReflectionException
     * @throws SystemException
     */
    public static function getTypeIds(): array
    {
        /** @var SmartProcessService ${DS}srvSmartProcess */
        ${DS}srvSmartProcess = Container::get(SmartProcessService::SERVICE_CODE);

        return [
            ${DS}srvSmartProcess->getByName(SmartProcessOne::getName())->getTypeId(),
            ${DS}srvSmartProcess->getByName(SmartProcessTwo::getName())->getTypeId(),
        ];
    }
}
```