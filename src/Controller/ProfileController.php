<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function pricing(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/profilecompany', name: 'app_profilecompany')]
    public function company(Request $request)
    {
        return $this->render('profile/company.html.twig',[
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/profileqr', name: 'app_profileqr')]
    public function qr(Request $request)
    {
        return $this->render('profile/qr.html.twig',[
            'controller_name' => 'ProfileController',
        ]);
    }
}