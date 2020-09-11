<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function getLastForCardPresentation($limit = 4)
    {
        return $this->createQueryBuilder('c')
            ->select('c.title, c.slug, u.firstName, u.lastName, s.title as subCategory, s.slug as subCategorySlug, k.title as category, k.slug as categorySlug')
            ->groupBy('c.createdAt')
            ->orderBy('c.createdAt', 'DESC')
            ->join('c.formator', 'u')
            ->join('c.subCategory', 's')
            ->join('s.category', 'k')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneByHisSlug(string $slug)
    {
        return $this->createQueryBuilder('c')
            ->select('c as course, u.firstName, u.lastName, s.title as subCategory, k.title as category')
            ->andWhere('c.slug = :val')
            ->setParameter('val',$slug)
            ->join('c.formator', 'u')
            ->join('c.subCategory', 's')
            ->join('s.category', 'k')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // /**
    //  * @return Course[] Returns an array of Course objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Course
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
