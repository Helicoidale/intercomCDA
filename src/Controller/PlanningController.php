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

        if ($imprimer == "imprimer"){

            return $this->render('planning/imprimer.html.twig', [

                'plannings' => $listePlanningsDuMois,
                'unitesSoins' => $listeUnitesSoins,
                'days'=>$days,
                'premierJourDuMois'=>$premierJourMois,
                'nbreJourDuMois'=>$nbreJourDansLeMois,
            ]);
        }

        return $this->render('planning/index.html.twig', [
            //'plannings' => $planningRepository->findAll(),
            'plannings' => $listePlanningsDuMois,
            'unitesSoins' => $listeUnitesSoins,
            'days'=>$days,
            'premierJourDuMois'=>$premierJourMois,
            'nbreJourDuMois'=>$nbreJourDansLeMois,
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
     * @Route ("/ajoutParUniteSoin" ,name="planning_ajout_par_unite_soin")
     * @param Request $request
     * @return Response
     */
    public function ajoutParUniteSoin(Request $request): Response
    {

        $tabPlanning [] = Planning::class;

        dump($request);
        $date = new Calendrier();
        $date = $request->query->get('mois');
        dump($date);
        $service = $request->query->get('service');
        dump($service);
        $nbrJours = $request->query->get('nbrJours');
        $lannee = $request->query->get('lannee');
        $lemois = $request->query->get('lemois');

        $resGardeRepo = $this->getDoctrine()->getRepository(ResponsableDeGarde::class);
        $listedesResGarde = $resGardeRepo->findAll();

        for ($i = 1; $i <= $nbrJours; $i++) {


            $ceJour = mktime(0, 0, 0, ($lemois - 1), $lannee, $i);

            $planning = new Planning();
            $form = $this->createForm(PlanningType::class, $planning);
            $form->handleRequest($request);


            return $this->render('planning/ajoutParUniteSoin.html.twig', [
                'service' => $service,
                'mois' => $date,
                'ceJour' => $ceJour,
                'form' => $form->createView(),
                'listeGarde' => $listedesResGarde,

            ]);


        }

        $lejour = 01;

        $ceMois = mktime(0, 0, 0, ($lemois - 1), $lannee, $lejour);

        $planning = new Planning();
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);


//        $jourDate=$date->format('Y-m-d');
//        $jourDate->add->format ('d')->{+1};

        return $this->render('planning/ajoutParUniteSoin.html.twig', [
            'service' => $service,
            'mois' => $date,
            'form' => $form->createView(),
        ]);

    }


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

            return $this->redirectToRoute('planning_index');
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
