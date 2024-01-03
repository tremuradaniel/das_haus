<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\ORM\QueryBuilder;
use App\Model\Items\ItemListFiltersModel;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

  /**
    * @return Item[] Returns an array of Site objects
    */
    public function getUserItems(ItemListFiltersModel $filters): array
    {
        $qb = $this->buildUserSiteItemsJoins();
        $qb
         ->where($qb->expr()->eq('u.email', ':email'))
         ->andWhere($qb->expr()->eq('IDENTITY(us.site)', ':siteId'))
         ->andWhere($qb->expr()->eq('i.status', ':status'))
         ->orderBy('i.name', 'ASC')
         ->setFirstResult($filters->getOffset())
         ->setMaxResults($filters->getRows())
         ;
 
         $this->setUserSiteItemsParams($filters, $qb);
         
         return $qb->getQuery()
             ->getResult()
        ;
    }
 
    public function getUserTotalSites(ItemListFiltersModel $filters): int
    {
         $qb = $this->buildUserSiteItemsJoins();
         $qb->select($qb->expr()->count('u.id'))
         ->where($qb->expr()->eq('u.email', ':email'))
         ->andWhere($qb->expr()->eq('IDENTITY(us.site)', ':siteId'))
         ->andWhere($qb->expr()->eq('i.status', ':status'))
        ;

        $this->setUserSiteItemsParams($filters, $qb);
         
         return $qb->getQuery()
         ->getSingleScalarResult();
    }
 
    private function buildUserSiteItemsJoins(): QueryBuilder
    {
     $qb = $this->createQueryBuilder('i');
 
     return $qb
         ->join('i.userSite', 'us')
         ->join('us.user', 'u')
         ->join('us.site', 's')
     ;
    }

    private function setUserSiteItemsParams(
        ItemListFiltersModel $filters, 
        QueryBuilder $qb
    ): void {
        $qb->setParameters([
            'email' => $filters->getUserEmail(),
            'siteId' => $filters->getSiteId(),
            'status' => Item::ACTIVE_STATUS,
        ]);
    }
}
