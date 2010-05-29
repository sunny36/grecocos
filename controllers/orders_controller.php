<?php 
class OrdersController extends AppController {

  var $name = 'Orders';
  var $uses = array('Order', 'Product', 'LineItem', 'Delivery',
    'Transaction');
  var $helpers = array('Html', 'Form', 'Javascript');
  var $components = array('Jqgrid');

  function supplier_index() {
    $this->layout = 'supplier/index';
    if($this->RequestHandler->isAjax()) {
      $page = $this->params['url']['page']; 
      $limit = $this->params['url']['rows']; 
      $sidx = $this->params['url']['sidx']; 
      $sord = $this->params['url']['sord']; 
      if(!$sidx) $sidx =1;
      $search = $this->params['url']['_search']; 
      $params = array('conditions' => array('Order.status <>' => 'entered'));
      if($search == "true") {
        if(!empty($this->params['url']['delivery_date'])) {
          $delivery_id = $this->params['url']['delivery_date'];
          if($delivery_id != "all") {
            if($delivery_id == "current_delivery_date") {
              $params = array(
                'conditions' => array('Delivery.next_delivery' => true)); 
              $next_delivery = $this->Delivery->find('first', $params);              
              $params = array('conditions' => array(
                'Delivery.id' => $next_delivery['Delivery']['id'], 
                'Order.status <>' => 'entered'));                             

            } else {
              $params = array('conditions' => array(
                'Delivery.id' => $delivery_id, 'Order.status <>' => 'entered'));                             
            }
          } 
        }
      }
      $count = $this->Order->find('count', $params);
      $this->log($count, 'activity');
      if( $count >0 ) {
        $total_pages = ceil($count/$limit);
      } else {
        $total_pages = 0;
      }
      if ($page > $total_pages) $page=$total_pages;
      $start = $limit*$page - $limit;
      if($start < 0) $start = 0; 
      if($limit < 0) $limit = 0; 
      $params = array('recursive' => 0, 'offset' => $start, 'limit' => $limit,
        'conditions' => array('Order.status <>' => 'entered'));
      if(!empty($this->params['url']['delivery_date'])) {
        $delivery_id = $this->params['url']['delivery_date'];
        if($delivery_id != "all") {
          if($delivery_id == "current_delivery_date") {
            $params = array(
              'conditions' => array('Delivery.next_delivery' => true)); 
            $next_delivery = $this->Delivery->find('first', $params);
            $params = array('recursive' => 0, 'offset' => $start, '
              limit' => $limit, 'conditions' => array( 
                'Delivery.id' => $next_delivery['Delivery']['id'], 
                'Order.status <>' => 'entered'));             
          } else {
            $params = array('recursive' => 0, 'offset' => $start, '
              limit' => $limit, 'conditions' => array( 
                'Delivery.id' => $delivery_id, 'Order.status <>' => 'entered'));
          }
        }
        $orders = $this->Order->find('all', $params);
      } 
      $orders = $this->Order->find('all', $params);
      $this->set('page',$page);
      $this->set('total_pages',$total_pages);
      $this->set('count',$count); 
      $this->set('orders', $orders);      
      $this->render('/elements/supplier_orders', 'ajax');
    }    
  }

  function coordinator_mark_as_paid() {
    $this->layout = "coordinator/index";
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

    $this->set('orders', $this->paginate());	  
  }

  function coordinator_mark_as_delivered() {
    $this->layout = "coordinator/index";
    $this->Order->recursive = 0;
    $this->paginate = array('conditions' => array('Order.status' => array('packed', 'delivered')));
    if(!empty($this->params['url']['id'])){
      $id = $this->params['url']['id'];
      $this->paginate = array(
        'conditions' => array('AND' => array(
          'Order.id' => $this->params['url']['id'],
          'Order.status' => array('packed', 'delivered')))
        );
    }
    if(!empty($this->params['url']['user_name'])){
      $this->paginate = array(
        'conditions' => array(
          'AND' => array(
            'OR' => array(
              'User.firstname LIKE' => '%' . $this->params['url']['user_name']. '%',
              'User.lastname LIKE' => '%' . $this->params['url']['user_name']. '%')
            ),
            'Order.status' => array('packed', 'delivered')

          )
        );
    }	  
    $this->set('orders', $this->paginate());	  
  }

  function coordinator_refunds() {
    $this->layout = "coordinator/index"; 
    $this->Order->recursive = 1; 
    $this->paginate = array('conditions' => array(
      'AND' =>(
        array(
          'Delivery.closed' => true,
          'Order.status' => 'packed',
          'Order.total_supplied <> Order.total'))));
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
      $this->set('products', $products);
      $this->render('/elements/order', 'ajax');
    } else {
      //Non-Ajax
      //Show pdf
      $this->log($this->params, 'activity');
      $this->layout = "fpdf";
      $products = $this->Order->getProducts($id);
      $this->set('products', $products);
      $this->set('order', $this->Order->read(null, $id));     
      $this->render('/elements/supplier_order_pdf');
    }
  }

  function supplier_edit($id = null) {	  
    if($this->RequestHandler->isAjax()) {
      $this->autoRender = false;    
      if($this->params['form']['status']) {
        $status = $this->params['form']['status'];
        $this->Order->updateOrderStatus($this->params['form']['id'],
          $this->params['form']['status']);
        $transaction = array('Transaction' => array(
          'type' => "Sales", 
          'user_id' => $this->currentUser['User']['id'], 
          'order_id' => $this->params['form']['id'])); 
        $this->Transaction->create(); 
        $this->Transaction->save($transaction); 

      }
      if($this->params['form']['quantity_supplied']) {
        $order_id = $this->params['pass'][0];
        $product_id = $this->params['form']['id'];
        $this->LineItem->updateQuantitySupplied($order_id, $product_id,
          $this->params['form']['quantity_supplied']); 	     
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
    $this->layout = 'supplier/index';
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
      $params = array('conditions' => array('Delivery.next_delivery' => true)); 
      $next_delivery = $this->Delivery->find('first', $params);

      $params = array('conditions' => array('Delivery.date <=' => 
        $next_delivery['Delivery']['date']),
      'order' => array('Delivery.' . $sidx . ' ' . 
      strtoupper($sord))); 
      $delivery_dates = $this->Delivery->find('all', $params); 
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
      $this->set('page',$page);
      $this->set('total_pages',$total_pages);
      $this->set('count',$count); 
      $this->set('delivery_dates', $delivery_dates);
      $this->render('/elements/supplier_close_batch', 'ajax');
    }
  }

  function coordinator_view($id = null) {
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
      $order =  $this->Order->find('first', 
        array('conditions' => array('Order.id' => $this->params['form']['id']), 
              'recursive' => -1));
      $transactionType = "";
      if(!empty($this->params['form']['status'])) {
        $order['Order']['status'] = $this->params['form']['status'];
        if ($order['Order']['status'] == "paid") {
         $transactionType = "Cash Payment";  
        }
        if ($order['Order']['status'] == "delivered") {
         $transactionType = "Delivery";  
        }
      }
      if(!empty($this->params['form']['refund'])) {
        if($this->params['form']['refund'] == "yes") {
          $order['Order']['refund'] = true;
        } 
        if($this->params['form']['refund'] == "no") {
          $order['Order']['refund'] = false;
        } 
        $transactionType = "Refund";  
      }      
      $this->Order->save($order);
      //Log to Transaction table
      $transaction = array('Transaction' => array(
      'type' => $transactionType, 
      'user_id' => $this->currentUser['User']['id'], 
      'order_id' => $order['Order']['id'])); 
      $this->Transaction->create(); 
      $this->Transaction->save($transaction); 
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

  function getdeliverystatus(){
    Configure::write('debug', 0);
    // $this->autoRender = false;
    if($this->RequestHandler->isAjax()) {
      $this->log($this->params, 'activity');
      $order =  $this->Order->find('first', 
        array('conditions' => array(
          'Order.id' => $this->params['url']['id']), 
        'recursive' => 1));
      $this->set('status', $order['Delivery']['closed']);
      $this->log($order, 'activity');
    } 
  }



}
?>
