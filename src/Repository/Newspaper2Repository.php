<?php

namespace App\Repository;

use App\Entity\Newspaper2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Newspaper2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Newspaper2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Newspaper2[]    findAll()
 * @method Newspaper2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Newspaper2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Newspaper2::class);
    }

    // /**
    //  * @return Newspaper2[] Returns an array of Newspaper2 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Newspaper2
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
