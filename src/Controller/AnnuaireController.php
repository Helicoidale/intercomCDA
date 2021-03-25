<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnuaireController extends AbstractController
{
    /**
     * @Route("/annuaire", name="annuaire")
     */
    public function annuaire(): Response
    {
        return $this->render('annuaire/annuaire.html.twig', [
            'controller_name' => 'AnnuaireController',
        ]);
    }


    /**
     * @Route("/annuaire/ajoutPersonne", name="annuaire_ajoutPersonne")
     */
    public function ajoutPersonne(Request $request):Response
    {

        return $this->render('annuaire/ajouterPersonne.html.twig');

    }
}
