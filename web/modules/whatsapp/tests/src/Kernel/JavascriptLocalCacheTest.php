<?php

namespace Drupal\Tests\whatsapp\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\block\Traits\BlockCreationTrait;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

/**
 * Tests the Javascript local cache.
 *
 * @group whatsapp
 */
class JavascriptLocalCacheTest extends KernelTestBase {

  use BlockCreationTrait;

  /**
   * Modules to install.
   *
   * @var array
   */
  protected static $modules = ['whatsapp', 'whatsapp_test', 'key', 'system', 'user'];

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The key value.
   *
   * @var string
   */
  protected $key = 'muahahaha';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installConfig(['whatsapp', 'whatsapp_test', 'key']);
    $this->container->get('cache.render')->deleteAll();

    $this->configFactory = $this->container->get('config.factory');
  }

  /**
   * Tests that the external file for caching is being generated correctly.
   */
  public function testFileGeneration() {
    $httpClient = $this->prophesize(ClientInterface::class);
    $httpClient
      ->request('GET', '//widget.tochat.be/bundle.js?key=' . $this->key)
      ->willReturn(new Response(200, [], 'pop!'));
    $this->container->set('http_client', $httpClient->reveal());

    $this->assertFileDoesNotExist('public://whatsapp/bundle.js');

    $this->container->get('state')->set('whatsapp.last_cache', 0);
    $this->configFactory->getEditable('whatsapp.settings')->set('external_library_cache', TRUE)->save();
    whatsapp_cron();
    $this->assertFileExists('public://whatsapp/bundle.js');

  }

}
