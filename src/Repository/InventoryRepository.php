<?php

namespace App\Repository;

use DateTime;
use App\Entity\Inventory;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Inventory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inventory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inventory[]    findAll()
 * @method Inventory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inventory::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Inventory $entity, bool $flush = true): void
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
    public function remove(Inventory $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Inventory[]
     */
    public function findAllOrderedByDESC(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT i
            FROM App\Entity\Inventory i
            ORDER BY i.createdAt DESC'
        );

        // returns an array of Station objects
        return $query->getResult();
    }

    // * @return Inventory[] Returns an array of Inventory objects
    public function findAllInventoriesUpdatedToday()
    {   

        $date = new DateTime('now');
        $date = date("Y-m-d");

        return $this->createQueryBuilder('i')
            ->andWhere('i.createdAt >= :val')
            ->setParameter('val', $date)
            ->orderBy('i.createdAt', 'DESC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    // /**
    //  * @return Inventory[] Returns an array of Inventory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Inventory
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
