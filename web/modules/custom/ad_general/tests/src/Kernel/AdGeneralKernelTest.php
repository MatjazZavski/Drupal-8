<?php

namespace Drupal\Tests\ad_general\Kernel;


use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\node\Traits\NodeCreationTrait;
use Drupal\Tests\user\Traits\UserCreationTrait;

/**
 * Class AdGeneralKernelTest.
 *
 * @package Drupal\Tests\ad_general\Kernel
 */
class AdGeneralKernelTest extends KernelTestBase {

  // Additional traits can be imported for more prebuilt tools in the tests.
  use NodeCreationTrait;
  use UserCreationTrait;

  /**
   * {@inheritdoc}
   *
   * Any modules added here will be loaded, along with anything in $modules in
   * parent classes.
   *
   * These modules are not installed, but their services and hooks are
   * available.
   *
   * @var string[]
   */
  public static $modules = ['user', 'system', 'field', 'node', 'text', 'filter'];

  /**
   * An 'owner' user object.
   *
   * @var \Drupal\user\Entity\UserInterface
   */
  protected $owner;

  /**
   * {@inheritdoc}
   *
   * Use setUp() to do anything that is common to all the tests in this class.
   *
   * Group tests in a class so they can take advantage of setUp() activities
   * as much as possible.
   *
   * In a Kernel test, setUp() can be responsible for creating any schema or
   * database configuration which must exist for the test.
   */
  protected function setUp() {
    parent::setUp();

    // Since kernel tests do not install modules, we have to install whatever
    // schema and config we expect to be present in those modules.
    //
    // Figuring out what schema and EntitySchema and config to install is not
    // always easy. Use core kernel tests for examples. The baseline is that you
    // have to install everything in the database that is needed.
    //
    // Sequences table is prerequisite of the 'node' schema.
    $this->installSchema('system', ['sequences']);

    // Install *module* schema for node/user modules.
    $this->installSchema('node', ['node_access']);
    $this->installSchema('user', ['users_data']);

    // Install *entity* schema for the node entity.
    $this->installEntitySchema('node');
    $this->installEntitySchema('user');

    // Install any config provided by the enabled.
    $this->installConfig(['field', 'node', 'text', 'filter', 'user']);

    // Finally, create an 'owner' account.
    $this->owner = $this->createUser([], 'testuser');
  }

  /**
   * Create a node by using createNode() from NodeCreationTrait.
   */
  public function testNodeCreation() {
    // Unless there's a specific reason to do so, strings in tests should not be
    // translated with t().
    $nodeTitle = 'Test Node!';



    /** @var \Drupal\node\NodeInterface $node */
    $node = $this->createNode([
                                'title' => $nodeTitle,
                                'type' => 'company',
                                'uid' => $this->owner->id(),
                              ]);
    var_dump($node);
    // Assert that the node we created has the title we expect.
    $this->assertEquals($nodeTitle, $node->getTitle());
  }

  /**
   * Create a user account using createUser() from the UserCreation trait.
   */
  public function testUserCreation() {
    // Create a user named 'extrauser'.
    $account = $this->createUser([], 'extrauser');
    // Assert that this user exists.
    $this->assertEquals('extrauser', $account->getAccountName());

    // Assert that our auth user is not the same user as extrauser.
    $this->assertNotEquals($this->owner->getAccountName(), $account->getAccountName());
  }

}
