<?php

namespace App\Repository;

use App\Entity\NewspaperSubject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewspaperSubject|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewspaperSubject|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewspaperSubject[]    findAll()
 * @method NewspaperSubject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewspaperSubjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewspaperSubject::class);
    }
}
