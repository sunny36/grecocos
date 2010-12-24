<?php 

App::import('vendor', 'fpdf/fpdf' );
class PDF_reciept extends FPDF {
	var $uses = array('Product', 'Order', 'LineItem');
	function __construct ($orientation = 'P', $unit = 'pt', $format = 'A4', $margin = 40) {
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
	
function PriceTable($cart, $total) {
  setlocale(LC_MONETARY, 'th_TH');
	$this->SetFont('Arial', 'B', 10);
	$this->SetTextColor(0);
	$this->SetFillColor(36, 140, 129);
	$this->SetLineWidth(1);
	$this->Cell(45, 25, "Quantity", 'LTR', 0, 'C', true);
	$this->Cell(260, 25, "Item Description", 'LTR', 0, 'C', true);
	$this->Cell(85, 25, "Price", 'LTR', 0, 'C', true);
	$this->Cell(85, 25, "Sub-Total", 'LTR', 1, 'C', true);
	 
	$this->SetFont('Arial', '');
	$this->SetFillColor(238);
	$this->SetLineWidth(0.2);
	$fill = false;
	
	 foreach($cart as $cartItem){
		$this->Cell(45, 20, $cartItem['quantity'], 1, 0, 'L', $fill);
		$this->Cell(260, 20, $cartItem['name'], 1, 0, 'L', $fill);
		$this->Cell(85, 20,  money_format("%i", $cartItem['price']), 1, 0, 'R', $fill);
		$this->Cell(85, 20,  money_format("%i", $cartItem['subtotal']), 1, 1, 'R', $fill);
		$fill = !$fill;
	}
	$this->SetX(305+40);
	$this->Cell(85, 20, "Total", 1);
	$this->Cell(85, 20,  money_format("%i", $total) . ' Baht', 1, 1, 'R');
}
	
	
	
	
	
	
}
?>