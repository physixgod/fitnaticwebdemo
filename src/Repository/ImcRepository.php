<?php

// src/Repository/ImcRepository.php

namespace App\Repository;

use App\Entity\Imc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ImcRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Imc::class);
    }

    /**
     * Récupérer le dernier IMC pour un utilisateur donné.
     *
     * @param int $userId
     * @return Imc|null
     */
    /**
 * @method Imc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Imc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Imc[]    findAll()
 * @method Imc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
    public function findLatestImcForUser($userId): ?Imc
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.IM = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('i.IMC', 'DESC') // Assurez-vous d'avoir un champ dateMesure ou similaire pour ordonner par date
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function findLatestImc(): ?Imc
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.IMC', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}



//    public function findOneBySomeField($value): ?Imc
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

