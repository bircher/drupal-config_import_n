<?php

namespace Drupal\config_import_n;

use Drupal\Core\Update\UpdateRegistry;

/**
 * Class PreImportRegistry.
 *
 * @package Drupal\config_import_n
 */
class PreImportRegistry extends UpdateRegistry implements UpdateRegistryInterface {

  /**
   * {@inheritdoc}
   */
  protected $updateType = 'pre_config_import';

}
