<?php

namespace App\Repository;

use App\Entity\AuthorRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AuthorRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuthorRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuthorRole[]    findAll()
 * @method AuthorRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthorRole::class);
    }
}
