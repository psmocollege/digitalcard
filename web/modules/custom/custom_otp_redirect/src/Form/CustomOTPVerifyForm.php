<?php

namespace Drupal\custom_otp_redirect\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Flood\FloodInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\UserDataInterface;

/**
 * Custom form to override OTP verification form.
 */
class CustomOTPVerifyForm extends FormBase {

  /**
   * Constructs an ExampleForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entityTypeManager.
   * @param \Drupal\Core\Flood\FloodInterface $flood
   *   The flood control handler.
   * @param \Drupal\user\UserDataInterface $userData
   *   The user data handler.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, FloodInterface $flood, UserDataInterface $userData) {
    $this->entityTypeManager = $entityTypeManager;
    $this->flood = $flood;
    $this->userData = $userData;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('entity_type.manager'), $container->get('flood'), $container->get('user.data'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'otp_verify_form';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state); // Call parent to ensure all other submit logic executes
    
    // Redirect to node/add/digitalcards after successful OTP verification.
    $form_state->setRedirect('node.add', ['node_type' => 'digitalcards']);
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Implement buildForm logic if needed, or reuse from OTP module.
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Implement validation if needed, or reuse from OTP module.
    parent::validateForm($form, $form_state);
  }
}
