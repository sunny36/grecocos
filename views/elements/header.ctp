<div id="header">
    <div id="branding">
      <h1 id="site-name">Grecocos administration</h1>
    </div>
    <div id="user-tools">
        Welcome, 
        <strong><?php e($currentUser['User']['name']) ?></strong>. /
        <?php e($html->link('Logout', array('controller' => 'users', 
			                                      'action' => 'logout'))); ?>
    </div>
    


    <ul id="navigation-menu">
      <li class="menu-item first">
        <?php e($html->link('Dashboard',
                            array('controller' => 'dashboard', 
                                  'action' => 'index', 'admin' => true))); ?>
      </li>
      <li class="menu-item bookmark">
        <?php e($html->link('Products',
                            array('controller' => 'products', 
                                  'action' => 'index', 'admin' => true))); ?>      
      </li>
      <li class="menu-item bookmark">
        <?php e($html->link('Orders',
                            array('controller' => 'orders', 
                                  'action' => 'index', 'admin' => true))); ?>      
      </li>
      <li class="menu-item bookmark">
        <?php e($html->link('Users',
                            array('controller' => 'users', 
                                  'action' => 'index', 'admin' => true))); ?>      
      </li>
    </ul>
</div>
