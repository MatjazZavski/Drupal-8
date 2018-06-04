<?php

namespace Drupal\Tests\ad_general\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Ad_general functional test.
 *
 * @group ad_general124124
 */
class CountRouteTest extends BrowserTestBase {

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
    $this->drupalGet($this->buildUrl('/count/30/50'));
    $assert->statusCodeEquals(200);
    $assert->pageTextContains('Result is:');
  }

}
