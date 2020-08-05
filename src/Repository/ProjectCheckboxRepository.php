<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProjectCheckbox;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;


final class ProjectCheckboxRepository
{
    /**
     * @var EntityRepository<ProjectCheckbox>
     */
    private $entityRepository;

    /**
     * ProjectCheckboxRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityRepository = $entityManager->getRepository(ProjectCheckbox::class);
    }

}
