<?php

namespace App\Controller;

use App\Entity\Medicament;
use App\Form\MedicamentType;
use App\Repository\MedicamentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/medicament/controlleur')]
class AdminMedicamentControlleurController extends AbstractController
{
    #[Route(
        '/{_locale}',
        name: 'app_admin_medicament_controlleur_index',
        methods: ['GET'],
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function index(MedicamentRepository $medicamentRepository): Response
    {
        return $this->render('admin_medicament_controlleur/index.html.twig', [
            'medicaments' => $medicamentRepository->findAll(),
        ]);
    }

    #[Route(
        '/new/{_locale}',
        name: 'app_admin_medicament_controlleur_new',
        methods: ['GET', 'POST'],
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $medicament = new Medicament();
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($medicament);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_medicament_controlleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_medicament_controlleur/new.html.twig', [
            'medicament' => $medicament,
            'form' => $form,
        ]);
    }

    #[Route(
        '/{id}/{_locale}',
        name: 'app_admin_medicament_controlleur_show',
        methods: ['GET'],
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function show(Medicament $medicament): Response
    {
        return $this->render('admin_medicament_controlleur/show.html.twig', [
            'medicament' => $medicament,
        ]);
    }

    #[Route(
        '/{id}/edit/{_locale}',
        name: 'app_admin_medicament_controlleur_edit',
        methods: ['GET', 'POST'],
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function edit(Request $request, Medicament $medicament, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_medicament_controlleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_medicament_controlleur/edit.html.twig', [
            'medicament' => $medicament,
            'form' => $form,
        ]);
    }

    #[Route(
        '/{id}/{_locale}',
        name: 'app_admin_medicament_controlleur_delete',
        methods: ['POST'],
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function delete(Request $request, Medicament $medicament, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $medicament->getId(), $request->request->get('_token'))) {
            $entityManager->remove($medicament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_medicament_controlleur_index', [], Response::HTTP_SEE_OTHER);
    }
}
