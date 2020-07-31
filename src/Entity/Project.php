<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projects")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ProjectCheckbox::class, mappedBy="project")
     */
    private $projectCheckLists;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currentFramework;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $desiredFramework;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currentPhpVersion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $desiredPhpVersion;

    /**
     * @ORM\Column(type="integer")
     */
    private $CheckboxCount;


    public function __construct()
    {
        $this->startDate = new \DateTime();
        $this->projectCheckLists = new ArrayCollection();
    }


    public function getId(): ?int
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProgress(Project $project): int
    {
        $checksComplete = 0;

        foreach ($project->getProjectCheckLists() as $check) {
            if ($check->getIsDone()) {
                $checksComplete++;
            }
        }

        return number_format($checksComplete / $this->getCheckboxCount() * 100, 2);
    }

    /**
     * @return Collection|ProjectCheckbox[]
     */
    public function getProjectCheckLists(): Collection
    {
        return $this->projectCheckLists;
    }

    public function addProjectCheckList(ProjectCheckbox $projectCheckList): self
    {
        if (!$this->projectCheckLists->contains($projectCheckList)) {
            $this->projectCheckLists[] = $projectCheckList;
            $projectCheckList->setProject($this);
        }

        return $this;
    }

    public function removeProjectCheckList(ProjectCheckbox $projectCheckList): self
    {
        if ($this->projectCheckLists->contains($projectCheckList)) {
            $this->projectCheckLists->removeElement($projectCheckList);
            // set the owning side to null (unless already changed)
            if ($projectCheckList->getProject() === $this) {
                $projectCheckList->setProject(null);
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

    public function getDesiredFramework(): ?string
    {
        return $this->desiredFramework;
    }

    public function setDesiredFramework(string $desiredFramework): self
    {
        $this->desiredFramework = $desiredFramework;

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

    public function getDesiredPhpVersion(): ?string
    {
        return $this->desiredPhpVersion;
    }

    public function setDesiredPhpVersion(string $desiredPhpVersion): self
    {
        $this->desiredPhpVersion = $desiredPhpVersion;

        return $this;
    }

    public function getCheckboxCount(): ?int
    {
        return $this->CheckboxCount;
    }

    public function setCheckboxCount(int $CheckboxCount): self
    {
        $this->CheckboxCount = $CheckboxCount;

        return $this;
    }


}
