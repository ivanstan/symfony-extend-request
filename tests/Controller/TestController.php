<?php

namespace Ivanstan\SymfonyExtendRequest\Tests\Controller;

use Ivanstan\SymfonyExtendRequest\Tests\Request\ExtendedRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestController extends AbstractController
{
    public function testGetCustomRequestParam(ExtendedRequest $request): JsonResponse
    {
        return new JsonResponse([
            'foo' => $request->foo(),
        ]);
    }

    public function testGetSymfonyRequestParam(ExtendedRequest $request): JsonResponse
    {
        return new JsonResponse([
            'foo' => $request->get('foo'),
        ]);
    }
}
