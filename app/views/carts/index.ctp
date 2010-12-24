<div id="box" style="border: solid; width: 400px;">
  My content is copied into the facybox!
</div>

<div id="cartDiv" style="display:none;">
  <table id="cartTable"></table> 
  <br/>
  <button id="confirmButton"><strong>Confirm</strong></button>
  <button id="continueShoppingButton">Continue Shopping</button>
</div>

<div id="wrap">
  <?php echo $this->Session->flash(); ?>
  <?php if (!$closed): ?>
  <div class="cart_list">
    <h3>Your shopping cart</h3>
    <div id="cart_content">
      <?php e($form->create(null, array('controller' => 'carts', 'action' => 'confirm'))); ?>
      <table id="products" width="100%" cellpadding="0" cellspacing="0">
        <?php $this->Cart->tableHeader(); ?>
        <?php $i = 1; $row = 1; $masterCategoryNum = 1; $categoryNum = 1;?>        
        <?php for($j=0; $j < count($products); $j++): ?>
          <?php $this->Cart->masterCategoryRow($categoryNum, $products[$j]['MasterCategory']['name']); ?>
          <?php for($k=0; $k<count($products[$j]['Products']); $k++): ?>
            <?php if(count($products[$j]['Products'][$k]['Product']) > 0): ?>
              <?php $this->Cart->categoryRow($categoryNum, $products[$j]['Products'][$k]['Category']['name']); ?>            
              <tbody class="<?php echo "category{$categoryNum} master_category{$masterCategoryNum}"; ?>">     
                <?php for($l=0; $l < count($products[$j]['Products'][$k]['Product']); $l++):?>   
                  <?php
                    $this->Cart->productRow(
                      $i, $row, $products[$j]['Products'][$k]['Product'][$l]['id'],
                      $products[$j]['Products'][$k]['Product'][$l]['short_description'],
                      $products[$j]['Products'][$k]['Product'][$l]['selling_price']);
                  ?>
                  <?php $row++; $i++; ?>
                <?php endfor; ?> <!-- l -->
              </tbody>
              <?php $categoryNum++; ?>
            <?php endif; ?>                        
          <?php endfor; ?> <!-- k -->
          <?php $masterCategoryNum++; ?>          
       <?php endfor; ?> <!-- j -->
  <tr id="totalRow">
    <td> </td>
    <td> </td>
    <td><h3>Total</h3></td>
    <td><h3>&#3647; 0<h3></td>
  </tr>
  
</table>
<p>

  <?php 
    e($form->button('View your order', array('div' => false, 'id' => 'toggle_zero', 'class' => 'empty')));
  ?>
</p>
<p>
  <?php e($form->submit('Checkout', array('div' => false, 'id' => "update"))); ?>
  <?php e($form->end());?>
  <?php 
    e($form->submit('Reset', array('div' => false, 'id' => 'empty_cart', 'class' => 'empty')));
  ?>
  
</p>

</div>
</div>
<?php else: ?>
  <h1>
    The order system is currently closed because we are preparing your orders for <?php echo $nextDeliveryDate; ?>.
  </h1>
<?php endif; ?>
</div>
