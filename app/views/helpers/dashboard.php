<?php

class DashboardHelper extends AppHelper {
  var $helpers = array('Html');
  
  function generateModule($moduleName, $links) {
    echo "<div class=\"module\">\n";
    echo "<table>\n";
    echo "<caption>{$moduleName}</caption>\n";
    foreach ($links as $key => $value) {
      echo "<tr>";
      echo "<th scope=\"row\">";
      echo $this->Html->link($key, $value);
      echo "</th>\n";
      echo "<td></td>\n";
      echo "<td></td>\n";
      echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
  }
}

?>