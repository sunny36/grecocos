<?php
class AppController extends Controller {
  var $components = array('Auth', 'Session', 'RequestHandler');

  function beforeFilter(){
    $this->Auth->fields = array('username' => 'email', 
                                'password' => 'password');
    if($this->action == 'login' && !empty($this->data['User']['email'])) {
      $conditions = array('email' => $this->data['User']['email'],
                          'status' => 'registered');
      if ($this->User->find('count', array('conditions' => $conditions))) {
        $msg = "You cannot login yet." .
          "Your account needs to be confirmed by the co-ordinator";
        $this->Session->setFlash($msg, 'default', array(), 'auth');
        $this->redirect(array('action' => 'login'));
      }
    }
    
    // $this->Auth->loginRedirect = array('controller' => 'carts',
    //                                    'action' => 'index');
    $this->Auth->logoutRedirect = array('controller' => 'users',
                                        'action' => 'login');
    $this->Auth->allow('signup');
    $this->set('loggedIn', $this->Auth->user('id'));
    $this->Auth->authorize = 'controller';
    $this->currentUser = $this->Auth->user();
    $this->set('currentUser', $this->Auth->user());
    $this->Auth->loginError = "Please enter a correct username and password. " . 
      "Note that password is case-sensitive.";
  }
  
  function isAuthorized() { 
    return true;
  }
  
  function _sendMail($to,$subject,$template) {
    $this->Email->to = $to;
    $this->Email->subject = $subject;
    $this->Email->replyTo = 'admin@grecocos.co.cc'; 
    $this->Email->from = 'Somchok Sakjiraphong <somchok.sakjiraphong@ait.ac.th>';
    $this->Email->template = $template;
    $this->Email->sendAs = 'html';
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
    
    $this->Email->send();
  }
  
}
?>