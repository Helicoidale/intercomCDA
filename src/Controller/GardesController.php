<?php

namespace App\Controller;

use App\Entity\Calendrier;
use App\Entity\Planning;
use App\Entity\ResponsableDeGarde;
use App\Entity\UniteSoin;
use App\Form\PlanningType;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GardesController extends AbstractController
{
    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/gardes", name="gardes")
     */
    public function gardes(): Response
    {
        return $this->render('gardes/gardes.html.twig', [
            'controller_name' => 'GardesController',
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route ("/garde/modif",name="modif")
     * @param Request $request
     * @return Response
     */
    public function modif(Request $request): Response
    {
        //dump("hello");
        dump($request);
        $service = json_decode($request->get('service'));
        $year = $request->get('year');
        $month = $request->get('month');
        $day = $request->get('day');
        $doc1 = json_decode($request->get('doc1'));
        $start1 = $request->get('start1');
        $end1 = $request->get('end1');
        $doc2 = json_decode($request->get('doc2'));
        $start2 = $request->get('start2');
        $end2 = $request->get('end2');
        $doc3 = json_decode($request->get('doc3'));
        $start3 = $request->get('start3');
        $end3 = $request->get('end3');
        dump($service);
        dump($year);
        dump($month);
        dump($day);
        dump($doc1);
        dump($start1);
        dump($end1);
        dump($doc2);
        dump($start2);
        dump($end2);
        dump($doc3);
        dump($start3);
        dump($end3);


        $uniteRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
        $unite = $uniteRepo->find($service);

        for ($i = 1; $i <= 31; $i++) {
            if ($day == $i) {

                dump("je suis dans la boucle des jour du mois");

                //le jour,le mois ,l annee en date time
                $jourEnregistrer = new DateTime("{$year}-{$month}-{$day}");
                dump($jourEnregistrer);

                //le jour,le mois, l annee en string
                $jourEnregistrer2 = date_format($jourEnregistrer, 'Y-m-d');
                dump($jourEnregistrer2);

                if (isset ($doc1)) {
                    dump("je suis dans la fonction le doc 1 nest pas null");

                    $saisie = 1;

                    //verifie l existance de donnée(s) pour ce service ce jour en saisie 1
                    $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
                    $gardetrouve = $planningRepo->findIdWhereDateServiceetSaisie($jourEnregistrer, $service, $saisie);
                    dump($gardetrouve);
                    if(empty($gardetrouve)){
                        $gardetrouve=null;
                    }else{
                    //tableau des donnees trouvé ( théoriquement il ne doit y avoir qu une donnee ou aucune)
                    $lecturetab = $gardetrouve[0];
                    $idServiceRecup = $lecturetab['id'];
                    dump($idServiceRecup);
                    }

                    //transformation des horaires et recherche du responsable de garde
                    $horaireDeb1 = DateTime::createFromFormat('H:i', $start1);
                    $horaireFin1 = DateTime::createFromFormat('H:i', $end1);
                    $respRepo = $this->getDoctrine()->getRepository(ResponsableDeGarde::class);
                    $resp1 = $respRepo->find($doc1);


                    if (!isset ($gardetrouve)) {
                        dump("je suis dans la fonction pas de saisie1 trouvé pour ce jour et ce service");
                        //creer un nouveau planning d'astreinte (tour de garde)
                        $planning = new planning();
                        $planning->setDate($jourEnregistrer);
                        $planning->setDateHeureDebut($horaireDeb1);
                        $planning->setDatetimefin($horaireFin1);
                        $planning->setResponsable($resp1);
                        dump($resp1);


                        $planning->setUniteSoin($unite);
                        dump($unite);
                        $planning->setNumeroDeSaisie($saisie);

                        //l enregistrer
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($planning);
                        $entityManager->flush();
                    } else {
                        dump("je suis dans la fonction modifier la saisie1  pour ce jour et ce service");
                        //modifier les horaires et le resp sur la donnee existante
                        $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
                        $gardeAModifier = $planningRepo->find($idServiceRecup);

                        $gardeAModifier->setDateHeureDebut($horaireDeb1);
                        $gardeAModifier->setDatetimefin($horaireFin1);
                        $gardeAModifier->setResponsable($resp1);
                        //l enregistrer
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($gardeAModifier);
                        $entityManager->flush();
                    }


                }
                if (isset ($doc2)) {
                   dump("je suis dans la fonction le doc 2 nest pas null");

                    $saisie = 2;

                    //verifie l existance de donnée(s) pour ce service ce jour en saisie 2
                    $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
                    $gardetrouve = $planningRepo->findIdWhereDateServiceetSaisie($jourEnregistrer, $service, $saisie);
                    dump($gardetrouve);
                    if(empty($gardetrouve)){
                        $gardetrouve=null;
                    }else{
                    //tableau des donnees trouvé ( theoriquement il ne doit y avoir qu une donnee ou aucune)
                    $lecturetab = $gardetrouve[0];
                    $idServiceRecup = $lecturetab['id'];
                    dump($idServiceRecup);}

                    //transformation des horaires et recherche du responsable de garde
                    $horaireDeb2 = DateTime::createFromFormat('H:i', $start2);
                    $horaireFin2 = DateTime::createFromFormat('H:i', $end2);
                    $respRepo = $this->getDoctrine()->getRepository(ResponsableDeGarde::class);
                    $resp2 = $respRepo->find($doc2);

                    if (!isset ($gardetrouve)) {

                          dump("je suis dans la fonction pas de saisie2 trouvé pour ce jour et ce service");
                        //creer un nouveau planning d'astreinte (tour de garde)
                        $planning = new planning();
                        $planning->setDate($jourEnregistrer);
                        $planning->setDateHeureDebut($horaireDeb2);
                        $planning->setDatetimefin($horaireFin2);
                        $planning->setResponsable($resp2);
                        dump($resp2);

                        $planning->setUniteSoin($unite);
                        dump($unite);
                        $planning->setNumeroDeSaisie($saisie);

                        //l enregistrer
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($planning);
                        $entityManager->flush();
                    } else {
                        dump("je suis dans la fonction modifier la saisie2  pour ce jour et ce service");
                        //modifier les horaires et le resp sur la donnee existante
                        $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
                        $gardeAModifier = $planningRepo->find($idServiceRecup);

                        $gardeAModifier->setDateHeureDebut($horaireDeb2);
                        $gardeAModifier->setDatetimefin($horaireFin2);
                        $gardeAModifier->setResponsable($resp2);
                        //l enregistrer
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($gardeAModifier);
                        $entityManager->flush();
                    }
                }
                if (isset ($doc3)) {
                    dump("je suis dans la fonction le doc 3 nest pas null");

                    $saisie = 3;

                    //verifie l existance de donnée(s) pour ce service ce jour en saisie 3
                    $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
                    $gardetrouve = $planningRepo->findIdWhereDateServiceetSaisie($jourEnregistrer, $service, $saisie);
                    dump($gardetrouve);
                    if(empty($gardetrouve)){
                        $gardetrouve=null;
                    }else{
                    //tableau des donnees trouvé ( theoriquement il ne doit y avoir qu une donnee ou aucune)
                    $lecturetab = $gardetrouve[0];
                    $idServiceRecup = $lecturetab['id'];
                    dump($idServiceRecup);}

                    //transformation des horaires et recherche du responsable de garde
                    $horaireDeb3 = DateTime::createFromFormat('H:i', $start3);
                    $horaireFin3 = DateTime::createFromFormat('H:i', $end3);
                    $respRepo = $this->getDoctrine()->getRepository(ResponsableDeGarde::class);
                    $resp3 = $respRepo->find($doc3);

                    if (!isset ($gardetrouve)) {

                          dump("je suis dans la fonction pas de saisie3 trouvé pour ce jour et ce service");
                        //creer un nouveau planning d'astreinte (tour de garde)
                        $planning = new planning();
                        $planning->setDate($jourEnregistrer);
                        $planning->setDateHeureDebut($horaireDeb3);
                        $planning->setDatetimefin($horaireFin3);
                        $planning->setResponsable($resp3);
                        dump($resp3);
                        $planning->setUniteSoin($unite);
                        dump($unite);
                        $planning->setNumeroDeSaisie($saisie);

                        //l enregistrer
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($planning);
                        $entityManager->flush();
                    } else {
                        dump("je suis dans la fonction modifier la saisie3  pour ce jour et ce service");
                        //modifier les horaires et le resp sur la donnee existante
                        $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
                        $gardeAModifier = $planningRepo->find($idServiceRecup);

                        $gardeAModifier->setDateHeureDebut($horaireDeb3);
                        $gardeAModifier->setDatetimefin($horaireFin3);
                        $gardeAModifier->setResponsable($resp3);
                        //l enregistrer
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($gardeAModifier);
                        $entityManager->flush();
                    }
                }
            }
        }

        return new Response($year . " " . $month . " " . $day . " doc1:" . $doc1 . " doc2:" . $doc2 . " doc3:" . $doc3 . "service: " . $service);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/garde/ajouterGardesMensuellesAService" , name="gardes_ajouter_gardes_mensuelles_a_service")
     * @return Response
     */
    public
    function ajouterGardesMensuellesAuService()
    {
        return $this->render('gardes/gardes.html.twig', [
            'controller_name' => 'GardesController',
        ]);
    }

    /**
     *  @IsGranted("ROLE_EDITOR")
     * @Route("/garde/tableDesMatieresGardes" ,name="gardes_table_des_matiere")
     * @return Response
     */
    public
    function tableDesMatieresGardes(): Response
    {
        return $this->render('gardes/tableDesMatieresGardes.html.twig', [
            'controller_name' => 'GardesController',
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/garde/ajouterOuModifier" , name="gardes_ajouter_ou_modifier")
     * @return Response
     * @throws \Exception
     */
    public
    function ajouterouModifier(Request $request): Response
    {
        dump($request);
        $planningValide=$request->request->get('planningOk');
        dump($planningValide);
        if($planningValide=="planningOk"){
            return $this->redirectToRoute('home');
        }

        $tabPlanning [] = Planning::class;
        //dump($request);

        $uniteSoinRepo = $this->getDoctrine()->getRepository(UniteSoin::class);
        $listeUniteSoin = $uniteSoinRepo->findAll();
        //dump($listeUniteSoin);

        $validation = $request->query->get('validation');
        //dump($validation);
        $daterecup = $request->query->get('date');
        dump($daterecup);

        $idService = $request->query->get('uniteSoin');
        //dump($idService);
        //dump ($request);
        $date = new Calendrier();

        if ((!$idService == null || !$daterecup == null) || (!$idService == null && !$daterecup == null)) {

            dump($daterecup);
            $verifDate = $date->isValid($daterecup);
            dump($verifDate);

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


                $premiereJourDuMois=new DateTime("{$lannee}-{$lemois}-01");
                dump(($premiereJourDuMois));
                $dernierJourDuMois=(clone $premiereJourDuMois)->modify('+1 month -1 day');
                dump( $dernierJourDuMois) ;
                $dernierJourDuMoisEnTexte = date_format($dernierJourDuMois, 'Y-m-d');
                dump( $dernierJourDuMoisEnTexte) ;
                $nbreJourDansLeMois = intval(explode('-', $dernierJourDuMoisEnTexte)[2]);
                dump( $nbreJourDansLeMois) ;

                $quelJourEstOnLePremierJourDuMOis=intval($premiereJourDuMois->format('N'));
                dump($quelJourEstOnLePremierJourDuMOis);

                $resGardeRepo = $this->getDoctrine()->getRepository(ResponsableDeGarde::class);
                $listedesResGarde = $resGardeRepo->findAll();
                //dump($listedesResGarde);

                //essai pour visualisation
//            $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
//            $liste = $planningRepo->findAll();
//            dump($liste);
//
                // NE FONCTIONNE PAS !
//                $dateTest = new DateTime("2021-04-14");
//                dump($dateTest);
//                $dateTest3 = "2021-04-14";
//                dump($dateTest3);
//                $dateTest2 = date_format($dateTest, 'Y-m-d');
//                dump($dateTest2);
//            //$jourEtDoc= new ArrayCollection();
//            $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
//            $jourEtDoc = $planningRepo->findAllByDateEtDocId($dateTest3, 1);
//            dump($jourEtDoc);
//
//            $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
//            $listejour = $planningRepo->findAllByDate($dateTest3);
//            dump($listejour);
//
//                $saisie = 1;
//                $serviceTest = 3;
//                $planningRepo = $this->getDoctrine()->getRepository(Planning::class);
////            $gardetrouve = $planningRepo->findAllByDateServiceetSaisie($dateTest3,$serviceTest,$saisie);
////            dump($gardetrouve);
//                $gardetrouve = $planningRepo->findIdWhereDateServiceetSaisie($dateTest3, $serviceTest, $saisie);
//                dump($gardetrouve);



                $planning = new Planning();
                $form = $this->createForm(Planningtype::class, $planning);
                $form->handleRequest($request);

                return $this->render('planning/ajoutParUniteSoin.html.twig', [
                    'service' => $service,
                    'mois' => $lemoisChoisi,
                    'lannee' => $lannee,
                    'lemois' => $lemois,
                    'nbrJours' => $nbreJourDansLeMois,
                    'form' => $form->createView(),
                    'listeGarde' => $listedesResGarde,
                    'listedesUnitedeSoin' => $listeUniteSoin,
                    'numjourDuPremier'=>$quelJourEstOnLePremierJourDuMOis,
                    'jourUn'=>$premiereJourDuMois,
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
