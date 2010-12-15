<?php
class Organization extends AppModel {
	var $name = 'Organization';
  var $hasMany = 'User';

  function getOrganizationsList() {
    return $this->find('list', array('fields' => array('Organization.id', 'Organization.delivery_address')));
  }
}
?>
