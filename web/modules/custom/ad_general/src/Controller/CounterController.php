<?php

namespace Drupal\ad_general\Controller;

use Drupal\ad_general\Counter;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class CounterController.
 */
class CounterController extends ControllerBase {

  /**
   * Count 2 numbers together.
   *
   * @return array
   *   Return Hello string.
   */
  public function count($first, $second) {
    $counter = new Counter();
    $result = $counter->add($first, $second);

    return [
      '#type' => 'markup',
      '#markup' => $this->t('Result is: @number', ['@number' => $result]),
    ];
  }

  /**
   * Display result in markup.
   *
   * @param int|float $result
   *   The result.
   *
   * @return array
   *   Return markup.
   */
  public function result($result) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Result is: @result', ['@result' => $result]),
    ];
  }

}
