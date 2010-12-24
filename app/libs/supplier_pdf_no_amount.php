<?php 

class SupplierPDF {
  function __construct($products, $order, $filename, $save = false) {
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

    $pdf->SetY($pdf->GetY() + 60);
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
    $pdf->Cell(226, 25, $order['User']['name'], 'TR', 1, 'L'); 

    $pdf->SetFont('Arial', 'B');
    $pdf->Cell(100, 25, "Delivery Date: ", 'LT', 0, 'L'); 
    $pdf->SetFont('Arial', '');
    $pdf->Cell(326, 25, $timeHelper->format($format = 'd-m-Y', $order['Delivery']['date']), 'TR', 1, 'L'); 

    $pdf->SetFont('Arial', 'B', '10');
    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 30;
    $pdf->MultiCell($cell_width, 25, "No.\n ", 'LTR',  'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $pdf->Cell(300, 25, "Description", 'LTR', 0, 'C');

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 48;
    $pdf->MultiCell($cell_width, 25, "Number Ordered", 'LTR', 'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 48;
    $pdf->MultiCell($cell_width, 25, "Number Supplied", 'LTR', 'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);
    
    $pdf->SetFont('Arial', '');
    $pdf->SetFillColor(238);
    $pdf->SetLineWidth(0.2);

    $pdf->SetY($pdf->GetY() + 50);
    $num = 1; 
    $number_ordered = 0;
    $number_supplied = 0;
    foreach($products as $product){
     $pdf->Cell(30, 20, $num++, 1, 0, 'L'); 
     $pdf->Cell(300, 20, $product['Product']['short_description'], 1, 0, 'L');
     $pdf->Cell(48, 20, $product['LineItem']['quantity'], 1, 0, 'R');
     $number_ordered += $product['LineItem']['quantity'];
     $pdf->Cell(48, 20, $product['LineItem']['quantity_supplied'], 1, 1, 'R');
     $number_supplied += $product['LineItem']['quantity_supplied'];
    }

    $pdf->SetX($pdf->GetX() + 30);
    $pdf->SetFont('Arial', 'B');
    $pdf->Cell(300, 20, "TOTALS", 1);
    $pdf->SetFont('Arial', '');
    $pdf->Cell(48, 20,  $number_ordered, 1, 0, 'R');
    $pdf->Cell(48, 20,  $number_supplied, 1, 0, 'R');    
    
    if ($save) {
      $pdf->Output($filename, 'F');
    } else {
      $pdf->Output($filename, 'I');
    }
  }
}
?>