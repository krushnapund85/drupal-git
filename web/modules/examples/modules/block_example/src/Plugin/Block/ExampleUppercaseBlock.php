<?php

namespace Drupal\block_example\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Example: uppercase this please' block.
 *
 * @Block(
 *   id = "example_uppercase",
 *   admin_label = @Translation("Example: uppercase this please")
 * )
 * 
 */

class ExampleUppercaseBlock extends BlockBase{
  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    //dump($user->name->value);die;
     /**
   * {@inheritdoc}
   */
   
    return [
      '#markup' => $this->getGreetings() . ' ' . $user->name->value,
    ];
  }
  function getGreetings() {
    $time = new \DateTime();
    if ((int) $time->format('G') >= 00 && (int) $time->format('G') < 12) {
      $out = t('Good Morning');
    }
    if ((int) $time->format('G') >= 12 && (int) $time->format('G') < 17) {
      $out = t('Good Afternoon');
    }
    if ((int) $time->format('G') >= 17 && (int) $time->format('G') < 19) {
      $out = t('Good Evening');
    }
    if ((int) $time->format('G') >= 19)  {
      $out = t('Good Night');
    }
    return $out;
  }
}