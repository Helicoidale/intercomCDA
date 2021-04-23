<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Entity\ResponsableDeGarde;
use App\Entity\UniteSoin;
use App\Form\PlanningsType;
use App\Form\PlanningType;
use App\Entity\Calendrier;

use App\Repository\PlanningRepository;
use DateTime;
use Doctrine\ORM\Tools\DebugUnitOfWorkListener;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/planning")
 */
class PlanningController extends AbstractController
{
    /**
     * @Route("/", name="planning_index", methods={"GET"})
     * @param PlanningRepository $planningRepository
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function index(PlanningRepository $planningRepository, Request $request): Response
    {
        $imprimer = $request->query->get('imprimer');
        $getMonth = $request->query->get('month');
        $getYear = $request->query->get('year');
        $lemois = new Calendrier ($getMonth, $getYear);
        $premierJourMois = $lemois->getStartingDay();
        //dump($premierJourMois);
        $dernierJourMois = (clone $premierJourMois)->modify('+1 month -1 day');
        //dump($dernierJourMois);
        $dernierJourDuMoisEnTexte = date_format($dernierJourMois, 'Y-m-d');
        $nbreJourDansLeMois = intval(explode('-', $dernierJourDuMoisEnTexte)[2]);
        //dump($nbreJourDansLeMois);

        $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
        $listePlanningsDuMois = $planningRepo->findAllEntrePremieretDernierJourDuMois($premierJourMois, $dernierJourMois);

        $uniteSoinRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
        $listeUnitesSoins = $uniteSoinRepo->findAll();
        dump($listePlanningsDuMois);


        //cree un tableau par jour-dans chaque jour il y a un tableau des planning du jour par service
        $days = [];
        foreach ($listePlanningsDuMois as $planning) {
            //dump($planning);
            $date = $planning->getDate();
            //dump($date);
            $d = date_format($date, 'Y-m-d');
            //dump($d);
            $ser = $planning->getUniteSoin()->getId();
            //dump($ser);
            if (!isset($days[$d])) {

                //dump("la date n existais pas ,cree une nouvelle date et un nouveau tableau de service pour cette date ");

                $days[$d][$ser] = [$planning];

            } else {

                if (!isset($d[$ser])) {
                    $days[$d][$ser] = [$planning];
                    //dump("la date existait ,le service n exitais pas");

                } else {
                    $days[$d][$ser][] = $planning;
                    //dump("la date existait ,le service existais");
                }

            }
        }
        dump($days);

        if ($imprimer == "imprimer") {

            return $this->render('planning/imprimer.html.twig', [

                'plannings' => $listePlanningsDuMois,
                'unitesSoins' => $listeUnitesSoins,
                'days' => $days,
                'premierJourDuMois' => $premierJourMois,
                'nbreJourDuMois' => $nbreJourDansLeMois,
            ]);
        }

        return $this->render('planning/index.html.twig', [
            //'plannings' => $planningRepository->findAll(),
            'calendrier' => $lemois,
            'plannings' => $listePlanningsDuMois,
            'unitesSoins' => $listeUnitesSoins,
            'days' => $days,
            'premierJourDuMois' => $premierJourMois,
            'nbreJourDuMois' => $nbreJourDansLeMois,
        ]);
    }

    /**
     * pour modifier  le planning mensuel d un service
     * @Route("/planningGarde", name="planning_planning_garde", methods={"GET"})
     * @param PlanningRepository $planningRepository
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function planningGarde(PlanningRepository $planningRepository, Request $request): Response
    {
        $uniteSoinRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
        $listeUnitesSoins = $uniteSoinRepo->findAll();
        //   dump($listeUnitesSoins);

        $validation = $request->query->get('validation');
        //  dump($validation);
        $daterecup = $request->query->get('date');
        //  dump($daterecup);

        $idService = $request->query->get('uniteSoin');
        //dump($idService);
        //dump ($request);
        $date = new Calendrier();

        if ((!$idService == null || !$daterecup == null) || (!$idService == null && !$daterecup == null)) {

            //   dump($daterecup);
            $verifDate = $date->isValid($daterecup);
            //  dump($verifDate);

            if ($verifDate != true) {
                //dump("la date n est pas valide!");
                $this->addFlash('notice', 'la date entrée n\'est pas valide !');
            }
            if ($idService == "selected") {
                //dump("le service n est pas selectionne");
                $this->addFlash('notice', 'Veuillez entrer un service !');
            }
            //TODO probleme d entré dans la fonction quand rien n est selectionne

            if (($idService != "selected" && $verifDate == true)) {

                $service = new UniteSoin();
                $service = $uniteSoinRepo->find($idService);
                //dump($service);
                $lemois = explode('-', $daterecup)[1];
                //dump($lemois);
                $lannee = explode('-', $daterecup)[0];
                //dump($lannee);
                $lemoisChoisi = new Calendrier($lemois, $lannee);
                //dump($lemoisChoisi);


                $premiereJourDuMois = new DateTime("{$lannee}-{$lemois}-01");
                //    dump(($premiereJourDuMois));
                $dernierJourDuMois = (clone $premiereJourDuMois)->modify('+1 month -1 day');
                //    dump($dernierJourDuMois);
                $dernierJourDuMoisEnTexte = date_format($dernierJourDuMois, 'Y-m-d');
                //    dump($dernierJourDuMoisEnTexte);
                $nbreJourDansLeMois = intval(explode('-', $dernierJourDuMoisEnTexte)[2]);
                //     dump($nbreJourDansLeMois);

                $quelJourEstOnLePremierJourDuMOis = intval($premiereJourDuMois->format('N'));
                //     dump($quelJourEstOnLePremierJourDuMOis);

//                $getMonth = $request->query->get('month');
//                $getYear = $request->query->get('year');
//                $lemois = new Calendrier ($getMonth, $getYear);
//                $premierJourMois = $lemois->getStartingDay();
//                //dump($premierJourMois);
//                $dernierJourMois = (clone $premierJourMois)->modify('+1 month -1 day');
//                //dump($dernierJourMois);
//                $dernierJourDuMoisEnTexte = date_format($dernierJourMois, 'Y-m-d');
//                $nbreJourDansLeMois = intval(explode('-', $dernierJourDuMoisEnTexte)[2]);
//                //dump($nbreJourDansLeMois);
                dump($idService);
                dump($premiereJourDuMois);
                dump($dernierJourDuMois);
                $idServ = intval($idService);
                dump($idServ);
                $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
                $listePlanningsDuMois = $planningRepo->findPlanningDuServiceEntreDeuxDate($idServ, $premiereJourDuMois, $dernierJourDuMois);

//                $uniteSoinRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
//                $listeUnitesSoins = $uniteSoinRepo->findAll();
                dump($listePlanningsDuMois);

                return $this->render('planning/planningGarde.html.twig', [
                    'plannings' => $listePlanningsDuMois,
                    'listedesUnitedeSoin' => $listeUnitesSoins,
                    'date' => $premiereJourDuMois,
                    'validation' => $validation,
                ]);
            }
        }
        return $this->render('planning/planningGarde.html.twig', [
            'plannings' => $planningRepository->findAll(),
            'listedesUnitedeSoin' => $listeUnitesSoins,
            'validation' => $validation,
        ]);
    }

    /**
     * @Route("/new", name="planning_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $planning = new Planning();
        $form = $this->createForm(Planningtype::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($planning);
            $entityManager->flush();

            return $this->redirectToRoute('planning_index');
        }

        return $this->render('planning/new.html.twig', [
            'planning' => $planning,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/gardesQuotidienne" ,name="planning_gardes_quotidienne")
     * @return Response
     */
    public function gardesQuotidienne(Request $request): Response
    {
        $imprimer = $request->query->get('imprimer');

        $day = new DateTime("2021-04-02");
        dump($day);
        $Aujourdhui = $day;
        $dayHeure = intval(date_format($day, 'H:i'));
//        $heureQuIlEst = intval(explode(' ', $day)[1]);
        dump($dayHeure);

        //si il est moins de 8h ,affiche le planning de la veille
        if ($dayHeure <= 8) {
            $day = (clone $day)->modify('-1 day');
            dump($day);
            $texte = "Responsables d'astreintes jusqu'à 8h ";

        } else {
            $texte = "Responsables d'astreintes de 8h à 8h demain ";
        }
        $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
        $listeDesGardes = $planningRepo->findAllPourCeJOur($day);
        dump($listeDesGardes);

        $services = [];
        foreach ($listeDesGardes as $planning) {
            $serv = $planning->getUniteSoin()->getId();
            dump($serv);
            if (!isset($services[$serv])) {
                //dump("le service existe ");
                $services[$serv] = [$planning];
            } else {
                $services[$serv][] = $planning;
                //dump("le service n exitais pas");
            }
        }
        dump($services);

        $uniteSoinRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
        $listeUnitesSoins = $uniteSoinRepo->findAll();
        dump($listeUnitesSoins);

        if ($imprimer == "imprimer") {

            return $this->render('planning/imprimerGardesQuotidiennes.html.twig', [
                'Aujourdhui' => $Aujourdhui,
                'listeGarde' => $listeDesGardes,
                'texte' => $texte,
                'service' => $services

            ]);
        }


        return $this->render('planning/gardesQuotidienne.html.twig', [
            'Aujourdhui' => $Aujourdhui,
            'listeGarde' => $listeDesGardes,
            'texte' => $texte,
            'service' => $services

        ]);
    }
//
//    /**
//     * @Route ("/ajoutParUniteSoin" ,name="planning_ajout_par_unite_soin")
//     * @param Request $request
//     * @return Response
//     */
//    public function ajoutParUniteSoin(Request $request): Response
//    {
//
//        $tabPlanning [] = Planning::class;
//
//        dump($request);
//        $date = new Calendrier();
//        $date = $request->query->get('mois');
//        dump($date);
//        $service = $request->query->get('service');
//        dump($service);
//        $nbrJours = $request->query->get('nbrJours');
//        $lannee = $request->query->get('lannee');
//        $lemois = $request->query->get('lemois');
//
//        $resGardeRepo = $this->getDoctrine()->getRepository(ResponsableDeGarde::class);
//        $listedesResGarde = $resGardeRepo->findAll();
//
//        for ($i = 1; $i <= $nbrJours; $i++) {
//
//
//            $ceJour = mktime(0, 0, 0, ($lemois - 1), $lannee, $i);
//
//            $planning = new Planning();
//            $form = $this->createForm(PlanningType::class, $planning);
//            $form->handleRequest($request);
//
//
//            return $this->render('planning/ajoutParUniteSoin.html.twig', [
//                'service' => $service,
//                'mois' => $date,
//                'ceJour' => $ceJour,
//                'form' => $form->createView(),
//                'listeGarde' => $listedesResGarde,
//
//            ]);
//
//
//        }
//
//        $lejour = 01;
//
//        $ceMois = mktime(0, 0, 0, ($lemois - 1), $lannee, $lejour);
//
//        $planning = new Planning();
//        $form = $this->createForm(PlanningType::class, $planning);
//        $form->handleRequest($request);
//
//
////        $jourDate=$date->format('Y-m-d');
////        $jourDate->add->format ('d')->{+1};
//
//        return $this->render('planning/ajoutParUniteSoin.html.twig', [
//            'service' => $service,
//            'mois' => $date,
//            'form' => $form->createView(),
//        ]);
//
//    }


