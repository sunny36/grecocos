<?php 

App::import('vendor', 'fpdf/fpdf' );
class PDF_reciept extends FPDF {
	function __construct ($orientation = 'P', $unit = 'pt', $format = 'Letter', $margin = 40) {
		$this->FPDF($orientation, $unit, $format);
		$this->SetTopMargin($margin);
		$this->SetLeftMargin($margin);
		$this->SetRightMargin($margin);
		
		$this->SetAutoPageBreak(true, $margin);
	}
	
	function Header () {
		$this->SetFont('Arial', 'B', 20);
		$this->SetFillColor(36, 96, 84);
		$this->SetTextColor(225);
		$this->Cell(0, 30, "GRECOCOS, FAO", 0, 1, 'C', true);
	}
	
	function Footer () {
		$this->SetFont('Arial', '', 12);
		$this->SetTextColor(0);
		$this->SetXY(40, -60);
		$this->Cell(0, 20, "Thank you for shopping!!!", 'T', 0, 'C');
	}
	
function PriceTable($products, $prices) {
	$this->SetFont('Arial', 'B', 12);
	$this->SetTextColor(0);
	$this->SetFillColor(36, 140, 129);
	$this->SetLineWidth(1);
	$this->Cell(427, 25, "Item Description", 'LTR', 0, 'C', true);
	$this->Cell(100, 25, "Price", 'LTR', 1, 'C', true);
	 
	$this->SetFont('Arial', '');
	$this->SetFillColor(238);
	$this->SetLineWidth(0.2);
	$fill = false;
	
	for ($i = 0; $i < count($products); $i++) {
		$this->Cell(427, 20, $products[$i], 1, 0, 'L', $fill);
		$this->Cell(100, 20,  $prices[$i], 1, 1, 'R', $fill);
		$fill = !$fill;
	}
	$this->SetX(367);
	$this->Cell(100, 20, "Total", 1);
	$this->Cell(100, 20,  array_sum($prices) . ' Baht', 1, 1, 'R');
}
	
	
	
	
	
	
}
?>