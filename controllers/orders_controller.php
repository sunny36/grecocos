<?php 
class OrdersController extends AppController {

  var $name = 'Orders';
  var $uses = array('Order', 'Product', 'LineItem', 'Delivery',
    'Transaction');
  var $helpers = array('Html', 'Form', 'Javascript', 'Number');
  var $components = array('Jqgrid');
  
  function beforeFilter(){
    parent::beforeFilter();
    if ($this->currentUser['User']['role'] == "customer") {
      $this->redirect($this->referer());
    }
  }
  

  function supplier_index() {
    $this->layout = 'supplier/index';
    if($this->RequestHandler->isAjax()) {
      $page = $this->params['url']['page']; 
      $limit = $this->params['url']['rows']; 
      $sidx = $this->params['url']['sidx']; 
      $sord = $this->params['url']['sord']; 
      if(!$sidx) $sidx =1;
      $search = $this->params['url']['_search']; 
      $nextDelivery = $this->Delivery->find('first', array(
        'conditions' => array('Delivery.next_delivery' => true))); 
      $params = array('conditions' => array(
        'Order.status <>' => 'entered', 
        'Order.delivery_id' => $nextDelivery['Delivery']['id']));
      if($search == "true") {
        if(!empty($this->params['url']['delivery_date'])) {
          $delivery_id = $this->params['url']['delivery_date'];
          if($delivery_id != "all") {
            if($delivery_id == "current_delivery_date") {
              $params = array('conditions' => array(
                'Delivery.next_delivery' => true)); 
              $next_delivery = $this->Delivery->find('first', $params);
              if (!empty($this->params['url']['status'])) {
                if ($this->params['url']['status'] == "packed") {
                  $params = array('conditions' => array(
                    'Delivery.id' => $next_delivery['Delivery']['id'],
                    'Order.status' => 'packed'));
                }
                if ($this->params['url']['status'] == "not_packed") {
                  $params = array('conditions' => array(
                    'Delivery.id' => $next_delivery['Delivery']['id'], 
                    'Order.status' => 'not_packed'));
                }
                if ($this->params['url']['status'] == "all") {
                  $params = array('conditions' => array(
                    'Delivery.id' => $next_delivery['Delivery']['id'],
                    'Order.status <>' => 'entered'));
                }
              } else {
                $params = array('conditions' => array(
                  'Delivery.id' => $next_delivery['Delivery']['id'], 
                  'Order.status <>' => 'entered'));                             
              }
            } else {
              if (!empty($this->params['url']['status'])) {
                if ($this->params['url']['status'] == "packed") {
                  $params = array('conditions' => array(
                    'Delivery.id' => $delivery_id, 'Order.status' => 'packed'));
                }
                if ($this->params['url']['status'] == "not_packed") {
                  $params = array('conditions' => array(
                    'Delivery.id' => $delivery_id, 
                    'Order.status' => 'not_packed'));
                }
                if ($this->params['url']['status'] == "all") {
                  $params = array('conditions' => array(
                    'Delivery.id' => $delivery_id, 'Order.status' => 'all'));
                }
              } else {
                $params = array('conditions' => array(
                  'Delivery.id' => $delivery_id, 
                  'Order.status <>' => 'entered'));
              }
            }
          } 
        }
      }
      $count = $this->Order->find('count', $params);
      if( $count >0 ) {
        $total_pages = ceil($count/$limit);
      } else {
        $total_pages = 0;
      }
      if ($page > $total_pages) $page=$total_pages;
      $start = $limit*$page - $limit;
      if($start < 0) $start = 0; 
      if($limit < 0) $limit = 0; 
      $nextDelivery = $this->Delivery->find('first', array(
        'conditions' => array('Delivery.next_delivery' => true))); 
      $params = array('recursive' => 0, 'offset' => $start, 'limit' => $limit, 
      'conditions' => array(
        'Order.status <>' => 'entered', 
        'Order.delivery_id' => $nextDelivery['Delivery']['id']));
      if(!empty($this->params['url']['delivery_date'])) {
        $delivery_id = $this->params['url']['delivery_date'];
        if($delivery_id != "all") {
          if($delivery_id == "current_delivery_date") {
            $params = array('conditions' => array(
              'Delivery.next_delivery' => true)); 
            $next_delivery = $this->Delivery->find('first', $params);
            if (!empty($this->params['url']['status'])) {
              if ($this->params['url']['status'] == "packed") {
                $params = array('recursive' => 0, 'offset' => $start, 
                'limit' => $limit, 'conditions' => array(
                  'Delivery.id' => $next_delivery['Delivery']['id'], 
                  'Order.status' => 'packed'));
              }
              if ($this->params['url']['status'] == "not_packed") {
                $params = array('recursive' => 0, 'offset' => $start, 
                'limit' => $limit, 'conditions' => array(
                  'Delivery.id' => $next_delivery['Delivery']['id'], 
                  'Order.status' => 'paid'));
              }
              if ($this->params['url']['status'] == "all") {
                $params = array('recursive' => 0, 'offset' => $start, 
                'limit' => $limit, 'conditions' => array(
                  'Delivery.id' => $next_delivery['Delivery']['id'], 
                  'Order.status <>' => 'entered'));
              }
            } else {
              $params = array('recursive' => 0, 'offset' => $start, 
              'limit' => $limit, 'conditions' => array(
                'Delivery.id' => $next_delivery['Delivery']['id'], 
                'Order.status <>' => 'entered'));
            }
          } else {
            if (!empty($this->params['url']['status'])) {
              if ($this->params['url']['status'] == "packed") {
                $params = array('recursive' => 0, 'offset' => $start, 
                'limit' => $limit, 'conditions' => array(
                  'Delivery.id' => $delivery_id, 'Order.status' => 'packed'));
              }
              if ($this->params['url']['status'] == "not_packed") {
                $params = array('recursive' => 0, 'offset' => $start, 
                'limit' => $limit, 'conditions' => array(
                  'Delivery.id' => $delivery_id, 'Order.status' => 'paid'));
              }
              if ($this->params['url']['status'] == "all") {
                $params = array('recursive' => 0, 'offset' => $start, 
                'limit' => $limit, 'conditions' => array(
                  'Delivery.id' => $delivery_id, 'Order.status <>' => 'entered'));
              }
            } else {
              $params = array('recursive' => 0, 'offset' => $start, 
              'limit' => $limit, 'conditions' => array(
                'Delivery.id' => $delivery_id, 'Order.status <>' => 'entered'));
            }
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
    $deliveryDates = $this->Delivery->getDeliveryDatesList(); 
    $deliveryDates = array(-1 => 'All') + $deliveryDates;
    if (!empty($this->params['url']['id'])) {
      $orderId = $this->params['url']['id']; 
      $this->set('default_order_id', $orderId); 
    }
    if (!empty($this->params['url']['user_name'])) {
      $customerName = $this->params['url']['user_name']; 
      $this->set('default_customer_name', $customerName); 
    }
    if (!empty($this->params['url']['delivery_date'])) {
      if ($this->params['url']['delivery_date'] != -1) {
        $deliveryId = $this->params['url']['delivery_date'];
        $this->set('default_delivery_id', $deliveryId);          
      }
    }
    if(!empty($orderId)){
      $this->paginate = array('conditions' => array('Order.id' => $orderId));
    }
    if(!empty($customerName)){
      $this->paginate = array('conditions' => array('OR' => array(
        'User.firstname LIKE' => '%' . $customerName. '%',
        'User.lastname LIKE' => '%' . $customerName. '%')));
    }	  
    if (!empty($deliveryId)) {
      $this->paginate = array('conditions' => array(
        'Order.delivery_id' => $deliveryId));
    }
    if (!empty($deliveryId) && !empty($customerName)) {
      $this->paginate = array('conditions' => array('AND' => array(
        'Order.delivery_id' => $deliveryId, 'OR' => array(
          'User.firstname LIKE' => '%' . $customerName. '%',
          'User.lastname LIKE' => '%' . $customerName. '%'))));
    }
    if (!empty($deliveryId) && !empty($orderId)) {
      $this->paginate = array('conditions' => array('AND' => array(
        'Order.delivery_id' => $deliveryId, 'Order.id' => $orderId)));
    }
    if (!empty($orderId) && !empty($customerName)) {
      $this->paginate = array('conditions' => array('AND' => array(
        'Order.id' => $orderId, 'OR' => array(
          'User.firstname LIKE' => '%' . $customerName. '%',
          'User.lastname LIKE' => '%' . $customerName. '%'))));
    }
    if (!empty($orderId) && !empty($deliveryId) && !empty($customerName)) {
      $this->paginate = array('conditions' => array('AND' => array(
        'Order.id' => $orderId, 'Order.delivery_id' => $deliveryId, 
        'OR' => array(
          'User.firstname LIKE' => '%' . $customerName. '%',
          'User.lastname LIKE' => '%' . $customerName. '%'))));
    }
    $this->set('delivery_dates', $deliveryDates);
    $this->set('orders', $this->paginate());	  
  }

  function coordinator_mark_as_delivered() {
    $this->layout = "coordinator/index";
    $this->Order->recursive = 0;
    $this->paginate = array('conditions' => array(
      'Order.status' => array('packed', 'delivered')));
    $deliveryDates = $this->Delivery->getDeliveryDatesList(); 
    $deliveryDates = array(-1 => 'All') + $deliveryDates;
    if (!empty($this->params['url']['id'])) {
      $orderId = $this->params['url']['id']; 
      $this->set('default_order_id', $orderId); 
    }
    if (!empty($this->params['url']['user_name'])) {
      $customerName = $this->params['url']['user_name']; 
      $this->set('default_customer_name', $customerName); 
    }
    if (!empty($this->params['url']['delivery_date'])) {
      if ($this->params['url']['delivery_date'] != -1) {
        $deliveryId = $this->params['url']['delivery_date'];
        $this->set('default_delivery_id', $deliveryId);          
      }
    }
    if(!empty($orderId)){
      $this->paginate = array('conditions' => array('AND' => array(
        'Order.id' => $orderId,
        'Order.status' => array('packed', 'delivered'))));
    }
    if(!empty($customerName)){
      $this->paginate = array('conditions' => array('AND' => array('OR' => array(
        'User.firstname LIKE' => '%' . $customerName. '%',
        'User.lastname LIKE' => '%' . $customerName. '%')), 
        'Order.status' => array('packed', 'delivered')));
    }	  
    if (!empty($deliveryId)) {
      $this->paginate = array('conditions' => array('AND' => array(
        'Order.delivery_id' => $deliveryId,
        'Order.status' => array('packed', 'delivered'))));
    }
    if (!empty($deliveryId) && !empty($customerName)) {
      $this->paginate = array('conditions' => array('AND' => array(
        'Order.status' => array('packed', 'delivered'), 
        'Order.delivery_id' => $deliveryId, 'OR' => array(
          'User.firstname LIKE' => '%' . $customerName. '%',
          'User.lastname LIKE' => '%' . $customerName. '%'))));
    }
    if (!empty($deliveryId) && !empty($orderId)) {
      $this->paginate = array('conditions' => array('AND' => array(
        'Order.status' => array('packed', 'delivered'), 
        'Order.delivery_id' => $deliveryId, 'Order.id' => $orderId)));
    }
    if (!empty($orderId) && !empty($customerName)) {
      $this->paginate = array('conditions' => array('AND' => array(
        'Order.status' => array('packed', 'delivered'), 
        'Order.id' => $orderId, 'OR' => array(
          'User.firstname LIKE' => '%' . $customerName. '%',
          'User.lastname LIKE' => '%' . $customerName. '%'))));
    }
    if (!empty($orderId) && !empty($deliveryId) && !empty($customerName)) {
      $this->paginate = array('conditions' => array('AND' => array(
        'Order.status' => array('packed', 'delivered'), 
        'Order.id' => $orderId, 'Order.delivery_id' => $deliveryId, 
        'OR' => array(
          'User.firstname LIKE' => '%' . $customerName. '%',
          'User.lastname LIKE' => '%' . $customerName. '%'))));
    }    
    $this->set('delivery_dates', $deliveryDates);
    $this->set('orders', $this->paginate());	  
  }

  function coordinator_refunds() {
    $this->layout = "coordinator/index"; 
    $this->Order->recursive = 1; 
    $this->paginate = array('conditions' => array('AND' =>(array(
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
      if(isset($this->params['form']['status'])) {
        $status = $this->params['form']['status'];
        $this->Order->updateOrderStatus($this->params['form']['id'], $this->params['form']['status']);
        //If transaction already exists delete it and re-create it. 
        $params = array('conditions' => array('AND' => array(
          array('Transaction.type' => 'Sales'),
          array('Transaction.order_id' => $this->params['form']['id']))));
        $transaction = $this->Transaction->find('first', $params);
        if ($transaction) {
          $this->Transaction->delete($transaction['Transaction']['id']);
        }
        //Create transaction only if the order is packed. 
        if ($this->params['form']['status'] == "Yes") {
          $order =  $this->Order->find('first', array('conditions' => array(
            'Order.id' => $this->params['form']['id']), 'recursive' => 2));
          $transaction = array('Transaction' => array(
            'type' => "Sales", 'user_id' => $this->currentUser['User']['id'], 
            'order_id' => $this->params['form']['id'], 'delivery_id' => $order['Delivery']['id'])); 
          $this->Transaction->create(); 
          $this->Transaction->save($transaction); 
        }
      }
      if(isset($this->params['form']['quantity_supplied'])) {
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
      $orderId = $this->params['url']['order_id'];
      $productId = $this->params['url']['product_id'];
      $conditions = array( "AND" => array ("LineItem.order_id" => $orderId, "LineItem.product_id >" => $productId));
      $lineItem = $this->LineItem->find('first', array('conditions' => array('LineItem.order_id' => $orderId, 
        'LineItem.product_id' => $productId)));
      $this->LineItem->id = $lineItem['LineItem']['id'];
      $lineItem = json_encode($lineItem);      
      $this->set('lineItem', $lineItem);
      $this->render('/elements/order_products');
    }
  }

  function supplier_close_batch() {
    $this->layout = 'supplier/index';
    $nextDelivery = $this->Delivery->getNextDelivery(); 
    $this->set('next_delivery', $nextDelivery);
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
      $params = array('conditions' => array('Delivery.date <=' => $next_delivery['Delivery']['date']), 
      'order' => array('Delivery.' . $sidx . ' ' . strtoupper($sord))); 
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
      $this->set('page',$page);
      $this->set('total_pages',$total_pages);
      $this->set('count',$count); 
      $this->set('products', $products);
      $this->set('order', $this->Order->findById($order_id));
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
      $order =  $this->Order->find('first', array('conditions' => array('Order.id' => $this->params['form']['id']), 
      'recursive' => 2));
      $transactionType = "";
      if(!empty($this->params['form']['status'])) {
        $order['Order']['status'] = $this->params['form']['status'];
        if ($order['Order']['status'] == "paid") {
          $this->Order->sendEmailConfirmingEmail($order['Order']['id']); 
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
        'type' => $transactionType, 'user_id' => $this->currentUser['User']['id'], 
        'order_id' => $order['Order']['id'],'delivery_id' => $order['Delivery']['id'])); 
      $this->Transaction->create(); 
      $this->Transaction->save($transaction); 
    }
  }

  function getstatus(){
    Configure::write('debug', 0);
    // $this->autoRender = false;
    if($this->RequestHandler->isAjax()) {
      $order =  $this->Order->find('first', array('conditions' => array('Order.id' => $this->params['url']['id']), 
      'recursive' => -1));
      $this->set('status', $order['Order']['status']);
    } 
  }

  function getdeliverystatus(){
    Configure::write('debug', 0);
    // $this->autoRender = false;
    if($this->RequestHandler->isAjax()) {
      $order =  $this->Order->find('first', array('conditions' => array('Order.id' => $this->params['url']['id']), 
      'recursive' => 1));
      $this->set('status', $order['Delivery']['closed']);
    } 
  }
  
  function coordinator_print_refund_receipt($id) {
    $this->layout = "fpdf";
    $order = $this->Order->findById($id); 
    $this->set('order', $order);
    $this->render('/elements/refund_receipt_pdf');
    
  }

}
?>
