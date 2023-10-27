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
    #[Route(
        '/{_locale}',
        defaults: ["_locale" => "ar"],
        name: 'app_index',
        requirements: ["_locale" => "fr|en|ar"]
    )]
    public function index()
    {
        /**@var User */
        $user = $this->getUser();
        if ($user && in_array('ROLE_LABORATOIRE', $user->getRoles())) {
            return $this->redirectToRoute('laboraratoire_index');
        }
        if ($user && in_array('ROLE_PHARMATIE', $user->getRoles())) {
            return $this->redirectToRoute('app_admin_medicament_controlleur_index');
        }
        if ($user && in_array('ROLE_PHARMATIE', $user->getRoles())) {
            return $this->redirectToRoute('app_admin_medicament_controlleur_index');
        }
        return $this->redirectToRoute('app_main');
    }
}
