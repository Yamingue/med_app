<?php

namespace App\Controller\api;

use App\Entity\Exament;
use App\Entity\ExamItem;
use App\Entity\ResultatExam;
use App\Repository\ExamentRepository;
use App\Repository\ExamItemRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiResultController extends AbstractController
{
    private $manager;
    public function __construct(private ManagerRegistry $managerRegistry)
    {
        $this->manager = $managerRegistry->getManager();
    }
    #[Route('/api/result', name: 'app_api_result_index')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiResultController.php',
        ]);
    }

    #[Route('/api/result_add/{id}', name: 'api_result_add')]
    public function add(
        Request $request,
        ExamItemRepository $examItemRepository,
        Exament $exament = null,
    ): JsonResponse {
        $content = json_decode($request->getContent(), true)['items'];
        foreach ($content as $c) {
            $it = new ResultatExam();
            $it->setItem($examItemRepository->find($c['id']));
            $it->setExamen($exament);
            $it->setValeur($c['valeur']);
            $this->manager->persist($it);
        }
        $exament->setEtat(true);
        $this->manager->persist($exament);
        $this->manager->flush();
        return $this->json([
            'code' => 200,
            'path' => 'Message save',
        ]);
    }
}
