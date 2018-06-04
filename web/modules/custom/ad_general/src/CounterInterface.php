<?php

namespace Drupal\ad_general;

/**
 * Interface CounterInterface.
 *
 * @package Drupal\ad_general
 */
interface CounterInterface {

  /**
   * Sums 2 numbers together.
   *
   * @param int|float $firstNumber
   *    First number.
   * @param int|float $secondNumber
   *    Second number.
   *
   * @return int|float|\InvalidArgumentException
   *    Returns number or invalid argument exception.
   */
  public function add($firstNumber, $secondNumber);

  /**
   * Quick maths function.
   *
   * @param string $operation
   *   Math operation.
   * @param array $numbers
   *   Array of numbers.
   *
   * @return mixed|string
   *   Returns result.
   */
  public function quickMaths($operation, array $numbers);

  /**
   * Check if all numbers in array are numeric.
   *
   * @param array $numbers
   *   The array of numbers.
   *
   * @return \InvalidArgumentException
   *   Return exception if number is not correct.
   */
  public function checkNumbers(array $numbers);

}
