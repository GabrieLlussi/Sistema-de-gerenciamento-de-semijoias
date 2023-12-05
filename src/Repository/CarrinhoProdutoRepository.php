<?php

namespace App\Repository;

use App\Entity\CarrinhoProduto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarrinhoProduto>
 *
 * @method CarrinhoProduto|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarrinhoProduto|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarrinhoProduto[]    findAll()
 * @method CarrinhoProduto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarrinhoProdutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarrinhoProduto::class);
    }

//    /**
//     * @return CarrinhoProduto[] Returns an array of CarrinhoProduto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CarrinhoProduto
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
