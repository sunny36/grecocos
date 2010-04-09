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
for($i=0;$i<sizeof($orders);$i++){
echo "<row id='".$orders[$i]['Order']['id']."'>";            

echo "<cell>". $orders[$i]['Order']['id']."</cell>";
echo "<cell>". $orders[$i]['Delivery']['date']."</cell>";
echo "<cell>". $orders[$i]['User']['firstname'] ." " . $orders[$i]['User']['lastname'] ."</cell>";

if ($orders[$i]['Order']['status'] != "packed") {
  echo "<cell>". "No" ."</cell>";
} else {
  echo "<cell>". "Yes" ."</cell>";
}
echo "<cell>". $orders[$i]['Order']['total']."</cell>";
echo "<cell>"."</cell>"; // for action
echo "</row>";
}
echo "</rows>"; 


?>