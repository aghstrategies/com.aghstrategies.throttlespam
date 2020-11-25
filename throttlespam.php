<?php

require_once 'throttlespam.civix.php';
// phpcs:disable
use CRM_Throttlespam_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function throttlespam_civicrm_config(&$config) {
  _throttlespam_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_buildForm
 */
function throttlespam_civicrm_buildForm($formName, &$form) {
  // print_r($formName); die();
  if ($formName == 'CRM_Contribute_Form_Contribution_Main' || $formName == 'CRM_Event_Form_Registration_Register') {
    $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    if (throttlespam_checkIP($ip)) {
      CRM_Utils_System::permissionDenied();
    }
  }
}

// TODO check If IP is ok or should be banned
function throttlespam_checkIP($ip) {
  $ipBlock = FALSE;
  $getSettings = throttlespam_apiHelper('Setting', 'get', ['return' => ["throttlespam_preferences"]]);
  if (isset($getSettings['values'][$getSettings['id']]['throttlespam_preferences'])) {
    $throttleSpamSettings = $getSettings['values'][$getSettings['id']]['throttlespam_preferences'];
    $settingsFields = CRM_Throttlespam_Form_Settings::settingsFields();

    foreach ($throttleSpamSettings as $scenario => $numberOfAttempts) {
      if (isset($settingsFields[$scenario]['sql_time'])) {
        // TODO check based off logged IPs
        // TODO check based off whether the submission went thru successfully or not
        $sql = "select count(*) from civicrm_contribution where receive_date > date_sub(now(), {$settingsFields[$scenario]['sql_time']});";
        $numberOfTries = CRM_Core_DAO::singleValueQuery($sql);
        if ($numberOfTries >= $numberOfAttempts) {
          $ipBlock = TRUE;
        }
      }
    }
  }
  return $ipBlock;
}

// TODO log ip addresses
function throttlespam_logIP() {

}

function throttlespam_apiHelper($entity, $action, $params) {
  $result = [];
  try {
     $result = civicrm_api3($entity, $action, $params);
   }
   catch (CiviCRM_API3_Exception $e) {
     $error = $e->getMessage();
     CRM_Core_Error::debug_log_message(ts('API Error %1', [
       'domain' => 'com.aghstrategies.throttlespam',
       1 => $error,
     ]));
     $result = [
       'error_message' => $error,
       'is_error' => 1,
     ];
   }
   return $result;
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function throttlespam_civicrm_xmlMenu(&$files) {
  _throttlespam_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function throttlespam_civicrm_install() {
  _throttlespam_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function throttlespam_civicrm_postInstall() {
  _throttlespam_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function throttlespam_civicrm_uninstall() {
  _throttlespam_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function throttlespam_civicrm_enable() {
  _throttlespam_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function throttlespam_civicrm_disable() {
  _throttlespam_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function throttlespam_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _throttlespam_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function throttlespam_civicrm_managed(&$entities) {
  _throttlespam_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function throttlespam_civicrm_caseTypes(&$caseTypes) {
  _throttlespam_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function throttlespam_civicrm_angularModules(&$angularModules) {
  _throttlespam_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function throttlespam_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _throttlespam_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function throttlespam_civicrm_entityTypes(&$entityTypes) {
  _throttlespam_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function throttlespam_civicrm_themes(&$themes) {
  _throttlespam_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function throttlespam_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function throttlespam_civicrm_navigationMenu(&$menu) {
 _throttlespam_civix_insert_navigation_menu($menu, 'Administer', array(
   'label' => E::ts('Throttle Spam Settings'),
   'name' => 'throttlespam_settings',
   'url' => 'civicrm/throttlespam/settings',
   'permission' => 'access CiviCRM',
   'operator' => 'OR',
   'separator' => 0,
 ));
 _throttlespam_civix_navigationMenu($menu);
}
