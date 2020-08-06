<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProjectCheckbox;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;


final class ProjectCheckboxRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist(ProjectCheckbox $projectCheckbox): void
    {
        $this->entityManager->persist($projectCheckbox);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function save(ProjectCheckbox $projectCheckbox): void
    {
        $this->entityManager->persist($projectCheckbox);
        $this->entityManager->flush();
    }
}
