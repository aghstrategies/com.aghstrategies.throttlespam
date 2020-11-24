<?php

use CRM_Throttlespam_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Throttlespam_Form_Settings extends CRM_Core_Form {
  public function buildQuickForm() {

    $fields = [
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

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function getSettings() {

  }

  public function postProcess() {
    // TODO save settings
    $values = $this->exportValues();
    print_r($values); die();
    CRM_Core_Session::setStatus(E::ts('You picked color "%1"', array(
      1 => 1,
    )));
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
