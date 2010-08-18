<?php
App::import('Lib', 'supplier_pdf_no_amount' );
App::import( 'Helper', 'Time' );
$timeHelper = new TimeHelper;

$filename = $order['Order']['id'] . "_" . $timeHelper->format($format = 'd-m-Y', $order['Delivery']['date']) . ".pdf"; 
$supplierPdf = new SupplierPDF($products, $order, $filename);
?>