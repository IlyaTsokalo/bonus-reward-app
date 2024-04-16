<?php

namespace App\Service\RewardStrategy;

use App\Entity\Customer;

class BirthdayRewardStrategy extends AbstractRewardStrategy implements RewardStrategyInterface
{
    public function isApplicable(Customer $customer): bool
    {
        return $customer->isBirthday();
    }
}
