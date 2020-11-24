<?php
/**
 * @file
 * Settings metadata for com.aghstrategies.proratemembership.
 * Copyright (C) 2020, AGH Strategies, LLC <info@aghstrategies.com>
 * Licensed under the GNU Affero Public License 3.0 (see LICENSE.txt)
 */

return [
  'throttlespam_preferences' => [
    'group_name' => 'Throttle Spam Preferences',
    'group' => 'throttlespam',
    'name' => 'throttlespam_preferences',
    'type' => 'Array',
    'default' => NULL,
    'add' => '5.0',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => 'Array of settings for throttle spam',
    'help_text' => 'Settings for the extension com.aghstrategies.throttlespam',
  ],
];
