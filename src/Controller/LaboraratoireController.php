<?php

namespace App\Controller;

use App\Entity\Exament;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/laboraratoire')]
class LaboraratoireController extends AbstractController
{
    private $manager;
    public function __construct(private ManagerRegistry $managerRegistry)
    {
        $this->manager = $managerRegistry->getManager();
    }
    #[Route(
        '/index/{_locale}',
        name: 'laboraratoire_index',
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function index(): Response
    {
        return $this->render('laboraratoire/index.html.twig', [
            'controller_name' => 'LaboraratoireController',
        ]);
    }
    #[Route(
        '/exam-{id}/done/{_locale}',
        name: 'laboraratoire_exam_done',
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function examDone(Exament $exament = null): Response
    {
        if ($exament) {
            $exament->setEtat(true);
            $this->manager->persist($exament);
            $this->manager->flush();
            $this->addFlash('success', 'Exament #' . $exament->getId() . ' effectuer');
        }
        return $this->redirectToRoute('laboraratoire_index');
    }
}
