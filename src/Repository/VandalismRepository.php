<?php

namespace App\Repository;

use DateTime;
use App\Entity\Vandalism;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
// Doctrine pagination
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Vandalism|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vandalism|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vandalism[]    findAll()
 * @method Vandalism[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VandalismRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vandalism::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Vandalism $entity, bool $flush = true): void
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
    public function remove(Vandalism $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    //  * @return Bike[] Returns an array of RepairAct objects
    public function findAllVandalimsUpdatedToday()
    {   

    $date = new DateTime('now');
    $date = date("Y-m-d");

    return $this->createQueryBuilder('v')
        ->andWhere('v.createdAt >= :val')
        ->setParameter('val', $date)
        ->orderBy('v.createdAt', 'DESC')
        //->setMaxResults(10)
        ->getQuery()
        ->getResult()
        ;
    }

    // /**
    //  * @return Vandalism[] Returns an array of Vandalism objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vandalism
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
