<?php

namespace App\Controller;

use App\Entity\Exament;
use App\Entity\Patient;
use App\Form\PatientAddType;
use App\Repository\PatientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->manager = $managerRegistry->getManager();
    }
    #[Route(
        '/main/{_locale}',
        name: 'app_main',
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
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
            $this->addFlash('success', 'Patient ajouter avec success');
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/index.html.twig', [
            'addForm' => $form->createView(),
            'patients' => $patientRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route(
        '/main/paye_exam-{id}/{_locale}',
        name: 'app_main_paye_xam',
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function payeExam(Exament $exament = null, Request $request)
    {
        if ($exament) {
            $exament->setIsPayed(true);
            $exament->setPayeAt(new \DateTimeImmutable());
            $this->manager->persist($exament);
            $this->manager->flush();
            $this->addFlash('success', 'examen #' . $exament->getId() . ' has been payed');
        }
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route(
        '/main/paye_discount_exam-{id}/{_locale}',
        name: 'app_main_paye_xam_discount',
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function payeExamWithDiscount(Exament $exament = null, Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('montant', NumberType::class, [
                'label' => 'Montant du rabais',
            ])
            ->add('Valider', SubmitType::class, [
                'label' => 'Valider le rabais',
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $montant = $form->get('montant')->getData();
            $exament->setDiscount($montant);
            $exament->setIsPayed(true);
            $this->manager->persist($exament);
            $this->manager->flush();
            $this->addFlash('success', 'Rabais effectuer');
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/discount.html.twig', [
            'form' => $form->createView(),
            'exament' => $exament,
        ]);
    }


    #[Route(
        '/main/print_exam-{id}/{_locale}',
        name: 'print_exam',
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function printExam(
        Exament $exament = null,
        Request $request
    ) {
        $referer = $request->headers->get('referer');

        return $this->render('main/print_exam.html.twig', [
            'exament' => $exament,
            'referer' => $referer,
            'payed' => $exament->isIsPayed(),
        ]);
    }
}
