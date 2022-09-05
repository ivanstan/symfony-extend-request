<?php

namespace Ivanstan\SymfonyExtendRequest\Tests;

use Ivanstan\SymfonyExtendRequest\SymfonyExtendRequestBundle;
use Ivanstan\SymfonyExtendRequest\Tests\Request\ExtendedRequest;
use Ivanstan\SymfonyExtendRequest\Tests\Service\FooService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function test(ExtendedRequest $request): JsonResponse
    {
        return new JsonResponse([
            'foo' => $request->foo(),
        ]);
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->extension('framework', [
            'test' => true,
            'http_method_override' => false,
        ]);
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->add('test', '/test')->controller([$this, 'test']);
    }
}
