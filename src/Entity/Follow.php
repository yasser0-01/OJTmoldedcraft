<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FollowRepository;

#[ORM\Entity(repositoryClass: FollowRepository::class)]
class Follow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'following')]
    #[ORM\JoinColumn(nullable: false)]
    private $follower;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'followers')]
    #[ORM\JoinColumn(nullable: false)]
    private $followee;

    public function getFollower(): ?User
    {
        return $this->follower;
    }

    public function setFollower(?User $follower): self
    {
        $this->follower = $follower;

        return $this;
    }

    public function getFollowee(): ?User
    {
        return $this->followee;
    }

    public function setFollowee(?User $followee): self
    {
        $this->followee = $followee;

        return $this;
    }
}