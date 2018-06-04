<?php

namespace Drupal\ad_general\Form;

use Drupal\ad_general\Counter;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MathOperationForm.
 */
class MathOperationForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'math_operation_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $header = [
      'number' => t('Number'),
      'operation' => t('Operation'),
    ];

    $form['table'] = [
      '#type' => 'table',
      '#title' => $this->t('Users'),
      '#header' => $header,
      '#empty' => t('No users found'),
    ];

    for ($i = 0; $i < 2; $i++) {
      $form['table'][$i]['number'] = [
        '#type' => 'textfield',
        '#title' => t('Number'),
      ];

      if ($i == 1) {
        $form['table'][$i]['operation'] = [
          '#type' => 'select',
          '#title' => $this->t('Operation'),
          '#default_value' => 'end',
          '#disabled' => TRUE,
          '#options' => [
            '+' => 'Add (+)',
            '-' => 'Subtract (-)',
            '*' => 'Multiply (*)',
            '/' => 'Divide (/)',
            'end' => 'Equals (=)',
          ],
        ];
      }
      else {
        $form['table'][$i]['operation'] = [
          '#type' => 'select',
          '#title' => $this->t('Operation'),
          '#default_value' => '+',
          '#options' => [
            '+' => 'Add (+)',
            '-' => 'Subtract (-)',
            '*' => 'Multiply (*)',
            '/' => 'Divide (/)',
            'end' => 'Equals (=)',
          ],
        ];
      }
    }

    $form_state->setCached(FALSE);
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue(['table']);
    $numbers = [];
    $operators = [];
    foreach ($values as $parent) {
      array_push($numbers, $parent['number']);
      if ($parent['operation'] != 'end') {
        array_push($operators, $parent['operation']);
      }
    }
    $counter = new Counter();
    $result = '';
    foreach ($operators as $operator) {
      $result = $counter->quickMaths($operator, $numbers);
    }
    $form_state->setRedirect('ad_general.counter_controller_result', ['result' => $result]);
  }

}
