<?php

namespace App\Controller\api;

use App\Entity\Exament;
use App\Entity\ExamItem;
use App\Entity\Consultation;
use App\Repository\ExamItemRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExamtItemController extends AbstractController
{
    private $manager;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->manager = $managerRegistry->getManager();
    }
    #[Route('/api/exament', name: 'app_examt_item', methods: ['GET'])]
    public function index(ExamItemRepository $examItemRepository): JsonResponse
    {

        return $this->json($examItemRepository->findAll(), context: [
            "groups" => ["exam_item_read"]
        ]);
    }

    #[Route('/api/exament', name: 'app_examt_query', methods: ['POST'])]
    public function query(ExamItemRepository $examItemRepository, Request $request): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $query = $content['query'];
        $examts = $examItemRepository->findByQuery($query);

        return $this->json($examts, context: [
            "groups" => ["exam_item_read"]
        ]);
    }

    #[Route('/api/exament_add/consultation/{id}', name: 'add_examt_consul', methods: ['POST'])]
    public function addManyToConsultaion(
        Consultation $consultation,
        Request $request,
        ExamItemRepository $examItemRepository,
    ): JsonResponse {
        $content = json_decode($request->getContent(), true);
        $query = $content['examts'];
        $examt = new Exament();
        $examt->setConsultation($consultation);
        foreach ($query as $item) {
            $examt->addItem($examItemRepository->find($item['id']));
        }
        $this->manager->persist($examt);
        $this->manager->flush();
        $this->addFlash('success', 'Exament ajouter');
        return $this->json([
            "success" => true,
            "message" => "examt added to consultation",
        ]);
    }
}
