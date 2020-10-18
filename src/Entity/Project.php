<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\DateTime;
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

    /**
     * @ORM\OneToMany(targetEntity=ProjectCheckbox::class, mappedBy="project")
     * @var Collection<int, ProjectCheckbox>|ProjectCheckbox[]
     */
    private $projectCheckboxes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $timezone;

    public function __construct()
    {
        $this->dateTime = DateTime::from('now');
        $this->id = Uuid::uuid4();
        $this->projectCheckboxes = new ArrayCollection();
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

    /**
     * @return Collection<int, ProjectCheckbox>|ProjectCheckbox[]
     */
    public function getProjectCheckboxes(): Collection
    {
        return $this->projectCheckboxes;
    }

    public function addProjectCheckbox(ProjectCheckbox $projectCheckbox): void
    {
        if ($this->projectCheckboxes->contains($projectCheckbox)) {
            return;
        }

        $this->projectCheckboxes->add($projectCheckbox);
        $projectCheckbox->setProject($this);
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): void
    {
        $this->timezone = $timezone;
    }
}
