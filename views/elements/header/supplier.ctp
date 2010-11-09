<div id="header">
  <div id="branding">
    <h1 id="site-name">Grecocos Supplier Interface</h1>
    <h2 id="site-name">
      <?php
        if (Configure::read('Grecocos.closed') == "yes") {
          echo "SITE STATUS: CLOSED";
        } else {
          echo "SITE STATUS: OPEN";
        }
      ?>
    </h1>
  </div>
  <div id="user-tools">
    Welcome, 
    <strong><?php e($currentUser['User']['name']) ?></strong>. /
    <?php e($html->link('Logout', array('controller' => 'users', 
    'action' => 'logout'))); ?>
  </div>
    </div>
