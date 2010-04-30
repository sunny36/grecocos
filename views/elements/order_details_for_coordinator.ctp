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


echo "<userdata name=\"price\">" . "Total" . "</userdata>";
echo "<userdata name=\"sub_total\">" . $products[0]['Order']['total'] . "</userdata>";

for($i=0;$i<sizeof($products);$i++){
echo "<row id='".$products[$i]['Product']['id']."'>"; 

echo "<cell><![CDATA[". $products[$i]['Product']['short_description'] .
     "]]></cell>";

echo "<cell>". $products[$i]['LineItem']['quantity'] . "</cell>";
     
echo "<cell>" . $products[$i]['Product']['selling_price'] . "</cell>"; 

echo "<cell>" . $products[$i]['LineItem']['total_price'] . "</cell>"; 

echo "</row>";
}
echo "</rows>"; 



?>