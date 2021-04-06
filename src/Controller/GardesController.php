<?php

namespace App\Controller;

use App\Entity\Calendrier;
use App\Entity\Planning;
use App\Entity\ResponsableDeGarde;
use App\Entity\UniteSoin;
use App\Form\PlanningType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GardesController extends AbstractController
{
    /**
     * @Route("/gardes", name="gardes")
     */
    public function gardes(): Response
    {
        return $this->render('gardes/gardes.html.twig', [
            'controller_name' => 'GardesController',
        ]);
    }

    /**
     * @Route ("/garde/modif",name="modif")
     * @param Request $request
     * @return Response
     */
    public function modif(Request $request):Response
    {
        dump("hello");
        dump($request);
        $service=json_decode($request->get('service'));
        $year=json_decode($request->get('year'));
        $month=json_decode($request->get('month'));
        $day=json_decode($request->get('day'));
        $doc=json_decode($request->get('doc'));
        $start=json_decode($request->get('start'));
        $end=json_decode($request->get('end'));
        dump($service);
        dump($year);
        dump($month);
        dump($day);
        dump($doc);
        dump($start);
        dump($end);

        $jourEnregistrer=new DateTime("{$year}-{$month}-{$day}");
        dump($jourEnregistrer);
        dump("hello");
        $tabPlanning []= Planning::class;

//        for($i=1; $i<=31 ;$i++){
//            if($day == $i){

//                 for($j=1 ; $j<=3 ; $j++){
//                     if($doc==$j){
//                         $jourEnregistrer=new DateTime("{$year}-{$month}-{$day}");
//                         $planning=new planning();
//                         $planning->setDate($jourEnregistrer);
//                         $planning->setDateHeureDebut($start);
//                         $planning->setDatetimefin($end);
//                         $planning->addResponsable($doc);
//                         $planning->addUniteSoin($service);
//                          dump($jourEnregistrer);
                         $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
                         $JourEtDoc=$planningRepo->findOneByDateEtDocId($jourEnregistrer,$doc);
                        //  dump($jourEtDoc);

//
//                     }
//
//
//                }
//            }
//        }



        return new Response("ok ".$year." ".$month." ".$day." ".$doc." ".$service);
    }

    /**
     * @Route("/garde/ajouterGardesMensuellesAService" , name="gardes_ajouter_gardes_mensuelles_a_service")
     * @return Response
     */
    public function ajouterGardesMensuellesAuService()
    {
        return $this->render('gardes/gardes.html.twig', [
            'controller_name' => 'GardesController',
        ]);
    }

    /**
     * @Route("/garde/tableDesMatieresGardes" ,name="gardes_table_des_matiere")
     * @return Response
     */
    public function tableDesMatieresGardes(): Response
    {
        return $this->render('gardes/tableDesMatieresGardes.html.twig', [
            'controller_name' => 'GardesController',
        ]);
    }

    /**
     * @Route("/garde/ajouterOuModifier" , name="gardes_ajouter_ou_modifier")
     * @return Response
     * @throws \Exception
     */
    public function ajouterouModifier(Request $request): Response
    {
        $tabPlanning []= Planning::class;
        //dump($request);

        $uniteSoinRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
        $listeUniteSoin = $uniteSoinRepo->findAll();
        //dump($listeUniteSoin);

        $validation = $request->query->get('validation');
        //dump($validation);
        $daterecup = $request->query->get('date');
        //dump($daterecup);

        $idService = $request->query->get('uniteSoin');
        //dump($idService);
        //dump ($request);
        $date = new Calendrier();

        if ((!$idService == null || !$daterecup == null) || (!$idService == null && !$daterecup == null)) {

            //dump($daterecup);
            $verifDate = $date->isValid($daterecup);
            //dump($verifDate);

            if ($verifDate != true) {
                //dump("la date n est pas valide!");
                $this->addFlash('notice', 'la date entrée n\'est pas valide !');
            }
            if ($idService == "selected") {
                //dump("le service n est pas selectionne");
                $this->addFlash('notice', 'Veuillez entrer un service !');
            }
            //TODO probleme d entre dan sle fonction quand rien n ets selectionne

            if (($idService != "selected"  && $verifDate == true)) {
                $uniteSoinRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
                $service = new UniteSoin();
                $service = $uniteSoinRepo->find($idService);
                //dump($service);
                $lemois = explode('-', $daterecup)[1];
                //dump($lemois);
                $lannee = explode('-', $daterecup)[0];
                //dump($lannee);
                $lemoisChoisi = new Calendrier($lemois, $lannee);
                //dump($lemoisChoisi);

                $ceMois = mktime(0, 0, 0, ($lemois - 1), $lannee);
                $nbreJourDansLeMois = intval(date("t", $ceMois));
                //dump($nbreJourDansLeMois);

                $resGardeRepo = $this->getDoctrine()->getRepository(ResponsableDeGarde::class);
                $listedesResGarde = $resGardeRepo->findAll();
                //dump($listedesResGarde);

                //essaie pour visualisation
                $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
                $JourEtDoc=$planningRepo->findOneByDateEtDocId(2021-01-01,1);
                //dump($jourEtDoc);

                $planning = new Planning();
                $form = $this->createForm(Planningtype::class, $planning);
                $form->handleRequest($request);
                return $this->render('planning/ajoutParUniteSoin.html.twig', [
                    'service' => $service,
                    'mois' => $lemoisChoisi,
                    'lannee'=>$lannee,
                    'lemois'=>$lemois,
                    'nbrJours' => $nbreJourDansLeMois,
                    'form' => $form->createView(),
                    'listeGarde'=>$listedesResGarde,
                    'listedesUnitedeSoin' => $listeUniteSoin,
                ]);
            };

            return $this->render('gardes/ajouterOuModifier.html.twig', [
                'listedesUnitedeSoin' => $listeUniteSoin,
                'dateDuJour' => $date,
            ]);
        }

        return $this->render('gardes/ajouterOuModifier.html.twig', [
            'listedesUnitedeSoin' => $listeUniteSoin,
            'dateDuJour' => $date,
        ]);
    }


}
