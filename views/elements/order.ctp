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

for($i=0;$i<sizeof($products);$i++){
echo "<row id='".$products[$i]['Product']['id']."'>"; 
$num = $i + 1;           
echo "<cell>". $num ."</cell>";
echo "<cell>". $products[$i]['LineItem']['quantity']."</cell>";
echo "<cell>". $products[$i]['LineItem']['quantity_supplied']."</cell>";
echo "<cell><![CDATA[". $products[$i]['Product']['short_description'] . "]]></cell>";
echo "<cell>"."</cell>"; //for action
echo "</row>";
}
echo "</rows>"; 


?>