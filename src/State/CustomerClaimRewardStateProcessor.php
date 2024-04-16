<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Event\CustomerRewardClaimEvent;
use App\Repository\CustomerRepository;
use App\Service\BonusService;
use App\Service\CustomerService;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerClaimRewardStateProcessor implements ProcessorInterface
{
    public function __construct(protected CustomerRepository $customerRepository, protected EventDispatcherInterface $eventDispatcher, protected CustomerService $customerService, protected BonusService $bonusService)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $customer = $this->customerRepository->findOneBy(['id' => $data->getId()]);

        if (!$customer) {
            throw new NotFoundHttpException();
        }

        if ($context['previous_data'] != $customer) {
            $customer = $this->customerService->updateBonusRelatedInformation($customer);
        }

        $winningBonuses = $this->bonusService->defineWinningBonuses($customer);

        if (null === $winningBonuses || !$this->customerService->customerHasNewBonusRewardsToClaim($customer, $winningBonuses)) {
            $response = new Response(null, Response::HTTP_NO_CONTENT);
            $response->headers->set('X-Message', 'Customer has no new bonus rewards to claim');

            return $response;
        }

        $this->eventDispatcher->dispatch(new CustomerRewardClaimEvent($customer, $winningBonuses));

        return $winningBonuses->map(fn ($entity) => $entity->getId())->toArray();
    }
}
