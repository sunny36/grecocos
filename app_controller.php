<?php
class AppController extends Controller {
  var $components = array('Auth', 'Session', 'RequestHandler', 
  'Secured.Ssl' => array(
    'secured' => array(
      'users' => array('login', 'signup', 'admin_login', 'supplier_login', 'coordinator_login'),      
      ), 
      'autoRedirect' => false      
    )
  );
  var $uses = array('Configuration');

  function beforeFilter(){
    if (isset($this->Configuration) && !empty($this->Configuration->table))  {  
      $this->Configuration->load();  
    }
    $this->Auth->fields = array('username' => 'email', 'password' => 'password');
    if($this->action == 'login' && !empty($this->data['User']['email'])) {
      $conditions = array('email' => $this->data['User']['email'], 'status' => 'registered');
      if ($this->User->find('count', array('conditions' => $conditions))) {
        $msg = "You cannot login yet. Your account needs to be confirmed by the co-ordinator";
        $this->Session->setFlash($msg, 'default', array(), 'auth');
        $this->redirect(array('action' => 'login'));
      }
    }
    
    $this->Auth->logoutRedirect = array('controller' => 'users','action' => 'login');
    $this->Auth->authError = "Please login.";
    $this->Auth->allow('signup', 'forgot_password', 'reset_password');
    $this->set('loggedIn', $this->Auth->user('id'));
    $this->Auth->authorize = 'controller';
    $this->currentUser = $this->Auth->user();
    $this->set('currentUser', $this->Auth->user());
    $this->Auth->loginError = "Please enter a correct username and password. Note that password is case-sensitive.";
  }
  
  function isAuthorized() { 
    return true;
  }
  
  
}
?>