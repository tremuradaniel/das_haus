<?php

namespace App\Model;

interface FiltersModelInterface 
{
  public function getOffset(): int;
  public function getPage(): int;
  public function getRows(): int;
  public function getUserEmail(): string;
}
