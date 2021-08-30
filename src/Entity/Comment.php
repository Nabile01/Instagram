<?php

namespace App\Entity;

use App\Repository\CommentRepository;
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
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_post;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_like;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_parent_comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getIdPost(): ?int
    {
        return $this->id_post;
    }

    public function setIdPost(int $id_post): self
    {
        $this->id_post = $id_post;

        return $this;
    }

    public function getIdLike(): ?int
    {
        return $this->id_like;
    }

    public function setIdLike(?int $id_like): self
    {
        $this->id_like = $id_like;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIdParentComment(): ?int
    {
        return $this->id_parent_comment;
    }

    public function setIdParentComment(?int $id_parent_comment): self
    {
        $this->id_parent_comment = $id_parent_comment;

        return $this;
    }
}
