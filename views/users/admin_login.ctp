<?php echo $javascript->link('admin/login.js', false); ?>
<div id="content" class="colM">
  <?php echo$this->Session->flash('auth', 'flash_error'); ?>
  <div id="content-main">
    <?php e($form->create('User', array('action' => 'login', 
    'admin' => true  )));?> 
      <div class="form-row">
        <label for="UserEmail">Email:</label> 
        <?php e($form->text('email', array('class' => 'fullwidth'))); ?>
      </div>
      <div class="form-row">
        <label for="UserPassword">Password:</label> 
        <?php e($form->password('password', array('class' => 'fullwidth'))); ?>
      </div>
      <div class="submit-row">
        <label>&nbsp;</label>
        <?php e($form->submit('Login In', array('div' => false, 
                                                'class' => 'submitbutton'))); ?>
        
      </div>
    <?php e($form->end()); ?>
    <br class="clear" />
  </div>
</div>


