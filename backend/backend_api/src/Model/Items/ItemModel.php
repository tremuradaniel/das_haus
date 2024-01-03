<?php

namespace App\Model\Items;

use JsonSerializable;

class ItemModel implements JsonSerializable
{
  private const ID = "id";
  private const NAME = "name";
  private const PATH = "path";

  private int $id;
  private string $name;
  private string $path;

  public function __construct(
    int $id,
    string $name,
    string $path
  ){
    $this->id = $id;
    $this->name = $name;
    $this->path = $path;
  }

  public function jsonSerialize(): array
  {
    return [
      self::ID => $this->id,
      self::NAME => $this->name,
      self::PATH => $this->path,
    ];
  }
}
