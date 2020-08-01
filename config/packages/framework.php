<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', ['secret' => '%env(APP_SECRET)%']);

    $containerConfigurator->extension('framework', ['session' => ['handler_id' => null, 'cookie_secure' => 'auto', 'cookie_samesite' => 'lax']]);

    $containerConfigurator->extension('framework', ['php_errors' => ['log' => true]]);
};
