<?php

namespace App\Controller;

use App\Entity\Secteur;
use App\Form\SecteurType;
use App\Repository\SecteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/secteur")
 */
class SecteurController extends AbstractController
{
    /**
     * @Route("/", name="secteur_index", methods={"GET"})
     */
    public function index(SecteurRepository $secteurRepository): Response
    {

        return $this->render('secteur/index.html.twig', [
            'secteurs' => $secteurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="secteur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $secteur = new Secteur();
        $form = $this->createForm(SecteurType::class, $secteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($secteur);
            $entityManager->flush();

            return $this->redirectToRoute('secteur_index');
        }

        return $this->render('secteur/new.html.twig', [
            'secteur' => $secteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="secteur_show", methods={"GET"})
     */
    public function show(Secteur $secteur): Response
    {
        $service=new ArrayCollection();
        $service=$secteur->getServices();
        dump("je fais un dump :" );
        dump( $service);

        return $this->render('secteur/show.html.twig', [
            'secteur' => $secteur,
            'services'=>$service,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="secteur_edit", methods={"GET","POST"})
     */
    public function modifierSecteur(Request $request, Secteur $secteur): Response
    {
        $form = $this->createForm(SecteurType::class, $secteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('secteur_index');
        }

        return $this->render('secteur/edit.html.twig', [
            'secteur' => $secteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="secteur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Secteur $secteur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$secteur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($secteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secteur_index');
    }
}
