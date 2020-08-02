<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CheckListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CheckListRepository::class)
 */
class Checkbox
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $help;

    /**
     * @ORM\OneToMany(targetEntity=ProjectCheckbox::class, mappedBy="checkbox")
     * @var \Doctrine\Common\Collections\Collection<ProjectCheckbox>
     */
    private $projectCheckboxes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $framework;

    public function __construct()
    {
        $this->projectCheckboxes = new ArrayCollection();
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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getHelp(): ?string
    {
        return $this->help;
    }

    public function setHelp(?string $help): self
    {
        $this->help = $help;

        return $this;
    }

    /**
     * @return Collection<ProjectCheckbox>
     */
    public function getProjectCheckboxes(): Collection
    {
        return $this->projectCheckboxes;
    }

    public function addProjectCheckbox(ProjectCheckbox $projectCheckbox): self
    {
        if (! $this->projectCheckboxes->contains($projectCheckbox)) {
            $this->projectCheckboxes[] = $projectCheckbox;
            $projectCheckbox->setCheckbox($this);
        }

        return $this;
    }

    public function removeProjectCheckbox(ProjectCheckbox $projectCheckbox): self
    {
        if ($this->projectCheckboxes->contains($projectCheckbox)) {
            $this->projectCheckboxes->removeElement($projectCheckbox);
            // set the owning side to null (unless already changed)
            if ($projectCheckbox->getCheckbox() === $this) {
                $projectCheckbox->setCheckbox(null);
            }
        }

        return $this;
    }

    public function getFramework(): ?string
    {
        return $this->framework;
    }

    public function setFramework(?string $framework): self
    {
        $this->framework = $framework;

        return $this;
    }
}
