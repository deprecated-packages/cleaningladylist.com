<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Checklist;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class ChecklistRepository
{
    /**
     * @var EntityRepository<Checklist>
     */
    private $entityRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityRepository = $entityManager->getRepository(Checklist::class);
    }
}
