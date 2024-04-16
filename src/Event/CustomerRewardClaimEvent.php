<?php

namespace App\Event;

use App\Entity\Customer;
use Doctrine\Common\Collections\Collection;
use Symfony\Contracts\EventDispatcher\Event;

class CustomerRewardClaimEvent extends Event
{
    public const NAME = 'customer.reward.claim';

    public function __construct(protected Customer $customer, protected Collection $bonuses)
    {
    }

    public function getBonuses(): Collection
    {
        return $this->bonuses;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
