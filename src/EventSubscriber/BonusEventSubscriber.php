<?php

namespace App\EventSubscriber;

use App\Event\CustomerRewardClaimEvent;
use App\Service\CustomerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BonusEventSubscriber implements EventSubscriberInterface
{
    public function __construct(protected CustomerService $customerService, protected EntityManagerInterface $entityManager)
    {
    }

    #[AsEventListener(event: CustomerRewardClaimEvent::class)]
    public function onBonusRewardClaimedEvent(CustomerRewardClaimEvent $event): void
    {
        $this->customerService->claimBonusRewards($event->getCustomer(), $event->getBonuses());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CustomerRewardClaimEvent::NAME => 'onBonusRewardClaimedEvent',
        ];
    }
}
