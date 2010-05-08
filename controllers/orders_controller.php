<?php 
class OrdersController extends AppController {

	var $name = 'Orders';
	var $uses = array('Order', 'Product', 'LineItem', 'Delivery');
	var $helpers = array('Html', 'Form', 'Javascript');
	var $components = array('Jqgrid');

  function supplier_index() {
    $this->layout = 'admin_index';
    if($this->RequestHandler->isAjax()) {
       $start = $this->Jqgrid->getStart($this->params, 'Order');
       $orders = $this->Order->find('all', array(
         'recursive' => 0, 
         'offset' => $start,
         'limit' => $this->Jqgrid->getLimit($this->params, 'Order'),
         'conditions' => array('Order.status <>' => 'entered')));

       $this->set('page', $this->Jqgrid->getLimit($this->params, 'Order'));
       $this->set('total_pages', $this->Jqgrid->getTotalPages($this->params, 'Order'));
       $this->set('count', $this->Jqgrid->getCount($this->params, 'Order')); 
       $this->set('orders', $orders);
       
       $this->render('/elements/supplier_orders', 'ajax');

     }    
  }

	function admin_index() {
	  $this->layout = "admin_index";
	  $this->log($this->params, 'activity');
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
	
	function coordinator_mark_as_paid() {
	  $this->layout = "admin_index";
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
	
	    
	    if($this->params['form']['status']) {
	      $status = $this->params['form']['status'];
	      $order = $this->Order->findById($this->params['form']['id']);
	      if($status == 'Yes') {
  	      $order['Order']['status'] = 'packed';
  	      $this->Order->save($order);
  	    }
  	    if($status == 'No') {
  	      $order['Order']['status'] = 'paid';
  	      $this->Order->save($order);
  	    }
	    }
	    
	    if($this->params['form']['quantity_supplied']) {
	      $order_id = $this->params['pass'][0];
	      $product_id = $this->params['form']['id'];
 	      $lineItems = $this->Order->getProductsByOrderId($order_id);
 	      foreach($lineItems as $lineItem) {
 	        if($lineItem['LineItem']['product_id'] == $product_id) {
 	         $lineItem['LineItem']['quantity_supplied'] = 
 	           $this->params['form']['quantity_supplied'];
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
      $conditions = array( "AND" => array (
       "LineItem.order_id" => $orderId,
       "LineItem.product_id >" => $productId));
      $lineItem = $this->LineItem->find('first', array(
        'conditions' => array('LineItem.order_id' => $orderId,
                              'LineItem.product_id' => $productId)));
      $this->LineItem->id = $lineItem['LineItem']['id'];
      $lineItem = json_encode($lineItem);      
      $this->set('lineItem', $lineItem);
      $this->render('/elements/order_products');
    }
	}
	
	function supplier_close_batch() {
	  $this->layout = 'admin_index';
	  if($this->RequestHandler->isAjax()) {
	    $page = $this->params['url']['page']; 
      $limit = $this->params['url']['rows']; 
      $sidx = $this->params['url']['sidx']; 
      $sord = $this->params['url']['sord']; 
	    if(!$sidx) $sidx =1;
	    $count = $this->Delivery->find('count');
      if( $count >0 ) {
        $total_pages = ceil($count/$limit);
      } else {
       $total_pages = 0;
      }
      if ($page > $total_pages) $page=$total_pages;
      $start = $limit*$page - $limit;
      $delivery_dates = $this->Delivery->find('all'); 
      foreach($delivery_dates as &$delivery) {
        $packed = 0; 
        $paid = 0;
        foreach($delivery['Order'] as $order) {
         if($order['status'] == "packed") $packed = $packed + 1;
         if($order['status'] == "paid") $paid = $paid + 1;
        }         
       $delivery['Delivery']['packed'] = $packed;
       $delivery['Delivery']['ordered'] = $packed + $paid;
      }
      $this->log($delivery_dates, 'activity');
      $this->set('page',$page);
      $this->set('total_pages',$total_pages);
      $this->set('count',$count); 
      $this->set('delivery_dates', $delivery_dates);

      $this->render('/elements/supplier_close_batch', 'ajax');
	    
    }
	}

	function admin_view($id = null) {
	  $this->layout = "admin_add";
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

      if( $count >0 ) {
        $total_pages = ceil($count/$limit);
      } else {
       $total_pages = 0;
      }
      if ($page > $total_pages) $page=$total_pages;
      $start = $limit*$page - $limit;

      $products = $this->Order->getProductsByOrderId($order_id, $start, $limit); 
      $this->log($products, "activity"); 
      $this->set('page',$page);
      $this->set('total_pages',$total_pages);
      $this->set('count',$count); 
      //$this->log($products, "activity"); 
      $this->set('products', $products);

      
      $this->render('/elements/order_details_for_coordinator', 'ajax');
	    
    }
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'order'));
			$this->redirect(array('action' => 'index'));
		}
		$products = $this->Order->getProducts($id);
	  $this->set('products', $products);
	  
		$this->set('order', $this->Order->read(null, $id));
	}
	
	function changeStatus(){
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
	
	function getstatus(){
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
