<?php

namespace Ivanstan\SymfonyExtendRequest\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ExtendRequestResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), Request::class);
    }

    public function resolve(Request $baseRequest, ArgumentMetadata $argument): iterable
    {
        yield $this->customRequestFactory($baseRequest, $argument->getType());
    }

    protected function customRequestFactory(Request $baseRequest, string $class): Request
    {
        $request = forward_static_call([$class, 'createFromGlobals']);
        $request->attributes = $baseRequest->attributes;
        $request->query = $baseRequest->query;
        $request->files = $baseRequest->files;
        $request->request = $baseRequest->request;

        return $request;
    }
}
