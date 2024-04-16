<?php

namespace App\Repository;

use App\Entity\CustomerBonus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerBonus>
 *
 * @method CustomerBonus|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerBonus|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerBonus[]    findAll()
 * @method CustomerBonus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerBonusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerBonus::class);
    }
}
