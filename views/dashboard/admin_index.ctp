<div id="content" class="colMS">
  <h1>Select you role</h1>    
  <div id="content-main">
    <?php if(in_array($currentUser['User']['role'], array("admin", "customer", "coordinator"))): ?>
      <h2>1. <?php e($html->link('Customer', '/carts')); ?></h2>
    <?php endif; ?>
    <?php if(in_array($currentUser['User']['role'], array("admin", "coordinator"))): ?>
      <h2>2. <?php e($html->link('Co-ordinator', '/coordinator')); ?></h2>
    <?php endif; ?>
    <?php if(in_array($currentUser['User']['role'], array("admin", "supplier"))): ?>
    <h2>3. <?php e($html->link('Supplier', '/supplier')); ?></h2>
    <?php endif; ?>
    <?php if(in_array($currentUser['User']['role'], array("admin"))): ?>
      <h2>4. <?php e($html->link('Administrator', '/administrator')); ?></h2>
    <?php endif; ?>
  <br class="clear" />
</div>
