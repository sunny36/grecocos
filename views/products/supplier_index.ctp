<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('admin/admin_index.js', false); ?>
<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', '/supplier'));
  ?> 
  &rsaquo; 
  Products
</div>
<!-- End Navigation  -->

<div id="content" class="flex">
  <h1>Products</h1> 
  <div id="content-main">
    <ul class="object-tools">
      <li>
        <?php 
          echo $html->link('Add Product', array('controller' => 'products', 'action' => 'add'), 
                            array('class' => 'addlink'));
        ?>
      </li>
    </ul>    
    <div class="module" id="changelist">
      <div id="toolbar">
        <?php e($form->create(null, array('type' => 'get', 'action' => 'index'))); ?>
      <div><!-- DIV needed for valid HTML -->
      <label for="searchbar">
        <?php echo $html->image('admin/icon_searchbox.png')?>
      </label>
      <?php e($form->text('short_description', array('size' =>
      '60'))); ?>
    	<?php e($form->submit('Search', array('div' => false))); ?>
    	 &nbsp;&nbsp;
    	<?php e($html->link('View All', '/supplier/products/index'))?>
    </div>
    </div>
          
<table cellspacing="0">
  <thead>
    <tr>
       <th><?php echo $this->Paginator->sort('id');?></th>
       <th><?php echo $this->Paginator->sort('short_description');?></th>
       <th><?php echo $this->Paginator->sort('selling_price');?></th>
       <th><?php echo $this->Paginator->sort('buying_price');?></th>
       <th><?php echo $this->Paginator->sort('quantity');?></th>
       <th><?php echo $this->Paginator->sort('stock');?></th>
       <th><?php echo $this->Paginator->sort('Available', 'display');?></th>
       
       <th><?php __('Actions');?></th>
   </tr>
  </thead>
<tbody>
  	<?php
  	$i = 0;
  	foreach ($products as $product):
  		$class = null;
  		if ($i++ % 2 == 0) {
  			$class = ' class="row1"';
  		} else {
  		  $class = ' class="row2"';
  		}
  	?>
  	<tr<?php echo $class;?>>
  		<td><?php echo $product['Product']['id']; ?>&nbsp;</td>
  		<td><?php echo $product['Product']['short_description']; ?>&nbsp;</td>
  		<td><?php echo $product['Product']['selling_price']; ?>&nbsp;</td>
  		<td><?php echo $product['Product']['buying_price']; ?>&nbsp;</td>
  		<td><?php echo $product['Product']['quantity']; ?>&nbsp;</td>
  		<td><?php echo $product['Product']['stock']; ?>&nbsp;</td>
  		<td>
  		  <?php if($product['Product']['display'] == '1') e('Yes'); else e('No'); ?>
  		  &nbsp;
  		</td>
  		<td class="actions">
  			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $product['Product']['id'])); ?> |
  			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $product['Product']['id'])); ?>
  		</td>
  	</tr>
  <?php endforeach; ?>

</tbody>
</table>
    </div>

  </div>

        
        <br class="clear" />
    </div>
