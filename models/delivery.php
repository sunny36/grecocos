<?php
class Delivery extends AppModel {
	var $name = 'Delivery';
	var $displayField = 'date';
	var $hasMany = 'Order';

        var $validate = array('date' => array(
                                              'notEmpty' => array('rule' => 'notEmpty',
                                                                  'message' => 'Please select a date'),
                                              'unique' => array('rule' => 'isUnique',
                                                                'message' => 'This date has already been selected')));


}
?>