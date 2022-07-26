<?php

namespace App\Repository;

use DateTime;
use App\Entity\Bike;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
    public function findAllBikesUpdatedToday()
    {   

        $date = new DateTime('now');
        $date = date("Y-m-d");

        return $this->createQueryBuilder('b')
            ->andWhere('b.updatedAt >= :val')
            ->setParameter('val', $date)
            ->orderBy('b.updatedAt', 'DESC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

       //  * @return Bike[] Returns an array of Bike objects
       public function findAllbikesUnavalable()
       {    
        $availablity_panne  = 'Dépôt - Panne';
        $availablity_stock  = 'Dépôt - Stock';
        $availablity_disparu  = 'Disparu';
        $availablity_maintenance  = 'Bloqué - Maintenance';
   
           return $this->createQueryBuilder('b')
               ->andWhere('b.availablity  = :panne')
               ->orWhere('b.availablity  = :stock')
               ->orWhere('b.availablity  = :disparu')
               ->orWhere('b.availablity  = :maintenance')
               ->setParameter('panne', $availablity_panne )
               ->setParameter('stock', $availablity_stock )
               ->setParameter('disparu', $availablity_disparu )
               ->setParameter('maintenance', $availablity_maintenance )
               ->orderBy('b.availablity', 'ASC')
               //->setMaxResults(10)
               ->getQuery()
               ->getResult()
           ;
       }


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
