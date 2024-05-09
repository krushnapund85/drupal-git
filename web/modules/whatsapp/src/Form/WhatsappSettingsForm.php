<?php

namespace Drupal\whatsapp\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\key\KeyRepositoryInterface;
use Drupal\whatsapp\JavascriptLocalCache;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure WhatsApp module settings.
 */
class WhatsappSettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'whatsapp.settings';

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
   * Constructs a new Whatsapp settings form.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\key\KeyRepositoryInterface $key_repository
   *   The key repository service.
   * @param \Drupal\whatsapp\JavascriptLocalCache $javascript_service
   *   The JavaScript service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, KeyRepositoryInterface $key_repository, JavascriptLocalCache $javascript_service) {
    parent::__construct($config_factory);
    $this->keyRepository = $key_repository;
    $this->javascriptService = $javascript_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('key.repository'),
      $container->get('whatsapp.javascript_cache')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'whatsapp_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['widget_key'] = [
      '#type' => 'key_select',
      '#title' => $this->t('Widget key'),
      '#default_value' => $config->get('widget_key'),
    ];

    $form['advanced']['external_library_cache'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Locally cache external library'),
      '#description' => $this->t('If checked, the external library is cached locally.'),
      '#default_value' => $config->get('external_library_cache'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->isValueEmpty('external_library_cache') && $form['advanced']['external_library_cache']['#default_value']) {
      $this->javascriptService->clearWhatsappJsCache();
    }

    $this->configFactory->getEditable(static::SETTINGS)
      ->set('external_library_cache', $form_state->getValue('external_library_cache'))
      ->set('widget_key', $form_state->getValue('widget_key'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
