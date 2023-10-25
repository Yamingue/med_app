<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route(
        '/index/{_locale}',
        name: 'app_index',
        defaults: ["_locale" => "ar"],
        requirements: ["_locale" => "fr|en|ar"]
    )]
    #[Route('/{_locale}', name: 'app_index', requirements: ["_locale" => "fr|en|ar"])]
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
