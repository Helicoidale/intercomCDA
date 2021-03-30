<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Entity\ResponsableDeGarde;
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
     * @return Response
     */
    public function index(PlanningRepository $planningRepository): Response
    {
        return $this->render('planning/index.html.twig', [
            'plannings' => $planningRepository->findAll(),
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
    public function ajoutParUniteSoin(Request $request):Response{

        $tabPlanning []=

        dump($request);
        $date=new Calendrier();
        $date=$request->query->get('mois');
        dump($date);
        $service=$request->query->get('service');
        dump($service);
        $nbrJours=$request->query->get('nbrJours');
        $lannee=$request->query->get('lannee');
        $lemois=$request->query->get('lemois');

        $resGardeRepo = $this->getDoctrine()->getRepository(ResponsableDeGarde::class);
        $listedesResGarde = $resGardeRepo->findAll();

        for ($i =1;$i <= $nbrJours;$i++){



            $ceJour = mktime(0, 0, 0, ($lemois - 1), $lannee,$i);




            $planning = new Planning();
            $form = $this->createForm(PlanningType::class, $planning);
            $form->handleRequest($request);


            return $this->render('planning/ajoutParUniteSoin.html.twig', [
                'service'=>$service,
                'mois'=>$date,
                'ceJour'=>$ceJour,
                'form' => $form->createView(),
                'listeGarde'=>$listedesResGarde,

            ]);


        }

        $lejour=01;

        $ceMois = mktime(0, 0, 0, ($lemois - 1), $lannee,$lejour);




        $planning = new Planning();
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);



//        $jourDate=$date->format('Y-m-d');
//        $jourDate->add->format ('d')->{+1};

        return $this->render('planning/ajoutParUniteSoin.html.twig', [
            'service'=>$service,
            'mois'=>$date,
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
     */
    public function delete(Request $request, Planning $planning): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planning->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($planning);
            $entityManager->flush();
        }

        return $this->redirectToRoute('planning_index');
    }


}
