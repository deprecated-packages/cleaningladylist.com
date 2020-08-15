<?php


namespace CleaningLadyList\Utils\PHPStan\Tests\Rule\NoGetRepositoryOutsideConstructorRule\Fixture;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Rector\DoctrineCodeQuality\Tests\Rector\Class_\ChangeQuerySetParametersMethodParameterFromArrayToArrayCollection\Fixture\SomeRepository;

final class TwoTestRepository
{
    /**
     * @var EntityRepository $testRepository
     */
    private $testRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->testRepository = $entityManager->getRepository(TestRepository::class);
    }
}
