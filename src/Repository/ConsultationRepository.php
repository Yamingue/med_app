<?php

namespace App\Repository;

use App\Entity\Consultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consultation>
 *
 * @method Consultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultation[]    findAll()
 * @method Consultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultation::class);
    }

    /**
     * @return Consultation[] Returns an array of Consultation objects
     */
    public function findByDate(\DateTime $date): array
    {
        $date_forma = $date->format("Y-m-d");
        return $this->createQueryBuilder('c')
            ->andWhere('c.create_at like :val')
            ->setParameter('val', '%' . $date_forma . "%")
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Consultation[] Returns an array of Consultation objects
     */
    public function findBetweenDate(\DateTime $first, \DateTime $last): array
    {
        $first_format = $first->format("Y-m-d H:i:s");
        $last_format = $last->format("Y-m-d H:i:s");
        return $this->createQueryBuilder('c')
            ->andWhere('c.create_at BETWEEN  :last AND :first')
            ->setParameter('first', $first_format)
            ->setParameter('last',  $last_format)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }



    //    public function findOneBySomeField($value): ?Consultation
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
