<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\Exament;
use App\Entity\Ordonance;
use App\Entity\ParametreViteaux;
use App\Entity\Patient;
use App\Entity\Remarque;
use App\Form\ExamentType;
use App\Form\OrdonanceType;
use App\Form\ParametreVitauxType;
use App\Form\RemarqueType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultationController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $managerRegistry)
    {
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
            $this->addFlash('success', 'Ordonnance ajouter avec success');
            return $this->redirectToRoute('consultation_details', ['id' => $consultation->getId()]);
        }

        $signeViteaux = $consultation->getParametreViteaux() ?? new ParametreViteaux();
        $formParam = $this->createForm(ParametreVitauxType::class, $signeViteaux);
        $formParam->handleRequest($request);
        if ($formParam->isSubmitted() && $formParam->isValid()) {
            if (!$signeViteaux->getConsultation()) {
                $signeViteaux->setConsultation($consultation);
            }
            $this->manager->persist($signeViteaux);
            $this->manager->flush();
            $this->addFlash('success', "Signeaux viteaux enregistrer");
            return $this->redirectToRoute('consultation_details', ['id' => $consultation->getId()]);
        }
        $rmq = new Remarque();
        $rmq->setConsultation($consultation);
        $formComment = $this->createForm(RemarqueType::class, $rmq);
        $formComment->handleRequest($request);
        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $this->manager->persist($rmq);
            $this->manager->flush();
            $this->addFlash('success', 'Remarque ajouter');
            return $this->redirectToRoute('consultation_details', ['id' => $consultation->getId()]);
        }
        // dump(new Patient());
        return $this->render('consultation/details.html.twig', [
            'patient' => $consultation->getPatient(),
            'consultation' => $consultation,
            'ordonnaces' => $consultation->getOrdonances(),
            'examents' => $consultation->getExaments(),
            'remarques' => $consultation->getRemarques(),
            'form' => $form->createView(),
            'formParam' => $formParam->createView(),
            'formComment' => $formComment->createView(),
        ]);
    }

    #[Route('/consultation/{id}/add_exam', name: 'consultation_add_exam')]
    public function add_exam(Consultation $consultation)
    {
        return $this->render('consultation/add_exam.html.twig', [
            'consultation' => $consultation,
        ]);
    }
}
