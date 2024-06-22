<?php

namespace Drupal\layoffrealty_bot\Service;

use Drupal\layoffrealty_bot\Service\TelegramService;
use Drupal\Core\Entity\EntityInterface;
use Drupal\file\Entity\File;
use Drupal\Core\Url;
use stdClass;

class TelegramSendMessages {

  protected $telegramService;

  public function __construct(TelegramService $telegramService) {
    $this->telegramService = $telegramService;
  }

  public function sendMessagesToTelegram(EntityInterface $entity) {
    $api_token = $this->telegramService->getApiToken();
    $chat_id = $this->telegramService->getChatId();

    if ($entity->getEntityTypeId() === 'node' && $entity->bundle() === 'realty') {
      $result = new stdClass();
      $result->body = '';
      $result->images = [];
  
      if ($entity->hasField('body') && !$entity->get('body')->isEmpty()) {
        $result->body = $entity->get('body')->value;
      }
  
      if ($entity->hasField('field_realty_images') && !$entity->get('field_realty_images')->isEmpty()) {
        $field_images = $entity->get('field_realty_images')->getValue();
  
        foreach ($field_images as $field_image) {
          $file = File::load($field_image['target_id']);
          
          if ($file) {
            // Get the file URL using the Url class.
            $file_url = Url::fromUri('internal://' . $file->getFileUri())->toString();
            $site_file_store = "sites/default/files";
            $base_url = Url::fromRoute('<front>', [], ['absolute' => TRUE])->toString();
  
            $full_url = $base_url .  $site_file_store . $file_url;
  
            $result->images[] = $full_url;
            
          }
        }
      }
    }

    $response = file_get_contents("https://api.telegram.org/bot$api_token/sendMessage?chat_id=$chat_id&text=" . urlencode($result->body));

    return $response;
  }
}
