<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProjectCheckbox;
use App\Exception\ShouldNotHappenException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class ProjectCheckboxRepository
{
    private EntityManagerInterface $entityManager;

    /**
     * @var ObjectRepository<ProjectCheckbox>
     */
    private ObjectRepository $objectRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(ProjectCheckbox::class);
    }

    public function get(int $projectCheckboxId): ProjectCheckbox
    {
        $projectCheckbox = $this->objectRepository->find($projectCheckboxId);
        if ($projectCheckbox === null) {
            throw new ShouldNotHappenException();
        }

        return $projectCheckbox;
    }

    public function persist(ProjectCheckbox $projectCheckbox): void
    {
        $this->entityManager->persist($projectCheckbox);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function save(?ProjectCheckbox $projectCheckbox): void
    {
        $this->entityManager->persist((object) $projectCheckbox);
        $this->entityManager->flush();
    }
}
