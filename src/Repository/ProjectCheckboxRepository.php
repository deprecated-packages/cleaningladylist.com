<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProjectCheckbox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectCheckbox|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectCheckbox|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectCheckbox[] findAll()
 * @method ProjectCheckbox[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProjectCheckboxRepository extends ServiceEntityRepository
{
    public $repository;

    /**
     * ProjectCheckboxRepository constructor.
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, ProjectCheckbox::class);
    }

    public function findOneBySomeField($value): ?ProjectCheckbox
    {
        return $this->repository->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
