<?php
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */

  Router::parseExtensions('json');
 
	Router::connect('/', array('controller' => 'users', 'action' => 'login'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));  
  Router::connect('/admin', array('controller' => 'dashboard', 'action' => 'index', 'admin' => true));
  Router::connect('/coordinator', array('controller' => 'dashboard', 'action' => 'coordinator', 'admin' => true));
  Router::connect('/supplier', array('controller' => 'dashboard', 'action' => 'supplier', 'admin' => true));
  Router::connect('/administrator', array('controller' => 'dashboard', 'action' => 'administrator', 'admin' => true));
  Router::connect('/line_items/index/:delivery_date', array('controller' => 'line_item', 'action' => 'index'),
                  array('delivery_date' => '[0-9]+'));                                  
  Router::connect('/supplier/batch_reports', array('controller' => 'line_items', 'action' => 'index', 
                                                   'supplier' => true));
  Router::connect('/coordinator/batch_reports', array('controller' => 'line_items', 'action' => 'index', 
                                                      'coordinator' => true));
?>
