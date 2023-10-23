<?php

namespace App\Repository;

use App\Entity\ExamItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExamItem>
 *
 * @method ExamItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExamItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExamItem[]    findAll()
 * @method ExamItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExamItem::class);
    }

//    /**
//     * @return ExamItem[] Returns an array of ExamItem objects
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

//    public function findOneBySomeField($value): ?ExamItem
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
