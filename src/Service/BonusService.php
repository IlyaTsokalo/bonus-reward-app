<?php

namespace App\Service;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Customer;
use App\Repository\BonusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ApiResource]
class BonusService
{
    protected const DEFAULT_REWARD_ID = 0;

    /**
     * @param \App\Service\RewardStrategy\RewardStrategyInterface[] $strategies
     */
    public function __construct(protected iterable $strategies, protected BonusRepository $bonusRepository)
    {
    }

    public function defineWinningBonuses(Customer $customer): ?Collection
    {
        $rewardId = $this->defineRewardId($customer);

        if (self::DEFAULT_REWARD_ID === $rewardId) {
            return null;
        }

        $bonuses = $this->bonusRepository->findByRewardId($rewardId);

        return new ArrayCollection($bonuses);
    }

    protected function defineRewardId(Customer $customer): int
    {
        /** @var RewardStrategy\AbstractRewardStrategy|RewardStrategy\RewardStrategyInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->isApplicable($customer)) {
                return $strategy->getRewardId();
            }
        }

        return self::DEFAULT_REWARD_ID;
    }
}
