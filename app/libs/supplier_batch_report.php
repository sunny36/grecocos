<?php 

class SupplierPDF {
  function __construct($lineItems, $lineItemTotals, $filename, $save = false) {
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

    $pdf->SetFont('Arial', 'B', '10');
    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 30;
    $pdf->MultiCell($cell_width, 25, "No.\n ", 'LTR',  'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $pdf->Cell(250, 25, "Description", 'LTR', 0, 'C');

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 48;
    $pdf->MultiCell($cell_width, 25, "# Ordered", 'LTR', 'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 48;
    $pdf->MultiCell($cell_width, 25, "# Supplied", 'LTR', 'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 70;
    $pdf->MultiCell($cell_width, 25, "Amount Wholesale", 'LTR', 'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 70;
    $pdf->MultiCell($cell_width, 25, "Amount Retail", 'LTR','C');
    $pdf->SetY($pdf->GetY() -25);

    $pdf->SetFont('Arial', '');
    $pdf->SetFillColor(238);
    $pdf->SetLineWidth(0.2);

    $pdf->SetY($pdf->GetY() + 25);
    $num = 1; 
    $number_ordered = 0;
    $number_supplied = 0;
    foreach($lineItems as $lineItem){
     $pdf->Cell(30, 20, $num++, 1, 0, 'L'); 
     $pdf->Cell(250, 20, $lineItem['Product']['short_description'], 1, 0, 'L');
     $pdf->Cell(48, 20, $lineItem['LineItem']['ordered'], 1, 0, 'R');
     $pdf->Cell(48, 20, $lineItem['LineItem']['supplied'], 1, 0, 'R');
     $pdf->Cell(70, 20, 
                money_format("%i", $lineItem['LineItem']['amount_wholesale']), 
                1, 0, 'R');
     $pdf->Cell(70, 20, 
                money_format("%i", $lineItem['LineItem']['amount_retail']), 1, 
                1, 'R');

    }

    $pdf->SetX($pdf->GetX() + 30);
    $pdf->SetFont('Arial', 'B');
    $pdf->Cell(250, 20, "TOTALS", 1);
    $pdf->SetFont('Arial', '');
    $pdf->Cell(48, 20, $lineItemTotals['LineItem']['ordered'], 1, 0, 'R');
    $pdf->Cell(48, 20, $lineItemTotals['LineItem']['ordered'], 1, 0, 'R');
    $pdf->Cell(70, 20, 
               money_format("%i", $lineItemTotals['LineItem']['amount_wholesale']), 
               1, 0, 'R');
    $pdf->Cell(70, 20,
               money_format("%i", $lineItemTotals['LineItem']['amount_retail']), 
               1, 1, 'R');

    
    if ($save) {
      $pdf->Output($filename, 'F');
    } else {
      $pdf->Output($filename, 'I');
    }
  }
}
?>