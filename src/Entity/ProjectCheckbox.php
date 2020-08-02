<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ProjectCheckbox
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * @var bool|null
     */
    private $isDone;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="projectCheckLists")
     * @var \App\Entity\Project|null
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity=Checkbox::class, inversedBy="projectCheckboxes")
     * @var \App\Entity\Checkbox|null
     */
    private $checkbox;

    public function getIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
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
}
