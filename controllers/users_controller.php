<?php
class UsersController extends AppController {

  var $name = 'Users';
  var $components = array('Email', 'SearchPagination.SearchPagination');
  var $helpers = array('Html', 'Form', 'Javascript');
  var $uses = array('User', 'Organization');

  function beforeFilter(){
    parent::beforeFilter();
    $coordinatorActions = array('coordinator_index', 
                                'coordinator_index_proxy', 
                                'coordinator_view', 
                                'coordinator_edit', 
                                'coordinator_delete');
    if (in_array($this->params['action'], $coordinatorActions)) {
      if ($this->currentUser['User']['role'] == "supplier") {
       $this->redirect('/supplier'); 
      }
    }
  }

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
    $delivery_addresses = $this->Organization->find('list', array(
      'fields' => 'Organization.delivery_address'));
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


  function edit() {
    $id = $this->currentUser['User']['id'];
    $this->layout = "customer/add";
    $delivery_addresses = $this->Organization->find('list', array(
      'fields' => 'Organization.delivery_address'));
    $this->set('delivery_addresses', $delivery_addresses);
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {			
      if ($this->User->save($this->data)) {
        $this->Session->setFlash('Your user profile has been updated',
                                 'flash_notice');
        $this->redirect(array('action' => 'edit'));
      } else {
        $this->Session->setFlash('Your user profile could not be updated. ' . 
                                 'Please try again', 
                                 'flash_error');
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
        $this->User->sendEmailWaitForConfirmation($this->data['User']['firstname'], $this->data['User']['email']); 
        $this->User->sendEmailNewUserSignUp(); 
        $this->Session->setFlash('Please wait for an confirmation email from the co-ordinator.');
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
      } else {
        $this->Session->setFlash('There was an error signing up. Please try again.', 'flash_error');
        $this->data['User']['password'] = null; 
        $this->data['User']['password2'] = null; 
      }
    }
  }

  function reset_password() {
    $this->set('title_for_layout', 'Forgot Password');
    $this->set('title_for_branding', 'Forgot Password');    
    $this->layout = "users/login";   
    $this->set('emailSent', false); 
    if (!empty($this->data)) {
      if(!$this->User->findByEmail($this->data['User']['email'])) {
        $this->Session->setFlash('Email does not exists', 'flash_error');
        $this->redirect('/users/reset_password');
      } else {
        $this->User->resetPassword($this->data['User']['email']);
        $this->set('emailSent', true);        
      }
    }    
  }

  function forgot_password() {
    $this->set('title_for_layout', 'Forgot Password');
    $this->set('title_for_branding', 'Forgot Password');
    $this->layout = "users/login";
    if (!empty($this->data)) {
      $this->data['User']['password'] = $this->Auth->password($this->data['User']['password1']);
      $this->data['User']['password2hashed'] = $this->Auth->password($this->data['User']['password2']);      
      if($this->User->save($this->data)) {       
        $this->User->read(null, $this->data['User']['id']);
        $this->User->set(array('token' => null, 'token_expiry' => null)); 
        $this->User->save();
        $this->Session->setFlash('Password has been changed', 'flash_notice');
        $this->redirect('/users/login');
      } else {
        $email = $this->Session->read('ForgotPassword.email');
        $token = $this->Session->read('ForgotPassword.token');
        $this->Session->setFlash('Password do not match.', 'flash_error');
        $this->redirect("/users/forgot_password?email={$email}&token={$token}");               
      }
    }    
    
    if (empty($this->data)) {
      $user = $this->User->findByEmail($this->params['url']['email']);
      if ($this->params['url']['token'] != $user['User']['token'] || 
          strtotime("now") > strtotime($user['User']['token_expiry'])) { 
        $this->cakeError('error404'); 
      } 
       $this->Session->write('ForgotPassword.email', $user['User']['email']);
       $this->Session->write('ForgotPassword.token', $user['User']['token']);
       $this->data = $this->User->read(null, $user['User']['id']);
       $this->data['User']['password1'] = null; 
       $this->data['User']['password2'] = null;        
    }    
  }

  function login(){
    $this->set('title_for_layout', 'Login');
    $this->set('title_for_branding', 'Login');
    $this->layout = "users/login";
    
    if($this->Auth->user()){
      if ($this->currentUser['User']['role'] == "customer") {
         $this->redirect( array('controller' => 'carts' , 'action' => 'index'));
      }      
      if ($this->currentUser['User']['role'] == "supplier") {
        $this->redirect('/supplier');
      }
      // Coordinator or Administrator
      $this->redirect('/admin/dashboard');      
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
      if ($this->currentUser['User']['role'] == "supplier") {
        $this->redirect('/supplier');
      }      
      // Coordinator or Administrator
      $this->redirect('/admin/dashboard');
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
      if ($this->currentUser['User']['role'] == "supplier") {
        $this->redirect('/supplier');
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
