<?php

namespace App\Repository;

use App\Entity\LogProduto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogProduto>
 *
 * @method LogProduto|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogProduto|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogProduto[]    findAll()
 * @method LogProduto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogProdutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogProduto::class);
    }

//    /**
//     * @return LogProduto[] Returns an array of LogProduto objects
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

//    public function findOneBySomeField($value): ?LogProduto
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
