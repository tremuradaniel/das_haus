<?php

namespace App\Model\ItemHistory;

use DateTime;
use JsonSerializable;

class ItemHistoryModel implements JsonSerializable
{
  private const ID = "id";
  private const DATE = "date";
  private const VALUE = "value";
  private const CURRENCY = "currency";

  private int $id;
  private string $date;
  private float $value;
  private string $currency;

  public function __construct(
    int $id,
    DateTime $date,
    float $value,
    string $currency
  ){
    $this->id = $id;
    $this->date = $date->format("Y-m-d");
    $this->value = $value;
    $this->currency = $currency;
  }

  public function jsonSerialize(): array
  {
    return [
      self::ID => $this->id,
      self::DATE => $this->date,
      self::VALUE => $this->value,
      self::CURRENCY => $this->currency,
    ];
  }
}
