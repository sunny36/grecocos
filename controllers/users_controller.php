<?php
class UsersController extends AppController {

  var $name = 'Users';
  var $components = array('Email', 'SearchPagination.SearchPagination');
  var $helpers = array('Html', 'Form', 'Javascript');
  var $uses = array('User', 'Organization');
  
  function admin_index() {
    $this->layout = "admin_index"; 
    $this->User->recursive = 0;
    $this->set('users', $this->paginate());
  }

  function coordinator_index() {
    $this->SearchPagination->setup();
    $this->layout = "coordinator/index"; 
    $this->User->recursive = 0;
    if (!empty($this->params['url']['user_name'])) {
      $customerName = $this->params['url']['user_name']; 
      $this->set('default_customer_name', $customerName); 
    }
    if(!empty($customerName)){
      $this->paginate = array('conditions' => array('OR' => array(
        'User.firstname LIKE' => '%' . $customerName. '%',
        'User.lastname LIKE' => '%' . $customerName. '%')));
    }	  
    $this->set('users', $this->paginate());
  }
  
  function coordinator_index_proxy() {
    if (!empty($this->params['url']['user_name'])) { 
      $customerName = $this->params['url']['user_name']; 
      $this->redirect(array('action' => 'index'.'?user_name='. $customerName));
    }
  }

