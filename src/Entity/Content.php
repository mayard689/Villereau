<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContentRepository::class)
 */
class Content
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=NewspaperSubject2::class, mappedBy="content", orphanRemoval=true)
     */
    private $newspaperSubject2s;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->newspaperSubject2s = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|NewspaperSubject2[]
     */
    public function getNewspaperSubject2s(): Collection
    {
        return $this->newspaperSubject2s;
    }

    public function addNewspaperSubject2(NewspaperSubject2 $newspaperSubject2): self
    {
        if (!$this->newspaperSubject2s->contains($newspaperSubject2)) {
            $this->newspaperSubject2s[] = $newspaperSubject2;
            $newspaperSubject2->setContent($this);
        }

        return $this;
    }

    public function removeNewspaperSubject2(NewspaperSubject2 $newspaperSubject2): self
    {
        if ($this->newspaperSubject2s->removeElement($newspaperSubject2)) {
            // set the owning side to null (unless already changed)
            if ($newspaperSubject2->getContent() === $this) {
                $newspaperSubject2->setContent(null);
            }
        }

        return $this;
    }
}
