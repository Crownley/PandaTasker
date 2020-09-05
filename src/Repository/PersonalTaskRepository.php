<?php

namespace App\Repository;

use App\Entity\PersonalTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PersonalTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalTask[]    findAll()
 * @method PersonalTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalTask::class);
    }

    // /**
    //  * @return PersonalTask[] Returns an array of PersonalTask objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersonalTask
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
