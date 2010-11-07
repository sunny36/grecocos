<?php
  header("Content-Type: application/vnd.ms-excel");
  header('Content-Disposition: attachment; filename="MyXls.xls"');
  
  echo "<?xml version='1.0' encoding='UTF-8'?>";
  echo "<Workbook xmlns='urn:schemas-microsoft-com:office:spreadsheet'" .
    "xmlns:o=\"urn:schemas-microsoft-com:office:office\"" .
    "xmlns:x=\"urn:schemas-microsoft-com:office:excel\"" .
    "xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"" .
    "xmlns:html=\"http://www.w3.org/TR/REC-html40\">";
  echo "<Styles>" .
     "<Style ss:ID=\"Default\" ss:Name=\"Normal\">" .
      "<Alignment ss:Vertical=\"Bottom\"/>" .
      "<Borders/>" .
      "<Font ss:FontName=\"Verdana\"/>" .
      "<Interior/>" .
      "<NumberFormat/>" .
      "<Protection/>" .
     "</Style>" .
     "<Style ss:ID=\"s21\">" .
      "<Font ss:FontName=\"Verdana\" ss:Bold=\"1\"/>" .
     "</Style>" .
    "</Styles>";
  echo "<Worksheet ss:Name=\"Sheet 1\">" .
      "<Table>" .
      "<Column ss:AutoFitWidth=\"0\" ss:Width=\"153.0\"/>" .
      "<Row ss:StyleID=\"s21\">";      
  for($j =1; $j < count($productsOrders[0]); $j++) {
    echo "<Cell>";
    if ($j ==1) {
      echo "<Data ss:Type=\"String\">" . $productsOrders[0][$j] . "</Data>";      
    } else {
      if ($j == count($productsOrders[0]) - 1) {
        echo "<Data ss:Type=\"String\">" . $productsOrders[0][$j] . "</Data>";      
      } else {
        echo "<Data ss:Type=\"String\">" . "ID " .$productsOrders[0][$j] . "</Data>";      
      }
    }
    echo "</Cell>";
  }
  echo " </Row>";
  for ($i = 1; $i < count($productsOrders); $i++) {
    echo "<Row>";
    for ($j = 1; $j < count($productsOrders[$i]); $j++) {
      echo "<Cell>";
      if ($j == 1) {
        echo "<Data ss:Type=\"String\">" . $productsOrders[$i][$j] . "</Data>";
      } else {
        if ($productsOrders[$i][$j] > 0) {
          echo "<Data ss:Type=\"Number\">" . $productsOrders[$i][$j] . "</Data>";
        } else {
          echo "<Data ss:Type=\"String\">" . " " . "</Data>";
        }
      }
      echo "</Cell>";
    }
    echo "</Row>";
  }
  echo     "</Table>";
  echo   "</Worksheet>";
  echo "</Workbook>";
  
?>
