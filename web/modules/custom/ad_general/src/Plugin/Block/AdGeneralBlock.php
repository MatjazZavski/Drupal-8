<?php

namespace Drupal\ad_general\Plugin\Block;

use Drupal\Component\Datetime\DateTimePlus;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\node\Entity\Node;
use \Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Ad_General' Block.
 *
 * @Block(
 *   id = "event_days",
 *   admin_label = @Translation("Event Days"),
 * )
 */
class AdGeneralBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Creates a LocalTasksBlock instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $route_match) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $node = $this->routeMatch->getParameter('node');

    // Check for Node instance.
    if ($node instanceof Node) {
      // Get start & end date.
      $startDate = $node->field_event_start_end_date->start_date;
      $endDate = $node->field_event_start_end_date->end_date;
      // Create diff with current date and check if event has ended.
      $diff = $startDate->diff(new DateTimePlus());
      $hasEnded = $endDate < new DrupalDateTime();
      // Get days left until event start.
      $days = $diff->days;
      // Check if event has ended.
      if ($hasEnded) {
        $build = [
          '#type' => 'markup',
          '#markup' => $this->t('The event has ended.'),
        ];
      }
      // Event has not started.
      elseif ($days > 0) {
        $build = [
          '#type' => 'markup',
          '#markup' => $this->t('Days left to event start: @days', ['@days' => $days]),
        ];
      }
      // Event is in progress.
      elseif ($days == 0) {
        $build = [
          '#type' => 'markup',
          '#markup' => $this->t('The event is in progress.'),
        ];
      }
    }

    return $build;
  }

}
