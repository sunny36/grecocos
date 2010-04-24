<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-us" xml:lang="en-us" >
<head>
<title><?php echo $title_for_layout; ?></title>
<?php echo $this->Html->css('admin/base.css'); ?>
<?php echo $this->Html->css('admin/forms.css'); ?>
<!--[if lte IE 7]>
<?php echo $this->Html->css('admin/ie.css'); ?>
<![endif]-->

<?php echo $scripts_for_layout; ?>
</head>


<body class="products-product change-form">

<!-- Container -->
<div id="container">    
    <!-- Header -->
    <div id="header">
        <div id="branding">        
          <h1 id="site-name">Django administration</h1>

        </div>
        
        <div id="user-tools">
            Welcome,
            <strong>somchok</strong>.
            
                
                
                
                
                    <a href="/admin/password_change/">

                
                Change password</a> /
                
                
                    <a href="/admin/logout/">
                
                Log out</a>
            
        </div>
        
        
    </div>
    <!-- END Header -->
    
<div class="breadcrumbs">
     <a href="../../../">Home</a> &rsaquo;

     <a href="../../">Products</a> &rsaquo; 
     <a href="../">Products</a> &rsaquo; 
     Add product
</div>

    

        

    <!-- Content -->
      <?php echo $content_for_layout; ?>
    <!-- END Content -->

    <div id="footer"></div>
</div>

<!-- END Container -->

</body>
</html>
