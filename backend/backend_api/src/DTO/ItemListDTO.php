<?php

namespace App\DTO;

use App\Entity\Item;
use App\Model\Items\ItemModel;

class ItemListDTO
{
  private int $page;
  private int $totalRows;
  /** @var Item[] $data */
  private array $data;

  public function __construct(
    array $data,
    int $page,
    int $totalRows
  ) {
    $this->data = array_map(function ($item) {
      return new ItemModel($item->getId(), $item->getName(), $item->getPath());
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
