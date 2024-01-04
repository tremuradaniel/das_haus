<?php

namespace App\Model\ItemHistory;

use App\Exception\ItemHistoryFiltersException;
use DateTime;
use App\Model\AbstractFiltersModel;
use Exception;

class ItemHistoryFiltersModel extends AbstractFiltersModel
{
  public const ITEM_ID_KEY = 'item_id';
  
  private const START_DATE_KEY = 'start_date';
  private const END_DATE_KEY = 'end_date';

  private int $itemId;
  private DateTime $startDate;
  private DateTime $endDate;

  public function __construct(array $queryParams, string $userEmail)
  {
    parent::__construct($queryParams, $userEmail);
    $this->setParams($queryParams);
  }

  public function getItemId(): int
  {
    return $this->itemId;
  }

  public function getStartDate(): DateTime
  {
    return $this->startDate;
  }

  public function getEndDate(): DateTime
  {
    return $this->endDate;
  }

  private function setParams(array $params): void
  {
    $missingValues = [];
    $itemId = $params[self::ITEM_ID_KEY];

    if (!$itemId) {
      $missingValues[] = self::ITEM_ID_KEY;
    } else {
      $this->itemId = $params[self::ITEM_ID_KEY];
    }

    $startDate = $params[self::START_DATE_KEY] ?? null;
    $endDate = $params[self::END_DATE_KEY] ?? null;

    if (!$startDate) {
      $missingValues[] = self::START_DATE_KEY;
    }

    if (!$endDate) {
      $missingValues[] = self::END_DATE_KEY;
    }

    if(!empty($missingValues)) {
      throw ItemHistoryFiltersException::missingParams($missingValues);
    }

    $wrongFormat = [];

    try {
      $this->startDate = new DateTime($params[self::START_DATE_KEY]);
    } catch (Exception $e) {
      $wrongFormat[] = self::START_DATE_KEY;
    }

    try {
      $this->endDate = new DateTime($params[self::END_DATE_KEY]);      
    } catch (Exception $e) {
      $wrongFormat[] = self::END_DATE_KEY;
    }

    if (!empty($wrongFormat)) {
      throw ItemHistoryFiltersException::wrongFormat($wrongFormat);
    }
  }
}
