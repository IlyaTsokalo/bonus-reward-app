<?php

namespace App\Service\RewardStrategy;

use App\Entity\Customer;

class EmailVerifiedRewardStrategy extends AbstractRewardStrategy implements RewardStrategyInterface
{
    public function isApplicable(Customer $customer): bool
    {
        return $customer->isEmailVerified();
    }
}
