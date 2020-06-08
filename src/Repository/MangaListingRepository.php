<?php

namespace App\Repository;

use App\Entity\MangaListing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MangaListing|null find($id, $lockMode = null, $lockVersion = null)
 * @method MangaListing|null findOneBy(array $criteria, array $orderBy = null)
 * @method MangaListing[]    findAll()
 * @method MangaListing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MangaListingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MangaListing::class);
    }

    /**
     * @return array
     */
    public function findAllOrderByManga(): array
    {
        return $this->createQueryBuilder('l')
            ->select(['l', 'm'])
            ->leftJoin('l.manga', 'm')
            ->orderBy('m.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
