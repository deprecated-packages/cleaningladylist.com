<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('twig', [
        'default_path' => '%kernel.project_dir%/templates'
    ]);

    $containerConfigurator->extension('twig', [
        'form_themes' => [
            'form/bootstrap_5_layout.html.twig'
        ],
    ]);
};
