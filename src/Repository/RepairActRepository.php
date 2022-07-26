<?php

namespace App\Repository;

use DateTime;
use App\Entity\RepairAct;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method RepairAct|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepairAct|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepairAct[]    findAll()
 * @method RepairAct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepairActRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepairAct::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(RepairAct $entity, bool $flush = true): void
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
    public function remove(RepairAct $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

        //  * @return Bike[] Returns an array of RepairAct objects
        public function findAllRepairsUpdatedToday()
        {   
    
        $date = new DateTime('now');
        $date = date("Y-m-d");

        return $this->createQueryBuilder('r')
            ->andWhere('r.createdAt >= :val')
            ->setParameter('val', $date)
            ->orderBy('r.createdAt', 'DESC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return RepairAct[] Returns an array of RepairAct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RepairAct
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
