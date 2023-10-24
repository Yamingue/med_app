<?php

namespace App\Controller\api;

use App\Entity\Exament;
use App\Entity\Consultation;
use App\Entity\Ordonance;
use App\Repository\ExamItemRepository;
use App\Repository\MedicamentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrdonnanceController extends AbstractController
{
    private $manager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->manager = $managerRegistry->getManager();
    }
    #[Route('/api/ordances', name: 'app_med_item', methods: ['GET'])]
    public function index(MedicamentRepository $medicamentRepository): JsonResponse
    {

        return $this->json($medicamentRepository->findAll(), context: [
            "groups" => ["ordance_read"]
        ]);
    }

    #[Route('/api/ordonnance', name: 'app_med_query', methods: ['POST'])]
    public function query(MedicamentRepository $medicamentRepository, Request $request): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $query = $content['query'];
        $medicaments = $medicamentRepository->findByQuery($query);

        return $this->json($medicaments, context: [
            "groups" => ["ordance_read"]
        ]);
    }

    #[Route('/api/ordonnace/consultation/{id}', name: 'add_ordonnace_consul', methods: ['POST'])]
    public function addManyToConsultaion(
        Consultation $consultation,
        Request $request,
        MedicamentRepository $medicamentRepository,
    ): JsonResponse {
        $content = json_decode($request->getContent(), true);
        $query = $content['ordonnaces'];
        $ordonnance = new Ordonance();
        $ordonnance->setConsulatation($consultation);
        foreach ($query as $item) {
            $ordonnance->addItem($medicamentRepository->find($item['id']));
        }
        $this->manager->persist($ordonnance);
        $this->manager->flush();
        $this->addFlash('success', 'Ordonnance ajouter');
        return $this->json([
            "success" => true,
            "message" => "examt added to consultation",
        ]);
    }
}
