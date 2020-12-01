<?php
use CRM_Throttlespam_ExtensionUtil as E;

class CRM_Throttlespam_BAO_ThrottleSpamIp extends CRM_Throttlespam_DAO_ThrottleSpamIp {

  /**
   * Create a new ThrottleSpamIp based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Throttlespam_DAO_ThrottleSpamIp|NULL
   *
  public static function create($params) {
    $className = 'CRM_Throttlespam_DAO_ThrottleSpamIp';
    $entityName = 'ThrottleSpamIp';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

}
