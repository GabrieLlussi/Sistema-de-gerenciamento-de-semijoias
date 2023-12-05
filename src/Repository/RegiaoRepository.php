<?php

namespace App\Repository;

use App\Entity\Regiao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Regiao>
 *
 * @method Regiao|null find($id, $lockMode = null, $lockVersion = null)
 * @method Regiao|null findOneBy(array $criteria, array $orderBy = null)
 * @method Regiao[]    findAll()
 * @method Regiao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegiaoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Regiao::class);
    }

//    /**
//     * @return Regiao[] Returns an array of Regiao objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Regiao
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
