<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;



#[Route('admin/user')]
class UserController extends AbstractController
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    #[Route(
        '/index/{_locale}',
        name: 'app_user_index',
        methods: ['GET'],
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route(
        '/new/{_locale}',
        name: 'app_user_new',
        methods: ['GET', 'POST'],
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pass = $form->get('password')->getData();
            $mess = '';
            if (!$pass) {
                $pass = '123456';
                $mess = "123456 est le mot de pass par default.";
            }
            $user->setPassword($this->hasher->hashPassword($user, $pass));
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Utilisateur ajouter.' . $mess);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route(
        '/{id}/{_locale}',
        name: 'app_user_show',
        methods: ['GET'],
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route(
        '/{id}/edit/{_locale}',
        name: 'app_user_edit',
        methods: ['GET', 'POST'],
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pass = $form->get('password')->getData();
            if ($pass) {
                $user->setPassword($this->hasher->hashPassword($user, $pass));
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Utilisateur modifier.');
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route(
        '/{id}/{_locale}',
        name: 'app_user_delete',
        methods: ['POST'],
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
