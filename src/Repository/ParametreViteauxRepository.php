<?php

namespace App\Repository;

use App\Entity\ParametreViteaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParametreViteaux>
 *
 * @method ParametreViteaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametreViteaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametreViteaux[]    findAll()
 * @method ParametreViteaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametreViteauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParametreViteaux::class);
    }

//    /**
//     * @return ParametreViteaux[] Returns an array of ParametreViteaux objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ParametreViteaux
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
