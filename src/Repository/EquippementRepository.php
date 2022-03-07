<?php

namespace App\Repository;

use App\Entity\Equippement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Equippement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equippement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equippement[]    findAll()
 * @method Equippement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquippementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equippement::class);
    }

    // /**
    //  * @return Equippement[] Returns an array of Equippement objects
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
    public function findOneBySomeField($value): ?Equippement
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
