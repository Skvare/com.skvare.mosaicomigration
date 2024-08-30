<?php

require_once 'mosaicomigration.civix.php';
use CRM_Mosaicomigration_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/ 
 */
function mosaicomigration_civicrm_config(&$config) {
  _mosaicomigration_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function mosaicomigration_civicrm_install() {
  _mosaicomigration_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function mosaicomigration_civicrm_enable() {
  _mosaicomigration_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *

 // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function mosaicomigration_civicrm_navigationMenu(&$menu) {
  _mosaicomigration_civix_insert_navigation_menu($menu, 'Administer/System Settings', [
    'label' => E::ts('Mosaico Extension Directory Changes'),
    'name' => 'extension_dir_change',
    'url' => CRM_Utils_System::url('civicrm/mosaicomigration', 'reset=1', TRUE),
    'permission' => 'administer CiviCRM',
    'operator' => 'OR',
    'separator' => 0,
  ]);
  _mosaicomigration_civix_navigationMenu($menu);
}
