<?php
namespace App\Service\Helper;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ResponseHelper
{
  public static function serializeViolations(
    ConstraintViolationListInterface $violations
  ): string {
    $result = [];

    foreach ($violations as $violation) {
      $result[$violation->getPropertyPath()][] = $violation->getMessage();
    }

    return json_encode($result);
  }
}
