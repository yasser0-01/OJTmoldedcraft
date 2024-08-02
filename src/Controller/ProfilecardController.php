<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilecardController extends AbstractController
{
    #[Route('/profilecard', name: 'app_profilecard')]
    public function index(): Response
    {
        return $this->render('profilecard/index.html.twig', [
            'controller_name' => 'ProfilecardController',
        ]);
    }
}
