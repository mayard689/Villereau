<?php

namespace App\Repository;

use App\Entity\Content;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Content|null find($id, $lockMode = null, $lockVersion = null)
 * @method Content|null findOneBy(array $criteria, array $orderBy = null)
 * @method Content[]    findAll()
 * @method Content[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Content::class);
    }

    /**
     * Return the content that as a publication date in the past
     * Return "limit" results
     * Avoid the "offset" later/newest ones
     * @param int $limit
     * @param int $offset
     * @return mixed
     * @throws \Exception
     */
    public function findComming(int $limit=999, int $offset=0)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.date < :now')
            ->setParameter('now', new \Datetime('now'))
            ->orderBy('c.date', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }
}
