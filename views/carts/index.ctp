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
