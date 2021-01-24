<?php

namespace App\Repository;

use App\Entity\Partyroom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Partyroom|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partyroom|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partyroom[]    findAll()
 * @method Partyroom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyroomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partyroom::class);
    }

    // /**
    //  * @return Partyroom[] Returns an array of Partyroom objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Partyroom
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
