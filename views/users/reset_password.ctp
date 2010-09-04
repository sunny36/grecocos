<style text="type/css">
.login #container {
  width: 40em;
}
</style>
<?php echo $javascript->link('users/login.js', false); ?>
<div id="content" class="colM">
  <?php echo$this->Session->flash('auth', 'flash_error'); ?>
  <p>
    Enter your email address to get the instructions for resetting your password
  </p>
  <div id="content-main">
    <?php e($form->create('User', array('action' => 'reset_password')));?> 
      <div class="form-row">
        <label for="UserEmail">Email</label> 
        <?php e($form->text('email', array('class' => 'fullwidth'))); ?>
      </div>
      <div class="submit-row">
        <?php e($form->submit('Reset Password', array('div' => false, 
                                                'class' => 'submitbutton'))); ?>
        
      </div>
    <?php e($form->end()); ?>
    <br class="clear" />    
  </div>
</div>


