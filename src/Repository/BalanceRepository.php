<?php

namespace App\Repository;

use DateTime;
use App\Entity\Balance;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Balance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Balance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Balance[]    findAll()
 * @method Balance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BalanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Balance::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Balance $entity, bool $flush = true): void
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
    public function remove(Balance $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

      //  * @return Bike[] Returns an array of Balance objects
      public function findAllBalancesUpdatedToday()
      {   
  
          $date = new DateTime('now');
          $date = date("Y-m-d");
  
          return $this->createQueryBuilder('b')
              ->andWhere('b.createdAt >= :val')
              ->setParameter('val', $date)
              ->orderBy('b.createdAt', 'DESC')
              //->setMaxResults(10)
              ->getQuery()
              ->getResult()
          ;
      }

    // /**
    //  * @return Balance[] Returns an array of Balance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Balance
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
