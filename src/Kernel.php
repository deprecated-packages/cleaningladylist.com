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
        parent::__construct($environment, $debug);

        $this->flexLoader = new FlexLoader($environment, $this->getProjectDir());
    }

    public function registerBundles(): Iterator
    {
        return $this->flexLoader->loadBundles();
    }

    protected function configureContainer(ContainerBuilder $containerBuilder, LoaderInterface $loader): void
    {
        $this->flexLoader->loadConfigs($containerBuilder, $loader);
    }

    /**
     * If routing gets broken, debug command will help to narrow the issue:
     * bin/console debug:router
     */
    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__ . '/../config/routes/**/*');
    }
}
