<?php

namespace Ivanstan\SymfonyExtendRequest\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class ExtendRequestResolverTest extends WebTestCase
{
    protected static function createKernel(array $options = []): KernelInterface
    {
        return new Kernel('dev', true);
    }

    public function testExtendedClass(): void
    {
        $client = static::createClient();

        $client->request('GET', '/test?foo=bar');

        self::assertResponseIsSuccessful();

        $response = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertEquals('bar', $response['foo']);
    }
}
