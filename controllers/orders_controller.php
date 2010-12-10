<?php 
class OrdersController extends AppController {

  var $name = 'Orders';
  var $uses = array('Order', 'Product', 'LineItem', 'Delivery','Transaction');
  var $helpers = array('Html', 'Form', 'Javascript', 'Number', 'Csv', 'Time', 'Order');
  var $components = array('SearchPagination.SearchPagination');
  
  function beforeFilter(){
    parent::beforeFilter();
    if ($this->currentUser['User']['role'] == "customer") {
      // Allow the customer to only access the index action
      if (!($this->params['action'] == "index")) {
        $this->redirect($this->referer());
      }      
    }
    $coordinatorActions = array(
      'coordinator_mark_as_paid', 
      'coordinator_mark_as_delivered', 
      'coordinator_refunds', 
      'coordinator_view', 
      'coordinator_print_refund_receipt');
    $supplierActions = array(
      'supplier_index', 
      'supplier_view', 
      'supplier_edit', 
      'supplier_lineitem', 
      'supplier_close_batch');
    if (in_array($this->params['action'], $coordinatorActions)) {
      if ($this->currentUser['User']['role'] == "supplier") {
        $this->redirect('/supplier');
      }
    }
    if (in_array($this->params['action'], $supplierActions)) {
      if ($this->currentUser['User']['role'] == "coordinator") {
        $this->redirect('/coordinator');
      }
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
      $nextDelivery = $this->Delivery->findByNextDelivery(true);
      $params = array('conditions' => array(
        'Order.status <>' => 'entered', 'Order.delivery_id' => $nextDelivery['Delivery']['id']));
      if ($search == "true") {
        if ($this->params['url']['status'] == "all") {
          $params = array('conditions' => array(
            'Order.status <>' => 'entered', 'Order.delivery_id' => $this->params['url']['delivery_date'])); 
        } 
        if ($this->params['url']['status'] == "packed") {
          $params = array('conditions' => array(
            'Order.status' => array('packed', 'delivered'), 
            'Order.delivery_id' => $this->params['url']['delivery_date'])); 
        } 
        if ($this->params['url']['status'] == "paid") {
          $params = array('conditions' => array(
            'Order.status' => $this->params['url']['status'], 
            'Order.delivery_id' => $this->params['url']['delivery_date'])); 
        }         
      }
      $orders = $this->Order->find('all', $params);
      $count = $this->Order->find('count', $params);
      $this->set('page',$page);
      $this->set('count',$count); 
      $this->set('orders', $orders);      
      $this->render('/elements/supplier_orders', 'ajax');
    }    
  }
  
  #TODO Refactor to remove common code from mark_as_paid and mark_as_delivered. 
  function coordinator_mark_as_paid() {
    $this->SearchPagination->setup();
    $this->layout = "coordinator/index";
    $deliveryDates = $this->Delivery->getDeliveryDatesList(true); 
    $nextDelivery = $this->Delivery->findByNextDelivery(true); 
    $this->set('nextDelivery', $nextDelivery);
    $condition = array();
    $condition += array('User.organization_id' => $this->currentUser['User']['organization_id']);
    if (!empty($this->params['url']['id'])) {
      $condition += array('Order.id' => $this->params['url']['id']);
    }
    if (!empty($this->params['url']['user_name'])) {
      $condition += array('OR' => array(
        'User.firstname LIKE' => '%' . $this->params['url']['user_name'] . '%', 
        'User.lastname LIKE' => '%' . $this->params['url']['user_name']. '%'));      
    }
    if (!empty($this->params['url']['delivery_date'])) {
      if ($this->params['url']['delivery_date'] > 0) {
        $condition += array('Order.delivery_id' => $this->params['url']['delivery_date']);
      }      
    } else {
      $condition += array('Order.delivery_id' => $nextDelivery['Delivery']['id']);
    }
    $count = $this->Order->find('count', array('conditions' => $condition));
    $this->paginate = array('conditions' => $condition, 'limit' => $count);
    $this->set('delivery_dates', $deliveryDates);
    $this->set('orders', $this->paginate());	  
  }

