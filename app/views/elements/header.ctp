<div id="header">
  <div id="branding">
    <h1 id="site-name">Grecocos</h1>
  </div>
  <div id="user-tools">
      Welcome, <strong><?php e($currentUser['User']['name']) ?></strong>. /
      <?php 
        echo $html->link('Logout', array('controller' => 'users', 
                                         'action' => 'logout')); 
      ?>
  </div>
</div>
