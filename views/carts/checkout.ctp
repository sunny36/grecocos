<p>
  <?php e($html->link('Click here to download your invoice.', 
                      array('controller' => 'carts', 
                            'action' => 'getInvoice')));
  ?>
</p>

<p>
  <?php e($html->link('Logout', array('controller' => 'users', 'action' => 'logout'))); ?>
</p>