  function coordinator_mark_as_delivered() {
    $this->SearchPagination->setup();
    $this->layout = "coordinator/index";
    $this->Order->recursive = 0;
    $deliveryDates = $this->Delivery->getDeliveryDatesList(true); // true includes an element called '-1' => 'All'
    $nextDelivery = $this->Delivery->findByNextDelivery(true);
    $this->set('nextDelivery', $nextDelivery);
    $condition = array(); 
    $condition += array(
      'Order.status' => array('packed', 'delivered'), 
      'User.organization_id' => $this->currentUser['User']['organization_id']
    );
    if (!empty($this->params['url']['id'])) {
      $condition += array('Order.id' => $this->params['url']['id']); 
    } 
    if (!empty($this->params['url']['user_name'])) {
      $condition += array('OR' => array(
        'User.firstname LIKE' => '%' . $this->params['url']['user_name'] . '%', 
        'User.lastname LIKE' => '%' . $this->params['url']['user_name']. '%'));      
    }
    if (!empty($this->params['url']['delivery_date'])) {
      if ($this->params['url']['delivery_date'] > 0) {
        $condition += array('Order.delivery_id' => $this->params['url']['delivery_date']);
      }      
    } else {
      $condition += array('Order.delivery_id' => $nextDelivery['Delivery']['id']);
    }
    $count = $this->Order->find('count', array('conditions' => $condition));
    $this->paginate = array('conditions' => $condition, 'limit' => $count);
    $this->set('delivery_dates', $deliveryDates);
    $this->set('orders', $this->paginate());	  
  }

