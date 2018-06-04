<?php

namespace Drupal\ad_general;

/**
 * Class Counter.
 */
class Counter implements CounterInterface {

  /**
   * {@inheritdoc}
   */
  public function add($firstNumber, $secondNumber) {
    // Check whether the arguments are numeric.
    foreach ([$firstNumber, $secondNumber] as $argument) {
      if (!is_numeric($argument)) {
        throw new \InvalidArgumentException('Arguments must be numeric.');
      }
    }
    return $firstNumber + $secondNumber;
  }

  /**
   * {@inheritdoc}
   */
  public function checkNumbers(array $numbers) {
    foreach ($numbers as $number) {
      if (!is_numeric($number)) {
        throw new \InvalidArgumentException('Arguments must be numeric.');
      }
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function quickMaths($operation, array $numbers) {
    // Check numbers.
    if ($this->checkNumbers($numbers)) {

      switch ($operation) {
        case '+':
          $result = 0;
          foreach ($numbers as $number) {
            $result += $number;
          }

          return $result;

        case '-':
          $result = 0;
          foreach ($numbers as $number) {
            $result -= $number;
          }

          return $result;

        case '/':
          $result = 1;
          foreach ($numbers as $number) {
            $result /= $number;
          }

          return $result;

        case '*':
          $result = 1;
          foreach ($numbers as $number) {
            $result *= $number;
          }

          return $result;

        default:
          throw new \InvalidArgumentException('Operation not found.');
      }
    }
  }

}
