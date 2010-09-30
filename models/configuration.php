<?php
class Configuration extends AppModel {
	var $name = 'Configuration';
	var $displayField = 'key';
	
	 function load()  {  
	   $settings = $this->find('all');  
     foreach ($settings as $variable)  {  
       Configure::write('Grecocos.' . $variable['Configuration']['key'],  
                        $variable['Configuration']['value']);  
      }  
    }  
  
}
?>