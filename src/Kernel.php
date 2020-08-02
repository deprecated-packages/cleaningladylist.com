<?php

declare(strict_types=1);

namespace App;

use Iterator;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symplify\FlexLoader\Flex\FlexLoader;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @var FlexLoader
     */
    private $flexLoader;

    public function __construct($environment, $debug)
    {
        $this->flexLoader = new FlexLoader($environment, $this->getProjectDir());

        parent::__construct($environment, $debug);
    }

    public function registerBundles(): Iterator
    {
        return $this->flexLoader->loadBundles();
    }

    protected function configureContainer(ContainerBuilder $containerBuilder, LoaderInterface $loader): void
    {
        $this->flexLoader->loadConfigs($containerBuilder, $loader);
    }

    protected function configureRoutes(RoutingConfigurator $routingConfigurator): void
    {
        $routingConfigurator->import(__DIR__ . '/../src/Controller/', 'annotation');
        $routingConfigurator->import(__DIR__ . '/../config/routes/*');
    }
}
