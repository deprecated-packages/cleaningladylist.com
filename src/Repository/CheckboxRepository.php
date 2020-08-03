<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Checkbox;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class CheckboxRepository
{
    /**
     * @var EntityRepository<Checkbox>
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Checkbox::class);
    }

    /**
     * @return Checkbox[]
     */
    public function findByFramework(string $framework): array
    {
        return $this->repository->createQueryBuilder('c')
            ->where('c.framework = :framework')
            ->setParameter('framework', $framework)
            ->orWhere('c.framework is NULL')
            ->getQuery()
            ->getResult();
    }
}
