<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LocalSwitchController extends AbstractController
{
    #[Route('/local/switch/{_locale}', name: 'local_switch', requirements: ["_locale" => "fr|en|ar"])]
    public function index($_locale, Request $request)
    {
        $referer = $request->headers->get('referer');
        if (str_ends_with($referer, 'fr') || str_ends_with($referer, 'en') || str_ends_with($referer, 'ar')) {
            $data = explode('//', $referer);
            $data1 = explode('/', $data[1]);
            $data1[count($data1) - 1] = $_locale;
            $data[1] = implode('/', $data1);
            $referer = implode('//', $data);
        } else {
            $referer .= '/' . $_locale;
        }
        return $this->redirect($referer);
    }
}
