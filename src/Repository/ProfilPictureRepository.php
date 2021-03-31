<?php

namespace App\Repository;

use App\Entity\ProfilPicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProfilPicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfilPicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfilPicture[]    findAll()
 * @method ProfilPicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfilPictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfilPicture::class);
    }

    // /**
    //  * @return ProfilPicture[] Returns an array of ProfilPicture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProfilPicture
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
