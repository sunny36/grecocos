<?php
class Delivery extends AppModel {
	var $name = 'Delivery';
	var $displayField = 'date';
	var $hasMany = 'Order';

  var $validate = array('date' => array('notEmpty' => array('rule' => 'notEmpty',
                                                            'message' => 'Please select a date'),
                                        'unique' => array('rule' => 'isUnique',
                                                          'message' => 'This date has already been selected')));
                                                          
  function changeNextDelivery($nextDeliveryId) {
    $currentNextDelivery = $this->find('first', array('conditions' => array('Delivery.next_delivery' => true)));
    $currentNextDelivery['Delivery']['next_delivery'] = false; 
    $this->save($currentNextDelivery);
    $nextDelivery = $this->find('first', array('conditions' => array('Delivery.id' => $nextDeliveryId)));
    $nextDelivery['Delivery']['next_delivery'] = true; 
    $this->save($nextDelivery);
  }


}
?>