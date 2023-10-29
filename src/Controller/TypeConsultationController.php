<?php

namespace App\Controller;

use App\Entity\TypeConsultation;
use App\Form\TypeConsultationType;
use App\Repository\TypeConsultationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/consultation')]
class TypeConsultationController extends AbstractController
{
    #[Route(
        '/{_locale}',
        name: 'app_type_consultation_index',
        methods: ['GET'],
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function index(TypeConsultationRepository $typeConsultationRepository): Response
    {
        return $this->render('type_consultation/index.html.twig', [
            'type_consultations' => $typeConsultationRepository->findAll(),
        ]);
    }

    #[Route(
        '/new/{_locale}',
        name: 'app_type_consultation_new',
        methods: ['GET', 'POST'],
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeConsultation = new TypeConsultation();
        $form = $this->createForm(TypeConsultationType::class, $typeConsultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeConsultation);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_consultation/new.html.twig', [
            'type_consultation' => $typeConsultation,
            'form' => $form,
        ]);
    }

    #[Route(
        '/{id}/{_locale}',
        name: 'app_type_consultation_show',
        methods: ['GET'],
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function show(TypeConsultation $typeConsultation): Response
    {
        return $this->render('type_consultation/show.html.twig', [
            'type_consultation' => $typeConsultation,
        ]);
    }

    #[Route(
        '/{id}/edit/{_locale}',
        name: 'app_type_consultation_edit',
        methods: ['GET', 'POST'],
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function edit(Request $request, TypeConsultation $typeConsultation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeConsultationType::class, $typeConsultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_consultation/edit.html.twig', [
            'type_consultation' => $typeConsultation,
            'form' => $form,
        ]);
    }

    #[Route(
        '/{id}/{_locale}',
        name: 'app_type_consultation_delete',
        methods: ['POST'],
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function delete(Request $request, TypeConsultation $typeConsultation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $typeConsultation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeConsultation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_consultation_index', [], Response::HTTP_SEE_OTHER);
    }
}
