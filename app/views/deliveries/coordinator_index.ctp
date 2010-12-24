<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $javascript->link('util.js', false); ?>
<?php echo $javascript->link('orders.js', false); ?>
<?php echo $javascript->link('admin/admin_index.js', false); ?>
<?php echo $javascript->link('deliveries/update_next_delivery.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>

<style>
#changelist table tbody td:first-child {
  text-align: left;
}
</style>
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', '/coordinator')); 
  ?> &rsaquo; 
  Delivery Dates
</div>
<div id="content" class="flex">
  <h1> Delivery Dates</h1> 
  <div id="content-main" style="width: auto !important">
    <ul class="object-tools">
      <li>
        <?php echo $html->link('Add Delivery Date', 
          array('controller' => 'deliveries',                                               
                'action' => 'add'), 
        array('class' => 'addlink'))?>
      </li>
    </ul>    
    <?php echo $session->flash(); ?>     
    <div class="module" id="changelist">
      <table cellspacing="0">
        <thead>
          <tr>
            <th><?php echo $this->Paginator->sort('date');?></th>
            <th><?php echo $this->Paginator->sort('next_delivery');?></th>
            <th><?php __('Actions');?></th>
          </tr>
        </thead>
        <tbody>
  	  <?php
  	    $i = 0;
  	    foreach ($deliveries as $delivery):
  	    $class = null;
  	    if ($i++ % 2 == 0) {
              $class = ' class="row1"';
            } else {
              $class = ' class="row2"';
            }
  	  ?>
          <tr<?php echo $class;?>>
          <td><?php echo $delivery['Delivery']['date']; ?></td>
          <td>
            <?php echo $form->create('UpdateNextDelivery'); ?>
      		  <?php echo $form->hidden('id', array('value' => $delivery['Delivery']['id']))?>
      	    <?php
      	      if($delivery['Delivery']['next_delivery'] == 1) {
      	        e($form->checkbox('next_delivery', array('value' => '1', 'checked' => true, 
      	                                                 'class' => 'next_delivery')));
      	      } else {
      	        e($form->checkbox('next_delivery', array('value' => '1', 'class' => 'next_delivery')));
      	        
      	      }
      	    ?>
      	    <?php echo $form->end(); ?>
      	    &nbsp;
          </td>
          <td>
            
            <!-- <?php e($html->image('admin/icon_changelink.gif'));?>
            <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $delivery['Delivery']['id'])); ?> | -->
            <?php e($html->image('admin/icon_deletelink.gif'));?>
            <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $delivery['Delivery']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $delivery['Delivery']['id'])); ?>
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
