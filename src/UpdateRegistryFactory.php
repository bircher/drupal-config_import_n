<?php

namespace Drupal\config_import_n;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Service factory for the update registry.
 */
class UpdateRegistryFactory implements ContainerAwareInterface {

  use ContainerAwareTrait;

  /**
   * Creates a new PreImportRegistry instance.
   *
   * @return \Drupal\config_import_n\PreImportRegistry
   *   The pre_config_import registry
   */
  public function createPreImport() {
    return $this->createInstance(PreImportRegistry::class, 'pre_config_import');
  }

  /**
   * Creates a new PreImportRegistry instance.
   *
   * @return \Drupal\config_import_n\PreImportRegistry
   *   The pre_config_import registry
   */
  public function createPostImport() {
    return $this->createInstance(PostImportRegistry::class, 'post_config_import');
  }

  /**
   * Creates a new UpdateRegistry instance.
   *
   * @return mixed
   *   The update registry instance.
   */
  protected function createInstance($class, $key_value) {
    return new $class($this->container->get('app.root'), $this->container->get('site.path'), array_keys($this->container->get('module_handler')->getModuleList()), $this->container->get('keyvalue')->get($key_value));
  }

}
