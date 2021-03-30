<?php

namespace App\Repository;

use App\Entity\Plannings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Plannings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plannings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plannings[]    findAll()
 * @method Plannings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plannings::class);
    }

    // /**
    //  * @return Plannings[] Returns an array of Plannings objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Plannings
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
