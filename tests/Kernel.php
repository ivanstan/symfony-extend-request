<?php

namespace Ivanstan\SymfonyExtendRequest\Tests;

use Ivanstan\SymfonyExtendRequest\SymfonyExtendRequestBundle;
use Ivanstan\SymfonyExtendRequest\Tests\Controller\TestController;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new SymfonyExtendRequestBundle(),
        ];
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->extension('framework', [
            'test' => true,
            'http_method_override' => false,
        ]);

        $container->services()
            ->load('Ivanstan\\SymfonyExtendRequest\\Tests\\Controller\\', __DIR__.'/Controller/*')
            ->autowire()
            ->autoconfigure();

        $container->services()
            ->load('Ivanstan\\SymfonyExtendRequest\\Tests\\Request\\', __DIR__.'/Request/*')
            ->autowire()
            ->autoconfigure();
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes
            ->add('test-get-custom', '/test/get/custom')
            ->controller([TestController::class, 'testGetCustomRequestParam']);

        $routes
            ->add('test-get-symfony', '/test/get/symfony')
            ->controller([TestController::class, 'testGetSymfonyRequestParam']);
    }
}
