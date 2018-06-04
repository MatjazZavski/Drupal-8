<?php

namespace Drupal\Tests\ad_general\Unit;

use Drupal\ad_general\Counter;
use Drupal\Tests\UnitTestCase;

/**
 * CounterTest Class.
 *
 * @group ad_general
 */
class CounterTest extends UnitTestCase {

  public $counter;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->counter = new Counter();
  }

  /**
   * Data provider for testAdd().
   */
  public function provideTestAdd() {
    return [
      [5, 2, 3],
      [50, 20, 30],
      [-99, 1, -100],
    ];
  }

  /**
   * Bad data provider for testBadDataAdd().
   */
  public function addBadDataProvider() {
    return [
     ['', NULL],
     ['string', new \stdClass()],
     [FALSE, []],
    ];
  }

  /**
   * Test for add method.
   *
   * @dataProvider provideTestAdd
   */
  public function testAdd($expected, $first, $second) {
    $this->assertEquals($expected, $this->counter->add($first, $second));
  }

  /**
   * Bad providers Test for add method.
   *
   * @dataProvider addBadDataProvider
   *
   * @expectedException \InvalidArgumentException
   */
  public function testBadDataAdd($first, $second) {
    $this->counter->add($first, $second);
  }

  /**
   * Test for checkNumbers().
   *
   * @dataProvider provideTestCheckNumbers
   */
  public function testCheckNumbers(bool $expected, array $numbers) {
    $this->assertEquals($expected, $this->counter->checkNumbers($numbers));
  }

  /**
   * Invalid test for checkNumbers().
   *
   * @dataProvider invalidCheckNumbersProvider
   *
   * @expectedException \InvalidArgumentException
   */
  public function testInvalidCheckNumbers(array $numbers) {
    $this->counter->checkNumbers($numbers);
  }

  /**
   * Invalid data provider for testInvalidCheckNumbers().
   */
  public function invalidCheckNumbersProvider() {
    return [
      [
        [new \stdClass(), NULL, '', 'string'],
      ],
    ];
  }

  /**
   * Data provider for testCheckNumbers().
   */
  public function provideTestCheckNumbers() {
    return [
      [
        TRUE,
        [1, 2 -5, 10, 100000, 015],
      ],
    ];
  }

  /**
   * Data provider for testQuickMaths.
   */
  public function operationProvider() {
    return [
      [
        ['+', '-', '/', '*'],
        [1, 2, 5, 10, 100000, 15],
        [100033, -100033, 6.66666666667E-9, 150000000],
      ],
    ];
  }

  /**
   * Data provider for testQuickMaths.
   */
  public function badOperationProvider() {
    return [
      [
        ['string', 500, NULL, []],
        [new \stdClass(), NULL, '', 'string'],
      ],
    ];
  }

  /**
   * Test for quickMaths().
   *
   * @dataProvider operationProvider
   */
  public function testQuickMaths(array $operations, array $numbers, array $expected) {
    foreach ($operations as $key => $operation) {
      $this->assertEquals($expected[$key], $this->counter->quickMaths($operation, $numbers));
    }
  }

  /**
   * Test for quickMaths().
   *
   * @dataProvider badOperationProvider
   *
   * @expectedException \InvalidArgumentException
   */
  public function testBadQuickMaths(array $operations, array $numbers) {
    foreach ($operations as $operation) {
      $this->counter->quickMaths($operation, $numbers);
    }
  }

}
