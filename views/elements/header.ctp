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

    <li class="menu-item first"><a href="/admin/">Dashboard</a></li>

    <li class="menu-item bookmark"><a>Products</a></li>
    <li class="menu-item bookmark"><a>Orders</a></li>
    <li class="menu-item bookmark"><a>Users</a></li>

    <li class="menu-item"><a href="#"><span class="icon"></span>Applications</a><ul><li class="menu-item"><a href="/admin/products/"><span class="icon"></span>Products</a><ul><li class="menu-item"><a href="/admin/products/product/">Products</a></li></ul></li></ul></li>

    <li class="menu-item"><a href="#"><span class="icon"></span>Administration</a><ul><li class="menu-item"><a href="/admin/auth/"><span class="icon"></span>Auth</a><ul><li class="menu-item"><a href="/admin/auth/group/">Groups</a></li><li class="menu-item"><a href="/admin/auth/user/">Users</a></li></ul></li><li class="menu-item"><a href="/admin/sites/"><span class="icon"></span>Sites</a><ul><li class="menu-item"><a href="/admin/sites/site/">Sites</a></li></ul></li></ul></li>

    </ul>


</div>
