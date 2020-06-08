<?php

namespace App\Repository;

use App\Entity\Manga;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Manga|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manga|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manga[]    findAll()
 * @method Manga[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MangaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manga::class);
    }

    public function findAllOrderByTitle(): array
    {
        return $this->createQueryBuilder('m')
            ->select(['m', 'e', 'c', 'ma', 'a', 'r'])
//            ->leftJoin('m.author', 'a')
            ->leftJoin('m.editor', 'e')
            ->leftJoin('m.editorCollection', 'c')
            ->leftJoin('m.mangaAuthors', 'ma')
            ->leftJoin('ma.author', 'a')
            ->leftJoin('ma.role', 'r')
            ->orderBy('m.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
