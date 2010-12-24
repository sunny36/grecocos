<?php
  if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml;charset=utf-8"); 
  } else {
    header("Content-type: text/xml;charset=utf-8");
  }

  echo "<?xml version='1.0' encoding='utf-8'?>";
  echo "<rows>";
  echo "<records>".$count."</records>";
  for($i=0;$i<sizeof($products);$i++){
    echo "<row id='".$products[$i]['Product']['id']."'>";            
    echo "<cell>". $products[$i]['Product']['id']."</cell>";
    echo "<cell>". $products[$i]['Product']['short_description']."</cell>";
    echo "<cell>". $products[$i]['Product']['short_description_th']."</cell>";
    echo "<cell>". $products[$i]['Product']['selling_price']."</cell>";
    echo "<cell>". $products[$i]['Product']['buying_price']."</cell>";
    echo "<cell>". $products[$i]['Product']['quantity']."</cell>";
    echo "<cell>". $products[$i]['Product']['stock']."</cell>";
    echo "<cell>". $products[$i]['Product']['display']."</cell>";
    echo "<cell>". $products[$i]['Category']['name']."</cell>";
    echo "<cell>". $products[$i]['MasterCategory']['name']."</cell>";
    echo "<cell>"."</cell>"; // for action
    echo "</row>";
  }
  echo "</rows>"; 
?>