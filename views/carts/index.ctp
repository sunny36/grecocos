<div id="box" style="border: solid; width: 400px;">
	My content is copied into the facybox!
</div>
	
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
		  <?php $i = 1; $j = 1; $categoryNum = 1;?>
      <?php foreach($products as $productCategory): ?>
        <tbody>
          <tr>
        		<td></td>
         		 <td>
         		 	<button id="<?php echo "category{$categoryNum}"; ?>" class="category">
         		 	  <?php echo $productCategory['Category']['name']?>
         		 	</button>
         	    <strong><?php echo $productCategory['Category']['name']?></strong>
         		 </td>
         		 <td></td>
         		 <td></td>
        	</tr>
        </tbody>
        <tbody class="<?php echo "category{$categoryNum}"; ?>">
      		<?php foreach($productCategory['Product'] as $product):?>
      		  
      		    <tr <?php if($i&1){ echo 'class="alt"'; }?> >
        		    <td>
        		      <?php e($form->hidden('.'. $j .'.id', 
        		                            array('value' => $product['id'])))?>
                   <?php e($form->text('.'. $j .'.quantity', 
                                       array('value' => "0", 
                                             'maxlength' => '3', 
                                             'size' => '5')))?>
        		    </td>
        		    <td>
        		      <a class="short_description" href="javascript:void(0);">
        		        <?php echo $product['short_description']; ?>
        		      </a>
        		    </td>
        		    <td>&#3647 <?php echo $product['selling_price']; ?></td>
        		    <td>&#3647 <?php echo "0" ?></td>
        		  </tr>
      		  <?php $j++; $i++; ?>
      		<?php endforeach; ?>
          </tbody>
        <?php $categoryNum++ ?>
        <?php endforeach; ?>
        <tr>
    			<td</td>
     		 	<td></td>
     		 	<td><h3>Total</h3></td>
     		 	<td><h3>&#3647; 0<h3></td>
    		</tr>
        
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
