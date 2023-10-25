<?php

namespace App\Controller;

use App\Entity\ExamItem;
use App\Form\ExamItemType;
use App\Repository\ExamItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/exam/item')]
class ExamItemController extends AbstractController
{
    #[Route(
        '/{_locale}',
        name: 'app_exam_item_index',
        methods: ['GET'],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function index(ExamItemRepository $examItemRepository): Response
    {
        return $this->render('exam_item/index.html.twig', [
            'exam_items' => $examItemRepository->findAll(),
        ]);
    }

    #[Route(
        '/new/{_locale}',
        name: 'app_exam_item_new',
        methods: ['GET', 'POST'],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $examItem = new ExamItem();
        $form = $this->createForm(ExamItemType::class, $examItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($examItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_exam_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exam_item/new.html.twig', [
            'exam_item' => $examItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exam_item_show', methods: ['GET'])]
    public function show(ExamItem $examItem): Response
    {
        return $this->render('exam_item/show.html.twig', [
            'exam_item' => $examItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exam_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExamItem $examItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExamItemType::class, $examItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exam_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exam_item/edit.html.twig', [
            'exam_item' => $examItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exam_item_delete', methods: ['POST'])]
    public function delete(Request $request, ExamItem $examItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $examItem->getId(), $request->request->get('_token'))) {
            $entityManager->remove($examItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exam_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
