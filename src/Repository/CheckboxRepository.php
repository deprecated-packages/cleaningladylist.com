<?php

namespace App\Repository;

use App\Entity\Checkbox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Checkbox|null find($id, $lockMode = null, $lockVersion = null)
 * @method Checkbox|null findOneBy(array $criteria, array $orderBy = null)
 * @method Checkbox[]    findAll()
 * @method Checkbox[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckboxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Checkbox::class);
    }

    public function findByFramework(string $framework)
    {
        return $this->createQueryBuilder('c')
            ->where('c.framework = :framework')
            ->setParameter('framework', $framework)
            ->orWhere('c.framework is NULL')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Checkbox
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
