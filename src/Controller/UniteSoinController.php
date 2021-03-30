<?php

namespace App\Controller;

use App\Entity\UniteSoin;
use App\Form\UniteSoinType;
use App\Repository\UniteSoinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/unite/soin")
 */
class UniteSoinController extends AbstractController
{
    /**
     * @Route("/", name="unite_soin_index", methods={"GET"})
     */
    public function index(UniteSoinRepository $uniteSoinRepository): Response
    {
        return $this->render('unite_soin/index.html.twig', [
            'unite_soins' => $uniteSoinRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="unite_soin_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $uniteSoin = new UniteSoin();
        $form = $this->createForm(UniteSoinType::class, $uniteSoin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($uniteSoin);
            $entityManager->flush();

            return $this->redirectToRoute('unite_soin_index');
        }

        return $this->render('unite_soin/new.html.twig', [
            'unite_soin' => $uniteSoin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="unite_soin_show", methods={"GET"})
     */
    public function show(UniteSoin $uniteSoin): Response
    {
        return $this->render('unite_soin/show.html.twig', [
            'unite_soin' => $uniteSoin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="unite_soin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UniteSoin $uniteSoin): Response
    {
        $form = $this->createForm(UniteSoinType::class, $uniteSoin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('unite_soin_index');
        }

        return $this->render('unite_soin/edit.html.twig', [
            'unite_soin' => $uniteSoin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="unite_soin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UniteSoin $uniteSoin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$uniteSoin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($uniteSoin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('unite_soin_index');
    }
}
