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
     * @ORM\Column(type="string", length=255)
     */
    private $framework;

    /**
     * @ORM\OneToMany(targetEntity=Checkbox::class, mappedBy="project")
     */
    private $checkboxes;


    public function __construct()
    {
        $this->startDate = new \DateTime();
        $this->checkboxes = new ArrayCollection();
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

    public function getFramework(): ?string
    {
        return $this->framework;
    }

    public function setFramework(string $framework): self
    {
        $this->framework = $framework;

        return $this;
    }

    public function getProgress(Project $project): int
    {
        $checkTotalCount = 0;
        $checksComplete = 0;

        foreach ($project->getCheckboxes() as $check) {
            if ($check->getIsDone()) {
                $checksComplete++;
            }
            $checkTotalCount++;
        }


        dump($checkTotalCount);
        dump($checksComplete);

        if ($checkTotalCount > 0) {
            return number_format($checksComplete / $checkTotalCount * 100, 2);
        }

        return 0;
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
            $checkbox->setProject($this);
        }

        return $this;
    }

    public function removeCheckbox(Checkbox $checkbox): self
    {
        if ($this->checkboxes->contains($checkbox)) {
            $this->checkboxes->removeElement($checkbox);
            // set the owning side to null (unless already changed)
            if ($checkbox->getProject() === $this) {
                $checkbox->setProject(null);
            }
        }

        return $this;
    }

}
