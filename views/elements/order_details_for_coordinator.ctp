<?php
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
              header("Content-type: application/xhtml+xml;charset=utf-8"); 
} else {
          header("Content-type: text/xml;charset=utf-8");
}
echo "<?xml version='1.0' encoding='utf-8'?>";
echo "<rows>";
echo "<page>".$page."</page>";
echo "<total>".$total_pages."</total>";
echo "<records>".$count."</records>";

$quantity_ordered = 0; 
$quantity_supplied = 0; 
foreach($products as $product) {
  $quantity_ordered += $product['LineItem']['quantity'];
  $quantity_supplied += $product['LineItem']['quantity_supplied'];
}
echo "<userdata name=\"short_description\">" . "Totals" . "</userdata>";
echo "<userdata name=\"quantity_ordered\">" . $quantity_ordered . "</userdata>";
echo "<userdata name=\"quantity_supplied\">" . $quantity_supplied . "</userdata>";
echo "<userdata name=\"price\">" . "N.A." . "</userdata>";
if ($order['Order']['status'] == "entered" || $order['Order']['status'] == "paid") {
  echo "<userdata name=\"sub_total\">" . $products[0]['Order']['total'] . "</userdata>";
} 

if ($order['Order']['status'] == "packed" || $order['Order']['status'] == "delivered") {
  echo "<userdata name=\"sub_total\">" . $products[0]['Order']['total_supplied'] . "</userdata>";
} 



for($i=0;$i<sizeof($products);$i++){
echo "<row id='".$products[$i]['Product']['id']."'>"; 

echo "<cell><![CDATA[". $products[$i]['Product']['short_description'] .
     "]]></cell>";

echo "<cell>". $products[$i]['LineItem']['quantity'] . "</cell>";

echo "<cell>". $products[$i]['LineItem']['quantity_supplied'] . "</cell>";
     
echo "<cell>" . $products[$i]['Product']['selling_price'] . "</cell>"; 

if ($order['Order']['status'] == "entered" || $order['Order']['status'] == "paid") {
  echo "<cell>" . $products[$i]['LineItem']['total_price'] . "</cell>"; 
} 

if ($order['Order']['status'] == "packed" || $order['Order']['status'] == "delivered") {
  echo "<cell>" . $products[$i]['LineItem']['total_price_supplied'] . "</cell>"; 
} 




echo "</row>";
}
echo "</rows>"; 



?>