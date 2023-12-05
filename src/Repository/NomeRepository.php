<?php

namespace App\Repository;

use App\Entity\Nome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Nome>
 *
 * @method Nome|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nome|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nome[]    findAll()
 * @method Nome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nome::class);
    }

//    /**
//     * @return Nome[] Returns an array of Nome objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Nome
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
