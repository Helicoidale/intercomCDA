<?php

namespace App\Controller;


use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/monProfil", name="user_monProfil")
     * @param Request $request
     * @return Response
     */
    public function afficherProfil(Request $request): Response
    {

        $user = $this->getUser();
        dump($user);



        return $this->render('user/monProfil.html.twig', [
            'user' => $user,

        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route ("/modifierProfil" , name="user_modifierProfil")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function modifierProfil(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user = $this->getUser();

        dump($user);
        dump($request);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $oldPassword = $form->get('oldPassword')->getData();

            dump($oldPassword);
            //Si l'ancien mot de passe est bon

            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {


               $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());


                $user->setPassword($newEncodedPassword);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('notice', 'Votre mot de passe a bien été modifié !');

                return $this->redirectToRoute('user_monProfil');

            } else {

                return $this->render('user/modifierProfil.html.twig', [
                    'user' => $user,
                    'form' => $form->createView()
                ]);
            }


        }

        dump($user);

        return $this->render('user/modifierProfil.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);


    }
}
