<?php

namespace App\Repository;

use App\Entity\Exament;
use App\Entity\Patient;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    /**
     * @return Exament[] Returns an array of Exament objects
     */
    public function findNotFinished(): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.etat = :val')
            ->setParameter('val', false)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Exament[] Returns an array of Exament objects
     */
    public function findByDate(\DateTime $dateTime): array
    {
        $date_forma = $dateTime->format("Y-m-d");
        return $this->createQueryBuilder('e')
            ->andWhere('e.paye_at like :val')
            ->setParameter('val', '%' . $date_forma . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Exament[] Returns an array of Exament objects
     */
    public function findByPatient(
        Patient $patient
    ): array {

        $query =  $this->createQueryBuilder('e')
            ->innerJoin('e.consultation', 'cons')
            ->where('cons.patient = :val')
            ->setParameter('val', $patient->getId());
        return  $query->getQuery()
            ->getResult();
    }

    /**
     * @return Exament[] Returns an array of Exament objects
     */
    public function findBetweenDate(\DateTime $first, \DateTime $last): array
    {
        $first_format = $first->format("Y-m-d H:i:s");
        $last_format = $last->format("Y-m-d H:i:s");
        $query =  $this->createQueryBuilder('e')
            ->andWhere("e.paye_at  BETWEEN  :last AND :first")
            ->setParameter('first', $first_format)
            ->setParameter('last',  $last_format);
        // dump($query->getQuery());
        return $query->getQuery()
            ->getResult();
    }
}
