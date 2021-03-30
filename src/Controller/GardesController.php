<?php

namespace App\Controller;

use App\Entity\Calendrier;
use App\Entity\Planning;
use App\Entity\ResponsableDeGarde;
use App\Entity\UniteSoin;
use App\Form\PlanningType;
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
     */
    public function ajouterouModifier(Request $request): Response
    {
        $uniteSoinRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
        $listeUniteSoin = $uniteSoinRepo->findAll();
        dump($listeUniteSoin);

        $validation = $request->query->get('validation');
        //dump($validation);
        $daterecup = $request->query->get('date');
        dump($daterecup);

        $idService = $request->query->get('service');
        dump($idService);
        //dump ($request);
        $date = new Calendrier();

        if ((!$idService == null || !$daterecup == null) || (!$idService == null && !$daterecup == null)) {

            dump($daterecup);
            $verifDate = $date->isValid($daterecup);
            dump($verifDate);

            if ($verifDate != true) {
                dump("la date n est pas valide!");
                $this->addFlash('notice', 'la date entrée n\'est pas valide !');
            }
            if ($idService == "selected") {
                dump("le service n est pas selectionne");
                $this->addFlash('notice', 'Veuillez entrer un service !');
            }
            //TODO probleme d entre dan sle fonction quand rien n ets selectionne

            if (($idService != "selected"  && $verifDate == true)) {
                $uniteSoinRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
                $service = new UniteSoin();
                $service = $uniteSoinRepo->find($idService);
                dump($service);
                $lemois = explode('-', $daterecup)[1];
                dump($lemois);
                $lannee = explode('-', $daterecup)[0];
                dump($lannee);
                $lemoisChoisi = new Calendrier($lemois, $lannee);
                dump($lemoisChoisi);

                $ceMois = mktime(0, 0, 0, ($lemois - 1), $lannee);
                $nbreJourDansLeMois = intval(date("t", $ceMois));
                dump($nbreJourDansLeMois);

                $resGardeRepo = $this->getDoctrine()->getRepository(ResponsableDeGarde::class);
                $listedesResGarde = $resGardeRepo->findAll();


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
