<?php

namespace App\Repository;

use App\Entity\Site;
use SiteListFiltersModel;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Site>
 *
 * @method Site|null find($id, $lockMode = null, $lockVersion = null)
 * @method Site|null findOneBy(array $criteria, array $orderBy = null)
 * @method Site[]    findAll()
 * @method Site[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Site::class);
    }

   /**
    * @return Site[] Returns an array of Site objects
    */
   public function getSitesForListing(SiteListFiltersModel $filters): array
   {
       $qb = $this->buildUserSitesJoins();
       $qb
        ->where($qb->expr()->eq('u.email', ':email'))
        ->orderBy('s.name', 'ASC')
        ->setFirstResult($filters->getOffset())
        ->setMaxResults($filters->getRows())
        ->setParameter('email', $filters->getUserEmail());        
        
        return $qb->getQuery()
            ->getResult()
       ;
   }

   public function getUserTotalSites(string $userEmail): int
   {
        $qb = $this->buildUserSitesJoins();
        $qb->select($qb->expr()->count('u.id'))
        ->where($qb->expr()->eq('u.email', ':email'))
        ->orderBy('s.name', 'ASC')
        ->setParameter('email', $userEmail);        
        
        return $qb->getQuery()
        ->getSingleScalarResult();
   }

   private function buildUserSitesJoins(): QueryBuilder
   {
    $qb = $this->createQueryBuilder('s');

    return $qb
        ->join('s.userSites', 'us')
        ->join('us.user', 'u')
    ;
   }
}
