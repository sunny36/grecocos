<div id="content" class="colMS">
  <div id="content-main">
    <?php
      $this->Dashboard->generateModule('1. Customers', array(
        '1.1 View/accept/edit customers' => '/coordinator/users'));
    ?>  
    <?php
      $this->Dashboard->generateModule('2. Orders', array(
        '2.1 View Orders and mark as paid' => '/coordinator/orders/mark_as_paid',
        '2.2 Send email informing arrival of shipment' => '/coordinator/deliveries/arrival_of_shipment',
        '2.3 View Orders and mark as delivered' => '/coordinator/orders/mark_as_delivered'
        ));
    ?>  
    
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
      <tr>
        <th scope="row">
          <?php e($html->link('4.1 View Batch Reports',
                              '/coordinator/batch_reports'))?>
        </th>        
        <td></td>
        <td></td>  
      </tr>            
      <tr>
        <th scope="row">
          <?php e($html->link('4.2 View Cash Report 1',
                              '/coordinator/transactions'))?>
        </th>        
        <td></td>
        <td></td>  
      </tr>            
      <tr>
        <th scope="row">
          <?php e($html->link('4.3 View Cash Report 2',
                              '/coordinator/transactions/cash_report2'))?>
        </th>        
        <td></td>
        <td></td>  
      </tr>            
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

    <div class="module">
      <table>
      <caption>6. Emails</caption>
        <tr>
          <th scope="row"><?php e($html->link('6.1 Send emails to customers', '/coordinator/emails')); ?></th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">
            <?php 
              e($html->link(
                '6.2 Send Payment Reminder Email', 
                '/coordinator/orders/send_payment_reminder_emails')); 
            ?>
          </th>
          <td></td>
          <td></td>
        </tr>        
        
      </table>
    </div>    
  <div>  
  <br class="clear" />
</div>
