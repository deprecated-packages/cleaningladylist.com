<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProjectCheckbox;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class ProjectCheckListRepository
{
    /**
     * @var EntityRepository<ProjectCheckbox>
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(ProjectCheckbox::class);
    }

    /**
     * @param mixed[] $criteria
     */
    public function findOneBy(array $criteria): ?ProjectCheckbox
    {
        return $this->repository->findOneBy($criteria);
    }
}
