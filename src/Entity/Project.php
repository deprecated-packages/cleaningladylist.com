<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private ?UuidInterface $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private ?string $title;

    /**
     * @ORM\OneToMany(targetEntity=Checklist::class, mappedBy="project")
     * @var Checklist[]|Collection
     */
    private $checklists = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private ?string $currentFramework;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private ?string $currentPhpVersion;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private ?string $desiredFramework;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private ?string $desiredPhpVersion;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTimeInterface
     */
    private ?DateTimeInterface $dateTime;

    public function __construct()
    {
        $this->dateTime = new DateTime();
        $this->id = Uuid::uuid4();
        $this->checklists = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Collection|Checklist[]
     */
    public function getChecklists(): Collection
    {
        return $this->checklists;
    }

    public function addChecklist(Checklist $checklist): void
    {
        if (! $this->checklists->contains($checklist)) {
            $this->checklists[] = $checklist;
            $checklist->setProject($this);
        }
    }

    public function removeChecklist(Checklist $checklist): void
    {
        if ($this->checklists->contains($checklist)) {
            $this->checklists->removeElement($checklist);
            // set the owning side to null (unless already changed)
            if ($checklist->getProject() === $this) {
                $checklist->setProject(null);
            }
        }
    }

    public function getCurrentFramework(): ?string
    {
        return $this->currentFramework;
    }

    public function setCurrentFramework(string $currentFramework): void
    {
        $this->currentFramework = $currentFramework;
    }

    public function getCurrentPhpVersion(): ?string
    {
        return $this->currentPhpVersion;
    }

    public function setCurrentPhpVersion(string $currentPhpVersion): void
    {
        $this->currentPhpVersion = $currentPhpVersion;
    }

    public function getDesiredFramework(): ?string
    {
        return $this->desiredFramework;
    }

    public function setDesiredFramework(string $desiredFramework): void
    {
        $this->desiredFramework = $desiredFramework;
    }

    public function getDesiredPhpVersion(): ?string
    {
        return $this->desiredPhpVersion;
    }

    public function setDesiredPhpVersion(string $desiredPhpVersion): void
    {
        $this->desiredPhpVersion = $desiredPhpVersion;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDate(DateTimeInterface $dateTime): void
    {
        $this->dateTime = $dateTime;
    }
}
