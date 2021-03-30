<?php

namespace App\Controller;

use App\Entity\Calendrier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendrierController extends AbstractController
{
    /**
     * @Route("/calendrier", name="calendrier")
     * @throws \Exception
     */
    public function index(Request $request): Response
    {
        dump($request);
        $getMonth=$request->query->get('month');
        $getYear=$request->query->get('year');
        $leMois=new Calendrier ( $getMonth ,$getYear);
        dump($leMois);
        //$mars->setMonth(3);
        //$mars->setYear(2021);

        $weeks=$leMois->getweeks(); //retourne le nbre de semaine dans le mois

        $premierJourDuMois=$leMois->getStartingDay();
        dump($premierJourDuMois);
            //recupere le precedent lundi du 1er jour du mois
        $dernierLundi=$premierJourDuMois->format('N')==='1'? $premierJourDuMois : $leMois->getStartingDay()->modify('last monday');

        $dernierJourMois=(clone $premierJourDuMois)->modify('+' .(6+7*($weeks-1).'day'));//dernier jour de la vue du mois
        dump($dernierJourMois);

        //dump($dernierLundi);
        $numeroDuLundi=$dernierLundi->format('d');//le convertie en numero de jour
        //dump($dernierLundi);
        //dump($numeroDuLundi);


        //dump($leMois->getMonth());
        //dump($leMois->getWeeks());

        return $this->render('calendrier/index.html.twig', [
            'controller_name' => 'CalendrierController',
            'calendrier'=>$leMois,
            'lundi'=>$numeroDuLundi,
            'startingDay'=>$dernierLundi,
        ]);
    }
}