    /**
     * @Route("/{id}", name="planning_show", methods={"GET"})
     */
    public function show(Planning $planning): Response
    {
        return $this->render('planning/show.html.twig', [
            'planning' => $planning,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="planning_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Planning $planning): Response
    {
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            // pour retourner surla vue du planning qui viens d etre modifier
            dump($planning);
            $date = $planning->getDate();
            $dateTexte= date_format($date, 'Y-m-d');

            //je retrouve les date de debut et de fin de mois garce a la date choisie
            $lemois = explode('-', $dateTexte)[1];
            //dump($lemois);
            $lannee = explode('-', $dateTexte)[0];
            //dump($lannee);

            $premiereJourDuMois = new DateTime("{$lannee}-{$lemois}-01");
            //    dump(($premiereJourDuMois));
            $dernierJourDuMois = (clone $premiereJourDuMois)->modify('+1 month -1 day');
            //    dump($dernierJourDuMois);

            $idServ = $planning->getUniteSoin()->getId();
            $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
            $listePlanningsDuMois = $planningRepo->findPlanningDuServiceEntreDeuxDate($idServ, $premiereJourDuMois, $dernierJourDuMois);

            $uniteSoinRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
            $listeUnitesSoins = $uniteSoinRepo->findAll();

            $validation = "valider";

            return $this->render('planning/planningGarde.html.twig', [

                'plannings' => $listePlanningsDuMois,
                'listedesUnitedeSoin' => $listeUnitesSoins,
                'date' => $premiereJourDuMois,
                'validation' => $validation,
            ]);
        }

        return $this->render('planning/edit.html.twig', [
            'planning' => $planning,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="planning_delete", methods={"DELETE"})
     * @param Request $request
     * @param Planning $planning
     * @return Response
     */
    public function delete(Request $request, Planning $planning): Response
    {
        if ($this->isCsrfTokenValid('delete' . $planning->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($planning);
            $entityManager->flush();
        }

        return $this->redirectToRoute('planning_index');
    }


}
