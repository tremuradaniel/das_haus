<?php

namespace App\DTO;

use App\Entity\ItemHistory;
use App\Model\ItemHistory\ItemHistoryModel;

class ItemHistoryDTO
{
  private int $page;
  private int $totalRows;
  /** @var ItemHistory[] $data */
  private array $data;

  public function __construct(
    array $data,
    int $page,
    int $totalRows
  ) {
    $this->data = array_map(function ($item) {
      return new ItemHistoryModel(
        $item->getId(), 
        $item->getDate(), 
        $item->getValue(),
        $item->getCurrency()->getCode()
    );
    }, $data);
    $this->page = $page;
    $this->totalRows = $totalRows;
  }

  public function getResponse(): array
  {
    return [
        'data' => $this->data,
        'page' => $this->page,
        'total_rows' => $this->totalRows        
    ];
  }
}
