<?php

namespace App\Repository;

use App\Entity\Calorique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Calorique>
 */
class CaloriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calorique::class);
    }

    /**
     * Retourne le dernier besoins calorique enregistré.
     *
     * @return Calorique|null
     */
    public function findLatestBesoinsCalorique(): ?Calorique
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC') // Assurez-vous que 'id' est le nom de la colonne d'identifiant de votre entité Calorique
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }


}