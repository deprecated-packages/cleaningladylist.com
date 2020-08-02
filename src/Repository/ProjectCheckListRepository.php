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
final class ProjectCheckListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectCheckbox::class);
    }

    // /**
    //  * @return ProjectCheckbox[] Returns an array of ProjectCheckbox objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProjectCheckbox
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
