<?php

namespace App\Repository;

use App\Entity\EditorCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EditorCollection|null find($id, $lockMode = null, $lockVersion = null)
 * @method EditorCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method EditorCollection[]    findAll()
 * @method EditorCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EditorCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EditorCollection::class);
    }

    /**
     * @return array
     */
    public function findAllOrderByEditor(): array
    {
        return $this->createQueryBuilder('c')
            ->select(['c', 'e'])
            ->leftJoin('c.editor', 'e')
            ->orderBy('e.name', 'ASC')
            ->addOrderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
