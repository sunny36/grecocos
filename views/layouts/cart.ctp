<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en-us" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GRECOCOS Shopping Cart</title>
<?php echo $this->Html->css('cart.css'); ?>
<?php echo $javascript->link('jquery-1.4.2.min.js'); ?>
<?php echo $javascript->link('jquery-ui-1.8.custom.min.js'); ?>
<?php echo $this->Html->css('jquery-ui/smoothness/jquery-ui-1.8.custom.css'); ?>
<?php echo $javascript->link('cart.js'); ?>
<style type="text/css">
	body{ margin: 20px;}
</style>	
</head>
<body>
  <?php echo $this->Session->flash(); ?>

	<?php echo $content_for_layout; ?>
	
	

</body>
</html>


