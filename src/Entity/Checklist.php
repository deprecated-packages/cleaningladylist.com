<?php

namespace App\Entity;

use App\Repository\ChecklistRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChecklistRepository::class)
 */
class Checklist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="checklists")
     */
    private ?Project $project;

    /**
     * @ORM\ManyToOne(targetEntity=Checkbox::class)
     */
    private ?Checkbox $checkbox;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $isComplete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getCheckbox(): ?Checkbox
    {
        return $this->checkbox;
    }

    public function setCheckbox(?Checkbox $checkbox): self
    {
        $this->checkbox = $checkbox;

        return $this;
    }

    public function getIsComplete(): ?\DateTimeInterface
    {
        return $this->isComplete;
    }

    public function setIsComplete(?\DateTimeInterface $isComplete): self
    {
        $this->isComplete = $isComplete;

        return $this;
    }

}
