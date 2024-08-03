<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ProfilecardController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    #[Route('/profilecard', name: 'app_profilecard')]
    public function index(): Response
    {
        $data = $this->doctrine->getRepository(User::class)->findAll();
        return $this->render('profilecard/index.html.twig', [
            'controller_name' => 'ProfilecardController',
            'list' => $data
        ]);
    }

    #[Route('/viewprofile/{id}', name: 'app_viewprofile')]
    public function viewProfile(int $id): Response
    {
        $user = $this->doctrine->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        return $this->render('profilecard/pccompany.html.twig', [
            'controller_name' => 'ProfilecardController',
            'user' => $user,
        ]);
    }

    #[Route('/viewprofilepersonal/{id}', name: 'app_viewprofilepersonal')]
    public function viewPersonal(int $id): Response
    {
        $user = $this->doctrine->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        return $this->render('profilecard/pcpersonal.html.twig', [
            'controller_name' => 'ProfilecardController',
            'user' => $user,
        ]);
    }

    #[Route('/viewprofileqr/{id}', name: 'app_viewprofileqr')]
    public function viewQr(int $id): Response
    {
        $user = $this->doctrine->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        return $this->render('profilecard/pcqr.html.twig', [
            'controller_name' => 'ProfilecardController',
            'user' => $user,
        ]);
    }
}