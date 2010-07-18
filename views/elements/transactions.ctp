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
echo "<userdata name=\"type\">" . "Totals" . "</userdata>";
echo "<userdata name=\"cash_in\">" . $cash_in . "</userdata>";
echo "<userdata name=\"cash_out\">" . $cash_out . "</userdata>";
for($i=0;$i<sizeof($transactions);$i++){
echo "<row id='".$transactions[$i]['Transaction']['id']."'>";            

if ($transactions[$i]['Transaction']['type'] == "Bank Transfer") {
  echo "<cell>". "Swift Co. Ltd." ."</cell>";
} else {
  echo "<cell>". $transactions[$i]['User']['name']."</cell>";
}

echo "<cell>". $transactions[$i]['Transaction']['type']."</cell>";

App::import( 'Helper', 'Time' );
if ($transactions[$i]['Transaction']['type'] == "Bank Transfer") {
  echo "<cell>". $time->format($format = 'Y-m-d', $transactions[$i]['Transaction']['created']) ."</cell>";
} else {
  echo "<cell>". $transactions[$i]['Order']['ordered_date']."</cell>";
}
if ($transactions[$i]['Transaction']['type'] == "Bank Transfer") {
  echo "<cell>". $time->format($format = 'Y-m-d', $transactions[$i]['Transaction']['from']) . " TO " . 
       $time->format($format = 'Y-m-d', $transactions[$i]['Transaction']['to']) . "</cell>";
       
} else {
  echo "<cell>". $transactions[$i]['Order']['Delivery']['date']."</cell>";  
}
echo "<cell>". $transactions[$i]['Transaction']['cash_in']."</cell>";
echo "<cell>". $transactions[$i]['Transaction']['cash_out']."</cell>";
echo "</row>";
}
echo "</rows>"; 


?>

