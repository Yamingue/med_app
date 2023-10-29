<?php

namespace App\Repository;

use App\Entity\Patient;
use App\Entity\ResultatExam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResultatExam>
 *
 * @method ResultatExam|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResultatExam|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResultatExam[]    findAll()
 * @method ResultatExam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultatExamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResultatExam::class);
    }

    // /**
    //  * @return ResultatExam[] Returns an array of ResultatExam objects
    //  */
    // public function findPatientResult(Patient $patient): array
    // {
    //     return $this->createQueryBuilder('r')
    //         ->innerJoin("r.examen", 'ex')
    //         ->innerJoin("ex.consultation", 'cons')
    //         ->where("cons.patient = :val")
    //         // ->andWhere('r.exampleField = :val')
    //         ->setParameter('val', $patient)
    //         ->orderBy('r.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult();
    // }

    //    public function findOneBySomeField($value): ?ResultatExam
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
