<?php

namespace App\Controller;

use App\Entity\Follow;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FollowController extends AbstractController
{
    #[Route('/follow/{id}', name: 'follow_user')]
    public function follow(User $user, EntityManagerInterface $em): Response
    {
        $currentUser = $this->getUser();

        if ($currentUser->getId() !== $user->getId()) {
            $follow = new Follow();
            $follow->setFollower($currentUser);
            $follow->setFollowing($user);

            $em->persist($follow);
            $em->flush();
        }

        return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
    }

    #[Route('/unfollow/{id}', name: 'unfollow_user')]
    public function unfollow(User $user, EntityManagerInterface $em): Response
    {
        $currentUser = $this->getUser();
        $follow = $em->getRepository(Follow::class)->findOneBy([
            'follower' => $currentUser,
            'following' => $user,
        ]);

        if ($follow) {
            $em->remove($follow);
            $em->flush();
        }

        return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
    }
}
