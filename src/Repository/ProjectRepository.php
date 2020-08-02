<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Project;
use App\Exception\ShouldNotHappenException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class ProjectRepository
{
    /**
     * @var EntityRepository<Project>
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Project::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param mixed[] $criteria
     * @return iterable<Project>
     */
    public function findBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function find(int $project_id): Project
    {
        $project = $this->repository->find($project_id);
        if ($project === null) {
            throw new ShouldNotHappenException();
        }

        return $project;
    }

    public function save(Project $project): void
    {
        $this->entityManager->persist($project);
        $this->entityManager->flush();
    }
}
