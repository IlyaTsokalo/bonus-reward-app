<?php

namespace App\Factory;

use App\Entity\RewardInterface;
use App\Entity\SmileReward;

class SmileRewardFactory implements RewardFactoryInterface
{
    public function createReward(): RewardInterface
    {
        return new SmileReward();
    }
}
