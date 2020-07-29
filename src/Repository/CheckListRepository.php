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
class CheckListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Checkbox::class);
    }

    // /**
    //  * @return Checkbox[] Returns an array of Checkbox objects
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
