<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\CustomerBonus;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class CustomerService
{
    public function __construct(protected CustomerRepository $customerRepository, protected BonusService $bonusService, protected EntityManagerInterface $entityManager)
    {
    }

    public function getFirstUserID(): int
    {
        $customer = $this->customerRepository->findOneBy([], ['id' => 'ASC']);

        return $customer->getId();
    }

    public function customerHasNewBonusRewardsToClaim(Customer $customer, Collection $winningBonuses): bool
    {
        $customerBonuses = $customer->getBonuses();

        foreach ($winningBonuses as $winningBonus) {
            if (!$customerBonuses->contains($winningBonus)) {
                return true;
            }
        }

        return false;
    }

    public function claimBonusRewards(Customer $customer, Collection $bonuses): void
    {
        foreach ($bonuses as $bonus) {
            $customerBonus = new CustomerBonus();
            $customerBonus->setCustomer($customer);
            $customerBonus->setBonus($bonus);

            $this->entityManager->persist($customerBonus);
        }

        $this->entityManager->flush();
    }

    public function updateBonusRelatedInformation(Customer $customer): Customer
    {
        $this->entityManager->flush();

        return $customer;
    }
}
