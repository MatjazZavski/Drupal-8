<?php

namespace Drupal\Tests\ad_general\Functional;

use Drupal\Core\Form\FormState;
use Drupal\Tests\BrowserTestBase;

/**
 * Class SendEmailTest.
 *
 * @package Drupal\Tests\ad_general\Functional
 */
class SendEmailTest extends BrowserTestBase {

  public static $modules = [
    'system',
    'user',
    'ad_general',
    'node',
    'text',
    'taxonomy',
    'field',
    'address',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  public function testFormSubmission() {
   $edit = [
     'name' => 'test',
     'email' => 'test@gmail.com',
   ];
   $this->drupalPostForm('node/1', $edit, 'Submit');
  }

}
