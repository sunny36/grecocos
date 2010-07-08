<div class="breadcrumbs">
  <?php e($html->link('Shopping Cart', array('controller' => 'carts', 'action' =>'index'))); ?> &rsaquo; 
  Invoice
</div>

<div id="content" class="flex">
  <div id="content-main">
    <div class="module" id="changelist">
      <h1>
        <?php e($html->link('Click here to download your invoice.', 
                            array('controller' => 'carts', 
                                  'action' => 'getInvoice')));
        ?>
      </h1>

      <p>
        <?php e($html->link('Logout', array('controller' => 'users', 'action' => 'logout'))); ?>
      </p>
      
    </div>
  </div>
</div>




