<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientAddType;
use App\Repository\PatientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->manager = $managerRegistry->getManager();
    }
    #[Route('/main', name: 'app_main')]
    public function index(
        Request $request,
        PatientRepository $patientRepository
        
    ): Response {
        $patient = new Patient();
        $form = $this->createForm(PatientAddType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($patient);
            $this->manager->flush();
            $this->addFlash('success','Patient ajouter avec success');
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/index.html.twig', [
            'addForm' => $form->createView(),
            'patients' => $patientRepository->findBy([],['id' => 'DESC']),
        ]);
    }
}
