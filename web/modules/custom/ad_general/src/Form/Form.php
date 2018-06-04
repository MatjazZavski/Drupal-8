<?php

namespace Drupal\ad_general\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\Core\Mail\MailManager;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implements an example form.
 */
class Form extends FormBase {

  /**
   * The RouteMatch.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $routeMatch;

  /**
   * The MailManager.
   *
   * @var \Drupal\Core\Mail\MailManager
   */
  protected $mailManager;

  /**
   * The Current user.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * The logger factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactory
   */
  protected $loggerChannelFactory;

  /**
   * Constructs Form class.
   *
   * @param \Drupal\Core\Routing\CurrentRouteMatch $route_match
   *   CurrentRouteMatch definition.
   * @param \Drupal\Core\Mail\MailManager $mailManager
   *   MailManager definition.
   * @param \Drupal\Core\Session\AccountProxy $current_user
   *   The current user.
   * @param \Drupal\Core\Logger\LoggerChannelFactory $logger_channel_factory
   *   The logger factory.
   */
  public function __construct(CurrentRouteMatch $route_match, MailManager $mailManager, AccountProxy $current_user, LoggerChannelFactory $logger_channel_factory) {
    $this->routeMatch = $route_match;
    $this->mailManager = $mailManager;
    $this->currentUser = $current_user;
    $this->loggerChannelFactory = $logger_channel_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_route_match'),
      $container->get('plugin.manager.mail'),
      $container->get('current_user'),
      $container->get('logger.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'send_email_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => t('Name'),
    ];
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => t('Email'),
      '#required' => TRUE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Send'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get current node.
    $node = $this->routeMatch->getParameter('node');

    // Set mailManager, module, key and to.
    $module = 'ad_general';
    $key = 'ad_general_email';
    $to = $form_state->getValue('email');

    // Set params.
    $params['event_title'] = $node->getTitle();
    $params['company_name'] = $node->field_event_organizer
      ->first()
      ->get('entity')
      ->getTarget()
      ->getValue()
      ->getTitle();
    $params['event_url'] = $node->toUrl('canonical', ['absolute' => TRUE])->toString();
    $params['name'] = $form_state->getValue('name');

    $langcode = $this->currentUser->getPreferredLangcode();
    $send = TRUE;

    // Send mail.
    $result = $this->mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
    $messenger = \Drupal::messenger();
    // Check if mail was send.
    if ($result['result'] !== TRUE) {
      $messenger->addMessage('There was a problem sending your email', 'error');
      $this->loggerChannelFactory->get('d8mail')->error('There was a problem sending your email');
    }
    else {
      $messenger->addMessage('The mail has been sent successfully');
      $this->loggerChannelFactory->get('ad_general_mail')->notice('The mail has been sent successfully');
    }
  }

}
