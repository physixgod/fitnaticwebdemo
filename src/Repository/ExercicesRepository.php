<?php

namespace App\Repository;

use App\Entity\Exercices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercices>
 *
 * @method Exercices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exercices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exercices[]    findAll()
 * @method Exercices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExercicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercices::class);
    }

    public function findHistoricalProgressData()
{
    $qb = $this->createQueryBuilder('e')
        ->select('e.progress as progress', 'e.repetitions as repetitions')
        // Add any additional conditions or joins if needed
        ->orderBy('e.series', 'ASC') // Optional: Order by series in ascending order
        ->getQuery();

    return $qb->getResult();
}

//    /**
//     * @return Exercices[] Returns an array of Exercices objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Exercices
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}