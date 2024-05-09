<?php

namespace Drupal\whatsapp;

use Drupal\Component\Utility\Crypt;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

/**
 * Allows caching the external library locally.
 *
 * Based on code from Google Analytics module
 * (https://www.drupal.org/project/google_analytics).
 */
class JavascriptLocalCache {

  /**
   * The file URL generator.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * The file system helper.
   *
   * @var \Drupal\Core\File\FileSystem
   */
  protected $fileSystem;

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The logger channel interface.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * The client interface for sending HTTP requests.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Constructs a new JavascriptLocalCache object.
   *
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $file_url_generator
   *   The file URL generator.
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The client interface for sending HTTP requests.
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system helper.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   The logger channel interface.
   */
  public function __construct(FileUrlGeneratorInterface $file_url_generator, ClientInterface $http_client, FileSystemInterface $file_system, ConfigFactoryInterface $config_factory, LoggerChannelFactoryInterface $logger_factory) {
    $this->fileUrlGenerator = $file_url_generator;
    $this->httpClient = $http_client;
    $this->fileSystem = $file_system;
    $this->configFactory = $config_factory;
    $this->logger = $logger_factory->get('whatsapp');
  }

  /**
   * Cache external library locally.
   *
   * @param string $key
   *   The key ID.
   * @param bool $synchronize
   *   Synchronize to local cache if remote file has changed.
   *
   * @return string
   *   The path to the local or remote library.
   */
  public function fetchWhatsappJavascript(string $key, bool $synchronize = FALSE) {
    $path = 'public://whatsapp';
    $file_destination = $path . '/bundle.js';
    $remote_url = "//widget.tochat.be/bundle.js?key=$key";

    if (!$this->configFactory->get('whatsapp.settings')->get('external_library_cache')) {
      return $remote_url;
    }

    if (!file_exists($file_destination) || $synchronize) {
      try {
        $data = (string) $this->httpClient->request('GET', $remote_url)->getBody();

        if (file_exists($file_destination)) {
          // If local != remote, then they are outdated and need to be replaced.
          $data_hash_local = Crypt::hashBase64(file_get_contents($file_destination));
          $data_hash_remote = Crypt::hashBase64($data);
          if ($data_hash_local != $data_hash_remote && $this->fileSystem->prepareDirectory($path)) {
            $this->fileSystem->saveData($data, $file_destination, FileSystemInterface::EXISTS_REPLACE);
            if (extension_loaded('zlib') && $this->configFactory->get('system.performance')->get('js.gzip')) {
              $this->fileSystem->saveData(gzencode($data, 9, FORCE_GZIP), $file_destination . '.gz', FileSystemInterface::EXISTS_REPLACE);
            }
            $this->logger->info('Locally cached tracking code file has been updated.');

            _drupal_flush_css_js();
          }
        }
        else {
          if ($this->fileSystem->prepareDirectory($path, FileSystemInterface::CREATE_DIRECTORY)) {
            // Since new files are added, refreshes JS caches automatically.
            $this->fileSystem->saveData($data, $file_destination, FileSystemInterface::EXISTS_REPLACE);
            if (extension_loaded('zlib') && $this->configFactory->get('system.performance')->get('js.gzip')) {
              $this->fileSystem->saveData(gzencode($data, 9, FORCE_GZIP), $file_destination . '.gz', FileSystemInterface::EXISTS_REPLACE);
            }
            $this->logger->info('Locally cached library file has been saved.');
          }
        }
      }
      catch (RequestException $exception) {
        watchdog_exception('whatsapp', $exception);
        return $remote_url;
      }
    }

    return $this->fileUrlGenerator->generateString($file_destination);

  }

  /**
   * Delete cached files and directory.
   */
  public function clearWhatsappJsCache() {
    $path = 'public://whatsapp';
    if (is_dir($path)) {
      $this->fileSystem->deleteRecursive($path);

      _drupal_flush_css_js();

      $this->logger->info('Local WhatsApp file cache has been purged.');
    }
  }

}
