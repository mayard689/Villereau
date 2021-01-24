<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 * @Vich\Uploadable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="report_document", fileNameProperty="document", size="documentSize")
     *
     * @var File|null
     */
    private $documentFile;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int|null
     */
    private $documentSize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $annex;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="report_document", fileNameProperty="annex", size="annexSize")
     *
     * @var File|null
     */
    private $annexFile;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int|null
     */
    private $annexSize;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setDocumentFile(?File $documentFile = null): void
    {
        $this->documentFile = $documentFile;

        if (null !== $documentFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getDocumentFile(): ?File
    {
        return $this->documentFile;
    }

    public function setDocumentSize(?int $documentSize): void
    {
        $this->documentSize = $documentSize;
    }

    public function getDocumentSize(): ?int
    {
        return $this->documentSize;
    }

    public function getAnnex(): ?string
    {
        return $this->annex;
    }

    public function setAnnex(?string $annex): self
    {
        $this->annex = $annex;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setAnnexFile(?File $annexFile = null): void
    {
        $this->annexFile = $annexFile;

        if (null !== $annexFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getAnnexFile(): ?File
    {
        return $this->annexFile;
    }

    public function setAnnexSize(?int $annexSize): void
    {
        $this->annexSize = $annexSize;
    }

    public function getAnnexSize(): ?int
    {
        return $this->annexSize;
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
