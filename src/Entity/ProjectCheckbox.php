<?php

namespace App\Entity;

use App\Repository\ProjectCheckboxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectCheckboxRepository::class)
 */
class ProjectCheckbox
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="projectCheckboxes")
     */
    private $project;

    /**
     * @ORM\ManyToMany(targetEntity=Checkbox::class, inversedBy="projectCheckboxes")
     */
    private $checkboxes;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $isComplete;

    public function __construct()
    {
        $this->checkboxes = new ArrayCollection();
    }

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

    /**
     * @return Collection|Checkbox[]
     */
    public function getCheckboxes(): Collection
    {
        return $this->checkboxes;
    }

    public function addCheckbox(Checkbox $checkbox): self
    {
        if (!$this->checkboxes->contains($checkbox)) {
            $this->checkboxes[] = $checkbox;
        }

        return $this;
    }

    public function removeCheckbox(Checkbox $checkbox): self
    {
        if ($this->checkboxes->contains($checkbox)) {
            $this->checkboxes->removeElement($checkbox);
        }

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
