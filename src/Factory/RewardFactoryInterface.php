<?php

namespace App\Factory;

use App\Entity\RewardInterface;

interface RewardFactoryInterface
{
    public function createReward(): RewardInterface;
}
