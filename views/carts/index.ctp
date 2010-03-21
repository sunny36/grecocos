<ul class="products">
	<?php foreach($products as $p): ?>
	  <li>
	    <h3><?php echo $p['Product']['name']; ?></h3>
	    <?php e($html->image($p['Product']['image'])); ?><br/>
	    <medium>&#3647;<?php echo $p['Product']['price']; ?></medium>
	    
	    <?php e($form->create(null, array('controller' => 'cart', 'action' => 'add')));?> 
	    <fieldset>
				<label>Quantity</label>
		    <?php e($form->text('quantity', array('value' => '0', 'maxlength' => '2'))); ?>
				<?php e($form->hidden('id', array('value' => $p['Product']['id']))); ?>
				<?php e($form->submit('Add', array('div' => false))); ?>
			</fieldset>
			<?php e($form->end()); ?>
    </li>
	  <?php endforeach;?>
</ul>

<div class="cart_list">
	<h3>Your shopping cart</h3>
	
	<div id="cart_content">
	<?php if(!$this->Session->check('cart')):
		echo 'You don\'t have any items yet.';
	else:
	?>
		<?php e($form->create(null, array('controller' => 'cart', 'action' => 'update'))); ?>
		<table width="100%" cellpadding="0" cellspacing="0">
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
        <?php foreach($this->Session->read('cart') as $item): ?>
        <?php e($form->hidden('.'. $j .'.rowid', array('value' => $item['rowid'])))?>
        <tr <?php if($i&1){ echo 'class="alt"'; }?>>
          <td>
            <?php e($form->text('.'. $j .'.quantity', array('value' => $item['quantity'], 'maxlength' => '3', 'size' => '5')))?>
          </td>
          <td><?php echo $item['name']; ?></td>
          <td><?php echo $item['price']; ?></td>
          <td><?php echo $item['subtotal'] ?></td>
        </tr>
        <?php $i++; $j++?>
        <?php endforeach; ?>
        <tr>
    			<td</td>
     		 	<td></td>
     		 	<td><strong>Total</strong></td>
     		 	<td>&euro;<?php echo $this->Session->read('cart_total') ; ?></td>
    		</tr>
    		
			</tbody>
		</table>
		<p>
		  <?php e($form->submit('Update your cart', array('div' => false))); ?>
		  <?php e($html->link('Empty Cart', array('controller' => 'carts', 'action' => 'empty_cart'), 
		                                    array('class' => 'empty')))?>
		</p>
    <p><small>If the quantity is set to zero, the item will be removed from the cart.</small></p>
    

		<?php 
		e($form->end());
		endif;
		?>
	</div>
</div>

