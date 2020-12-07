<?php

namespace App\Repository;

use App\Entity\Newspaper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Newspaper|null find($id, $lockMode = null, $lockVersion = null)
 * @method Newspaper|null findOneBy(array $criteria, array $orderBy = null)
 * @method Newspaper[]    findAll()
 * @method Newspaper[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewspaperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Newspaper::class);
    }
}
