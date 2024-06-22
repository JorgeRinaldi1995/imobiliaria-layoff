<?php

namespace Drupal\layoffrealty_bot\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

class TelegramService {

  protected $configFactory;
  protected $entityTypeManager;
  protected $logger;

  public function __construct(ConfigFactoryInterface $configFactory, EntityTypeManagerInterface $entityTypeManager, LoggerChannelFactoryInterface $logger) {
    $this->configFactory = $configFactory;
    $this->entityTypeManager = $entityTypeManager;
    $this->logger = $logger;
  }

  public function getApiToken() {
    return $this->configFactory->get('layoffrealty_bot.settings')->get('api_token');
  }

  public function getChatId() {
    return $this->configFactory->get('layoffrealty_bot.settings')->get('chat_id');
  }
}
