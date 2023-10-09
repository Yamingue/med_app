<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Repository\ConsultationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PatientController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->manager = $managerRegistry->getManager();
    }
    
    #[Route('/patient', name: 'patient')]
    public function index(): Response
    {
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }

    #[Route('/patient/{id}', name: 'patient_detail')]
    public function detail(
        Request $request,
        ConsultationRepository $consultationRepository,
        Patient $patient = null
        ): Response
    {
        if ($patient == null) {
            return $this->redirectToRoute('patient');
        }
        $consultation = new Consultation();
        $consultation->setPatient($patient);
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($consultation);
            $this->manager->flush();
            $this->addFlash('success','Consultation ajouter avec success');
            return $this->redirectToRoute('patient_detail',['id'=>$patient->getId()]);
        }
        return $this->render('patient/details.html.twig', [
            'form' => $form->createView(),
            'consultations' => $consultationRepository->findBy(['patient' => $patient],['id' => 'DESC']),
        ]);
    }
}