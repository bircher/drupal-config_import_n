<?php

namespace Drupal\config_import_n;

use Drupal\Core\Update\UpdateRegistry;

/**
 * Class PostImportRegistry.
 *
 * @package Drupal\config_import_n
 */
class PostImportRegistry extends UpdateRegistry implements UpdateRegistryInterface {

  /**
   * {@inheritdoc}
   */
  protected $updateType = 'post_config_import';

}
