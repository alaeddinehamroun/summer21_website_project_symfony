<?php

namespace App\Entity;

use App\Repository\PostRepository;
use App\Utilities\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Post
{
    use TimeStampTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="post")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=RatingInfo::class, mappedBy="post")
     */
    private $ratingInfos;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->ratingInfos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RatingInfo[]
     */
    public function getRatingInfos(): Collection
    {
        return $this->ratingInfos;
    }

    public function addRatingInfo(RatingInfo $ratingInfo): self
    {
        if (!$this->ratingInfos->contains($ratingInfo)) {
            $this->ratingInfos[] = $ratingInfo;
            $ratingInfo->setPost($this);
        }

        return $this;
    }

    public function removeRatingInfo(RatingInfo $ratingInfo): self
    {
        if ($this->ratingInfos->removeElement($ratingInfo)) {
            // set the owning side to null (unless already changed)
            if ($ratingInfo->getPost() === $this) {
                $ratingInfo->setPost(null);
            }
        }

        return $this;
    }




}
