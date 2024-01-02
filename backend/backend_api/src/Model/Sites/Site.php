<?php

namespace App\Model\Sites;

use JsonSerializable;

class Site implements JsonSerializable
{
  private const ID = "id";
  private const NAME = "name";
  private const DOMAIN = "domain";

  private int $id;
  private string $name;
  private string $domain;

  public function __construct(
    int $id,
    string $name,
    string $domain
  ){
    $this->id = $id;
    $this->name = $name;
    $this->domain = $domain;
  }

  public function jsonSerialize(): array
  {
    return [
      self::ID => $this->id,
      self::NAME => $this->name,
      self::DOMAIN => $this->domain,
    ];
  }
}
