<!-- Begin Navigation  -->
<style>
.aligned label {
  width: 14em;
}
</style>
<div class="breadcrumbs">
  <?php e($html->link('Home', '/supplier')); ?> 
  &rsaquo; 
  <?php 
    e($html->link('Product Master Categories', '/supplier/master_categories')); 
  ?> 
  &rsaquo;                            
  Add Product Master Category
</div>

<div id="content" class="colM">
  <h1>Add Product Master Category</h1>
  <div id="content-main">
    <?php echo $this->Form->create('MasterCategory');?>
    <div>
      <?php e($form->hidden('id'))?>
      <?php echo $session->flash(); ?>
      <fieldset class="module aligned ">
        <!-- Begin Name  -->
        <div class="form-row name">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('MasterCategory.name')) {
                e($form->error ('MasterCategory.name', null, array('wrap' => 'li')));                 
              }
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('name', "Master Category Name", 
                             array('class' => 'required'))); 
                             e($form->text('name', array('class' => 'vTextField')));
            ?>        
          </div>        
        </div>
        <!-- End Name  -->
        

      </fieldset>
      
      <div class="submit-row" >
        <?php echo $form->end(array('label' => 'Save', 'class' => 'default', 'div' => array('class' => false)));?>

      </div>

    </div>
  </form></div>
  <br class="clear" />
</div>
