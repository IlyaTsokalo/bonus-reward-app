<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;

abstract class AbstractApiTestCase extends ApiTestCase
{
    protected string $apiKey;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->apiKey = static::getContainer()->getParameter('API_KEY');
    }

    protected function createClientWithAuthorization(): Client
    {
        return static::createClient([], ['headers' => ['Authorization' => sprintf('Bearer %s', $this->apiKey)]]);
    }
}
