<?php

namespace Drupal\Tests\ad_general\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Class MathOperationFormTest.
 *
 * @package Drupal\Tests\ad_general\Functional
 */
class MathOperationFormTest extends BrowserTestBase {

  public static $modules = [
    'ad_general',
  ];

  /**
   * Fixture authenticated user with no permissions.
   *
   * @var \Drupal\user\Entity\UserInterface
   */
  protected $authUser;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    // Create users.
    $this->authUser = $this->drupalCreateUser([
      'access content',
    ]);
  }

  /**
   * This test method fails, so we can be sure our test is discovered.
   */
  public function testCountPage() {
    /** @var \Drupal\Tests\WebAssert $assert */
    $this->drupalLogin($this->authUser);

    $assert = $this->assertSession();
    $this->drupalGet($this->buildUrl('/math'));
    $assert->statusCodeEquals(200);

    // Post a title.
    $edit = [
      'table[0][number]' => 15,
      'table[0][operation]' => '+',
      'table[1][number]' => 10,
      'table[1][operation]' => 'end',
    ];
    $this->drupalPostForm(NULL, $edit, 'Submit');
    $this->assertSession()->addressEquals('/math/25');
    $assert->pageTextContains('Result is: 25');
  }

}
