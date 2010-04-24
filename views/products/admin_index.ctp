<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('admin/admin_index.js', false); ?>
<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', array('controller' => 'dashboard', 
                                'action' => 'index'))); ?> &rsaquo; 
    Products
</div>
<!-- End Navigation  -->

<div id="content" class="flex">
  <h1>Products</h1> 
  <div id="content-main">
    <ul class="object-tools">
      <li>
        <?php echo $html->link('Add Product', 
                          array('controller' => 'products',                                               
                                'action' => 'add'), 
                          array('class' => 'addlink'))?>
      </li>
    </ul>    
    <div class="module" id="changelist">
      <div id="toolbar">
        <form id="changelist-search" action="" method="get">
      <div><!-- DIV needed for valid HTML -->
      <label for="searchbar">
        <?php echo $html->image('admin/icon_searchbox.png')?>

      </label>
      <input type="text" size="40" name="q" value="" id="searchbar" />
      <input type="submit" value="Search" />
    </div>
    </form>
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
       <th><?php echo $this->Paginator->sort('display');?></th>
       
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
  			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $product['Product']['id'])); ?> |
  			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $product['Product']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['Product']['id'])); ?>
  		</td>
  	</tr>
  <?php endforeach; ?>

</tbody>
</table>


	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<p class="paginator">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
          
      
      

<!-- <p class="paginator">

2 users


</p> -->

      </form>
    </div>

  </div>

        
        <br class="clear" />
    </div>