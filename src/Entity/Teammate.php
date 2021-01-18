<?php

namespace App\Entity;

use App\Repository\TeammateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TeammateRepository::class)
 */
class Teammate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Veuiller entrer plus de {{ limit }} caractères",
     *      maxMessage = "Veuiller entrer moins de {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Veuiller entrer plus de {{ limit }} caractères",
     *      maxMessage = "Veuiller entrer moins de {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Veuiller entrer plus de {{ limit }} caractères",
     *      maxMessage = "Veuiller entrer moins de {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Choice({"Maire", "Adjoint", "Conseiller", "Agent", "Secrétaire général"})
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
}
