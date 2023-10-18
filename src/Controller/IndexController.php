<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    #[Route('/', name: 'app_index')]
    public function index()
    {
        /**@var User */
        $user = $this->getUser();
        if ($user &&  $user->getRole() == 'LABORATOIRE') {
           return $this->redirectToRoute('laboraratoire_index');
        }
        return $this->redirectToRoute('app_main');
    }
}
