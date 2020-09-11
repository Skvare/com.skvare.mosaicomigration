<?php

use CRM_Mosaicomigration_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Mosaicomigration_Form_Migration extends CRM_Core_Form {
  public $_currentValue;
  public $_newValue;
  public $_currentValueNameEncode;
  public $_newValueNameEncode;

  public function buildQuickForm() {

    $options = [
      '1' => ts('Replace Domain Name'),
      '2' => ts('Replace Extension Path'),
    ];
    $this->addRadio('migration_type', ts('Migration Type'), $options, NULL, NULL, TRUE);
    $attributes = ['class' => 'huge40'];
    $this->add('text', 'migration_find', ts('Current Value'), $attributes, TRUE);
    $this->add('text', 'migration_replace', ts('New Value'), $attributes, TRUE);

    $this->addButtons([
      [
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ],
    ]);

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    $this->addFormRule(['CRM_Mosaicomigration_Form_Migration', 'formRule'], $this);
    parent::buildQuickForm();

    //$this->addRule('migration_replace', ts("CiviCRM Extensions Directory"), 'settingPath');
  }

  /**
   * Global form rule.
   *
   * @param array $fields
   *   The input form values.
   * @param array $files
   *   The uploaded files if any.
   * @param $self
   *
   * @return bool|array
   *   true if no errors, else array of errors
   */
  public static function formRule($fields, $files, $self) {
    $errors = [];
    if ($fields['migration_type'] == '1') {
      $doamins = ['migration_find' => $fields['migration_find'], 'migration_replace' => $fields['migration_replace']];
      foreach ($doamins as $fieldName => $doamin) {
        $urlparts = parse_url(filter_var($doamin, FILTER_SANITIZE_URL));
        if (!isset($urlparts['scheme']) || !isset($urlparts['host'])) {
          $errors[$fieldName] = ts('Invalid Domain Name,<br/> use https://www.example.com or https://example.com, http part is required.');
        }
      }
    }

    return $errors;
  }

  public function postProcess() {
    $values = $this->exportValues();
    // Replace Domain in multiple tables.
    $this->_currentValue = $values['migration_find'];
    $this->_currentValueNameEncode = urlencode($this->_currentValue . '/');
    $this->_newValue = $values['migration_replace'];
    $this->_newValueNameEncode = urlencode($this->_newValue . '/');

    if ($values['migration_type'] == '1') {
      $this->replaceDomain();
      $this->replaceJsonData();
    }
    elseif ($values['migration_type'] == '2') {
      $this->replacePath();
      $this->replaceJsonData();
    }

    parent::postProcess();
  }

  /**
   *  Function to replace json data
   */
  function replaceJsonData() {
    $currentValue = $this->_currentValue;
    $newValue = $this->_newValue;
    $selectSQL = "SELECT * FROM `civicrm_mailing` WHERE `template_options` LIKE '%uk.co.vedaconsulting.mosaico%'";
    $dao = CRM_Core_DAO::executeQuery($selectSQL);
    while ($dao->fetch()) {
      $templateOptions = json_decode($dao->template_options, TRUE);
      $templateOptions = array_map(
        function ($str) use ($currentValue, $newValue) {
          return str_replace($currentValue, $newValue, $str);
        },
        $templateOptions
      );
      $templateOptionsString = json_encode($templateOptions);
      $mailing = new CRM_Mailing_DAO_Mailing();
      $mailing->id = $dao->id;
      $mailing->template_options = $templateOptionsString;
      //CRM_Core_Error::debug_var(' $templateOptionsString', $templateOptionsString);
      $mailing->save();
    }
  }

  /**
   * Function to replace domain name
   */
  function replaceDomain() {
    $currentDoamin = $this->_currentValue;
    $currentDomainNameEncode = $this->_currentValueNameEncode;
    $newDomain = $this->_newValue;
    $newDomainNameEncode = $this->_newValueNameEncode;
    $sqls = [];
    $sqls[] = "UPDATE civicrm_mosaico_template SET html = REPLACE(html, '{$currentDomainNameEncode}', '{$newDomainNameEncode}')";
    $sqls[] = "UPDATE civicrm_mosaico_template SET html = REPLACE(html, '{$currentDoamin}', '{$newDomain}')";
    $sqls[] = "UPDATE civicrm_mosaico_template SET content = REPLACE(content, '{$currentDoamin}', '{$newDomain}')";
    $sqls[] = "UPDATE civicrm_mosaico_template SET metadata = REPLACE(metadata, '{$currentDoamin}', '{$newDomain}')";

    $sqls[] = "UPDATE civicrm_mailing SET body_html = REPLACE(body_html, '{$currentDomainNameEncode}', '{$newDomainNameEncode}')";
    $sqls[] = "UPDATE civicrm_mailing SET body_html = REPLACE(body_html, '{$currentDoamin}', '{$newDomain}')";
    foreach ($sqls as $sql) {
      CRM_Core_DAO::executeQuery($sql);
      //CRM_Core_Error::debug_var('replaceDomain sql', $sql);
    }
  }

  /**
   * Function to replace extension path
   */
  function replacePath() {
    $currentPath = $this->_currentValue;
    $newPath = $this->_newValue;
    $sqls = [];
    $sqls[] = "UPDATE civicrm_mosaico_template SET metadata = REPLACE(metadata, '{$currentPath}', '{$newPath}')";
    $sqls[] = "UPDATE civicrm_mosaico_template SET html = REPLACE(html, '{$currentPath}', '{$newPath}')";
    $sqls[] = "UPDATE civicrm_mailing SET body_html = REPLACE(body_html, '{$currentPath}', '{$newPath}')";
    foreach ($sqls as $sql) {
      CRM_Core_DAO::executeQuery($sql);
      //CRM_Core_Error::debug_var('replacePath sql', $sql);
    }
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
    $elementNames = [];
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
