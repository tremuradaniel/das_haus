<?php

namespace App\Repository;

use App\Entity\UserSite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserSite>
 *
 * @method UserSite|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSite|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSite[]    findAll()
 * @method UserSite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserSite::class);
    }

//    /**
//     * @return UserSite[] Returns an array of UserSite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserSite
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
