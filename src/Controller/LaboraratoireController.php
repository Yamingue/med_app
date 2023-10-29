<?php

namespace App\Controller;

use App\Entity\Exament;
use App\Entity\Patient;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

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
        defaults: ["_locale" => "ar"],
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
        defaults: ["_locale" => "ar"],
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

    #[Route(
        '/exam-{id}/add_result/{_locale}',
        name: 'laboraratoire_add_result',
        defaults: ["_locale" => "ar"],
        requirements: ['id' => '\d+', "_locale" => "fr|en|ar"]
    )]
    public function add_result(Exament $exament = null): Response
    {
        $content = [];

        foreach ($exament->getItems() as $it) {
            $c = [
                'id' => $it->getId(),
                'nom' => $it->getNom(),
                'valeur' => ""
            ];
            $content[] = $c;
        }
        return $this->render('laboraratoire/add_result.html.twig', [
            'exament' => $exament,
            'items' => json_encode($content)
        ]);
    }
}
