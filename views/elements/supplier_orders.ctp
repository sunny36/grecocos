<?php
setlocale(LC_MONETARY, 'th_TH');
App::import( 'Helper', 'Time' );
$timeHelper = new TimeHelper;
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
              header("Content-type: application/xhtml+xml;charset=utf-8"); 
} else {
          header("Content-type: text/xml;charset=utf-8");
}
echo "<?xml version='1.0' encoding='utf-8'?>";
echo "<rows>";
echo "<page>".$page."</page>";
echo "<records>".$count."</records>";
for($i=0;$i<sizeof($orders);$i++){
echo "<row id='".$orders[$i]['Order']['id']."'>";            

echo "<cell>". $orders[$i]['Order']['id']."</cell>";


echo "<cell>". $timeHelper->format($format = 'd-m-Y', $orders[$i]['Delivery']['date']) . "</cell>";
echo "<cell>". $orders[$i]['User']['firstname'] ." " . $orders[$i]['User']['lastname'] ."</cell>";

if ($orders[$i]['Order']['status'] == "packed" || 
    $orders[$i]['Order']['status'] == "delivered") {
  echo "<cell>". "1" ."</cell>";
} else {
  echo "<cell>". "0" ."</cell>";
}

echo "<cell>".money_format("%i", $orders[$i]['Order']['total_supplied']) ."</cell>";
echo "<cell>"."</cell>"; // for action
echo "<cell>" . "Print". "</cell>"; // for pdf
echo "<cell>"."</cell>"; // for order details
echo "</row>";
}
echo "</rows>"; 


?>
