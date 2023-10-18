<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPassType;
use App\Form\UserProfileType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->manager = $managerRegistry->getManager();
    }
    #[Route('/profile', name: 'app_profile')]
    public function index(Request  $request, UserPasswordHasherInterface $hasher): Response
    {
        /**@var User */
        $user = $this->getUser();
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('success', 'Information mise a jours');
            return $this->redirectToRoute('app_profile');
        }
        $formPass = $this->createForm(UserPassType::class);
        $formPass->handleRequest($request);
        if ($formPass->isSubmitted() && $formPass->isValid()) {
            if ($hasher->isPasswordValid($user, $formPass->get('old_pass')->getData())) {
                $user->setPassword($hasher->hashPassword($user,$formPass->get('new_pass')->getData()));
                $this->manager->persist($user);
                $this->manager->flush();
                $this->addFlash('success','Mot de pass changer avec success.');
            }else{
                $this->addFlash('error','Mot de passe invalide');
            }
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('profile/index.html.twig', [
            'form' => $form->createView(),
            'formPass' => $formPass->createView()
        ]);
    }
}
