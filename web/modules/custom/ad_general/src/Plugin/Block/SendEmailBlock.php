<?php

namespace Drupal\ad_general\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a 'Ad_General' Block.
 *
 * @Block(
 *   id = "send_email",
 *   admin_label = @Translation("Send Email"),
 * )
 */
class SendEmailBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\ad_general\Form\Form');
    return $form;
  }

}
