<?php

namespace App\Repository;

use App\Entity\WorldCountries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorldCountries|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorldCountries|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorldCountries[]    findAll()
 * @method WorldCountries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorldCountriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorldCountries::class);
    }

    // /**
    //  * @return WorldCountries[] Returns an array of WorldCountries objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorldCountries
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
