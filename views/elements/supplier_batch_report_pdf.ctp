<?php
App::import('Lib', 'supplier_batch_report' );
App::import( 'Helper', 'Time' );
$timeHelper = new TimeHelper;

$filename = "BatchReport.pdf";
$supplierPdf = new SupplierPDF($lineItems, $lineItemTotals, $filename);
?>
