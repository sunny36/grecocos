<?php 

class SupplierPDF {
  function __construct($products, $order, $filename, $save = false) {
    App::import('vendor', 'fpdf/fpdf' );
    $orientation = 'P'; $unit = 'pt'; $format = 'Letter'; $margin = 40;
    $pdf = new FPDF($orientation, $unit, $format); 
    App::import( 'Helper', 'Time' );
    $timeHelper = new TimeHelper;
    setlocale(LC_MONETARY, 'th_TH');

    $pdf->AddPage(); 

    $pdf->SetTopMargin($margin);
    $pdf->SetLeftMargin($margin);
    $pdf->SetRightMargin($margin);
    $pdf->SetAutoPageBreak(true, $margin);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0);
    $pdf->SetFillColor(255);
    $pdf->SetLineWidth(1);

    $pdf->Cell(50, 25, "Order ID: ", 'LT', 0, 'L'); 
    $pdf->SetFont('Arial', '');
    $pdf->Cell(50, 25, $order['Order']['id'], 'T', 0, 'L'); 
    $pdf->SetFont('Arial', 'B');
    $pdf->Cell(100, 25, 'Customer Name: ', 'T', 0, 'L'); 
    $pdf->SetFont('Arial', '');
    $pdf->Cell(290, 25, $order['User']['name'], 'TR', 1, 'L'); 

    $pdf->SetFont('Arial', 'B');
    $pdf->Cell(100, 25, "Delivery Date: ", 'LT', 0, 'L'); 
    $pdf->SetFont('Arial', '');
    $pdf->Cell(390, 25, $timeHelper->format($format = 'd-m-Y', $order['Delivery']['date']), 'TR', 1, 'L'); 

    $pdf->SetFont('Arial', 'B');
    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 30;
    $pdf->MultiCell($cell_width, 25, "No.\n ", 'LTR',  'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $pdf->Cell(200, 25, "Description", 'LTR', 0, 'C');

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 50;
    $pdf->MultiCell($cell_width, 25, "Number Ordered", 'LTR', 'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 50;
    $pdf->MultiCell($cell_width, 25, "Number Supplied", 'LTR', 'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 80;
    $pdf->MultiCell($cell_width, 25, "Amount per Unit", 'LTR', 'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 80;
    $pdf->MultiCell($cell_width, 25, "Amount\n ", 'LTR','C');
    $pdf->SetY($pdf->GetY() -25);

    $pdf->SetFont('Arial', '');
    $pdf->SetFillColor(238);
    $pdf->SetLineWidth(0.2);

    $pdf->SetY($pdf->GetY() + 25);
    $num = 1; 
    $number_ordered = 0;
    $number_supplied = 0;
    foreach($products as $product){
     $pdf->Cell(30, 20, $num++, 1, 0, 'L'); 
     $pdf->Cell(200, 20, $product['Product']['short_description'], 1, 0, 'L');
     $pdf->Cell(50, 20, $product['LineItem']['quantity'], 1, 0, 'L');
     $number_ordered += $product['LineItem']['quantity'];
     $pdf->Cell(50, 20, $product['LineItem']['quantity_supplied'], 1, 0, 'L');
     $number_supplied += $product['LineItem']['quantity_supplied'];
     $pdf->Cell(80, 20, money_format("%i", $product['Product']['selling_price']), 1, 0, 'R');
     $pdf->Cell(80, 20, money_format("%i", $product['LineItem']['total_price_supplied']) , 1, 1, 'R');

    }

    $pdf->SetX($pdf->GetX() + 30);
    $pdf->SetFont('Arial', 'B');
    $pdf->Cell(200, 20, "TOTALS", 1);
    $pdf->SetFont('Arial', '');
    $pdf->Cell(50, 20,  $number_ordered, 1, 0, 'L');
    $pdf->Cell(50, 20,  $number_supplied, 1, 0, 'L');
    $pdf->Cell(80, 20,  "N.A.", 1, 0, 'R');
    $pdf->Cell(80, 20,  money_format("%i", $order['Order']['total_supplied']), 1, 1, 'R');


    $pdf->SetY($pdf->GetY() + 25);

    $pdf->SetFont('Arial', 'B');
    $pdf->Cell(80, 20, "Amount Paid: ");
    $pdf->SetFont('Arial', '');
    $pdf->Cell(80, 20, money_format("%i", $order['Order']['total']), 0, 1);

    $pdf->SetFont('Arial', 'B');
    $pdf->Cell(80, 20, "Actual Amount: ");
    $pdf->SetFont('Arial', '');
    $pdf->Cell(80, 20, money_format("%i", $order['Order']['total_supplied']), 0, 1);

    $pdf->SetFont('Arial', 'B');
    $pdf->Cell(80, 20, "Rebate Amount: ");
    $pdf->SetFont('Arial', '');
    $pdf->Cell(80, 20, money_format("%i", $order['Order']['total'] - $order['Order']['total_supplied']), 0, 1);
    
    if ($save) {
      $pdf->Output($filename, 'F');
    } else {
      $pdf->Output($filename, 'I');
    }
  }
}
?>