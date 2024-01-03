<?php

namespace App\Repository;

use App\Entity\Item;
use App\Entity\ItemHistory;
use App\Entity\Site;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use App\Model\ItemHistory\ItemHistoryFiltersModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ItemHistory>
 *
 * @method ItemHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemHistory[]    findAll()
 * @method ItemHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemHistoryRepository extends ServiceEntityRepository
{
    private const DATE_FORMAT = 'Y-m-d';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemHistory::class);
    }
 /**
    * @return ItemHistory[] Returns an array of Site objects
    */
    public function getUserItems(ItemHistoryFiltersModel $filters): array
    {
        $qb = $this->buildUserItemHistoryJoins();
        $this->setUserItemHistoryConditions($filters, $qb);
        $qb      
         ->orderBy('ih.date', 'ASC')
         ->setFirstResult($filters->getOffset())
         ->setMaxResults($filters->getRows())
         ;
 
         $this->setUserItemsHistoryParams($filters, $qb);
         
         return $qb->getQuery()
             ->getResult()
        ;
    }
 
    public function getUserItemHistoryTotalInstances(ItemHistoryFiltersModel $filters): int
    {
        $qb = $this->buildUserItemHistoryJoins();
        $qb->select($qb->expr()->count('ih.id'));
        $this->setUserItemHistoryConditions($filters, $qb);
        $this->setUserItemsHistoryParams($filters, $qb);
         
         return $qb->getQuery()
         ->getSingleScalarResult();
    }
 
    private function buildUserItemHistoryJoins(): QueryBuilder
    {
     $qb = $this->createQueryBuilder('ih');
 
     return $qb
         ->join('ih.item', 'i')
         ->join('i.userSite', 'us')
         ->join('us.site', 's')
         ->join('us.user', 'u')
     ;
    }

    private function setUserItemsHistoryParams(
        ItemHistoryFiltersModel $filters, 
        QueryBuilder $qb
    ): void {
        $qb->setParameters([
            'itemId' => $filters->getItemId(),
            'email' => $filters->getUserEmail(),
            'itemStatus' => Item::ACTIVE_STATUS,
            'siteStatus' => Site::ACTIVE_STATUS,
            'startDate' => $filters->getStartDate()->format(self::DATE_FORMAT),
            'endDate' => $filters->getEndDate()->format(self::DATE_FORMAT),
        ]);
    }

    private function setUserItemHistoryConditions(
        ItemHistoryFiltersModel $filters, 
        QueryBuilder $qb
    ): void {
        $qb   
        ->where($qb->expr()->eq('IDENTITY(ih.item)', ':itemId'))
        ->andWhere($qb->expr()->eq('u.email', ':email'))
        ->andWhere($qb->expr()->eq('i.status', ':itemStatus'))
        ->andWhere($qb->expr()->eq('s.status', ':siteStatus'))
        ->andWhere($qb->expr()->gte('ih.date', ':startDate'))
        ->andWhere($qb->expr()->lte('ih.date', ':endDate'))
        ;
    }
}
