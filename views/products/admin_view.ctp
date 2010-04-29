<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php e($html->link('Home', array('controller' => 'dashboard', 
                                'action' => 'index', 'admin' => true))); ?> 
  &rsaquo; 
  <?php e($html->link('Products', array('controller' => 'products', 
                                'action' => 'index', 'admin' => true))); ?> 
  &rsaquo;                            
  View Product
</div>
<!-- End Navigation  -->
<div id="content" class="colM">
  <h1>Add product</h1>
  <div id="content-main">
  <div>
  <?php echo $session->flash(); ?>
  <fieldset class="module aligned ">
    <!-- Begin Id  -->
    <div class="form-row id">
      <div>
        <?php e($form->label('id', "Product Id")); ?>        
        <strong> <?php e($product['Product']['id']); ?></strong>
      </div>        
    </div>
    <!-- End Id  -->
    
    <!-- Begin Short Description  -->
    <div class="form-row short_description">
      <div>
        <div>
          <?php e($form->label('short_description', "Short Description")); ?>        
          <strong> 
            <?php e($product['Product']['short_description']); ?>
          </strong>
        </div>                
      </div>
    </div>
    <!-- End Short Description  -->
    
    <!-- Begin Long Description  -->
    <div class="form-row long_description">
      <div>
        <div>
          <?php e($form->label('long_description', "Long Description")); ?>        
          <strong> <?php e($product['Product']['long_description']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Long Description  -->
    
    <!-- Begin Selling Price  -->
    <div class="form-row selling_price">
      <div>
        <div>
          <?php e($form->label('selling_price', "Selling Price")); ?>        
          <strong> <?php e($product['Product']['selling_price']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Selling Price  -->

    <!-- Begin Buying Price  -->
    <div class="form-row buying_price">
      <div>
        <div>
          <?php e($form->label('buying_price', "Buying Price")); ?>        
          <strong> <?php e($product['Product']['buying_price']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Buying Price  -->

    <!-- Begin Quantity  -->
    <div class="form-row quantity">
      <div>
        <div>
          <?php e($form->label('quantity', "Quantity")); ?>        
          <strong> <?php e($product['Product']['quantity']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Quantity  -->

    <!-- Begin Stock  -->
    <div class="form-row stock">
      <div>
        <div>
          <?php e($form->label('stock', "Stock")); ?>        
          <strong> <?php e($product['Product']['stock']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Stock  -->

    <!-- Begin Stock  -->
    <div class="form-row display">
      <div>
        <div>
          <?php e($form->label('display', "Display")); ?>        
          <strong> <?php e($product['Product']['display']); ?></strong>
        </div>                
      </div>
    </div>
    <!-- End Stock  -->

    <!-- Begin Image  -->
    <div class="form-row image">
      <div>
        <div>
          <?php e($form->label('image', "Image")); ?>        
          <?php 
            e($html->image('/attachments/photos/small/' . 
            $product['Product']['image']));
          ?>
        </div>                
      </div>
    </div>
    <!-- End Buying Price  -->


    
    
</fieldset>