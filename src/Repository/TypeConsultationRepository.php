<?php

namespace App\Repository;

use App\Entity\TypeConsultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeConsultation>
 *
 * @method TypeConsultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeConsultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeConsultation[]    findAll()
 * @method TypeConsultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeConsultation::class);
    }

//    /**
//     * @return TypeConsultation[] Returns an array of TypeConsultation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeConsultation
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
