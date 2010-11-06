<?php
class LineItemsController extends AppController {

	var $name = 'LineItems';
	var $helpers = array('Html', 'Form', 'Javascript', 'Number');
	
  function beforeFilter(){
    parent::beforeFilter();
    if ($this->currentUser['User']['role'] == "customer") {
      $this->redirect($this->referer());
    }
    $coordinatorActions = array('coordinator_index');
    $supplierActions = array('supplier_index');
    if (in_array($this->params['action'], $coordinatorActions)) {
      if ($this->currentUser['User']['role'] == "supplier") $this->redirect('/supplier');
    }
    if (in_array($this->params['action'], $supplierActions)) {
      if ($this->currentUser['User']['role'] == "coordinator") $this->redirect('/coordinator');
    }    
  }

	function supplier_index() {
    $this->set('title_for_layout', 'Supplier | Batch Reports');
	  $this->layout = "supplier/index"; 
    $this->__index();
	}
	
	function coordinator_index() {
    $this->set('title_for_layout', 'Coordinator | Batch Reports');
	  $this->layout = "coordinator/index"; 
	  $this->__index();
	}
	
	function __index() {
	  $Delivery = ClassRegistry::init('Delivery');
	  $deliveryDates = $Delivery->getDeliveryDatesList(); 
	  $this->set('delivery_dates', $deliveryDates);
		$this->LineItem->recursive = 0;
		if (!empty($this->params['url']['delivery_date'])) {
		  $deliveryId = $this->params['url']['delivery_date'];
		} elseif (!empty($this->params['named']['delivery_date'])) {
		  $deliveryId = $this->params['named']['delivery_date'];
		}
		if (!empty($this->params['url']['print'])) {
		  $isPrint = true; 
		}  else {
		  $isPrint = false; 
		}
    if (!empty($deliveryId)) {
      $Order = ClassRegistry::init('Order');
      $orders = $Order->find('all', array(
        'conditions' => array('Order.delivery_id' => $deliveryId, 
                              'Order.status <>' => 'entered')));
      $orderIds = NULL; 
      foreach ($orders as $order) {
        $orderIds[] = $order['Order']['id'];
        $orderIds2['id'][] = $order['Order']['id'];
      }
      $virtualFields = array(
        'ordered' => 'SUM(LineItem.quantity)', 
        'supplied' => 'SUM(LineItem.quantity_supplied)', 
        'amount_retail' => 'SUM(LineItem.total_price_supplied)', 
        'amount_wholesale' => 'SUM(LineItem.total2_price_supplied)'
        );
      $this->LineItem->createVirtualFields($virtualFields);
      /* TODO Fix limit not to be hardcode.  */       
      $this->paginate = array('conditions' => array(
        'LineItem.order_id' => $orderIds), 'group' => array(
          'LineItem.product_id'), 'limit' => 100000);
      $this->set('lineItems', $this->paginate());
      $this->LineItem->removeVirtualFields();                          	        
      $lineItems = $this->LineItem->find('all', array(
        'conditions' => array('LineItem.order_id' => $orderIds)));     
      $ordered = 0; $supplied = 0; $amount_retail = 0; $amount_wholesale = 0;
      foreach ($lineItems as $lineItem) {
      	$ordered += $lineItem['LineItem']['quantity'];
      	$supplied += $lineItem['LineItem']['quantity_supplied'];
      	$amount_retail += $lineItem['LineItem']['total_price_supplied'];
      	$amount_wholesale += $lineItem['LineItem']['total2_price_supplied'];
      }
      $this->set('ordered', $ordered);
      $this->set('supplied', $supplied);
      $this->set('amount_retail', $amount_retail);
      $this->set('amount_wholesale', $amount_wholesale);
      $this->set('default_delivery_id', $deliveryId);
      if ($isPrint) {
        $this->render('/elements/supplier_batch_report_pdf');
      }
    } 	  
	}
	

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'line item'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('lineItem', $this->LineItem->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->LineItem->create();
			if ($this->LineItem->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'line item'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'line item'));
			}
		}
		$products = $this->LineItem->Product->find('list');
		$orders = $this->LineItem->Order->find('list');
		$this->set(compact('products', 'orders'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'line item'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->LineItem->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'line item'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'line item'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->LineItem->read(null, $id);
		}
		$products = $this->LineItem->Product->find('list');
		$orders = $this->LineItem->Order->find('list');
		$this->set(compact('products', 'orders'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'line item'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->LineItem->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Line item'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Line item'));
		$this->redirect(array('action' => 'index'));
	}
}
?>
