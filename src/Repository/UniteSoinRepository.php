<?php

namespace App\Repository;

use App\Entity\UniteSoin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UniteSoin|null find($id, $lockMode = null, $lockVersion = null)
 * @method UniteSoin|null findOneBy(array $criteria, array $orderBy = null)
 * @method UniteSoin[]    findAll()
 * @method UniteSoin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UniteSoinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UniteSoin::class);
    }

    public function findUniteSoinById($id){

        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult();

    }
    // /**
    //  * @return UniteSoin[] Returns an array of UniteSoin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UniteSoin
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
