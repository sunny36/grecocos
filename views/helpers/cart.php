<?php

class CartHelper extends AppHelper {
  var $helpers = array('Html', 'Form');
  
  function tableHeader() {
    echo "<thead>";
    echo "  <tr>";
    echo "    <td>Qty</td>";
    echo "    <td>Item Description</td>";
    echo "    <td>Item Price</td>";
    echo "    <td>Sub-Total</td>";
    echo "  </tr>";
    echo "</thead>";
  }
  
  function masterCategoryRow($masterCategoryNum, $masterCategory) {
    echo "<tbody>";
    echo "  <tr>";
    echo "    <td colspan=2>";
    echo "      <span id = \"master_category{$masterCategoryNum}\"" ;
    echo "            class=\"master_category ui-state-default ui-corner-all ui-icon ui-icon-minus\"";
    echo "            style=\"float:left;margin-right:0.5em;\">";
    echo "      </span>";
    echo "     <strong>" . $masterCategory . "</strong>";
    echo "    </td>";
    echo "    <td></td>";
    echo "    <td></td>";
    echo "  </tr>";
    echo "</tbody>";
  }

  function categoryRow($categoryNum, $category) {
    echo "<tbody>";
    echo "  <tr>";
    echo "    <td></td>";    
    echo "    <td>";
    echo "      <span id = \"category{$categoryNum}\"" ;
    echo "            class=\"category ui-state-default ui-corner-all ui-icon ui-icon-minus\"";
    echo "            style=\"float:left;margin-right:0.5em;\">";
    echo "      </span>";
    echo "     <strong>" . $category . "</strong>";
    echo "    </td>";    
    echo "    <td></td>";   
    echo "  </tr>" ;
    echo "</tbody>";
  }
  
  function productRow($i, $row, $id, $shortDescription, $sellingPrice) {
    if ($i & 1) {
      echo "<tr class=\"alt products\">\n";
    } else {
      echo "<tr class=\"products\">\n";
    }
    echo  "<td>";
    echo $this->Form->hidden('.'. $row .'.id', array('value' => $id));
    echo $this->Form->text(
      '.'. $row .'.quantity', 
      array('value' => "0", 'maxlength' => '3', 'size' => '5'));
    echo "</td>";
    echo "<td><a class=\"short_description\" href=\"javascript:void(0);\">" .
         $shortDescription . "</a></td>"; 
    echo "<td>&#3647 " . $sellingPrice . "</td>"; 
    echo "<td>&#3647 0</td>"; 
    echo "</tr>\n";
  }
  
  
}
?>