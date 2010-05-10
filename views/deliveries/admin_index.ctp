<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('orders.js', false); ?>
<div class="breadcrumbs">
  <?php 
    e($html->link('Home', array('controller' => 'dashboard', 
                                'action' => 'index'))); 
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
            <th><?php echo $this->Paginator->sort('id');?></th>
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
          <td><?php echo $delivery['Delivery']['id']; ?>&nbsp;</td>
          <td><?php echo $delivery['Delivery']['date']; ?>&nbsp;</td>
          <td>
  	    <?php
  	      if($delivery['Delivery']['next_delivery'] == 1) {
                e($html->image('admin/icon-yes.gif'));
              } else {
                e($html->image('admin/icon-no.gif'));
              }
  	    ?>
          </td>
          <td>
            
            <?php e($html->image('admin/icon_changelink.gif'));?>
            <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $delivery['Delivery']['id'])); ?> |
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
