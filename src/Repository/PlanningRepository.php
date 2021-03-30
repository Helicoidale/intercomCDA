<?php

namespace App\Repository;

use App\Entity\Planning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Planning|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planning|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planning[]    findAll()
 * @method Planning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planning::class);
    }

    /**recupere le planning commencant par et finissant par les dates entree
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function getEventBetween(\DateTime $start ,\DateTime $end):array{

        $queryBuilder=$this->createQueryBuilder('p')
            ->select('o')
            ->where('o.date_heure_debut>= :start')
            ->setParameter('start',$start)
            ->where('o.date_time_fin >= :end')
            ->setParameter('start',$end);
            return $queryBuilder->getQuery()->getResult();

    }

    /**recupere le planning commencant par et finissant par les dates entree indexe par jour
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function getEventBetweenByDay(\DateTime $start ,\DateTime $end):array{

        $plannings=$this->getEventBetween($start,$end);
        $days=[];
        foreach ($plannings as $planning){
            $date= explode (' ',$planning ['start'])[0];
            if(!isset($day[$date])){
                $days[$date]=[$planning];
            }else{
                $days[$date][]=$planning;
            }
        }


    }




    // /**
    //  * @return Planning[] Returns an array of Planning objects
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
    public function findOneBySomeField($value): ?Planning
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
