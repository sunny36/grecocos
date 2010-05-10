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
        <?php e($html->link('Dashboard', '/admin/dashboard/supplier')); ?>
      </li>
      <li class="menu-item">
        <a href="#"><span class="icon"></span>Orders</a>
        <ul>
          <li class="menu-item">
            <?php e($html->link('View Orders',
                                '/supplier/orders/index'))?>
          </li>
          <li class="menu-item">
            <?php e($html->link('Modify Orders',
                                '/supplier/orders/index'))?>
          </li>
          <li>
            <?php e($html->link('Close batch of orders',
                                '/supplier/orders/close_batch'))?>
          </li>          
        </ul>
      </li>
      <li class="menu-item">
        <a href="#"><span class="icon"></span>Products</a>
        <ul>
          <li class="menu-item">
            <?php e($html->link('View products',
                                '/supplier/products/index'))?>
          </li>
          <li class="menu-item">
            <?php e($html->link('View product categories',
                                '/supplier/categories/index'))?>

          </li>
        </ul>
      </li>
    </ul>
</div>
