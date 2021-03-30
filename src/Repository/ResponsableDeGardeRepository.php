<?php

namespace App\Repository;

use App\Entity\ResponsableDeGarde;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResponsableDeGarde|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponsableDeGarde|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponsableDeGarde[]    findAll()
 * @method ResponsableDeGarde[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponsableDeGardeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponsableDeGarde::class);
    }

    // /**
    //  * @return ResponsableDeGarde[] Returns an array of ResponsableDeGarde objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResponsableDeGarde
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
