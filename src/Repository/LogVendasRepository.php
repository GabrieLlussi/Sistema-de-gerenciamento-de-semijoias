<?php

namespace App\Repository;

use App\Entity\LogVendas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogVendas>
 *
 * @method LogVendas|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogVendas|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogVendas[]    findAll()
 * @method LogVendas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogVendasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogVendas::class);
    }

//    /**
//     * @return LogVendas[] Returns an array of LogVendas objects
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

//    public function findOneBySomeField($value): ?LogVendas
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
