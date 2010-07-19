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
      <caption><a href="auth/" class="section">Transactions</a></caption>
        <tr>
          <th scope="row">
            <?php e($html->link('Cash Report 1', '/administrator/transactions/index'))?>
          </th>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">
            <?php e($html->link('Cash Report 2', '/administrator/transactions/cash_report2'))?>
          </th>
          <td></td>
          <td></td>
        </tr>

      </table>
    </div>

  <br class="clear" />
</div>
