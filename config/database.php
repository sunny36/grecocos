<?php
class DATABASE_CONFIG {

	var $local = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '127.0.0.1',
		'login' => 'root',
		'password' => 'root',
		'database' => 'grecocos',
	);
	
	var $test = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '127.0.0.1',
		'login' => 'root',
		'password' => 'root',
		'database' => 'grecocos',
	);
	
	var $production = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'sql313.ispace.in.th',
		'login' => 'ispac_4967521',
		'password' => 'jaewjing',
		'database' => 'ispac_4967521_grecocos',
	);
	
	function __construct() {
	  $host_r = explode('.', $_SERVER['SERVER_NAME']);
  	if(count($host_r)>2) while(count($host_r)>2)array_shift($host_r);
  	$mainhost = implode('.', $host_r);
  		switch(strtolower($mainhost)) {
  			case 'localhost':
  				$this->default = $this->local;
  				break;
  			case 'grecocos.co.cc':
  				$this->default = $this->production;
  				break;
  			default:
  				$this->default = $this->local;
  		}
  	}
	
}
?>