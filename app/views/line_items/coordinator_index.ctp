<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js', false); ?>
<?php echo $html->css('jquery-ui/smoothness/jquery-ui-1.8.custom',null, array('inline' => false)); ?>
<?php echo $javascript->link('admin/admin_index.js', false); ?>
<style>
.numbers {
  text-align: right;
}
</style>
<?php setlocale(LC_MONETARY, 'th_TH'); ?>
<div class="breadcrumbs">
  <?php 
   e($html->link('Home', '/coordinator')); 
  ?>
  &rsaquo;
  Batch Reports
</div>
<div id="confirmation_dialog"></div>
<div id="content" class="flex">
  <h1>Batch Reports</h1> 
  <div id="content-main">
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
        Delivery Date
        <?php 
          if (isset($this->params['url']['delivery_date'])) {
            e($form->select('delivery_date', $delivery_dates, 
                            array('selected' => $this->params['url']['delivery_date']))); 
          } else {
            e($form->select('delivery_date', $delivery_dates, NULL)); 

          }
        ?>
         &nbsp;&nbsp;
      	<?php e($form->submit('Search', array('div' => false))); ?>
      	&nbsp;&nbsp;
      	<?php
        //   if (isset($default_delivery_id) && count($lineItems) != 0) {
        //            e($html->link('Print Report',                 
        //                         "/coordinator/line_items/index?" .
        //                         "delivery_date={$default_delivery_id}&" .
        //                         "print=yes"));
        // } 
      ?>
    </div>
    </form>
    </div> 
    
<?php if(isset($default_delivery_id)): ?>   
  
  <?php if(count($lineItems) == 0): ?>      
    <h3>There are no orders for this batch.</h3>
  <?php else: ?>
  <?php
  $this->Paginator->options(array('url'=>array_merge(array('delivery_date'=>$default_delivery_id),$this->passedArgs)));
  ?>
<table cellspacing="0">
  <thead>
  	<tr>
  	    <th><?php echo "No."; ?></th>
  			<th><?php echo $this->Paginator->sort('product_id');?></th>
  			<th><?php echo $this->Paginator->sort('# Ordered', 'ordered');?></th>
  			<th><?php echo $this->Paginator->sort('# Supplied', 'supplied');?></th>
  			<th>
  			  <?php echo $this->Paginator->sort('Amount Wholesale', 
  			                                    'wholesale_amount'); ?>
  		  </th>
  		  <th>
  			  <?php echo $this->Paginator->sort('Amount Retail', 
  			                                    'retail_amount');?>
  			</th>
  	</tr>
  </thead>
<tbody>
  	<?php
  	$i = 0;
  	$row_number = 1; 
  	foreach ($lineItems as $lineItem):
  		$class = null;
  		if ($i++ % 2 == 0) {
  			$class = ' class="row1"';
  		} else {
  		  $class = ' class="row2"';
  		}
  	?>
    	<tr<?php echo $class;?>>
    	  <td><?php echo $row_number++; ?></td>
    	  <td><?php echo $lineItem['Product']['short_description']; ?>&nbsp;</td>
    		<td class="numbers">
    		  <?php echo $lineItem['LineItem']['ordered']; ?>&nbsp;
    		</td>
    		<td class="numbers">
    		  <?php echo $lineItem['LineItem']['supplied']; ?>&nbsp;
    		</td>
    		<td class="numbers">
    		  <?php 
    		    echo money_format("%i", $lineItem['LineItem']['amount_wholesale']); 
    		  ?>&nbsp;
    		</td>
    		<td class="numbers">
    		  <?php 
    		    echo money_format("%i", $lineItem['LineItem']['amount_retail']); 
    		  ?>&nbsp;
    		</td>
    	</tr>
    <?php endforeach; ?>
</tbody>
<tbody>
  <tr>
    <td></td>
	  <td><strong>TOTALS</strong></td>
	  <td class="numbers">
	    <strong><?php echo $ordered; ?></strong>
	  </td>
	  <td class="numbers">
	    <strong><?php echo $supplied; ?></strong>
	  </td>
	  <td class="numbers">
	    <strong>
	      <?php echo money_format("%i", $amount_wholesale); ?>
	    </strong>
	  </td>
	  <td class="numbers">
	    <strong>
	      <?php echo money_format("%i", $amount_retail); ?>
	    </strong>
	  </td>
  </tr>
</tbody>
</table>
<?php endif; ?>
<?php else: ?>
  <h3>Select a delivery date to view the batch report</h3>
<?php endif; ?>


	</div>
          
      
      


      </form>
    </div>

  </div>

         <br class="clear" />
    </div>
