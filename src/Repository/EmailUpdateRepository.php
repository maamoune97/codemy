<?php

namespace App\Repository;

use App\Entity\EmailUpdate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmailUpdate|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailUpdate|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailUpdate[]    findAll()
 * @method EmailUpdate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailUpdateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailUpdate::class);
    }

    // /**
    //  * @return EmailUpdate[] Returns an array of EmailUpdate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmailUpdate
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
