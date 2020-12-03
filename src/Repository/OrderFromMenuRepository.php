<?php

namespace App\Repository;

use App\Entity\OrderFromMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderFromMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderFromMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderFromMenu[]    findAll()
 * @method OrderFromMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderFromMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderFromMenu::class);
    }

    // /**
    //  * @return OrderFromMenu[] Returns an array of OrderFromMenu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderFromMenu
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
