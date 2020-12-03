<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 */
class Report
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=ReportSubject::class, mappedBy="report", orphanRemoval=true)
     */
    private $reportSubjects;

    public function __construct()
    {
        $this->reportSubjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): self
    {
        $this->document = $document;

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

    /**
     * @return Collection|ReportSubject[]
     */
    public function getReportSubjects(): Collection
    {
        return $this->reportSubjects;
    }

    public function addReportSubject(ReportSubject $reportSubject): self
    {
        if (!$this->reportSubjects->contains($reportSubject)) {
            $this->reportSubjects[] = $reportSubject;
            $reportSubject->setReport($this);
        }

        return $this;
    }

    public function removeReportSubject(ReportSubject $reportSubject): self
    {
        if ($this->reportSubjects->removeElement($reportSubject)) {
            // set the owning side to null (unless already changed)
            if ($reportSubject->getReport() === $this) {
                $reportSubject->setReport(null);
            }
        }

        return $this;
    }
}