  function coordinator_refunds() {
    $this->layout = "coordinator/index"; 
    $this->Order->recursive = 1; 
    $this->paginate = array(
      'conditions' => array(
        'AND' =>(array(
          'Delivery.closed' => true, 'Order.status' => array('packed', 'delivered'), 
          'Order.total_supplied <> Order.total'
        ))), 
      'order' => 'Order.ordered_date DESC');
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
      $this->render('/elements/supplier_order_pdf_no_amounts');
    }
  }

  function supplier_edit($id = null) {	  
    if($this->RequestHandler->isAjax()) {
      $this->autoRender = false;    
      if(isset($this->params['form']['status'])) {
        $status = $this->params['form']['status'];
        $this->Order->updateOrderStatus(
          $this->params['form']['id'], 
          $this->params['form']['status']);
        //If transaction already exists delete it and re-create it. 
        $params = array(
          'conditions' => array(
            'AND' => array(
              array('Transaction.type' => 'Sales'),
              array('Transaction.order_id' => $this->params['form']['id']))));
        $transaction = $this->Transaction->find('first', $params);
        if ($transaction) {
          $this->Transaction->delete($transaction['Transaction']['id']);
        }
        //Create transaction only if the order is packed. 
        if ($this->params['form']['status'] == "Yes") {
          $order =  $this->Order->find('first', array(
                      'conditions' => array(
                        'Order.id' => $this->params['form']['id']), 
                      'recursive' => 2));
          $transaction = array('Transaction' => array(
                           'type' => "Sales", 
                           'user_id' => $this->currentUser['User']['id'], 
                           'order_id' => $this->params['form']['id'], 
                           'delivery_id' => $order['Delivery']['id'])); 
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
      $conditions = array(
        "AND" => array (
          "LineItem.order_id" => $orderId, 
          "LineItem.product_id >" => $productId));
      $lineItem = $this->LineItem->find('first', array(
                    'conditions' => array(
                      'LineItem.order_id' => $orderId, 
                      'LineItem.product_id' => $productId)));
      $this->LineItem->id = $lineItem['LineItem']['id'];
      $lineItem = json_encode($lineItem);      
      $this->set('lineItem', $lineItem);
      $this->render('/elements/order_products');
    }
  }

  function supplier_close_batch() {
    $this->layout = 'supplier/index';
    $nextDelivery = $this->Delivery->getAllDeliveriesAfterNextDelivery(); 
    $this->set('next_delivery', $nextDelivery);
    if($this->RequestHandler->isAjax()) {
      $sidx = $this->params['url']['sidx']; 
      $sord = $this->params['url']['sord']; 
      if(!$sidx) $sidx ="date";
      if(!$sord) $sord ="desc";
      $count = $this->Delivery->find('count');
      $this->log($count);
      $params = array('conditions' => array('Delivery.next_delivery' => true)); 
      $next_delivery = $this->Delivery->find('first', $params);
      $params = array(
        'conditions' => array(
          'Delivery.date <=' => $next_delivery['Delivery']['date']),
        'order' => array('Delivery.' . $sidx . ' ' . strtoupper($sord), 'Delivery.date DESC')); 
      $delivery_dates = $this->Delivery->find('all', $params); 
      $this->log(count($delivery_dates));
      App::import( 'Helper', 'Time' );
      $time = new TimeHelper;
      foreach($delivery_dates as &$delivery) {
        $delivery['Delivery']['date'] = 
          $time->format($format = 'd-m-Y', $delivery['Delivery']['date']);
        $packed = 0; 
        $paid = 0;
        foreach($delivery['Order'] as $order) {
          if($order['status'] == "delivered") {
            $packed = $packed + 1;
          }
          if($order['status'] == "packed") $packed = $packed + 1;
          if($order['status'] == "paid") $paid = $paid + 1;
        }         
        $delivery['Delivery']['packed'] = $packed;
        $delivery['Delivery']['ordered'] = $packed + $paid;
      }

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
      $order =  $this->Order->find(
        'first', array(
          'conditions' => array('Order.id' => $this->params['form']['id']), 
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
      $transaction = array(
        'Transaction' => array(
          'type' => $transactionType, 
          'user_id' => $this->currentUser['User']['id'], 
          'order_id' => $order['Order']['id'],
          'delivery_id' => $order['Delivery']['id'])); 
      $this->Transaction->create(); 
      $this->Transaction->save($transaction); 
    }
  }

  function getstatus(){
    Configure::write('debug', 0);
    // $this->autoRender = false;
    if($this->RequestHandler->isAjax()) {
      $order =  $this->Order->find(
        'first', array(
          'conditions' => array('Order.id' => $this->params['url']['id']), 
          'recursive' => -1));
      $this->set('status', $order['Order']['status']);
    } 
  }

  function getdeliverystatus(){
    Configure::write('debug', 0);
    // $this->autoRender = false;
    if($this->RequestHandler->isAjax()) {
      $order =  $this->Order->find(
        'first', array(
          'conditions' => array('Order.id' => $this->params['url']['id']), 
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
  
  function index() {    
    $this->layout = 'customer_index';
    $this->paginate = array(
      'conditions' => array(
        'Order.user_id' => $this->currentUser['User']['id']),
      'order' => 'ordered_date DESC');    
    $this->set('orders', $this->paginate()); 
  }
  
  function supplier_products_orders() {    
    $this->set('title_for_layout', 'Supplier | Products Orders Reports');
    $this->layout = "supplier/index"; 
    $Delivery = ClassRegistry::init('Delivery');
    $deliveryDates = $Delivery->getDeliveryDatesList(); 
    $this->set('delivery_dates', $deliveryDates);
    if (!empty($this->params['url']['delivery_date'])) {
      $Order = ClassRegistry::init('Order');
      $orders = $Order->findAllByDeliveryIdAndStatus(
        $this->params['url']['delivery_date'], 
        array('paid', 'packed', 'delivered'));
      if (count($orders) < 1) {
        $this->Session->setFlash('Sorry, there is no orders for this delivery date', 'flash_notice');
        $this->redirect(array('action' => 'products_orders'));
      }
      $productIds = NULL; 
      foreach ($orders as $order) {
        foreach ($order['LineItem'] as $lineItem) {
          $productIds[] = $lineItem['product_id']; 
        }
      }
      $productIds = array_values(array_unique($productIds)); 
      $products = $this->Product->find('all', array(
        'conditions' => array('Product.id' => $productIds)));
      $this->set('products', $products); 
      $productsOrders = NULL; 
      $productsOrders[0][0] = 'Id';
      $productsOrders[0][1] = 'ชื่อสินค้า';
      $productsOrders[0][count($orders) + 2] = 'รวม';
      $col = 2;
      foreach ($orders as $order) {
        $productsOrders[0][$col++] = $order['Order']['id'];
      }
      $row = 1;
      // Fill in products for every row
      foreach ($products as $product) {
        $productsOrders[$row][0] = $product['Product']['id'];
        $productsOrders[$row][1] = $product['Product']['short_description_th'];
        $row++;
      }
      for ($row = 1; $row < count($productsOrders); $row++) {
        foreach ($orders as $order) {
          foreach ($order['LineItem'] as $lineItem) {
            if ($productsOrders[$row][0] == $lineItem['product_id']) {
              $productsOrders[$row][array_search($lineItem['order_id'], $productsOrders[0])] = 
                $lineItem['quantity_supplied'];                                  
            }
          }
        }
      }
      for ($row = 1; $row < count($products) + 1; $row++) { 
        for ($col = 2; $col  < count($orders) + 2; $col ++) { 
          if (!array_key_exists($col, $productsOrders[$row])) {
            $productsOrders[$row][$col] = 0; 
          }
        }
      }
      // Sort productOrders by key
      for($row = 0; $row < count($products) + 1; $row++) {
        ksort($productsOrders[$row]); 
      }      
      for ($i = 1; $i < count($productsOrders); $i++) { 
        $productTotal = 0; 
        for ($j = 2; $j < count($productsOrders[$i]); $j++) { 
          $productTotal += $productsOrders[$i][$j];
        }
        $productsOrders[$i][$j] = $productTotal; 
      }
      $this->log(count($products));
      for ($j = 2; $j < count($orders) + 3; $j++) { 
        $orderTotal = 0; 
        for ($i = 1; $i < count($products) + 1 ; $i++) { 
          $orderTotal = $orderTotal + $productsOrders[$i][$j];
        }
        $productsOrders[$i][0] = 'รวม';
        $productsOrders[$i][1] = 'รวม';
        $productsOrders[$i][$j] = $orderTotal;
      }                  
     $this->log($productsOrders);
     $this->set('productsOrders', $productsOrders);
     App::import( 'Helper', 'Time' );
     $time = new TimeHelper;
     $Delivery = ClassRegistry::init('Delivery');
     $delivery = $Delivery->findById($this->params['url']['delivery_date']);
     $fileName = $time->format($format = 'd-m-Y', $delivery['Delivery']['date']) . 
                 "_report.xls";
    $this->set('fileName', $fileName);
     $this->render('/elements/pdf_report/supplier_products_orders', 'fpdf');      
    }
  }
  
  function coordinator_send_payment_reminder_emails() {
    if($this->RequestHandler->isAjax()) { 
      $Order = ClassRegistry::init('Order');
      $Order->sendReminderEmailForPayment();
    } else {
      $this->layout ="coordinator/index";
      $Delivery = ClassRegistry::init('Delivery');
      $deliveryDates = $Delivery->getDeliveryDatesList(); 
      $this->set('delivery_dates', $deliveryDates);      
      $delivery = $Delivery->getNextDelivery();
      $Order = ClassRegistry::init('Order');
      $orders = $Order->findAllByDeliveryIdAndStatusAndOrderedDate(
        $delivery['Delivery']['id'],
        array('entered'),
        date('Y-m-d H:i:s', strtotime('-1 hour')));
      $this->log(date('Y-m-d H:i:s', strtotime('-1 hour')));
      $this->set('orders', $orders);  
    }
    
  }
}
?>
