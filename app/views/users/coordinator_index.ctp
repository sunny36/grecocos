<div class="breadcrumbs">
  <?php 
    e($html->link('Home', '/coordinator')); 
  ?> &rsaquo; 
  Users
</div>
<div id="content" class="flex">
  <h1>Users</h1> 
  <div id="content-main">
    <?php echo $session->flash(); ?>     
    <div class="module" id="changelist">
      <div id="toolbar">
        <?php 
    	    e($form->create(null, array('type' => 'get', 
    	                                'action' => 'index'))); 
    	  ?>
        
      <div><!-- DIV needed for valid HTML -->
        <label for="searchbar">
          <?php echo $html->image('admin/icon_searchbox.png')?>
        </label>
      	<?php e($form->label('customer name')); ?>  
      	<?php
      	  if (isset($this->params['url']['user_name'])) {
      	    e($form->text('user_name', array('value' => $this->params['url']['user_name'], 'size' => '40')));
      	  } else {
      	    e($form->text('user_name', array('size' => '40')));
      	  }
      	?>
      	<?php e($form->submit('Search', array('div' => false))); ?>
      	 &nbsp;&nbsp;
      	<?php e($html->link('View All', '/coordinator/users/index'))?>
      	</div>
        
        </div>          
<table cellspacing="0">
  <thead>
  	<tr>
  			<th><?php echo $this->Paginator->sort('id');?></th>
  			<th><?php echo $this->Paginator->sort('email');?></th>
  			<th><?php echo $this->Paginator->sort('firstname');?></th>
  			<th><?php echo $this->Paginator->sort('lastname');?></th>
  			<th><?php echo $this->Paginator->sort('middlename');?></th>
  			<th><?php echo $this->Paginator->sort('status');?></th>
  			<th><?php echo $this->Paginator->sort('created');?></th>
  			<th><?php echo $this->Paginator->sort('modified');?></th>
  			<th><?php __('Actions');?></th>
  	</tr>
  </thead>
<tbody>
  	<?php
  	$i = 0;
  	foreach ($users as $user):
  		$class = null;
  		if ($i++ % 2 == 0) {
  			$class = ' class="row1"';
  		} else {
  		  $class = ' class="row2"';
  		}
  	?>
  	<tr<?php echo $class;?>>
  		<td><?php echo $user['User']['id']; ?>&nbsp;</td>

  		<td><?php echo $user['User']['email']; ?>&nbsp;</td>
  		<td><?php echo $user['User']['firstname']; ?>&nbsp;</td>
  		<td><?php echo $user['User']['lastname']; ?>&nbsp;</td>
  		<td><?php echo $user['User']['middlename']; ?>&nbsp;</td>
  		<td><?php echo $user['User']['status']; ?>&nbsp;</td>
  		<td><?php echo $user['User']['created']; ?>&nbsp;</td>
  		<td><?php echo $user['User']['modified']; ?>&nbsp;</td>
  		<td class="actions">
  			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $user['User']['id'])); ?> |
  			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $user['User']['id'])); ?> |
  			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
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
          
    </div>

  </div>

        
        <br class="clear" />
    </div>