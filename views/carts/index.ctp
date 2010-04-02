<div id="wrap">
<div class="cart_list">
	<h3>Your shopping cart</h3>
	<div id="cart_content">
		<?php e($form->create(null, array('controller' => 'carts', 'action' => 'update'))); ?>
		<table id="products" width="100%" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<td>Qty</td>
					<td>Item Description</td>
					<td>Item Price</td>
					<td>Sub-Total</td>
				</tr>
			</thead>
			<tbody>
        <?php $i = 1; $j = 1; ?>
        <?php foreach($products as $item): ?>
        
        <tr <?php if($i&1){ echo 'class="alt"'; }?>>
          <td>
            <?php e($form->hidden('.'. $j .'.id', array('value' => $item['Product']['id'])))?>
            
            <?php e($form->text('.'. $j .'.quantity', array('value' => "0", 'maxlength' => '3', 'size' => '5')))?>
          </td>
          <td><?php echo $item['Product']['short_description']; ?></td>
          <td>&#3647 <?php echo $item['Product']['selling_price']; ?></td>
          <td>&#3647 <?php echo "0" ?></td>
        </tr>
        <?php $i++; $j++?>
        <?php endforeach; ?>
        <tr>
    			<td</td>
     		 	<td></td>
     		 	<td><strong>Total</strong></td>
     		 	<td>&#3647; 0</td>
    		</tr>
    		
			</tbody>
		</table>
		<p>
		  <?php e($html->link('Hide zero\'s quantity items', 
		                      array('controller' => 'carts', 
		                            'action' => 'empty_cart'), 
		                      array('id' => 'toggle_zero', 'class' => 'empty')))?>
		</p>
		<p>
		  <?php e($form->submit('Checkout', 
		                        array('div' => false, 'id' => "update"))); ?>
		  <?php e($html->link('Reset', 
		                      array('controller' => 'carts', 
		                            'action' => 'empty_cart'), 
		                      array('id' => 'empty_cart', 'class' => 'empty')))?>
		                      
		</p>
		<?php 
		e($form->end());
		?>
	</div>
</div>
</div>
