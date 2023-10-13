<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\Ordonance;
use App\Form\ExamentType;
use App\Form\OrdonanceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultationController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->manager = $managerRegistry->getManager();
    }  
    #[Route('/consultation', name: 'consultation')]
    public function index(): Response
    {
        return $this->render('consultation/index.html.twig', [
            'controller_name' => 'ConsultationController',
        ]);
    }

    #[Route('/consultation/{id}/more', name: 'consultation_details')]
    public function details(Consultation $consultation, Request $request): Response
    {
        $ordonnace = new Ordonance();
        $ordonnace->setConsulatation($consultation);
        $form = $this->createForm(OrdonanceType::class, $ordonnace);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($ordonnace);
            $this->manager->flush();
            $this->addFlash('success','Ordonnance ajouter avec success');
            return $this->redirectToRoute('consultation_details',['id'=>$consultation->getId()]);
        }

        $formExam = $this->createForm(ExamentType::class);
        return $this->render('consultation/details.html.twig', [
            'form' => $form->createView(),
            'ordonnaces' => $consultation->getOrdonances(),
            'formExam'=>$formExam->createView()
        ]);
    }
}
