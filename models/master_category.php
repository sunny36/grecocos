<?php
class MasterCategory extends AppModel {
	var $name = 'MasterCategory';
	var $displayField = 'name';
	
	var $hasMany = 'Product';
}
?>