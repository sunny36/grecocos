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
        <?php e($html->link('Dashboard', '/admin/dashboard/administrator')); ?>
      </li>
      <li class="menu-item">
        <a href="#"><span class="icon"></span>Customers</a>
        <ul>
          <li class="menu-item">
            <?php e($html->link('View customers information',
                                '/admin/users/index'))?>

          </li>
        </ul>
      </li>
    </ul>
</div>
