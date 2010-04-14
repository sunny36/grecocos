
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>YUI App Theme</title>
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
            <h1>YUI App Theme</h1>
            <div id="navigation">
                <!-- <ul id="primary-navigation">
                    <li><a href="#">Some Page</a></li>
                    <li class="active"><a href="#">Active</a></li>
                    <li><a href="#">Login</a></li>
                    <li><a href="#">Signup</a></li>
                </ul> -->

                <ul id="user-navigation">
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Settings</a></li>
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
                        <h3>Page Width</h3>
                        <ul id="page-width-switcher" class="biglist">
                            <li><a href="#" title="doc">750px centered</a></li>
                            <li><a href="#" title="doc2">950px centered</a></li>
                            <li><a href="#" title="doc4">974px fluid</a></li>
                            <li><a href="#" title="doc3" class="highlight">100% fluid</a></li>
                        </ul>

                        <h3>Layout</h3>
                        <ul id="page-layout-switcher" class="biglist">
                            <li><a href="#" title="yui-t1">Left sidebar, 160px</a></li>
                            <li><a href="#" title="yui-t2">Left sidebar, 180px</a></li>
                            <li><a href="#" title="yui-t3">Left sidebar, 300px</a></li>
                            <li><a href="#" title="yui-t4">Right sidebar, 180px</a></li>
                            <li><a href="#" title="yui-t5">Right sidebar, 240px</a></li>
                            <li><a href="#" title="yui-t6" class="highlight">Right sidebar, 300px</a></li>
                            <li><a href="#" title="yui-t0">Single Column</a></li>
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
