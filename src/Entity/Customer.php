<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\CustomerRepository;
use App\State\CustomerClaimRewardStateProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_ID', fields: ['id'])]
#[ApiResource(operations: [
    new GetCollection(
        normalizationContext: ['groups' => 'readCustomer'],
        name: 'get_customers_collection',
    ),
    new Post(
        uriTemplate: '/customers/{id}/bonuses',
        openapiContext: [
            'summary' => 'Claim customers reward',
            'requestBody' => [
                'required' => true,
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'isEmailVerified' => ['type' => 'boolean'],
                                'isBirthday' => ['type' => 'boolean'],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        name: 'claim_customers_rewards',
        processor: CustomerClaimRewardStateProcessor::class,
    ),
])]
class Customer implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('readCustomer')]
    private ?int $id = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(nullable: true)]
    #[Assert\NotNull]
    #[Assert\Type(type: 'bool')]
    private ?bool $isEmailVerified = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotNull]
    #[Assert\Type(type: 'bool')]
    private ?bool $isBirthday = null;

    /**
     * @var Collection<int, CustomerBonus>
     */
    #[ORM\OneToMany(targetEntity: CustomerBonus::class, mappedBy: 'customer', orphanRemoval: true)]
    private Collection $bonuses;

    public function __construct()
    {
        $this->bonuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->id;
    }

    /**
     * @return list<string>
     *
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isEmailVerified(): ?bool
    {
        return $this->isEmailVerified;
    }

    public function setIsEmailVerified(?bool $isEmailVerified): static
    {
        $this->isEmailVerified = $isEmailVerified;

        return $this;
    }

    public function isBirthday(): ?bool
    {
        return $this->isBirthday;
    }

    public function setIsBirthday(?bool $isBirthday): static
    {
        $this->isBirthday = $isBirthday;

        return $this;
    }

    /**
     * @return Collection<int, CustomerBonus>
     */
    public function getBonuses(): Collection
    {
        return $this->bonuses;
    }

    public function addBonus(CustomerBonus $bonus): static
    {
        if (!$this->bonuses->contains($bonus)) {
            $this->bonuses->add($bonus);
            $bonus->setCustomer($this);
        }

        return $this;
    }

    public function removeBonus(CustomerBonus $bonus): static
    {
        if ($this->bonuses->removeElement($bonus)) {
            // set the owning side to null (unless already changed)
            if ($bonus->getCustomer() === $this) {
                $bonus->setCustomer(null);
            }
        }

        return $this;
    }
}
