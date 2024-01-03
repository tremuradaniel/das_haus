<?php

namespace App\Exception;

use RuntimeException;

class ItemListFiltersException extends RuntimeException
{
  public static function missingMandatoryParam(string $param): self 
  {
    return new self(sprintf('Missing mandatory parameter: %s', $param));
  }
}
