<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

final class ProjectRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Project $project): void
    {
        $this->entityManager->persist($project);
        $this->entityManager->flush();
    }
}
