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
    //  * @return OrderFromMenu[] Returns an array of Order objects
    //  */
    public function findByUser($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.user = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function findByDish($value){
        return $this->createQueryBuilder('u')
            ->andWhere('u.dish = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function findAllDishByUser($value){
        return $this->createQueryBuilder('u')
            ->andWhere('u.user = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
