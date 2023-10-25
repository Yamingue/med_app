<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LocalSwitchController extends AbstractController
{
    #[Route('/local/switch/{_locale}', name: 'app_local_switch', requirements: ["_locale" => "fr|en|ar"])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LocalSwitchController.php',
        ]);
    }
}
