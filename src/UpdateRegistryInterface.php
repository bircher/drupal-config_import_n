<?php

namespace Drupal\config_import_n;

/**
 * Interface UpdateRegistryInterface.
 *
 * This is the interface core implements implicitly.
 *
 * @package Drupal\config_import_n
 */
interface UpdateRegistryInterface {

  /**
   * Find all update functions that haven't been executed.
   *
   * @return callable[]
   *   A list of update functions.
   */
  public function getPendingUpdateFunctions();

  /**
   * Returns a list of all the pending updates.
   *
   * @return array[]
   *   An associative array keyed by module name which contains all information
   *   about database updates that need to be run, and any updates that are not
   *   going to proceed due to missing requirements.
   *
   *   The subarray for each module can contain the following keys:
   *   - start: The starting update that is to be processed. If this does not
   *       exist then do not process any updates for this module as there are
   *       other requirements that need to be resolved.
   *   - pending: An array of all the pending updates for the module including
   *       the description from source code comment for each update function.
   *       This array is keyed by the update name.
   */
  public function getPendingUpdateInformation();

  /**
   * Registers that update fucntions got executed.
   *
   * @param string[] $function_names
   *   The executed update functions.
   *
   * @return $this
   */
  public function registerInvokedUpdates(array $function_names);

  /**
   * Returns all available updates for a given module.
   *
   * @param string $module_name
   *   The module name.
   *
   * @return callable[]
   *   A list of update functions.
   */
  public function getModuleUpdateFunctions($module_name);

  /**
   * Filters out already executed update functions by module.
   *
   * @param string $module
   *   The module name.
   */
  public function filterOutInvokedUpdatesByModule($module);

}