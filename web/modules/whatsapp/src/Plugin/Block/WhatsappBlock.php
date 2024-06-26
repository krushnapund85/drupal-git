<?php

namespace Drupal\whatsapp\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\key\KeyRepositoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\whatsapp\JavascriptLocalCache;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'WhatsApp' Block.
 *
 * @Block(
 *   id = "whatsapp_block",
 *   admin_label = @Translation("WhatsApp block"),
 * )
 */
class WhatsappBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The key repository.
   *
   * @var \Drupal\key\KeyRepositoryInterface
   */
  protected $keyRepository;

  /**
   * The JavaScript service.
   *
   * @var \Drupal\whatsapp\JavascriptLocalCache
   */
  protected $javascriptService;

  /**
   * Constructs a new WhatsappBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\key\KeyRepositoryInterface $key_repository
   *   The key repository service.
   * @param \Drupal\whatsapp\JavascriptLocalCache $javascript_service
   *   The JavaScript service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, KeyRepositoryInterface $key_repository, JavascriptLocalCache $javascript_service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->keyRepository = $key_repository;
    $this->javascriptService = $javascript_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('key.repository'),
      $container->get('whatsapp.javascript_cache')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $widget_key = $this->configFactory->get('whatsapp.settings')->get('widget_key');
    $key = $this->keyRepository->getKey($widget_key)->getKeyValue();

    return [
      '#type' => 'inline_template',
      '#template' => '<script defer src="{{ url }}"></script>',
      '#context' => [
        'url' => $this->javascriptService->fetchWhatsappJavascript($key),
      ],
    ];

  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return Cache::mergeTags(['config:whatsapp.settings']);
  }

}
