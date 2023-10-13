<?php

namespace App\Repository;

use App\Entity\Exament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exament>
 *
 * @method Exament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exament[]    findAll()
 * @method Exament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exament::class);
    }

//    /**
//     * @return Exament[] Returns an array of Exament objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Exament
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
