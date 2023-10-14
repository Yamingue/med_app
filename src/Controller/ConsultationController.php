<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\Exament;
use App\Entity\Ordonance;
use App\Entity\ParametreViteaux;
use App\Form\ExamentType;
use App\Form\OrdonanceType;
use App\Form\ParametreVitauxType;
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
        $exament = new Exament();
        $exament->setConsultation($consultation);
        $formExam = $this->createForm(ExamentType::class, $exament);
        $formExam->handleRequest($request);
        if ($formExam->isSubmitted()) {
           if ($formExam->isValid()) {
            
            $this->manager->persist($exament);
            $this->manager->flush();
            $this->addFlash('success',"Examents ajouter");
            return $this->redirectToRoute('consultation_details',['id'=>$consultation->getId()]);
           }else{
            $this->addFlash('error',"Incoherance sur le remplissage des exament;");
           }
        }

        $signeViteaux = $consultation->getParametreViteaux() ?? new ParametreViteaux();
        $formParam = $this->createForm(ParametreVitauxType::class, $signeViteaux);
        $formParam->handleRequest($request);
        if ($formParam->isSubmitted() && $formParam->isValid() ) 
        {
            if (!$signeViteaux->getConsultation()) {
                $signeViteaux->setConsultation($consultation);
            }
            $this->manager->persist($signeViteaux);
            $this->manager->flush();
            $this->addFlash('success',"Signeaux viteaux enregistrer");
        }
        return $this->render('consultation/details.html.twig', [
            'ordonnaces' => $consultation->getOrdonances(),
            'examents' => $consultation->getExaments(),
            'form' => $form->createView(),
            'formExam' => $formExam->createView(),
            'formParam' => $formParam->createView(),
        ]);
    }
}
