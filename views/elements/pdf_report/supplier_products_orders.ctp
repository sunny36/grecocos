<?php
App::import('Lib', 'supplier_products_orders' );

function GenerateWord()
{
    //Get a random word
    $nb=rand(3, 10);
    $w='';
    for($i=1;$i<=$nb;$i++)
        $w.=chr(rand(ord('a'), ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb=rand(1, 10);
    $s='';
    for($i=1;$i<=$nb;$i++)
        $s.=GenerateWord().' ';
    return substr($s, 0, -1);
}

$pdf=new PDF_MC_Table();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(45, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15));
srand(microtime()*1000000);
for($i=0;$i<20;$i++)
    $pdf->Row(array($products[$i]['Product']['short_description'], '', '', '', '', '', '', '', '', '', ''));
$pdf->Output();
?>