<?php


namespace CleaningLadyList\Utils\PHPStan\Tests\Rule\NoGetRepositoryOutsideConstructorRule\Fixture;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Rector\DoctrineCodeQuality\Tests\Rector\Class_\ChangeQuerySetParametersMethodParameterFromArrayToArrayCollection\Fixture\SomeRepository;

final class OneTestRepository
{
    /**
     * @var EntityRepository $entityManager
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find()
    {
        return $this->entityManager->getRepository(TestRepository::class)->findAll();
    }

}
