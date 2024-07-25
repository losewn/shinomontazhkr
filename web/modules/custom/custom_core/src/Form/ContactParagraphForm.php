<?php

namespace Drupal\custom_core\Form;
use \Drupal\node\Entity\Node;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ContactParagraphForm.
 */
class ContactParagraphForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'get_licence_guide_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $data = NULL) {
    $form['#attributes']['class'][] = 'label-as-placeholder';
    $form['#attributes']['id'][] = 'contact_form';

    $form['start_form_contact_div'] = [
      '#type' => 'markup',
      '#markup' => '<div class="row">'
    ];

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Ім'я"),
      '#maxlength' => 64,
      '#attributes' => array('class' => ['form-control']),
      '#size' => 64,
      '#required' => TRUE,
      '#prefix' => '<div class="col-12 col-md-6">',
      '#suffix' => '</div>'
    ];

    $form['contact'] = array(
      '#type' => 'textfield',
      '#title' => t("Телефон або пошта"),
      '#attributes' => array('class' => ['form-control']),
      '#required' => TRUE,
      '#prefix' => '<div class="col-12 col-md-6">',
      '#suffix' => '</div>'
    );

    $form['message'] = array(
      '#type' => 'textfield',
      '#title' => t('Повідомлення'),
      '#attributes' => array('class' => ['form-control']),
      '#required' => TRUE,
      '#prefix' => '<div class="col-12">',
      '#suffix' => '</div>'
    );



    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Отримати консультацію'),
      '#attributes' => array('class' => ['btn', 'btn-secondary']),
      '#prefix' => '<div class="col-sm-12">',
      '#suffix' => '</div>'
    ];

    $form['end_form_contact_div'] = [
      '#type' => 'markup',
      '#markup' => '</div>'
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

    $values = $form_state->getValues();

    \Drupal::messenger()->addStatus(t('Your message was successfully sent. We\'ll contact you shortly to assist with your license.'));

// Create node object with attached file.
    $node = Node::create([
      'type'     => 'requests',
      'title'     => 'Client ' . $values['name'],
      'field_name'     => $values['name'],
      'field_contact'   => $values['contact'],
      'field_message'    => $values['message'],
    ]);
    $node->save();

    $message = [
      '#type' => 'markup',
      '#markup' => t('Your message was successfully sent. We\'ll contact you shortly to assist with your license.'),
    ];

    \Drupal::messenger()->addStatus($message);
  }


}
