<?php

namespace App\Controller;

use App\Form\PatientAddType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        $form = $this->createForm(PatientAddType::class);
        return $this->render('main/index.html.twig', [
            'addForm' => $form->createView(),
        ]);
    }
}
