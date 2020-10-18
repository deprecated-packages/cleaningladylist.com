<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector;
use Rector\Set\ValueObject\SetList;
use Rector\SOLID\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(FinalizeClassesWithoutChildrenRector::class);
    $services->set(PropertyTypeDeclarationRector::class);
    $services->set(MoveRepositoryFromParentToConstructorRector::class);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
    ]);

    $parameters->set(Option::SETS, [
        SetList::NAMING,
        SetList::CODE_QUALITY,
        SetList::DOCTRINE_CODE_QUALITY,
        SetList::DOCTRINE_REPOSITORY_AS_SERVICE,
        SetList::NETTE_CODE_QUALITY,
    ]);

};
