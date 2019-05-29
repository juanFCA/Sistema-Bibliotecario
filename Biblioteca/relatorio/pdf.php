
<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 2019-05-29
 * Time: 10:17
 */

require "../vendor/autoload.php";
require_once "gerar.php";

class MEUPDF extends TCPDF{
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$gerar = new gerar();
$pdf = new MEUPDF();

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Juan Ferreira Carlos');
$pdf->SetTitle('Relatório do Sistema');
$pdf->SetSubject('Listagem de Autores');
$pdf->SetKeywords('TCPDF, PDF, Relatório, Autores');
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();

//$html = '<style>'.file_get_contents('../assets/css/bootstrap.min.css').'</style>';
$html = $gerar->listaAutores();
$html.= '<pre>'.$_SESSION.'</pre>';

$pdf->writeHTML($html);

ob_end_clean();
$pdf->Output('autores.pdf', 'I');

?>