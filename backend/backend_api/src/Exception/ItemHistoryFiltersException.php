<?php

namespace App\Exception;

use RuntimeException;

class ItemHistoryFiltersException extends RuntimeException
{
  public static function missingParams(array $params): self 
  {
    return new self(sprintf('Missing mandatory parameter(s): %s', implode(", ", $params)));
  }

  public static function wrongFormat(array $params): self 
  {
    return new self(sprintf('Parameter(s) with wrong format: %s. Accepted: YYYY-MM-DD', implode(", ", $params)));
  }
}
