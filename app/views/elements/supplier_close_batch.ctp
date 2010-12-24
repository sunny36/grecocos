<?php
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
              header("Content-type: application/xhtml+xml;charset=utf-8"); 
} else {
          header("Content-type: text/xml;charset=utf-8");
}
echo "<?xml version='1.0' encoding='utf-8'?>";
echo "<rows>";
echo "<page>". "1"."</page>";
echo "<total>"."1"."</total>";
echo "<records>".$count."</records>";
for($i=0;$i<count($delivery_dates);$i++){
echo "<row id='".$delivery_dates[$i]['Delivery']['id']."'>";            
echo "<cell>". $delivery_dates[$i]['Delivery']['date']."</cell>";
echo "<cell>". $delivery_dates[$i]['Delivery']['next_delivery']."</cell>";
echo "<cell>". $delivery_dates[$i]['Delivery']['ordered']."</cell>";
echo "<cell>". $delivery_dates[$i]['Delivery']['packed']."</cell>";
echo "<cell>". $delivery_dates[$i]['Delivery']['closed']."</cell>";
echo "<cell>"."</cell>"; // for action
echo "</row>";
}
echo "</rows>"; 


?>