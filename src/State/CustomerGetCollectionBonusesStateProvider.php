<?php

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Validator\Exception\ValidationException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CustomerGetCollectionBonusesStateProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: CollectionProvider::class)] private readonly ProviderInterface $collectionProvider
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $this->validateId($context);

        return $this->collectionProvider->provide($operation, $uriVariables, $context);
    }

    protected function validateId(mixed $context): void
    {
        $id = $context['request']?->get('customerId');

        if ((int) $id < 1) {
            throw new ValidationException('Invalid or missing id , id must be > 0');
        }
    }
}
