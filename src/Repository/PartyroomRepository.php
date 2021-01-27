<?php

namespace App\Repository;

use App\Entity\Partyroom;
use DateTime;
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

    /**
     * Return the partyroom event between the two given dates
     * @return mixed
     * @throws \Exception
     */
    public function findEvents(Datetime $startDate, Datetime $endDate)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.date <= :end')
            ->setParameter('end', $endDate)
            ->andWhere('p.date >= :start')
            ->setParameter('start', $startDate)
            ->orderBy('p.date', 'ASC')
            ->getQuery()
            ->getResult()
            ;
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
