<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Checkbox;
use App\Exception\ShouldNotHappenException;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class CheckListRepository
{
    /**
     * @var EntityRepository<Checkbox>
     */
    private $entityRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityRepository = $entityManager->getRepository(Checkbox::class);
    }

    /**
     * @return Collection&iterable<Checkbox>
     */
    public function findByFramework(string $framework)
    {
        return $this->entityRepository->createQueryBuilder('checkbox')
            ->where('checkbox.framework is NULL')
            ->orWhere('checkbox.framework = :framework')
            ->setParameter('framework', $framework)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param mixed[] $criteria
     */
    public function findOneBy(array $criteria): ?Checkbox
    {
        return $this->entityRepository->findOneBy($criteria);
    }

    public function find(int $checkbox_id): Checkbox
    {
        $checkbox = $this->entityRepository->find($checkbox_id);
        if ($checkbox === null) {
            throw new ShouldNotHappenException();
        }

        return $checkbox;
    }
}
