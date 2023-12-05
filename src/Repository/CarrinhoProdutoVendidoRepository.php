<?php

namespace App\Repository;

use App\Entity\CarrinhoProdutoVendido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarrinhoProdutoVendido>
 *
 * @method CarrinhoProdutoVendido|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarrinhoProdutoVendido|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarrinhoProdutoVendido[]    findAll()
 * @method CarrinhoProdutoVendido[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarrinhoProdutoVendidoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarrinhoProdutoVendido::class);
    }

//    /**
//     * @return CarrinhoProdutoVendido[] Returns an array of CarrinhoProdutoVendido objects
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

//    public function findOneBySomeField($value): ?CarrinhoProdutoVendido
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
