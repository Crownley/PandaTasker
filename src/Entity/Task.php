<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
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
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $positive;

    /**
     * @ORM\Column(type="integer")
     */
    private $easy;

    /**
     * @ORM\Column(type="integer")
     */
    private $medium;

    /**
     * @ORM\Column(type="integer")
     */
    private $hard;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPositive(): ?bool
    {
        return $this->positive;
    }

    public function setPositive(bool $positive): self
    {
        $this->positive = $positive;

        return $this;
    }

    public function getEasy(): ?int
    {
        return $this->easy;
    }

    public function setEasy(int $easy): self
    {
        $this->easy = $easy;

        return $this;
    }

    public function getMedium(): ?int
    {
        return $this->medium;
    }

    public function setMedium(int $medium): self
    {
        $this->medium = $medium;

        return $this;
    }

    public function getHard(): ?int
    {
        return $this->hard;
    }

    public function setHard(int $hard): self
    {
        $this->hard = $hard;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'positive' => $this->getPositive(),
            'easy' => $this->getEasy(),
            'medium' => $this->getMedium(),
            'hard' => $this->getHard(),
            'description' => $this->getDescription()
        ];
    }
}
