<div id="content" class="colMS">
  <h1>Site administration</h1>    
  <div id="content-main">
    
    <div class="module">
      <table summary="Models available in the Auth application.">
      <caption><a href="auth/" class="section">Auth</a></caption>
        <tr>
          <th scope="row">
            <?php e($html->link('Users', array('controller' => 'users', 
                                                  'action' => 'index')))
            ?>            
          </th>
          <!-- Two empty <td> so that the table doesn't break -->
          <td></td>
          <td></td>
        </tr>
      </table>
    </div>
  
    <div class="module">
      <table summary="Models available in the Sites application.">
      <caption><a href="sites/" class="section">Modules</a></caption>
      <tr>
        <th scope="row">
          <?php e($html->link('Products', array('controller' => 'products', 
                                                'action' => 'index')))?>
        </th>
        
        <td><a href="sites/site/add/" class="addlink">Add</a></td>
        <td><a href="sites/site/" class="changelink">Change</a></td>  
      </tr>
      <tr>
        <th scope="row"><a href="sites/site/">Orders</a></th>
        
        <td><a href="sites/site/add/" class="addlink">Add</a></td>
        <td><a href="sites/site/" class="changelink">Change</a></td>  
      </tr>
      <tr>
        <th scope="row"><a href="sites/site/">Sites</a></th>
        
        <td><a href="sites/site/add/" class="addlink">Add</a></td>
        <td><a href="sites/site/" class="changelink">Change</a></td>  
      </tr>            
        <tr>
          <th scope="row"><a href="sites/site/">Sites</a></th>
          
          <td><a href="sites/site/add/" class="addlink">Add</a></td>
          <td><a href="sites/site/" class="changelink">Change</a></td>  
        </tr>
      </table>
    </div>
  </div>

  <div id="content-related">
    <div class="module" id="recent-actions-module">
      <h2>Recent Actions</h2>
      <h3>My Actions</h3>
        <ul class="actionlist">
          
        </ul>
          
    </div>
  </div>

  <br class="clear" />
</div>
