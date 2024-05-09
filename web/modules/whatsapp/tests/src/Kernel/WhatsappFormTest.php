<?php

namespace Drupal\Tests\whatsapp\Kernel;

use Drupal\Core\Form\FormInterface;
use Drupal\KernelTests\KernelTestBase;
use Drupal\whatsapp\Form\WhatsappSettingsForm;

/**
 * WhatsApp Kernel test for form.
 *
 * Based on code from Google Analytics module
 * (https://www.drupal.org/project/google_analytics).
 *
 * @group whatsapp
 */
class WhatsappFormTest extends KernelTestBase {

  /**
   * The WhatsApp form object under test.
   *
   * @var Drupal\whatsapp\Form\WhatsappSettingsForm
   */
  protected $whatsappSettingsForm;


  /**
   * Modules to install.
   *
   * @var array
   */
  protected static $modules = ['whatsapp', 'key'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installConfig(static::$modules);
    $this->whatsappSettingsForm = new WhatsappSettingsForm(
      $this->container->get('config.factory'),
      $this->container->get('key.repository'),
      $this->container->get('whatsapp.javascript_cache')
    );
  }

  /**
   * Tests for Drupal\whatsapp\Form\WhatsappSettingsForm.
   */
  public function testWhatsappSettingsForm() {
    $this->assertInstanceOf(FormInterface::class, $this->whatsappSettingsForm);

    $this->assertEquals('whatsapp_settings', $this->whatsappSettingsForm->getFormId());

    $method = new \ReflectionMethod(whatsappSettingsForm::class, 'getEditableConfigNames');
    $method->setAccessible(TRUE);

    $name = $method->invoke($this->whatsappSettingsForm);
    $this->assertEquals(['whatsapp.settings'], $name);
  }

}
