<?php
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */

class AppController extends Controller {
  var $components = array('Auth', 'Session');

  function beforeFilter(){
    //$this->Auth->userScope = array('User.status' => '010');
    $this->Auth->fields = array('username' => 'email', 'password' => 'password');

		if($this->action == 'login' && !empty($this->data['User']['email'])) {
			$conditions = array('email' => $this->data['User']['email'], 'status' => '000');
			if ($this->User->find('count', array('conditions' => $conditions))) {
				$this->Session->setFlash("You cannot login yet. Your account needs to be confirmed by the co-ordinator", 
																 'default', 
																	array(), 
																	'auth');
				$this->redirect(array('action' => 'login'));
			}
		}
		
    $this->Auth->loginRedirect = array('controller' => 'carts', 
                                       'action' => 'index');
    $this->Auth->logoutRedirect = array('controller' => 'users', 
                                       'action' => 'login');                          
    $this->Auth->allow('signup');
    
    $this->set('loggedIn', $this->Auth->user('id'));   
    $this->Auth->authorize = 'controller';         
		$this->currentUser = $this->Auth->user();           
		$this->Auth->loginError = "Invalid email or password";                  
  }
  
  function isAuthorized() { 
    return true;
  }
}
?>