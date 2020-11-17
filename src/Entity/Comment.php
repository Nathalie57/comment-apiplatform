<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ApiResource(
 *  collectionOperations={"GET", "POST"},
 *  itemOperations={
 *      "GET", 
 *      "DELETE"={"security"="object.getUser() == user"},
 *      "report"={
 *          "method"="PUT",
 *          "path"="/comments/{id}/report",
 *          "controller"="App\Controller\ReportCommentController",
 *          "openapi_context"={
 *              "summary"="Report a comment"
 *          }
 *      },
 *      "validReport"={
 *          "method"="PUT",
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "path"="/comments/{id}/validReport",
 *          "controller"="App\Controller\ValidReportCommentController",
 *          "openapi_context"={
 *              "summary"="Validate a reported comment"
 *          }
 *      }
 *  },
 *  attributes={
 *      "order"={"sentAt":"ASC"}
 *  },
 *  normalizationContext={
 *      "groups"={"comments_read"}
 *  },
 * )
 * @ApiFilter(SearchFilter::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comments_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"comments_read"})
     * @Assert\NotBlank(message="Le message est obligatoire")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"comments_read"})
     */
    private $reported;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"comments_read"})
     */
    private $displayed;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"comments_read"})
     * @Assert\NotBlank(message="La date est obligatoire")
     */
    private $sentAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comments_read"})
     * @Assert\NotBlank(message="Le nom de l'utilisateur est obligatoire")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Comment::class, inversedBy="parentComment")
     * @Groups({"comments_read"})
     */
    private $commentParent;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="commentParent")
     * @Groups({"comments_read"})
     */
    private $parentComment;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