  function admin_view($id = null) {
    $this->layout = "admin_add";
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
      $this->redirect(array('action' => 'index'));
    }
    $user = $this->User->getUser($id); 
    $this->set('user', $user);
  }

  function coordinator_view($id = null) {
    //Same as admin_index except that use a differnt layout 
    $this->layout = "coordinator/add";
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
      $this->redirect(array('action' => 'index'));
    }
    $user = $this->User->getUser($id); 
    $this->set('user', $user);
    $this->render('/users/admin_view');
  }

  function admin_edit($id = null) {
    $this->layout = "admin_add";
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {
      if($this->data['User']['status'] == 'accepted'){
        $this->User->sendAcceptanceEmail($this->data['User']['id']); 
      }      
      if ($this->User->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
      }
    }
    if (empty($this->data)) {
      $this->data = $this->User->read(null, $id);
    }
  }

  function coordinator_edit($id = null) {
    $this->layout = "coordinator/add";
    $delivery_addresses = $this->Organization->find('list', array('fields' => 'Organization.delivery_address'));
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {
      if($this->data['User']['status'] == 'accepted'){
        $this->User->sendAcceptanceEmail($this->data['User']['id']); 
      }      
      if ($this->User->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
      }
    }
    if (empty($this->data)) {
      $this->data = $this->User->read(null, $id);
    }
    $this->set('delivery_addresses', $delivery_addresses);
    $this->render("admin_edit");
  }
  
  function admin_delete($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'user'));
      $this->redirect(array('action'=>'index'));
    }
    if ($this->User->delete($id)) {
      $this->Session->setFlash(sprintf(__('%s deleted', true), 'User'));
      $this->redirect(array('action'=>'index'));
    }
    $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'User'));
    $this->redirect(array('action' => 'index'));
  }

  function coordinator_delete($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'user'));
      $this->redirect(array('action'=>'index'));
    }
    if ($this->User->delete($id)) {
      $this->Session->setFlash(sprintf(__('%s deleted', true), 'User'), 'flash_notice');
      $this->redirect(array('action'=>'index'));
    }
    $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'User'), 'flash_notice');
    $this->redirect(array('action' => 'index'));
  }
  
  function view($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
      $this->redirect(array('action' => 'index'));
    }
    $this->set('user', $this->User->read(null, $id));
  }


  function edit($id = null) {
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {			
      if ($this->User->save($this->data)) {
        $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
      }
    }
    if (empty($this->data)) {
      $this->data = $this->User->read(null, $id);
    }
  }

  function delete($id = null) {
    if (!$id) {
      $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'user'));
      $this->redirect(array('action'=>'index'));
    }
    if ($this->User->delete($id)) {
      $this->Session->setFlash(sprintf(__('%s deleted', true), 'User'));
      $this->redirect(array('action'=>'index'));
    }
    $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'User'));
    $this->redirect(array('action' => 'index'));
  }
  
  function signup(){
    $this->set('title_for_layout', 'Customer Signup');
    $this->layout = "users/signup"; 
    $delivery_addresses = $this->Organization->find('list', array('fields' => 'Organization.delivery_address'));
    $this->set('delivery_addresses', $delivery_addresses);
    if(!empty($this->data)) {
      $this->data['User']['status'] = 'registered';
      $this->data['User']['role'] = 'customer';
      if(isset($this->data['User']['password2'])){
        $this->data['User']['password2hashed'] = $this->Auth->password($this->data['User']['password2']);
      }
      $this->User->create();
      if($this->User->save($this->data)){
        // $this->set('firstname', $this->data['User']['firstname']); 
        // $sendEmail = $this->_sendMail($this->data['User']['email'], 'GRECOCOS: Signup', 'signup');
        $this->User->sendEmailWaitForConfirmation($this->data['User']['firstname'], $this->data['User']['email']); 
        $this->User->sendEmailNewUserSignUp(); 
        $msg = 'Please wait for an confirmation email from the co-ordinator.';
        $this->Session->setFlash($msg);
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
        
        // if($sendEmail){
        //   $msg = 'Please wait for an confirmation email from the co-ordinator.';
        //   $this->Session->setFlash($msg);
        //   $this->redirect(array('controller' => 'users', 'action' => 'login'));
        // } else {
        //   $this->User->delete($this->User->getLastInsertID());
        //   $msg = 'There was a problem in sending email. Please try again';
        //   $this->Session->setFlash($msg, 'flash_error');
        //   $this->data['User']['password'] = null; 
        //   $this->data['User']['password2'] = null; 
        // }
      } else {
        $msg = 'There was an error signing up. Please try again.';
        $this->Session->setFlash($msg, 'flash_error');
        $this->data['User']['password'] = null; 
        $this->data['User']['password2'] = null; 
      }
    }
  }
  function reset_password() {
    $this->set('title_for_layout', 'Forgot Password');
    $this->set('title_for_branding', 'Forgot Password');    
    $this->layout = "users/login";    
    $this->User->resetPassword($this->data['User']['email']);
  }
  
  function forgot_password() {
    $this->set('title_for_layout', 'Forgot Password');
    $this->set('title_for_branding', 'Forgot Password');
    $this->layout = "users/login";    
  }
  
  function login(){
    $this->set('title_for_layout', 'Login');
    $this->set('title_for_branding', 'Login');
    $this->layout = "users/login";
    if( $this->Auth->user( )){
      $this->redirect( array('controller' => 'carts' , 'action' => 'index'));
    }
  }
  
  function logout() { 
    $this->redirect($this->Auth->logout());
  }
  
  function admin_login(){ 
    $this->set('title_for_layout', 'Login | Grecocos Administration');
    $this->layout = "admin_login"; 
    if($this->Auth->user()) {
      if ($this->currentUser['User']['role'] == "customer") {
        $this->redirect('/admin/users/logout');
      }
      $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
    }
  }

  function coordinator_login(){ 
    $this->set('title_for_layout', 'Login | Grecocos Administration');
    $this->layout = "admin_login"; 
    if($this->Auth->user()) {
      if ($this->currentUser['User']['role'] == "customer") {
        $this->redirect('/coordinator/users/logout');
      }
      $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
    }
    $this->render('/users/admin_login');
  }

  function supplier_login(){ 
    $this->set('title_for_layout', 'Login | Grecocos Administration');
    $this->layout = "admin_login"; 
    if($this->Auth->user()) {
      if ($this->currentUser['User']['role'] == "customer") {
        $this->redirect('/supplier/users/logout');
      }
      $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
    }
    $this->render('/users/admin_login');
  }

  function administrator_login(){ 
    $this->set('title_for_layout', 'Login | Grecocos Administration');
    $this->layout = "admin_login"; 
    if($this->Auth->user()) {
      if ($this->currentUser['User']['role'] == "customer") {
        $this->redirect('/administrator/users/logout');
      }
      $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
    }
    $this->render('/users/admin_login');
  }
  
  function admin_logout() { 
    if($this->Auth->logout()){
      $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => true));
    }
  }

  function coordinator_logout() { 
    if($this->Auth->logout()){
      $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => true));
    }
  }

  function supplier_logout() { 
    if($this->Auth->logout()){
      $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => true));
    }
  }
  
  function administrator_logout() { 
    if($this->Auth->logout()){
      $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => true));
    }
  }
  
}
?>
