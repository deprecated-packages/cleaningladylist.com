<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Checkbox
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private ?int $id;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private ?string $task;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private ?string $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $framework;

    /**
     * @ORM\ManyToMany(targetEntity=ProjectCheckbox::class, mappedBy="checkboxes")
     * @var ProjectCheckbox|Collection
     */
    private Collection $projectCheckboxes;

    public function __construct()
    {
        $this->projectCheckboxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): void
    {
        $this->task = $task;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getFramework(): ?string
    {
        return $this->framework;
    }

    public function setFramework(?string $framework): void
    {
        $this->framework = $framework;
    }

    /**
     * @return Collection|ProjectCheckbox[]
     */
    public function getProjectCheckboxes(): Collection
    {
        return $this->projectCheckboxes;
    }

    public function addProjectCheckbox(ProjectCheckbox $projectCheckbox): self
    {
        if (! $this->projectCheckboxes->contains($projectCheckbox)) {
            $this->projectCheckboxes[] = $projectCheckbox;
            $projectCheckbox->addCheckbox($this);
        }

        return $this;
    }

    public function removeProjectCheckbox(ProjectCheckbox $projectCheckbox): self
    {
        if ($this->projectCheckboxes->contains($projectCheckbox)) {
            $this->projectCheckboxes->removeElement($projectCheckbox);
            $projectCheckbox->removeCheckbox($this);
        }

        return $this;
    }
}
