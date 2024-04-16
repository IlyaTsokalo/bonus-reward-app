<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\CustomerBonusRepository;
use App\State\CustomerGetCollectionBonusesStateProvider;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CustomerBonusRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table('customer_bonus')]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/customers/{customerId}/bonuses',
            uriVariables: [
                'customerId' => new Link(fromProperty: 'bonuses', fromClass: Customer::class),
            ],
            paginationClientItemsPerPage: true,
            normalizationContext: ['groups' => 'read'],
            name: 'get_customer_bonuses',
            provider: CustomerGetCollectionBonusesStateProvider::class,
        ),
    ],
)]
class CustomerBonus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private int $id;

    #[ORM\Column]
    #[Groups('read')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'bonuses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'customer')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('read')]
    private ?Bonus $bonus = null;

    public function getId(): int
    {
        return $this->id;
    }

    #[ApiProperty(identifier: true)]
    public function getCustomerString(): string
    {
        return (string) $this->customer->getId();
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return $this
     */
    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getBonus(): ?Bonus
    {
        return $this->bonus;
    }

    public function setBonus(?Bonus $bonus): static
    {
        $this->bonus = $bonus;

        return $this;
    }
}
