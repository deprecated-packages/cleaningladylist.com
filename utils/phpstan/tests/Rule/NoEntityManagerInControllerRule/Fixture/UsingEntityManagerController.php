<?php

declare(strict_types=1);

namespace CleaningLadyList\Utils\PHPStan\Tests\Rule\NoEntityManagerInControllerRule\Fixture;

use CleaningLadyList\Utils\PHPStan\Tests\Rule\NoEntityManagerInControllerRule\Source\SomeController;
use Doctrine\ORM\EntityManager;

final class UsingEntityManagerController extends SomeController
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
