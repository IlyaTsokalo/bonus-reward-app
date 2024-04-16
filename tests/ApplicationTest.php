<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\Customer;
use App\Entity\CustomerBonus;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApplicationTest extends AbstractApiTestCase
{
    public function testGetCollectionNotAuthenticated(): void
    {
        static::createClient()->request('GET', static::getContainer()->get('router')->generate('get_customer_bonuses', ['customerId' => 1]));

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testGetCollectionReturnsNotEmptyCollection(): void
    {
        $client = static::createClientWithAuthorization();

        $this->claimCustomerRewards($client);

        $response = $client->request('GET', static::getContainer()->get('router')->generate('get_customer_bonuses', ['customerId' => 1]), [
            'headers' => [
                'Content-Type' => 'application/vnd.api+json',
            ],
            'json' => [],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertCount(30, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(CustomerBonus::class);
    }

    public function testClaimCustomerRewardsReturnsClaimedRewards(): void
    {
        $client = static::createClientWithAuthorization();

        $response = $this->claimCustomerRewards($client);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertGreaterThan(0, $response->toArray()['hydra:member']);
    }

    public function testGetCustomersCollection(): void
    {
        $client = static::createClientWithAuthorization();

        $response = $client->request('GET', static::getContainer()->get('router')->generate('get_customers_collection'), [
            'headers' => [
                'Content-Type' => 'application/vnd.api+json',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertGreaterThan(0, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(Customer::class);
    }

    private function claimCustomerRewards(Client $client): ResponseInterface
    {
        return $client->request('POST', static::getContainer()->get('router')->generate('claim_customers_rewards', ['id' => 1]), [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'isEmailVerified' => true,
                'isBirthday' => true,
            ],
        ]);
    }
}
