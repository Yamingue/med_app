<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminStateController extends AbstractController
{
    #[Route(
        '/admin/state/{_locale}',
        name: 'app_admin_state',
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function index(): Response
    {
        return $this->render('admin_state/index.html.twig', [
            'controller_name' => 'AdminStateController',
        ]);
    }
}
