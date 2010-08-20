<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php e($html->link('Home', '/supplier')); ?> 
  &rsaquo; 
  <?php e($html->link('Products', '/supplier/products')); ?> 
  &rsaquo;                            
  Edit Product
</div>

<div id="content" class="colM">
  <h1>Edit Product</h1>
  <div id="content-main">
    <?php echo $this->Form->create('Product', array('type' => 'file'));?>
    <div>
      <?php e($form->hidden('id'))?>
      <?php echo $session->flash(); ?>
      <fieldset class="module aligned ">
        <!-- Begin Short Description  -->
        <div class="form-row short_description">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('Product.short_description')) 
                e($form->error ('Product.short_description', null, 
                                array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('short_description', "Short Description", 
                             array('class' => 'required'))); 
                             e($form->text('short_description', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End Short Description  -->
        
        <!-- Begin Long Description  -->
        <div class="form-row long_description">
          <div>
            <?php 
                               e($form->label('long_description', "Long Description")); 
                               e($form->textarea('long_description', 
                                                 array('class' => 'vLargeTextField')));
            ?>        
          </div>
        </div>
        <!-- End Long Description  -->
        
        <!-- End Selling Price  -->    
        <div class="form-row selling_price">
          <ul class="errorlist">
            <?php 
                                 if($form->isFieldError('Product.selling_price')) 
                                   e($form->error ('Product.selling_price', null, 
                                                   array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('selling_price', "Selling Price", 
                             array('class' => 'required'))); 
                             e($form->text('selling_price'));
            ?>        
          </div>            
        </div>
        <!-- End Selling Price  -->    
        
        <!-- Begin Buying Price  -->    
        <div class="form-row buying_price">
          <ul class="errorlist">
            <?php 
                               if($form->isFieldError('Product.buying_price')) 
                                 e($form->error ('Product.buying_price', null, 
                                                 array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('buying_price', "Buying Price", 
                             array('class' => 'required'))); 
                             e($form->text('buying_price'));
            ?>        
          </div>            
        </div>
        <!-- End Buying Price  -->    
        
        <!-- Begin Quantity  -->    
        <div class="form-row quantity">
          <ul class="errorlist">
            <?php 
                               if($form->isFieldError('Product.quantity')) 
                                 e($form->error ('Product.quantity', null, 
                                                 array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('quantity', "Quantity", 
                             array('class' => 'required'))); 
                             e($form->text('quantity'));
            ?>        
          </div>                  
        </div>    
        <!-- End Quantity  -->    

        <!-- Begin Stock  -->        
        <div class="form-row stock">
          <ul class="errorlist">
            <?php 
                               if($form->isFieldError('Product.stock')) 
                                 e($form->error ('Product.stock', null, 
                                                 array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('stock', "Stock", 
                             array('class' => 'required'))); 
                             e($form->text('stock', array('class' => 'vIntegerField')));
            ?>        
          </div>        
        </div>    
        <!-- End Stock  -->        

        <!-- Begin Image  -->            
        <div class="form-row image">
          <ul class="errorlist">
            <?php 
                               if($form->isFieldError('Product.image')) 
                                 e($form->error ('Product.image', null, 
                                                 array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('image', "Image", 
                             array('class' => 'required'))); 
                             e($form->file('Attachment'));e("<br/>"); 
                             e("<label></label>");
                             e($html->image('/attachments/photos/small/' .   
                                            $this->Form->value('image')));
            ?>        
          </div>                   
        </div>
        
        <!-- Begin Display  -->    
        <div class="form-row display">
          <ul class="errorlist">
            <?php 
                               if($form->isFieldError('Product.display')) 
                                 e($form->error ('Product.display', null, 
                                                 array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('display', "Available", 
                             array('class' => 'required'))); 
                             e($form->checkbox('display', array('class' => 'vCheckBoxField')));
            ?>        
          </div>        
        </div>       
        <!-- Begin Category  -->    
        <div class="form-row category_id">
          <ul class="errorlist">
            <?php 
                               if($form->isFieldError('Product.category_id')) 
                                 e($form->error ('Product.category_id', null, 
                                                 array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('category_id', "Category",
                             array('class' => 'required')));
              e($form->select('category_id', $categories, NULL, 
                              array('empty' => false)));
            ?>        
          </div>        
        </div>        
        <!-- End Category -->

      </fieldset>
      
      <div class="submit-row" >
        <?php echo $form->end(array('label' => 'Save', 'class' => 'default', 'div' => array('class' => false)));?>

      </div>

    </div>
  </form></div>
  <br class="clear" />
</div>
