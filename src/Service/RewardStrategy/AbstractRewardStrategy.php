<?php

namespace App\Service\RewardStrategy;

use App\Factory\RewardFactoryInterface;

abstract class AbstractRewardStrategy
{
    public function __construct(protected RewardFactoryInterface $rewardFactory)
    {
    }

    public function getRewardId(): int
    {
        return $this->rewardFactory->createReward()->getId();
    }
}
