<?php


namespace CleaningLadyList\Utils\PHPStan\Tests\Rule\NoGetRepositoryOutsideConstructorRule\Fixture;


use Doctrine\ORM\EntityManager;
use Rector\DoctrineCodeQuality\Tests\Rector\Class_\ChangeQuerySetParametersMethodParameterFromArrayToArrayCollection\Fixture\SomeRepository;

class SomeController
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function example()
    {
        return $this->entityManager->getRepository(SomeRepository::class)->findAll();
    }

}
