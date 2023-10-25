<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminStateController extends AbstractController
{
    #[Route('/admin/state', name: 'app_admin_state')]
    public function index(): Response
    {
        return $this->render('admin_state/index.html.twig', [
            'controller_name' => 'AdminStateController',
        ]);
    }
}
