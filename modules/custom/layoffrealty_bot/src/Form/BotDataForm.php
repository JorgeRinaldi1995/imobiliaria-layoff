<?php

namespace Drupal\layoffrealty_bot\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Example form for Telegram bot settings.
 */
class BotDataForm extends ConfigFormBase  {

    /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['layoffrealty_bot.settings'];
  }
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'layoffrealty_bot';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('layoffrealty_bot.settings');

    $form['api_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Token'),
      '#default_value' => $config->get('api_token'),
      '#required' => TRUE,
    ];

    $form['chat_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Chat ID'),
      '#default_value' => $config->get('chat_id'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('layoffrealty_bot.settings')
      ->set('api_token', $form_state->getValue('api_token'))
      ->set('chat_id', $form_state->getValue('chat_id'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
