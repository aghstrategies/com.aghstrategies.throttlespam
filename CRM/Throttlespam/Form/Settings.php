<?php

use CRM_Throttlespam_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Throttlespam_Form_Settings extends CRM_Core_Form {
  public function settingsFields () {
    return [
      'per_min' => [
        'label' => 'Per Minute',
        'name' => 'per_min',
        'type' => text,
        'required' => TRUE,
        'help_text' => "No more than X submissions of frontend contribution or event registration forms per minute",
      ],
      'per_5_min' => [
        'label' => 'Per 5 Minutes',
        'name' => 'per_5_min',
        'type' => text,
        'required' => TRUE,
        'help_text' => "No more than X submissions of frontend contribution or event registration forms per five minutes",
      ],
      'per_hour' => [
        'label' => 'Per hour',
        'name' => 'per_hour',
        'type' => text,
        'required' => TRUE,
        'help_text' => "No more than X submissions of frontend contribution or event registration forms per hour",
      ],
      'per_min_fail' => [
        'label' => 'Per Minute after the most recent one failed',
        'name' => 'per_min_fail',
        'type' => text,
        'required' => TRUE,
        'help_text' => "No more than X submissions of frontend contribution or event registration forms per minute when the most recent one failed",
      ],
      'per_min_5_fail' => [
        'label' => 'Per 5 Minutes after the most recent one failed',
        'name' => 'per_min_5_fail',
        'type' => text,
        'required' => TRUE,
        'help_text' => "No more than X submissions of frontend contribution or event registration forms per 5 minutes when the most recent one failed",
      ],
      'per_hour_fail' => [
        'label' => 'Per hour after the most recent one failed',
        'name' => 'per_hour_fail',
        'type' => text,
        'required' => TRUE,
        'help_text' => "No more than X submissions of frontend contribution or event registration forms per hour when the most recent one failed",
      ],
    ];
  }

  public function buildQuickForm() {
    $fields = $this->settingsFields();

    foreach ($fields as $name => $details) {
      // add form elements
      $this->add(
        $details['type'], // field type
        $details['name'], // field name
        $details['help_text'],
        NULL, // field label
        $details['required']
      );
    }

    // TODO set defaults

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    $getSettings = throttlespam_apiHelper('Setting', 'get', ['return' => ["throttlespam_preferences"]]);
    if (isset($getSettings['values'][$getSettings['id']]['throttlespam_preferences'])) {
      $this->setDefaults($getSettings['values'][$getSettings['id']]['throttlespam_preferences']);
    }
    
    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $settingsFields = $this->settingsFields();
    $values = $this->exportValues();
    $settingsToBeSet = [];
    foreach ($values as $fieldName => $value) {
      if (isset($settingsFields[$fieldName])) {
        $settingsToBeSet[$fieldName] = $value;
      }
    }
    $saveSettings = throttlespam_apiHelper('Setting', 'create', ['throttlespam_preferences' => $settingsToBeSet]);
    if ($saveSettings['is_error'] == 0) {
      CRM_Core_Session::setStatus(E::ts('Settings Saved'), 'Success', 'success');
    }
    else {
      CRM_Core_Session::setStatus(E::ts('Settings NOT Saved'), 'Oops, something went wrong');
    }
    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
