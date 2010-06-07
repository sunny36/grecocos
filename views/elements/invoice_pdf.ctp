<?php
App::import('Lib', 'pdf' );
$pdf = new PDF_reciept();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetY(80);

$pdf->Cell(100, 15, "Delivery Date");
$pdf->SetFont('Arial', '');

$pdf->Cell(200, 13, $deliveryDate['Delivery']['date']);

$pdf->Ln(80);


$pdf->SetY(100);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 15, "Order ID");
$pdf->SetFont('Arial', '');

$orderId = str_pad($orderId, 6, '0', STR_PAD_LEFT);
$pdf->Cell(200, 13, $orderId);

$pdf->Ln(100);


$pdf->SetFont('Arial', 'B', 12);
$pdf->SetY(120);

$pdf->Cell(100, 13, "Ordered By");
$pdf->SetFont('Arial', '');

$pdf->Cell(200, 13, $currentUser['User']['firstname'] . ' ' . $currentUser['User']['lastname']);

$pdf->SetFont('Arial', 'B');
$pdf->Cell(50, 13, "Date:");
$pdf->SetFont('Arial', '');
$pdf->Cell(100, 13, date('F j, Y'), 0, 1);

$pdf->SetFont('Arial', '');
$pdf->SetX(140);
$pdf->Cell(200, 15, $currentUser['Organization']['delivery_address'], 0, 2);

$pdf->Ln(50);

$pdf->PriceTable($cart, $total);

$pdf->Ln(30);

$message = "Please pay cash to the co-ordinator.";

$pdf->MultiCell(0, 15, $message);

$fileName = $orderId . '_' . 'invoice.pdf';
$pdf->Output($fileName, 'I');

?>