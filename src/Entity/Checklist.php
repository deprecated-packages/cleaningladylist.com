<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Checklist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
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
     * @var DateTimeInterface|null
     */
    private $completedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): void
    {
        $this->project = $project;
    }

    public function getCheckbox(): ?Checkbox
    {
        return $this->checkbox;
    }

    public function setCheckbox(?Checkbox $checkbox): void
    {
        $this->checkbox = $checkbox;
    }

    public function getCompleteAt(): ?DateTimeInterface
    {
        return $this->completedAt;
    }

    public function setCompleteAt(?DateTimeInterface $completedAt): void
    {
        $this->completedAt = $completedAt;
    }
}
