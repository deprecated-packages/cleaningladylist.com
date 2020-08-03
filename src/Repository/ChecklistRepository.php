<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Checklist;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class ChecklistRepository
{
    /**
     * @var ObjectRepository<Checklist>
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Checklist::class);
    }
}
