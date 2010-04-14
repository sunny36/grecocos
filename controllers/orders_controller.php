<?php
class OrdersController extends AppController {

	var $name = 'Orders';
	var $uses = array('Order', 'Product', 'LineItem');
	var $helpers = array('Html', 'Form', 'Javascript');

  function supplier_index() {
    $this->layout = 'supplier';
    if($this->RequestHandler->isAjax()) {
 	     $page = $this->params['url']['page']; 
       $limit = $this->params['url']['rows']; 
       $sidx = $this->params['url']['sidx']; 
       $sord = $this->params['url']['sord']; 
       if(!$sidx) $sidx =1;
       $count = $this->Order->find('count');

       if( $count >0 ) {
       	$total_pages = ceil($count/$limit);
       } else {
       	$total_pages = 0;
       }
       if ($page > $total_pages) $page=$total_pages;
       $start = $limit*$page - $limit;
       $orders = $this->Order->find('all', array(
         'recursive' => 0, 
         'offset' => $start,
         'limit' => $limit,
         'conditions' => array('Order.status <>' => 'entered')));

       $this->set('page',$page);
       $this->set('total_pages',$total_pages);
       $this->set('count',$count); 
       $this->set('orders', $orders);
       
       $this->render('/elements/supplier_orders', 'ajax');

     }    
  }
  
  
	function supplier_view($id = null) {
	  if($this->RequestHandler->isAjax()) {
      $this->autoRender = false;
      
	    $page = $this->params['url']['page']; 
      $limit = $this->params['url']['rows']; 
      $sidx = $this->params['url']['sidx']; 
      $sord = $this->params['url']['sord']; 
      $order_id = $this->params['pass'][0];

      if(!$sidx) $sidx =1;
      $products = $this->Order->getProductsByOrderId($order_id);
	    $count = count($products);
	    //$this->log($products, "activity"); 
      if( $count >0 ) {
        $total_pages = ceil($count/$limit);
      } else {
       $total_pages = 0;
      }
      if ($page > $total_pages) $page=$total_pages;
      $start = $limit*$page - $limit;

      $products = $this->Order->getProductsByOrderId($order_id, $start, $limit); 

      $this->set('page',$page);
      $this->set('total_pages',$total_pages);
      $this->set('count',$count); 
      //$this->log($products, "activity"); 
      $this->set('products', $products);

      
      $this->render('/elements/order', 'ajax');
    } else {
      //Non-Ajax
      if (!$id) {
  			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'order'));
  			$this->redirect(array('action' => 'index'));
  		}
  		$products = $this->Order->getProducts($id);
  	  $this->set('products', $products);
  		$this->set('order', $this->Order->read(null, $id));
    }
	}
	function supplier_edit($id = null) {	  
	  if($this->RequestHandler->isAjax()) {
	    $this->autoRender = false;
	    $this->log($this->params['form'], 'activity');
	    
	    if($this->params['form']['status']) {
	      $status = $this->params['form']['status'];
	      $order = $this->Order->findById($this->params['form']['id']);
	      $this->log($order, 'activity');
	      if($status == 'Yes') {
  	      $order['Order']['status'] = 'packed';
  	      $this->Order->save($order);
  	    }
  	    if($status == 'No') {
  	      $order['Order']['status'] = 'paid';
  	      $this->Order->save($order);
  	    }
	    }
	   if($this->params['form']['qty']) {
	     $order_id = $this->params['pass'][0];
	     $product_id = $this->params['form']['id'];
	     $this->log($order_id, 'activity');
	     $lineItems = $this->Order->getProductsByOrderId($order_id);
	     $this->log($lineItems, 'activity');
	     foreach($lineItems as $lineItem) {
	       if($lineItem['LineItem']['product_id'] == $product_id) {
	         $lineItem['LineItem']['quantity'] = $this->params['form']['qty'];
	         $this->LineItem->save($lineItem);
	       }
	     }
	   }
    }
	}
	
	function supplier_lineitem() {
	  Configure::write('debug', 0);
	  if($this->RequestHandler->isAjax()) {
	    $this->log($this->params, 'activity');
      $orderId = $this->params['url']['order_id'];
      $productId = $this->params['url']['product_id'];
      $this->log($orderId, 'activity');
      $this->log($productId, 'activity');
      $conditions = array( "AND" => array (
      	"LineItem.order_id" => $orderId,
      	"LineItem.product_id >" => $productId));
      $lineItem = $this->LineItem->find('first', array(
        'conditions' => array('LineItem.order_id' => $orderId,
                              'LineItem.product_id' => $productId)));
      $this->log($lineItem, 'activity');
      $this->LineItem->id = $lineItem['LineItem']['id'];
      $originalLineItem = $this->LineItem->oldest();
      $this->log($originalLineItem, 'activity');
      $lineItem = json_encode($originalLineItem);
      
      $this->set('lineItem', $lineItem);
      $this->render('/elements/order_products');
    }
	}
	
	function admin_index() {
	  if(!empty($this->params['url']['id'])){
	    $id = $this->params['url']['id'];
      $this->paginate = array(
        'conditions' => array('Order.id' => $this->params['url']['id'])
        );
	  }
	  if(!empty($this->params['url']['user_name'])){
      $this->paginate = array(
        'conditions' => array(
          'OR' => array(
          'User.firstname LIKE' => '%' . $this->params['url']['user_name']. '%',
          'User.lastname LIKE' => '%' . $this->params['url']['user_name']. '%')
          )
        );
	  }	  
		$this->Order->recursive = 0;
		$this->set('orders', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'order'));
			$this->redirect(array('action' => 'index'));
		}
		$products = $this->Order->getProducts($id);
	  $this->set('products', $products);
	  
		$this->set('order', $this->Order->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Order->create();
			if ($this->Order->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'order'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'order'));
			}
		}
		$users = $this->Order->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'order'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Order->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'order'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'order'));
			}
		}
		if (empty($this->data)) {
		  $products = $this->Order->getProducts($id);
		  $this->set('products', $products);
			$this->data = $this->Order->read(null, $id);
			$this->set('order', $this->Order->read(null, $id));

		}
		$users = $this->Order->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'order'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Order->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Order'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Order'));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_changeStatus(){
    Configure::write('debug', 0);
    $this->autoRender = false;
    if($this->RequestHandler->isAjax()) {
      // $this->log($this->params, 'activity');
      $order =  $this->Order->find('first', 
                                   array('conditions' => array(
                                     'Order.id' => $this->params['form']['id']), 
                                  'recursive' => -1));
      $order['Order']['status'] = $this->params['form']['status'];
      $this->Order->save($order);
      // $this->log($order, 'activity');
    }
	}
	
	function admin_getstatus(){
    Configure::write('debug', 0);
    // $this->autoRender = false;
    if($this->RequestHandler->isAjax()) {
      $this->log($this->params, 'activity');
      $order =  $this->Order->find('first', 
                                   array('conditions' => array(
                                     'Order.id' => $this->params['url']['id']), 
                                  'recursive' => -1));
      $this->set('status', $order['Order']['status']);
      $this->log($order, 'activity');
    } 
	}
}
?>
