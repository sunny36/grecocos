<?php

class DashboardHelper extends AppHelper {
  var $helpers = array('Html');
  
  function generateModule($moduleName, $links) {
    echo "<div class=\"module\">";
    echo "<table>";
    echo "<caption>{$moduleName}</caption>";
    foreach ($links as $key => $value) {
      echo "<tr>";
      echo "<th scope=\"row\">";
      echo $this->Html->link($key, $value);
      echo "<td></td>";
      echo "<td></td>";
      echo "</tr>";
    }
    echo "<table>";
    echo "</div>";
  }
}

?>