<div id="content" class="colMS">
  <div id="content-main">

    <div class="module">
      <table>
      <caption>1. Customers</caption>
        <tr>
          <th scope="row">
            <?php 
              e($html->link('1.1 View/accept/edit customers', 
                            '/coordinator/users')); 
            ?>            
          </th>
          <!-- Two empty <td> so that the table doesn't break -->
          <td></td>
          <td></td>
        </tr>
      </table>
    </div>
  
    <div class="module">
      <table>
      <caption>2. Orders</caption>
      <tr>
        <th scope="row">
          <?php 
            e($html->link('2.1 View Orders and mark as paid',
                          '/coordinator/orders/mark_as_paid'));
          ?>
        </th>        
        <td></td>
        <td></td>  
      </tr>
      <tr>
        <th scope="row">
          <?php 
            e($html->link('2.2 Send email informing arrival of shipment',
                          '/coordinator/deliveries/arrival_of_shipment'));
          ?>
        </th>        
        <td></td>
        <td></td>  
      </tr>
      <tr>
        <th scope="row">
          <?php 
            e($html->link('2.3 View Orders and mark as delivered',
                          '/coordinator/orders/mark_as_delivered'));
          ?>
        </th>        
        <td></td>
        <td></td>  
      </tr>      
      </table>
    </div>

    <div class="module">
      <table>
      <caption>3. Payments</caption>
        <tr>
          <th scope="row">
            <?php
              e($html->link('3.1 View/make refunds', 
                            '/coordinator/orders/refunds'));
            ?>
          </th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">
            <?php 
              e($html->link('3.2 View/make payment to supplier', 
                            '/coordinator/deliveries/payments'));
            ?>
          </th>
          <td></td>
          <td></td>
        </tr>
      </table>
    </div>

    <div class="module">
      <table>
      <caption>4. Reports</caption>
      <th scope="row">
      </th>
      <td></td>
      <td></td>
      
      </table>
    </div>
    
    <div class="module">
      <table>
      <caption>5. Configuration</caption>
        <tr>
          <th scope="row">
            <?php
              e($html->link('5.1 Open/close website', 
                            '/coordinator/configurations')); 
            ?>
          </th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">
            <?php e($html->link('5.2 View/maintain delivery dates',
                                '/coordinator/deliveries/index'))?>
          </th>        
          <td></td>
          <td></td>  
        </tr>        
      </table>
    </div>
    

  <br class="clear" />
</div>
