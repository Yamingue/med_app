<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\Exament;
use App\Entity\ParametreViteaux;
use App\Entity\Remarque;
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
    #[Route(
        '/consultation/{_locale}',
        name: 'consultation',
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function index(): Response
    {
        return $this->render('consultation/index.html.twig', [
            'controller_name' => 'ConsultationController',
        ]);
    }

    #[Route(
        '/consultation/{id}/more/{_locale}',
        name: 'consultation_details',
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function details(Consultation $consultation, Request $request): Response
    {

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
            'formParam' => $formParam->createView(),
            'formComment' => $formComment->createView(),
        ]);
    }

    #[Route(
        '/consultation/{id}/add_exam/{_locale}',
        name: 'consultation_add_exam',
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function add_exam(Consultation $consultation)
    {
        return $this->render('consultation/add_exam.html.twig', [
            'consultation' => $consultation,
        ]);
    }

    #[Route(
        '/consultation/{id}/remove/{_locale}',
        name: 'consultation_remove',
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function remove(Consultation $consultation = null)
    {
        if ($consultation) {
            $patientId = $consultation->getPatient()->getId();
            $this->manager->remove($consultation);
            $this->manager->flush();
            return $this->redirectToRoute('patient_detail', ['id' => $patientId]);
        }
        return $this->redirectToRoute('app_main');
    }

    #[Route(
        '/exam/{id}/remove/{_locale}',
        name: 'exam_remove',
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function remove_exam(Exament $exament = null)
    {
        if ($exament) {
            $this->manager->remove($exament);
            $this->manager->flush();
        }
        return $this->redirectToRoute('app_main');
    }

    #[Route(
        '/consultation/{id}/add_ordonnace',
        name: 'consultation_add_ordonnace',
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function add_ordonnace(Consultation $consultation)
    {
        return $this->render('consultation/add_ordonnace.html.twig', [
            'consultation' => $consultation,
        ]);
    }
}
