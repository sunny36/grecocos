<?php echo $javascript->link('admin/admin_index.js', false); ?>
<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php e($html->link('Home', '/supplier')); ?> 
   &rsaquo; 
  Product Categories
</div>
<!-- End Navigation  -->

<div id="content" class="flex">
  <h1>Product Categories</h1> 
  <div id="content-main" style="width: auto !important">
    <ul class="object-tools">
      <li>
        <?php echo $html->link('Add Category', 
          array('controller' => 'categories',                                               
                'action' => 'add'), 
        array('class' => 'addlink'))?>
      </li>
    </ul>    
    <?php echo $session->flash(); ?> 
    <div class="module" id="changelist" >
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
      
      <table cellspacing="0" >
        <thead>
          <tr>
            <th><?php echo $this->Paginator->sort('id');?></th>
            <th><?php echo $this->Paginator->sort('name');?></th>
            <th><?php __('Actions');?></th>
          </tr>
        </thead>
        <tbody>
  	  <?php
  	    $i = 0;
  	    foreach ($categories as $category):
  	    $class = null;
  	    if ($i++ % 2 == 0) {
              $class = ' class="row1"';
            } else {
              $class = ' class="row2"';
            }
  	  ?>
          <tr<?php echo $class;?>>
          <td><?php echo $category['Category']['id']; ?>&nbsp;</td>
	  <td><?php echo $category['Category']['name']; ?>&nbsp;</td>
          <td>
            <?php echo $this->Html->link(__('Edit', true), 
array('action' => 'edit', $category['Category']['id'])); ?> |
            <?php echo $this->Html->link(__('Delete', true), 
array('action' => 'delete', $category['Category']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $category['Category']['id'])); ?>
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
