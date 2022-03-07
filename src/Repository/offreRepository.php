<?php

namespace App\Repository;

use App\Entity\offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method offre[]    findAll()
 * @method offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class offreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, offre::class);
    }

    // /**
    //  * @return offre[] Returns an array of offre objects
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
    public function findOneBySomeField($value): ?offre
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
