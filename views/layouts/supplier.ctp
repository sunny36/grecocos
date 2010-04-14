<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
    <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
    <?php echo $html->css('yuiapp'); ?><?php echo $html->css('yuiaqua'); ?>
    
    <?php echo $this->Html->charset(); ?>
  	<title>
  		<?php echo $title_for_layout; ?>
  	</title>
  	<?php

  		echo $scripts_for_layout;
  	?>
  	
</head>
<body>
    <div id="doc3" class="yui-t2">

        <div id="hd">
            <h1>GreCoCoS</h1>
            <div id="navigation">
                <ul id="user-navigation">
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Settings</a></li>
                    <li>
                      <?php e($html->link('Logout', 
                                          array('controller' => 'users', 
            			                              'action' => 'logout'))); ?>
            			  </li>
            			  
                    <li><a href="#">Logout</a></li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">
                    <div class="block">
                        <div class="hd">
                            <h2>Orders</h2>
                        </div>
                        <div class="bd">
                    			<?php echo $this->Session->flash(); ?>

                    			<?php echo $content_for_layout; ?>
                        </div>
                    </div>

                </div></div>
            </div>
            <div id="sidebar" class="yui-b">
                <!-- Layout adjustment options (for demo purposes) -->
                <div class="block">
                    <div class="hd">
                        <h2>Menu</h2>
                    </div>
                    <div class="bd">
                        <h3>Orders</h3>
                        <ul id="page-width-switcher" class="biglist">
                          <li>
                            <a href="#" class="highlight">List all Orders</a>
                          </li>
                        </ul>
                    </div>
                </div>


            </div>
        </div>
        <div id="ft">
            <p class="inner">Copyright &copy; 2009 Blah Your Website</p>
        </div>
    </div>
</body>
</html>
