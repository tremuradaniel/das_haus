<?php

namespace App\Model\Items;

use App\Exception\ItemListFiltersException;
use TypeError;
use App\Model\AbstractFiltersModel;

class ItemListFiltersModel extends AbstractFiltersModel
{
  private const SITE_ID_KEY = 'site_id';

  private int $siteId;

  public function __construct(array $queryParams, string $userEmail)
  {
    parent::__construct($queryParams, $userEmail);
    try {
      $this->siteId = $queryParams[self::SITE_ID_KEY] ?? null;
    } catch (TypeError $e) {
      throw ItemListFiltersException::missingMandatoryParam(self::SITE_ID_KEY);
    }
  }

  public function getSiteId(): int
  {
    return $this->siteId;
  }
}
