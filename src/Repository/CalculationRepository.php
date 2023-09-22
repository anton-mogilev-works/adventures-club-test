<?php

namespace App\Repository;

use App\Entity\Calculation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Calculation>
 *
 * @method Calculation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calculation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calculation[]    findAll()
 * @method Calculation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalculationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calculation::class);
    }

    public function getQueue() : array {
        return $this->createQueryBuilder('c')
                   ->andWhere('c.result IS NULL')                
                   ->orderBy('c.id', 'DESC')                   
                   ->getQuery()
                   ->getResult()
               ;
    }

}
