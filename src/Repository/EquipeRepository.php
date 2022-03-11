<?php

namespace App\Repository;

use App\Entity\Equipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Equipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipe[]    findAll()
 * @method Equipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipe::class);
    }
    /**
     * //  * @return Equipe[] Returns an array of Equipe objects
     * //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findOneBySomeField($value): ?Equipe
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function searchEquipe(Equipe $equipe):array
    {
        $query = $this
            ->createQueryBuilder('e');
            if(!empty($equipe->getNom())){
                $query = $query
                    ->andWhere('e.nom LIKE :q')
                    ->setParameter('q',"%{$equipe->getNom()}%");
            }

        if(!empty($equipe->getPrenom())){
            $query = $query
                ->andWhere('e.prenom LIKE :w')
                ->setParameter('w',"%{$equipe->getPrenom()}%");
        }

        if(!empty($equipe->getMetier())){
            $query = $query
                ->andWhere('e.nom LIKE :k')
                ->setParameter('k',"%{$equipe->getMetier()}%");
        }

        if(!empty($equipe->getAge())){
            $query = $query
                ->andWhere('e.age LIKE :a')
                ->setParameter('a',"%{$equipe->getAge()}%");
        }

        return $query->getQuery()->getArrayResult();
    }

}
