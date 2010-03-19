<div class="products index">
	<h2><?php __('Products');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('short_description');?></th>
			<th><?php echo $this->Paginator->sort('long_description');?></th>
			<th><?php echo $this->Paginator->sort('buying_price');?></th>
			<th><?php echo $this->Paginator->sort('selling_price');?></th>
			<th><?php echo $this->Paginator->sort('quantity');?></th>
			<th><?php echo $this->Paginator->sort('stock');?></th>
			<th><?php echo $this->Paginator->sort('image');?></th>
			<th><?php echo $this->Paginator->sort('display');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($products as $product):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $product['Product']['id']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['short_description']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['long_description']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['buying_price']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['selling_price']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['quantity']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['stock']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['image']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['display']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['active']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $product['Product']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $product['Product']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $product['Product']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['Product']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Product', true)), array('action' => 'add')); ?></li>
	</ul>
</div>