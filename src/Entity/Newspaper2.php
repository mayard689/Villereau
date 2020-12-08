<?php

namespace App\Entity;

use App\Repository\Newspaper2Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Newspaper2Repository::class)
 */
class Newspaper2
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=NewspaperSubject2::class, mappedBy="newspaper2", orphanRemoval=true)
     */
    private $newspaperSubject2s;

    public function __construct()
    {
        $this->newspaperSubject2s = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $newspaperSubject2->setNewspaper2($this);
        }

        return $this;
    }

    public function removeNewspaperSubject2(NewspaperSubject2 $newspaperSubject2): self
    {
        if ($this->newspaperSubject2s->removeElement($newspaperSubject2)) {
            // set the owning side to null (unless already changed)
            if ($newspaperSubject2->getNewspaper2() === $this) {
                $newspaperSubject2->setNewspaper2(null);
            }
        }

        return $this;
    }

    public function getMonth() : String
    {
        $month = $this->getDate()->format('m');

        switch($month) {
            case "01":
                return "Janvier";
            case "02":
                return "Février";
            case "03":
                return "Mars";
            case "04":
                return "Avril";
            case "05":
                return "Mai";
            case "06":
                return "Juin";
            case "07":
                return "Juillet";
            case "08":
                return "Août";
            case "09":
                return "Septembre";
            case "10":
                return "Octobre";
            case "11":
                return "Novembre";
            case "12":
                return "Décembre";
        }
    }
}
