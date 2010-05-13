<?php
class UsersController extends AppController {

  var $name = 'Users';
  var $components = array('Email');
  var $helpers = array('Html', 'Form', 'Javascript');
  
  function admin_index() {
    $this->layout = "admin_index"; 
    $this->User->recursive = 0;
    $this->set('users', $this->paginate());
  }

  function coordinator_index() {
    //Same as admin_index except that use a differnt layout 
    $this->layout = "coordinator/index"; 
    $this->User->recursive = 0;
    $this->set('users', $this->paginate());
    $this->render('/users/admin_index');
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
        $this->set('firstname', $this->data['User']['firstname']); 
        $this->_sendMail($this->data['User']['email'], 
                         "GRECOCOS: Your account has been accepted", 
                         "accepted"); 
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
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {
      if($this->data['User']['status'] == 'accepted'){
        $this->set('firstname', $this->data['User']['firstname']); 
        $this->_sendMail($this->data['User']['email'], 
                         "GRECOCOS: Your account has been accepted", 
                         "accepted"); 
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
      $this->Session->setFlash(sprintf(__('%s deleted', true), 'User'));
      $this->redirect(array('action'=>'index'));
    }
    $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'User'));
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
    if(!empty($this->data)) {
      //status: 000 means self registered but not accepted
      $this->data['User']['status'] = 'registered';
      if(isset($this->data['User']['password2'])){
        $this->data['User']['password2hashed'] =
          $this->Auth->password($this->data['User']['password2']);
      }
      $this->User->create();
      
      if($this->User->save($this->data)){
        
        $this->Email->to = $this->data['User']['email']; 
        $this->Email->subject = 'GRECOCOS: Signup'; 
        $this->Email->replyTo = 'admin@grecocos.co.cc'; 
        $this->Email->from = 'Somchok Sakjiraphong <somchok.sakjiraphong@ait.ac.th>'; 
        $this->Email->sendAs = 'html';
        $this->Email->template = 'signup';
        $this->set('firstname', $this->data['User']['firstname']); 
        /* SMTP Options */
        $this->Email->smtpOptions = array(
                                          'port'=>'25', 
                                          'timeout'=>'30',
                                          'host' => 'smtp.ait.ac.th',
                                          'username'=>'st108660',
                                          'password'=>'m2037compaq'
                                          );
        /* Set delivery method */
        $this->Email->delivery = 'smtp';
        if($this->Email->send()){
          $this->Session->setFlash('Please wait for an confirmation email from the co-ordinator.');
          $this->redirect(array('controller' => 'users', 'action' => 'login'));
        } else {
          $this->User->del($this->User->getLastInsertID());
          $this->Session->setFlash('There was a problem in sending email. Please try again');
        }
      } else {
        $this->Session->setFlash(
                                 'There was an error signing up. Please try again.');
        $this->data['User']['password'] = null; 
        $this->data['User']['password2'] = null; 
      }
    }
  }
  
  function login(){
    if( $this->Auth->user( )){
      $this->redirect( array('controller' => 'carts' , 'action' => 'index'));
    }
  }
  
  function logout() { 
    $this->Session->setFlash('You have logged out!!');
    $this->redirect($this->Auth->logout());
  }
  
  function admin_login(){ 
    $this->set('title_for_layout', 'Login | Grecocos Administration');
    $this->layout = "admin_login"; 
    if($this->Auth->user()) {
      $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
    }
  }

  function coordinator_login(){ 
    $this->set('title_for_layout', 'Login | Grecocos Administration');
    $this->layout = "admin_login"; 
    if($this->Auth->user()) {
      $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
    }
    $this->render('/users/admin_login');
  }

  function supplier_login(){ 
    $this->set('title_for_layout', 'Login | Grecocos Administration');
    $this->layout = "admin_login"; 
    if($this->Auth->user()) {
      $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
    }
    $this->render('/users/admin_login');
  }
  
  function admin_logout() { 
    $this->Session->setFlash('You have logged out!!');
    if($this->Auth->logout()){
      $this->redirect(array('controller' => 'users', 
                            'action' => 'login', 'admin' => true));
      
    }
  }

  function coordinator_logout() { 
    $this->Session->setFlash('You have logged out!!');
    if($this->Auth->logout()){
      $this->redirect(array('controller' => 'users', 
                            'action' => 'login', 'admin' => true));
      
    }
  }

  function supplier_logout() { 
    $this->Session->setFlash('You have logged out!!');
    if($this->Auth->logout()){
      $this->redirect(array('controller' => 'users', 
                            'action' => 'login', 'admin' => true));
      
    }
  }
  

}
?>