<?php

namespace Ivanstan\SymfonyExtendRequest\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

class ExtendRequestResolverTest extends WebTestCase
{
    protected static function createKernel(array $options = []): KernelInterface
    {
        return new Kernel('dev', true);
    }

    public function testGetCustomRequestParam(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/test/get/custom?foo=bar');

        $response = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertEquals('bar', $response['foo']);
    }

    public function testGetSymfonyRequestParam(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/test/get/symfony?foo=bar');

        $response = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertEquals('bar', $response['foo']);
    }
}
