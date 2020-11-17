<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reported;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayed;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sentAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Comment::class, inversedBy="parentComment")
     */
    private $commentParent;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="commentParent")
     */
    private $parentComment;

    public function __construct()
    {
        $this->parentComment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getReported(): ?bool
    {
        return $this->reported;
    }

    public function setReported(bool $reported): self
    {
        $this->reported = $reported;

        return $this;
    }

    public function getDisplayed(): ?bool
    {
        return $this->displayed;
    }

    public function setDisplayed(bool $displayed): self
    {
        $this->displayed = $displayed;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt(\DateTimeInterface $sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCommentParent(): ?self
    {
        return $this->commentParent;
    }

    public function setCommentParent(?self $commentParent): self
    {
        $this->commentParent = $commentParent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParentComment(): Collection
    {
        return $this->parentComment;
    }

    public function addParentComment(self $parentComment): self
    {
        if (!$this->parentComment->contains($parentComment)) {
            $this->parentComment[] = $parentComment;
            $parentComment->setCommentParent($this);
        }

        return $this;
    }

    public function removeParentComment(self $parentComment): self
    {
        if ($this->parentComment->removeElement($parentComment)) {
            // set the owning side to null (unless already changed)
            if ($parentComment->getCommentParent() === $this) {
                $parentComment->setCommentParent(null);
            }
        }

        return $this;
    }
}
