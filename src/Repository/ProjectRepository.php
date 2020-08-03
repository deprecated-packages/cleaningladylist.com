<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class ProjectRepository
{
    /**
     * @var EntityRepository<Project>
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Project::class);
    }
}
