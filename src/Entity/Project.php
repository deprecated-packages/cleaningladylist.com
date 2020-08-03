<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProjectRepository;
use App\Entity\Checklist;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @var \Ramsey\Uuid\UuidInterface|null
     */
    private ?UuidInterface $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private ?string $title;

    /**
     * @ORM\OneToMany(targetEntity=Checklist::class, mappedBy="project")
     * @var Checklist::class []|\Doctrine\Common\Collections\Collection
     */
    private $checklists;

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
    private ?DateTimeInterface $date;

    public function __construct()
    {
        $this->date = new DateTime();
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

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Checklist[]
     */
    public function getChecklists(): Collection
    {
        return $this->checklists;
    }

    public function addChecklist(Checklist $checklist): self
    {
        if (! $this->checklists->contains($checklist)) {
            $this->checklists[] = $checklist;
            $checklist->setProject($this);
        }

        return $this;
    }

    public function removeChecklist(Checklist $checklist): self
    {
        if ($this->checklists->contains($checklist)) {
            $this->checklists->removeElement($checklist);
            // set the owning side to null (unless already changed)
            if ($checklist->getProject() === $this) {
                $checklist->setProject(null);
            }
        }

        return $this;
    }

    public function getCurrentFramework(): ?string
    {
        return $this->currentFramework;
    }

    public function setCurrentFramework(string $currentFramework): self
    {
        $this->currentFramework = $currentFramework;

        return $this;
    }

    public function getCurrentPhpVersion(): ?string
    {
        return $this->currentPhpVersion;
    }

    public function setCurrentPhpVersion(string $currentPhpVersion): self
    {
        $this->currentPhpVersion = $currentPhpVersion;

        return $this;
    }

    public function getDesiredFramework(): ?string
    {
        return $this->desiredFramework;
    }

    public function setDesiredFramework(string $desiredFramework): self
    {
        $this->desiredFramework = $desiredFramework;

        return $this;
    }

    public function getDesiredPhpVersion(): ?string
    {
        return $this->desiredPhpVersion;
    }

    public function setDesiredPhpVersion(string $desiredPhpVersion): self
    {
        $this->desiredPhpVersion = $desiredPhpVersion;

        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
