<?php

namespace App\core;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @inheritDoc
     */
    protected function configureContainer(ContainerConfigurator $container)
    {
        $container->import(ROOT_DIR . '/config/framework.yaml');
        $container->import(ROOT_DIR . '/config/parameters.yaml');
        $container->import(ROOT_DIR . '/config/services.yaml');
    }

    /**
     * @inheritDoc
     */
    protected function configureRoutes(RoutingConfigurator $routes)
    {
        $routes->import(ROOT_DIR . '/config/routes.yaml');
    }
}