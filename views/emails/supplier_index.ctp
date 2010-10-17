<?php echo $javascript->link('jquery-1.4.2.min.js', false); ?>
<?php echo $javascript->link('jquery-ui-1.8.2.custom.min', false); ?>
<?php echo $javascript->link('tiny_mce/jquery.tinymce', false); ?>
<?php echo $javascript->link('ext-jquery-adapter', false); ?>
<?php echo $javascript->link('ext-all', false); ?>
<?php echo $html->css('jquery-ui/redmond/jquery-ui-1.8.2.custom', null, array('inline' => false)); ?>
<?php echo $html->css('ext-all', null, array('inline' => false)); ?>

<style>
form .aligned p, form .aligned ul {
  margin-left: 0;
}
#content-main {
  width: 56%;
}
input.default[type="submit"] {
float:left;
}
</style>
<script type="text/javascript">
	$().ready(function() {
		$('#EmailBody').tinymce({
			// Location of TinyMCE script
			script_url : '/js/tiny_mce/tiny_mce.js',
			// General options
			theme : "advanced",
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_resizing : false,
			// Example content CSS (should be your site CSS)
			content_css : "css/content.css",
			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
		if ($('#EmailTo :selected').val() != "individual") {
		  $('#individual').hide();
	  } else {
	    $('#individual').show();
	  }
		
		var converted = new Ext.form.ComboBox({
       typeAhead: true,
       triggerAction: 'all',
       transform:'EmailUser',
       width:300,
       forceSelection:true
     });
     $('#EmailTo').change(function () {
       if ($('#EmailTo :selected').val() == "individual") {
         $('#individual').show();
       } else {
         $('#individual').hide();
       }
     });
    
	});
</script>
<!-- /TinyMCE -->

<!-- Begin Navigation  -->
<div class="breadcrumbs">
  <?php e($html->link('Home', '/supplier')); ?> 
  &rsaquo;                            
  Send Emails
</div>

<div id="content" class="colM">
  <h1>Send Emails</h1>
  <div id="content-main">
    <?php e($this->Form->create('Email', array('action' => 'index')));?>
    <div>
      <?php echo $session->flash(); ?>
      <fieldset class="module aligned ">
        <!-- Begin To  -->
        <div class="form-row short_description">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('Email.to')) {
                e($form->error ('Email.to', null, array('wrap' => 'li'))); 
              }              
            ?>
          </ul>                          
          <?php e($form->label('to', "To", array('class' => 'required')));?>        
          <?php 
            $options = array(
              'all' => 'All Customers', 
              'not_ordered' => 'Customers who have not ordered', 
              'individual' => 'Individual customer'
              );
            e($form->select('to', $options, NULL, array('empty' => false)));
          ?>
        </div>
        <div id="individual" class="form-row short_description">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('Email.user')) {
                e($form->error ('Email.user', null, array('wrap' => 'li'))); 
              }              
            ?>
          </ul>                
          <?php 
            e($form->label('user', "Customer Name", 
                           array('class' => 'required')));
          ?> 
          <?php
            $User = ClassRegistry::init('User');
            $users = $User->find('list', array('fields' => 'User.name'));
            e($form->select('user', $users, NULL, array('empty' => true)));
          ?>
          
        </div>
        <!-- End To  -->
        
        <!-- Begin Subject  -->
        <div class="form-row short_description">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('Email.subject')) e($form->error ('Email.subject', null, array('wrap' => 'li'))); 
            ?>
          </ul>      
          <div>
            <?php 
              e($form->label('subject', "Subject", array('class' => 'required'))); 
              e($form->text('subject', array('class' => 'vMediumTextField', 'size' => '100')));
            ?>                    
          </div>
        </div>
        <!-- End Subject  -->
        
        <!-- Begin Body  -->
        <div class="form-row long_description">
          <ul class="errorlist">
            <?php 
              if($form->isFieldError('Email.body')) e($form->error ('Email.body', null, array('wrap' => 'li'))); 
            ?>
          </ul>                
          <div>
            <?php 
               e($form->label('body', "Message", array('class' => 'required'))); 
               e($form->textarea('body', array('rows' => "20", 'cols' => "80")));
            ?>        
          </div>
        </div>
        <!-- End Body  -->
      </fieldset>
      <div class="submit-row" >
        <?php 
          echo $form->end(array('label' => 'Send', 'class' => 'default', 'div' => array('class' => false)));
        ?>
      </div>

    </div>
  </div>
  <br class="clear" />
</div>
