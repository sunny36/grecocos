<div id="content" class="colMS">
  <div id="content-main">  
    <div class="module">
      <table>
      <caption><a href="sites/" class="section">Orders</a></caption>
      <tr>
        <th scope="row">
          <?php e($html->link('View Orders / Modify Order',
                              '/supplier/orders/index'))?>
        </th>        
        <td></td>
        <td></td>  
      </tr>
      <tr>
        <th scope="row">
          <?php e($html->link('Close Batch',
                              '/supplier/orders/close_batch'))?>
        </th>        
        <td></td>
        <td></td>  
      </tr>
      
      </table>
    </div>
    
    <div class="module">
      <table>
      <caption>Products</caption>
      <tr>
        <th scope="row">
          <?php e($html->link('View Products',
                              '/supplier/products/index'))?>
        </th>        
        <td></td>
        <td></td>  
      </tr>
      <tr>
        <th scope="row">
          <?php e($html->link('View Product Categories',
                              '/supplier/categories/index'))?>
        </th>        
        <td></td>
        <td></td>  
      </tr>
      </table>
    </div> 

    <div class="module">
      <table>
      <caption>Delivery date</caption>
      <tr>
        <th scope="row">
          <?php e($html->link('Add / Modify next delivery',
                              '/supplier/deliveries/index'))?>
        </th>        
        <td></td>
        <td></td>  
      </tr>
      </table>
    </div> 
   
  </div>

  <br class="clear" />
</div>
