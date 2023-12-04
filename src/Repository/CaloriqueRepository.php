<?php

namespace App\Repository;

use App\Entity\Calorique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Calorique>
 *
 * @method Calorique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calorique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calorique[]    findAll()
 * @method Calorique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaloriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calorique::class);
    }}

//    /**
//     * @return Calorique[] Returns an array of Calorique objects
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

//    public function findOneBySomeField($value): ?Calorique
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

