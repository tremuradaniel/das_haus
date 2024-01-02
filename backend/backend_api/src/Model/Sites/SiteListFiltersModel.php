<?php

class SiteListFiltersModel
{
  private const ROWS_KEY = 'rows';
  private const PAGE_KEY = 'page';

  private const DEFAULT_PAGE = 1;
  private const DEFAULT_ROWS = 10;

  private int $offset;
  private int $rows;
  private int $page;
  private string $userEmail;

  public function __construct(array $queryParams, string $userEmail)
  {
      $this->page = $queryParams[self::PAGE_KEY] ?? self::DEFAULT_PAGE;
      $this->rows = $queryParams[self::ROWS_KEY] ?? self::DEFAULT_ROWS;
      $this->offset = ($this->page - 1) * $this->rows;
      $this->userEmail = $userEmail;
  }

  public function getOffset(): int
  {
    return $this->offset;
  }

  public function getRows(): int
  {
    return $this->rows;
  }

  public function getUserEmail(): string
  {
    return $this->userEmail;
  }

  public function getPage() : int 
  {
    return $this->page;  
  }
}
