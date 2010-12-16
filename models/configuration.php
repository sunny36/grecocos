<?php
class Configuration extends AppModel {
	var $name = 'Configuration';
  var $displayField = 'key';
  var $belongsTo = 'Organization';

  function findByKeyAndOrganizationId($key, $organizationId) {
    $this->recursive = -1;
    $configuration = $this->find('first', array(
      'conditions' => array('Configuration.key' => $key, 'Configuration.organization_id' => $organizationId)));
    return $configuration['Configuration']['value'];
  }
  
}
?>
