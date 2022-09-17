<?php

namespace Ivanstan\SymfonyExtendRequest\Resolver;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class ExtendRequestResolver implements ArgumentValueResolverInterface, ServiceSubscriberInterface
{
    public function __construct(protected ValidatorInterface $validator, protected ContainerInterface $container)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), Request::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield $this->customRequestFactory($request, $argument->getType());
    }

    protected function customRequestFactory(Request $request, string $class): Request
    {
        $newRequest = $this->container->get($class);

        $newRequest->attributes = $request->attributes;
        $newRequest->query = $request->query;
        $newRequest->files = $request->files;
        $newRequest->request = $request->request;

        return $newRequest;
    }

    public static function getSubscribedServices(): array
    {
        $children  = [];
        foreach(get_declared_classes() as $class) {
            if (is_subclass_of($class, Request::class)) {
                $children[] = $class;
            }
        }

        return $children;
    }
}
