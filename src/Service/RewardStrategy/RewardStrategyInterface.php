<?php

namespace App\Service\RewardStrategy;

use App\Entity\Customer;

interface RewardStrategyInterface
{
    public function isApplicable(Customer $customer): bool;
}
