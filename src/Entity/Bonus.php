<?php

namespace App\Entity;

use App\Repository\BonusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BonusRepository::class)]
class Bonus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('read')]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups('read')]
    private ?int $rewardId = null;

    /**
     * @var Collection<int, CustomerBonus>
     */
    #[ORM\OneToMany(targetEntity: CustomerBonus::class, mappedBy: 'bonus', orphanRemoval: true)]
    private Collection $customer;

    public function __construct()
    {
        $this->customer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRewardId(): ?int
    {
        return $this->rewardId;
    }

    public function setRewardId(int $rewardId): static
    {
        $this->rewardId = $rewardId;

        return $this;
    }

    /**
     * @return Collection<int, CustomerBonus>
     */
    public function getCustomer(): Collection
    {
        return $this->customer;
    }

    public function addCustomer(CustomerBonus $customer): static
    {
        if (!$this->customer->contains($customer)) {
            $this->customer->add($customer);
            $customer->setBonus($this);
        }

        return $this;
    }

    public function removeCustomer(CustomerBonus $customer): static
    {
        if ($this->customer->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getBonus() === $this) {
                $customer->setBonus(null);
            }
        }

        return $this;
    }
}
