<?php

namespace App\Entity;

use App\Repository\PartyroomRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartyroomRepository::class)
 */
class Partyroom
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
     * @ORM\Column(type="string", length=255)
     */
    private $booker;

    /**
     * @ORM\Column(type="boolean")
     */
    private $validated;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      max = 15,
     *      minMessage = "Veuiller entrer plus de {{ limit }} caractères",
     *      maxMessage = "Veuiller entrer moins de {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $phoneNumber;

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

    public function getBooker(): ?string
    {
        return $this->booker;
    }

    public function setBooker(string $booker): self
    {
        $this->booker = $booker;

        return $this;
    }

    public function getValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): self
    {
        $this->validated = $validated;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
