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

    /**recupere le calendrier commencant par et finissant par les dates entree
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

    /**recupere le calendrier commencant par et finissant par les dates entree indexe par jour
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
        return $days;
    }

    /** recupere un planing par date et par doc
     * @param $date
     * @param $docId
     */
    public function findAllByDateEtDocId(string $date,int $docId)
   {
       $queryBuilder=$this->createQueryBuilder('p');
       $queryBuilder->select('p')
           ->andWhere('p.date = :d')
           ->setParameter('d', $date)
           ->andWhere('p.responsable = :r')
           ->setParameter('r', $docId)
           ->getQuery()
           ->getResult();
       //exit(print_r($querybuilder,true));
       return $queryBuilder;

   }



    /** recupere un planing par date et par doc
     * @param $date
     *
     */
    public function findAllByDate( $date)
    {
        $qb= $this->createQueryBuilder('p');
        $qb->select('p')
            ->andWhere('p.date = :d')
            ->setParameter('d', $date);
//            ->getQuery()
//            ->getResult();

        return $qb->getQuery()->getResult();
    }

    /** recupere un planing par date, doc et saisie
     * @param $date
     *
     */
    public function findAllByDateServiceetSaisie( $date,$serviceId,$saisie)
    {
        $qb= $this->createQueryBuilder('p');
        $qb->select('p')
            ->andWhere('p.date = :d')
            ->setParameter('d', $date)
            ->andWhere('p.UniteSoin = :u')
            ->setParameter('u',$serviceId)
            ->andWhere('p.numeroDeSaisie = :n')
            ->setParameter('n', $saisie)
        ;
        return $qb->getQuery()->getResult();
    }

    /** recupere l ID d un planing par date, doc et saisie
     * @param $date
     *
     */
    public function findIdWhereDateServiceetSaisie( $date,$serviceId,$saisie)
    {
        $qb= $this->createQueryBuilder('p');
        $qb->select('p.id')
            ->andWhere('p.date = :d')
            ->setParameter('d', $date)
            ->andWhere('p.UniteSoin = :u')
            ->setParameter('u',$serviceId)
            ->andWhere('p.numeroDeSaisie = :n')
            ->setParameter('n', $saisie)
        ;
        return $qb->getQuery()->getResult();
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
