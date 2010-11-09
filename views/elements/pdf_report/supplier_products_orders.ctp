<?php
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=\"" . $fileName . "\"");
  
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
  echo "<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"\n" .
    "xmlns:o=\"urn:schemas-microsoft-com:office:office\"\n" .
    "xmlns:x=\"urn:schemas-microsoft-com:office:excel\"\n" .
    "xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"\n" .
    "xmlns:html=\"http://www.w3.org/TR/REC-html40\">\n";
  echo "<Styles>\n" .
     "<Style ss:ID=\"Default\" ss:Name=\"Normal\">\n" .
      "<Alignment ss:Vertical=\"Bottom\"/>\n" .
      "<Borders/>\n" .
      "<Font ss:FontName=\"Verdana\"/>\n" .
      "<Interior/>\n" .
      "<NumberFormat/>\n" .
      "<Protection/>\n" .
     "</Style>\n" .
     "<Style ss:ID=\"s21\">\n" .
      "<Font ss:FontName=\"Verdana\" ss:Bold=\"1\"/>\n" .
     "</Style>\n" .
    "</Styles>\n";
  echo "<Worksheet ss:Name=\"Sheet 1\">\n" .
      "<Table>\n" .
      "<Column ss:AutoFitWidth=\"0\" ss:Width=\"153.0\"/>\n" .
      "<Row ss:StyleID=\"s21\">\n";      
  for($j =1; $j < count($productsOrders[0]); $j++) {
    echo "<Cell>\n";
    if ($j ==1) {
      echo "<Data ss:Type=\"String\">" . $productsOrders[0][$j] . "</Data>\n";      
    } else {
      if ($j == count($productsOrders[0]) - 1) {
        echo "<Data ss:Type=\"String\">" . $productsOrders[0][$j] . "</Data>\n";      
      } else {
        echo "<Data ss:Type=\"String\">" . "ID " .$productsOrders[0][$j] . "</Data>\n";      
      }
    }
    echo "</Cell>\n";
  }
  echo " </Row>\n";
  for ($i = 1; $i < count($productsOrders); $i++) {
    echo "<Row>\n";
    for ($j = 1; $j < count($productsOrders[$i]); $j++) {
      echo "<Cell>\n";
      if ($j == 1) {
        echo "<Data ss:Type=\"String\">" . $productsOrders[$i][$j] . "</Data>\n";
      } else {
        if ($productsOrders[$i][$j] > 0) {
          echo "<Data ss:Type=\"Number\">" . $productsOrders[$i][$j] . "</Data>\n";
        } else {
          echo "<Data ss:Type=\"String\">" . " " . "</Data>\n";
        }
      }
      echo "</Cell>\n";
    }
    echo "</Row>\n";
  }
  echo     "</Table>\n";
  echo   "</Worksheet>\n";
  echo "</Workbook>\n";
  
?>
