<?php

namespace App\Entity;

use App\Repository\NewspaperSubjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewspaperSubjectRepository::class)
 */
class NewspaperSubject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Newspaper::class, inversedBy="newspaperSubjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $newspaper;

    /**
     * @ORM\Column(type="text")
     */
    private $title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNewspaper(): ?Newspaper
    {
        return $this->newspaper;
    }

    public function setNewspaper(?Newspaper $newspaper): self
    {
        $this->newspaper = $newspaper;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
