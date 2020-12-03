<?php

namespace App\Repository;

use App\Entity\ReportSubject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReportSubject|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportSubject|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportSubject[]    findAll()
 * @method ReportSubject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportSubjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportSubject::class);
    }

    // /**
    //  * @return ReportSubject[] Returns an array of ReportSubject objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReportSubject
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
