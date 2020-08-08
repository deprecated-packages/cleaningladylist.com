<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ProjectCheckbox
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="projectCheckboxes")
     */
    private ?Project $project;

    /**
     * @ORM\ManyToMany(targetEntity=Checkbox::class, inversedBy="projectCheckboxes")
     * @var iterable<Checkbox>&Collection
     */
    private $checkboxes;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $completedAt;

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

    public function setProject(Project $project): self
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
        if (! $this->checkboxes->contains($checkbox)) {
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

    public function inverseCompleteAt(): void
    {
        if ($this->completedAt === null) {
            $this->completedAt = new DateTime();
            return;
        }

        $this->completedAt = null;
    }

    public function getCompleteAtAsString(): string
    {
        if ($this->completedAt !== null) {
            return $this->completedAt->format('Y-m-d');
        }

        return '';
    }
}
