<?php

namespace App\Repository;

use App\Entity\Carrinho;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Carrinho>
 *
 * @method Carrinho|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carrinho|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carrinho[]    findAll()
 * @method Carrinho[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarrinhoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carrinho::class);
    }

//    /**
//     * @return Carrinho[] Returns an array of Carrinho objects
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

//    public function findOneBySomeField($value): ?Carrinho
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
