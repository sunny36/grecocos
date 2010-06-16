<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-us" xml:lang="en-us" >
<head>
<title><?php echo $title_for_layout; ?></title>
<?php echo $this->Html->css('admin/base.css'); ?>
<?php echo $this->Html->css('admin/dashboard.css'); ?>
<?php echo $this->Html->css('admin/menu.css'); ?>
<!--[if lte IE 7]>
<?php echo $this->Html->css('admin/ie.css'); ?>
<![endif]-->
<?php echo $javascript->link('jquery-1.4.2.min.js'); ?>
<?php echo $scripts_for_layout; ?>
</head>

<body class="dashboard">
<!-- Container -->
<div id="container">

    
    <!-- Header -->
      <?php e($this->element('header/administrator')); ?>
    <!-- END Header -->

    <!-- Content -->
      <?php echo $content_for_layout; ?>
    <!-- END Content -->

    <div id="footer"></div>

</div>
<!-- END Container -->

</body>
</html>
