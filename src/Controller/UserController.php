<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    #[Route('/user/{id}', name: 'user_profile')]
    public function profile(User $user): Response
    {
        $currentUser = $this->getUser();
        
        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/follow/{id}', name: 'follow_user')]
    public function follow(User $user, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        
        if ($currentUser && $currentUser->getId() !== $user->getId() && !$currentUser->isFollowing($user)) {
            $follow = new Follow();
            $follow->setFollower($currentUser);
            $follow->setFollowed($user);

            $entityManager->persist($follow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
    }

    #[Route('/unfollow/{id}', name: 'unfollow_user')]
    public function unfollow(User $user, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();

        $follow = $entityManager->getRepository(Follow::class)->findOneBy([
            'follower' => $currentUser,
            'followed' => $user,
        ]);

        if ($follow) {
            $entityManager->remove($follow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
    }
}