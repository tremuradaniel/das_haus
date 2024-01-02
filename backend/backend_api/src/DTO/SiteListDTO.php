<?php

use App\Model\Sites\Site;

class SiteListDTO
{
  private int $page;
  private int $totalRows;
  /** @var Site[] $sites */
  private array $data;

  public function __construct(
    array $data,
    int $page,
    int $totalRows
  ) {
    $this->data = array_map(function ($site) {
      return new Site($site->getId(), $site->getName(), $site->getDomain());
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
