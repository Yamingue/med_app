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
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class PatientController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->manager = $managerRegistry->getManager();
    }

    #[Route(
        '/patient/{_locale}',
        name: 'patient',
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function index(): Response
    {
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'Patients',
        ]);
    }

    #[Route(
        '/patient/delete/{_locale}',
        name: 'patient_remove',
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function delete(Patient $patient = null): Response
    {
        if ($patient) {
            $this->manager->remove($patient);
            $this->manager->flush();
            $this->addFlash('success', 'Patient supprimer');
        }
        return $this->redirectToRoute('app_main');
    }

    #[Route(
        '/patient/{id<\d+>}/{_locale}',
        name: 'patient_detail',
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function detail(
        Request $request,
        ConsultationRepository $consultationRepository,
        Patient $patient = null
    ): Response {
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
            $this->addFlash('success', 'Consultation ajouter avec success');
            return $this->redirectToRoute('patient_detail', ['id' => $patient->getId()]);
        }
        return $this->render('patient/details.html.twig', [
            'form' => $form->createView(),
            'consultations' => $consultationRepository->findBy(['patient' => $patient], ['id' => 'DESC']),
            'patient' => $patient
        ]);
    }

    #[Route(
        '/patient/consultation/{id}/print/{_locale}',
        name: 'patient_print_consultation',
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function printConsultation(Consultation $consultation)
    {
        $patient = $this->json($consultation->getPatient(), context: [
            AbstractNormalizer::GROUPS => 'READ:PAIENT'
        ])->getContent();
        $consultationData = $this->json($consultation, context: [
            AbstractNormalizer::GROUPS => 'READ:CONSULTATION'
        ])->getContent();
        $type = $consultation->getType()->getNom();
        $p = $consultation->getPatient();
        return $this->render('patient/pintbook.html.twig', compact('patient', 'consultationData', 'type', 'p'));
    }
}
