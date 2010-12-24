<?php echo $javascript->link('users/login.js', false); ?>
<div id="content" class="colM">
  <?php echo $this->Session->flash('auth', 'flash_error'); ?>
  <?php echo $session->flash(); ?>
  <div id="content-main">
    <?php e($form->create('User', array('action' => 'login')));?> 
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
    <p>New users <?php echo $html->link('Signup', '/users/signup')?></p>
    <p><?php echo $html->link('Forgot Password?', '/users/reset_password')?></p>
  </div>
</div>


