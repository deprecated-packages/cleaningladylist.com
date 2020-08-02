<?php

declare(strict_types=1);

use App\Entity\User;
use App\Security\CustomAuthenticator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('security', ['encoders' => [User::class => ['algorithm' => 'auto']]]);

    $containerConfigurator->extension(
        'security',
        ['providers' => ['app_user_provider' => ['entity' => ['class' => User::class, 'property' => 'email']]]]
    );

    $containerConfigurator->extension(
        'security',
        ['firewalls' => ['dev' => ['pattern' => '^/(_(profiler|wdt)|css|images|js)/', 'security' => false], 'main' => ['anonymous' => true, 'lazy' => true, 'provider' => 'app_user_provider', 'guard' => ['authenticators' => [
            CustomAuthenticator::class,
        ]], 'logout' => ['path' => 'app_logout']]]]
    );

    $containerConfigurator->extension('security', ['access_control' => null]);
};
