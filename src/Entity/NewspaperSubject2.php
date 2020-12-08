<?php

namespace App\Entity;

use App\Repository\NewspaperSubject2Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewspaperSubject2Repository::class)
 */
class NewspaperSubject2
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Content::class, inversedBy="newspaperSubject2s")
     * @ORM\JoinColumn(nullable=false)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Newspaper2::class, inversedBy="newspaperSubject2s")
     * @ORM\JoinColumn(nullable=false)
     */
    private $newspaper2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?Content
    {
        return $this->content;
    }

    public function setContent(?Content $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getNewspaper2(): ?Newspaper2
    {
        return $this->newspaper2;
    }

    public function setNewspaper2(?Newspaper2 $newspaper2): self
    {
        $this->newspaper2 = $newspaper2;

        return $this;
    }
}
