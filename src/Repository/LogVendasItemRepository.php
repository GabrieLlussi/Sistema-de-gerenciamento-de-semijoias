<?php

namespace App\Repository;

use App\Entity\LogVendasItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogVendasItem>
 *
 * @method LogVendasItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogVendasItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogVendasItem[]    findAll()
 * @method LogVendasItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogVendasItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogVendasItem::class);
    }

//    /**
//     * @return LogVendasItem[] Returns an array of LogVendasItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LogVendasItem
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
