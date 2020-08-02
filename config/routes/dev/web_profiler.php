<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import(
        __DIR__ . '/../../../vendor/symfony/web-profiler-bundle/Resources/config/routing/wdt.xml'
    )
        ->prefix('/_wdt');

    $routingConfigurator->import(
        __DIR__ . '/../../../vendor/symfony/web-profiler-bundle/Resources/config/routing/profiler.xml'
    )
        ->prefix('/_profiler');
};
