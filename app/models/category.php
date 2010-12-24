<?php
class Category extends AppModel {
	var $name = 'Category';
	var $displayField = 'name';
	
	var $hasMany = 'Product';
	
}
?>