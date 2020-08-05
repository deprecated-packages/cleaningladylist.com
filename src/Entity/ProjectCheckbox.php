<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

/**
 * @ORM\Entity()
 */
class ProjectCheckbox
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="projectCheckboxes")
     * @var Project
     */
    private Project $project;

    /**
     * @ORM\ManyToMany(targetEntity=Checkbox::class, inversedBy="projectCheckboxes")
     * @var Checkbox|ArrayCollection
     */
    private ArrayCollection $checkboxes;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    private DateTime $isComplete;

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

    public function getIsComplete(): ?DateTimeInterface
    {
        return $this->isComplete;
    }

    public function setIsComplete(DateTime $dateTime): self
    {
        $this->isComplete = $dateTime;

        return $this;
    }
}
