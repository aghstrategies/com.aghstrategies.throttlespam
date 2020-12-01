<?php
// This file declares a new entity type. For more details, see "hook_civicrm_entityTypes" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
return [
  [
    'name' => 'ThrottleSpamIp',
    'class' => 'CRM_Throttlespam_DAO_ThrottleSpamIp',
    'table' => 'civicrm_throttlespam_ip',
  ],
];
