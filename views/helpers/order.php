<?php
class OrderHelper extends AppHelper {

  var $helpers = array('Html', 'Form');
  
  function searchWidget($formAction, $deliveryDates, $nextDelivery, $paramsUrl, $viewAllUrl) {
    echo $this->Form->create(null, array('type' => 'get', 'action' => $formAction)); 
    echo '<div>';
    echo '<label for"searchbar">' . $this->Html->image('admin/icon_searchbox.png') . '</label>'; 
    echo $this->Form->label('orderId');
    echo '&nbsp;&nbsp;';
    if (isset($paramsUrl['id'])) {
      echo $this->Form->text('id', array('value' => $paramsUrl['id'], 'size' => '10'));
    } else {
      echo $this->Form->text('id', array('size' => '10'));
    }
    echo '&nbsp;&nbsp;';
    echo $this->Form->label('customer name'); 
    echo '&nbsp;&nbsp;';
    if (isset($paramsUrl['user_name'])) {
      echo $this->Form->text('user_name', array('value' => $paramsUrl['user_name'], 'size' => '40'));
    } else {
      echo $this->Form->text('user_name', array('size' => '40'));
    }
    echo '&nbsp;&nbsp;';
    echo 'Delivery Date';
    echo '&nbsp;&nbsp;';
    if (isset($paramsUrl['delivery_date'])) {
      echo $this->Form->select(
        'delivery_date', $deliveryDates, array('selected' => $paramsUrl['delivery_date']), array('empty' => false)
      ); 
    } else {
      echo $this->Form->select(
        'delivery_date', $deliveryDates, array('selected' => $nextDelivery['Delivery']['id']), array('empty' => false)
      ); 
    }
    echo "&nbsp;&nbsp";
    echo $this->Form->submit('Search', array('div' => false));
    echo $this->Form->end(); 
    echo '&nbsp;&nbsp';
    echo $this->Html->link('View All', $viewAllUrl); 
    echo '</div>'; 
  }

}

?>
