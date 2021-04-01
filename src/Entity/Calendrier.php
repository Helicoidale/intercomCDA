<?php


namespace App\Entity;

use Cassandra\Date;
use DateTime;

class Calendrier{

    private $months =['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Decembre'];
    private $month;
    private $year;
    public $days =['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];

    /**
     * constructeur de mois
     * Month constructor.
     * @param int $month
     * @param int $year
     * @throws \Exception
     */
   public function __construct (?int $month= null ,?int $year= null ){
       //dump($month." ". $year);
       if($month===null ||$month < 1 ||$month > 12){
           $month=intval(date('m'));
       }
       if($year===null ){
           $year=intval(date('Y'));
       }
       $this->month=$month;
       $this->year=$year;

   }
    /**
     * revoie le nom du premier jour du mois
     * @return \DateTime
     */
    public function getStartingDay():\DateTime{
        return new \DateTime("{$this->year}-{$this->month}-01");
    }


    /**
     * retourne le mois en toutes lettres
     */
   public function toString (): string {
      return  $this->months[$this->month -1]." ".$this->year;

   }

    /**
     * permet de savoir le nbre de semaines dans le mois
     * recupere le numero de sem dy debut et de la fin
     * @return int
     */
   public function getWeeks():int {
       $start=$this->getStartingDay();
       $end=(clone $start)->modify('+1 month -1 day');
       //var_dump($start,$end);
       //var_dump(($end->format('W')),$start->format('W'));
       $weeks= intval($end->format('W'))-intval($start->format('W'))+1 ;
       if($weeks <0){
        $weeks=intval($end->format('W'));
       }
    return $weeks;
   }

    /**
     * est ce que le jour est dans le mois en cour
     */
   public function whitInMonth(\DateTime $date) : bool{
       return $this->getStartingDay()->format('Y-m')=== $date->format('Y-m');


   }

    /**
     * renvoie le calendrier du mois suivant
     * @return Calendrier
     * @throws \Exception
     */
   public function nextMonth() :Calendrier
   {
        $month=$this->month+1;
        $year=$this->year;
        if ($month>12){
            $month = 1;
            $year +=1;
        }
        return new Calendrier($month,$year);
   }
    /**
     * renvoie le calendrier du mois precedent
     * @return Calendrier
     * @throws \Exception
     */
    public function previousMonth() :Calendrier
    {
        $month=$this->month-1;
        $year=$this->year;
        if ($month<1){
            $month = 12;
            $year -=1;
        }
        return new Calendrier($month,$year);
    }

    public function isValid($date ){
        //dump($date);
        $format = 'Y-m';
        //dump($format);
        $dt = DateTime::createFromFormat($format, $date);
        //dump($dt);
        return $dt && $dt->format($format) === $date;
    }

    public function getDaysInMonth($month=null,$year=null){


}

    /**
     * @return string[]
     */
    public function getMonths(): array
    {
        return $this->months;
    }

    /**
     * @param string[] $months
     */
    public function setMonths(array $months): void
    {
        $this->months = $months;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year): void
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month): void
    {
        $this->month = $month;
    }



}