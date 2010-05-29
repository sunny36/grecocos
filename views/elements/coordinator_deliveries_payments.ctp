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
for($i=0;$i<sizeof($deliveries);$i++){
echo "<row id='".$deliveries[$i]['Delivery']['id']."'>";            
echo "<cell>". $deliveries[$i]['Delivery']['date']."</cell>";
echo "<cell>". $deliveries[$i]['Delivery']['total_received']."</cell>";
echo "<cell>". $deliveries[$i]['Delivery']['total_refund']."</cell>";
echo "<cell>". $deliveries[$i]['Delivery']['total_due']."</cell>";
if ($deliveries[$i]['Delivery']['paid']) {
  echo "<cell>". "1" ."</cell>";
} else {
  echo "<cell>". "0" ."</cell>";
}
echo "<cell>"."</cell>"; // for action
echo "</row>";
}
echo "</rows>"; 


?>