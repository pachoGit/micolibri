<?php

fpdf(); // Funcion que esta dentro de pdf_helper.php

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(40, 10, "Mi institución");

$pdf->Output();

?>

