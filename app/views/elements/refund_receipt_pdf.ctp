<?php
App::import('vendor', 'fpdf/fpdf' );
$orientation = 'P'; $unit = 'pt'; $format = 'A4'; $margin = 40;
$pdf = new FPDF($orientation, $unit, $format); 
App::import( 'Helper', 'Time' );
$timeHelper = new TimeHelper;
setlocale(LC_MONETARY, 'th_TH');

$pdf->AddPage(); 

$pdf->SetTopMargin($margin);
$pdf->SetLeftMargin($margin);
$pdf->SetRightMargin($margin);
$pdf->SetAutoPageBreak(true, $margin);

$pdf->SetY($pdf->GetY() + 10);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0);
$pdf->SetFillColor(255);
$pdf->SetLineWidth(1);
setlocale(LC_MONETARY, 'th_TH');
$refund = money_format("%i", $order['Order']['total'] - $order['Order']['total_supplied']); 
App::import( 'Helper', 'Time' );
$time = new TimeHelper;
$deliveryDate = $time->format($format = 'm-d-Y', $order['Delivery']['date']);
$pdf->MultiCell(0, 25, "Received from Coordinator of Grecocos FAO RAP, the amount of {$refund} Baht " .
                       "as rebate for incomplete delivery of order number {$order['Order']['id']} " . 
                       "on {$deliveryDate}"); 

$pdf->SetY($pdf->GetY() + 20);
$name = $order['User']['firstname'] . " " .$order['User']['lastname'];
$pdf->MultiCell(0, 25, "Signed: {$name}"); 
$pdf->SetY($pdf->GetY() + 40);
$date = date('m-d-Y'); 
$pdf->MultiCell(0, 25, "Date: {$date}"); 
$pdf->Output("refund.pdf", 'I');


?>