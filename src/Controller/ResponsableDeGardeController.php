<?php

namespace App\Controller;

use App\Entity\ResponsableDeGarde;
use App\Entity\UniteSoin;
use App\Form\ResponsableDeGardeType;
use App\Repository\ResponsableDeGardeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/responsable/de/garde")
 */
class ResponsableDeGardeController extends AbstractController
{
    /**
     * @Route("/", name="responsable_de_garde_index", methods={"GET"})
     */
    public function index(ResponsableDeGardeRepository $responsableDeGardeRepository): Response
    {
        return $this->render('responsable_de_garde/index.html.twig', [
            'responsable_de_gardes' => $responsableDeGardeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="responsable_de_garde_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $uniteSoinRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
        $listeUniteSoins=$uniteSoinRepo->findAll();


        $responsableDeGarde = new ResponsableDeGarde();
        $form = $this->createForm(ResponsableDeGardeType::class, $responsableDeGarde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($responsableDeGarde);
            $entityManager->flush();

            return $this->redirectToRoute('responsable_de_garde_index');
        }

        return $this->render('responsable_de_garde/new.html.twig', [
            'listeUnitesSoin'=> $listeUniteSoins,
            'responsable_de_garde' => $responsableDeGarde,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="responsable_de_garde_show", methods={"GET"})
     */
    public function show(ResponsableDeGarde $responsableDeGarde): Response
    {
        return $this->render('responsable_de_garde/show.html.twig', [
            'responsable_de_garde' => $responsableDeGarde,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="responsable_de_garde_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ResponsableDeGarde $responsableDeGarde): Response
    {
        $form = $this->createForm(ResponsableDeGardeType::class, $responsableDeGarde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('responsable_de_garde_index');
        }

        return $this->render('responsable_de_garde/edit.html.twig', [
            'responsable_de_garde' => $responsableDeGarde,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="responsable_de_garde_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ResponsableDeGarde $responsableDeGarde): Response
    {
        if ($this->isCsrfTokenValid('delete'.$responsableDeGarde->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($responsableDeGarde);
            $entityManager->flush();
        }

        return $this->redirectToRoute('responsable_de_garde_index');
    }
}
