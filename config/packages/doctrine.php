<?php

declare(strict_types=1);

use Ramsey\Uuid\Doctrine\UuidType;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('doctrine', [
        'dbal' => [
            'driver' => '%env(DATABASE_DRIVER)%',
            'host' => '%env(DATABASE_HOST)%',
            'user' => '%env(DATABASE_USER)%',
            'password' => '%env(DATABASE_PASSWORD)%',
            'dbname' => '%env(DATABASE_DBNAME)%',
            'types' => [
                UuidType::NAME => UuidType::class,
            ],
        ],
    ]);

    $containerConfigurator->extension(
        'doctrine',
        [
            'orm' => [
                'auto_generate_proxy_classes' => true,
                'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
                'auto_mapping' => true,
                'mappings' => [
                    'App' => [
                        'is_bundle' => false,
                        'type' => 'annotation',
                        'dir' => '%kernel.project_dir%/src/Entity',
                        'prefix' => 'App\Entity',
                        'alias' => 'App',
                    ],
                ],
            ],
        ]
    );
};
