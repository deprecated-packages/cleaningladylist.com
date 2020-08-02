<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Checkbox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Checkbox|null find($id, $lockMode = null, $lockVersion = null)
 * @method Checkbox|null findOneBy(array $criteria, array $orderBy = null)
 * @method Checkbox[] findAll()
 * @method Checkbox[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CheckListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Checkbox::class);
    }

    // /**
    //  * @return CheckList[] Returns an array of CheckList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findByFramework(string $framework)
    {
        return $this->createQueryBuilder('checkbox')
            ->where('checkbox.framework is NULL')
            ->orWhere('checkbox.framework = :framework')
            ->setParameter('framework', $framework)
            ->getQuery()
            ->getResult()
        ;
    }
}
