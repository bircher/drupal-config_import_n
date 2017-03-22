<?php

namespace Drupal\config_import_n;

use Drupal\Core\Config\ConfigImporter;
use Psr\Log\LoggerInterface;

/**
 * Class ConfigSyncBatch
 * @package Drupal\config_import_n
 */
class ConfigSyncBatch {

  protected $preImport;
  protected $postImport;
  protected $logger;

  public function __construct(UpdateRegistryInterface $pre_import_registry, UpdateRegistryInterface $post_import_registry, LoggerInterface $logger) {
    $this->preImport = $pre_import_registry;
    $this->postImport = $post_import_registry;
    $this->logger = $logger;
  }


  public function addSyncSteps(&$sync_steps) {
    // Add the pre import to the beginning and the post import to the end.
    // The steps are called again and again.
    array_unshift($sync_steps, [$this, 'callPreImportFunctions']);
    array_push($sync_steps, [$this, 'callPostImportFunctions']);
  }


  public function callPreImportFunctions(&$context, ConfigImporter $importer) {
    $this->invokeUpdateFunction($this->preImport, $context, $importer);
  }

  public function callPostImportFunctions(&$context, ConfigImporter $importer) {
    $this->invokeUpdateFunction($this->postImport, $context, $importer);
  }

  protected function invokeUpdateFunction(UpdateRegistryInterface $registry, &$context, ConfigImporter $importer) {

    // Getting all pending update functions loads the necessary files so that
    // subsequently the pending function is thus available.
    $pending = $registry->getPendingUpdateFunctions();
    $context['pending'] = count($pending);

    if (empty($pending)) {
      // Nothing is pending, do nothing further.
      $context['finished'] = 1;
      return;
    }

    if (!isset($context['total'])) {
      $context['total'] = count($pending);
    }

    $function = array_shift($pending);


    $func = new \ReflectionFunction($function);
    $description = trim(str_replace(["\n", '*', '/'], '', $func->getDocComment()), ' ');
    $this->logger->info('Performing: ' . $description);


    // @TODO: defice if we want to catch exceptions.
    $function($context['sandbox'], $importer);

    if (!isset($context['sandbox']['#finished']) || (isset($context['sandbox']['#finished']) && $context['sandbox']['#finished'] >= 1)) {
      $registry->registerInvokedUpdates([$function]);
      $context['pending']--;
      $this->logger->debug('Performed: ' . $description);
    }

    $context['finished'] = ($context['total'] - $context['pending']) / $context['total'];
  }

}