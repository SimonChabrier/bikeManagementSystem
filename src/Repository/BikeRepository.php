<?php

namespace App\Repository;

use App\Entity\Bike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bike|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bike|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bike[]    findAll()
 * @method Bike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bike::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Bike $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Bike $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    //  * @return Bike[] Returns an array of Bike objects
    // public function findByExampleField($value)
    // {
    //     return $this->createQueryBuilder('b')
    //         ->andWhere('b.id = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('b.id', 'ASC')
    //         ->setMaxResults(1   )
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }


    /*
    public function findOneBySomeField($value): ?Bike
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
