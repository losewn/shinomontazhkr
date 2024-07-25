<?php

namespace Drupal\custom_core\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Plugin\PluginFormInterface;

class ContainerColumn extends LayoutDefault implements PluginFormInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
      'additional_class' => ''
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    $configuration = $this->getConfiguration();

    $form['additional_class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Additional class'),
      '#default_value' => $configuration['additional_class'],
    ];

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    // any additional form validation that is required
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['additional_class'] = $form_state->getValue('additional_class');
  }

}
