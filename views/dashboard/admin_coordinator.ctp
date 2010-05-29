<div id="content" class="colMS">
  <div id="content-main">
    <div class="module">
      <table>
      <caption><a href="auth/" class="section">Customers</a></caption>
        <tr>
          <th scope="row">
            <?php e($html->link('View Customers information', 
                                '/coordinator/users'))?>            
          </th>
          <!-- Two empty <td> so that the table doesn't break -->
          <td></td>
          <td></td>
        </tr>
      </table>
    </div>
  
    <div class="module">
      <table>
      <caption><a href="sites/" class="section">Orders</a></caption>
      <tr>
        <th scope="row">
          <?php e($html->link('View Orders and mark as paid',
                              '/coordinator/orders/mark_as_paid'))?>
        </th>        
        <td></td>
        <td></td>  
      </tr>
      <tr>
        <th scope="row">
          <?php e($html->link('Send email informing arrival of shipment',
                              '/coordinator/orders/mark_as_paid'))?>
        </th>        
        <td></td>
        <td></td>  
      </tr>
      <tr>
        <th scope="row">
          <?php e($html->link('View Orders and mark as delivered',
                              '/coordinator/orders/mark_as_delivered'))?>
        </th>        
        <td></td>
        <td></td>  
      </tr>      
      </table>
    </div>
  </div>
    <div class="module">
      <table>
      <caption><a href="auth/" class="section">Payments</a></caption>
        <tr>
          <th scope="row">
            <?php e($html->link('View Refunds', 
                                '/coordinator/orders/refunds'))?>
          </th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">
            <?php e($html->link('View Payments', 
                                '/coordinator/deliveries/payments'))?>
          </th>
          <td></td>
          <td></td>
        </tr>
        
      </table>
    </div>

  <br class="clear" />
</div>
