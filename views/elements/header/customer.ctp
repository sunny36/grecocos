<div id="header">
  <div id="branding">
    <h1 id="site-name">Grecocos</h1>
  </div>
  <div id="user-tools">
    Welcome, <strong><?php e($currentUser['User']['name']) ?></strong>. /
    <?php echo $html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?><br/>
    <?php echo $html->link('Shopping Cart', array('controller' => 'carts', 'action' => 'index')); ?> |
    <?php if ($currentUser['User']['role'] == "supplier"): ?>
      <?php echo $html->link('Supplier Dashboard', '/supplier'); ?>
    <?php else: ?>
      <?php echo $html->link('Edit Profile', array('controller' => 'users', 'action' => 'edit')); ?> |
      <?php echo $html->link('View Orders History', array('controller' => 'orders', 'action' => 'index'));?>
    <?php endif; ?>
  </div>
</div>
