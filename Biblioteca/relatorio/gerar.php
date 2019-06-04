<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 2019-05-29
 * Time: 10:17
 */

require "../vendor/autoload.php";
require_once "../view/template.php";
require_once "../modelo/usuario.php";
require_once "relatorio.php";

template::session();

$tipo = $_GET['tipo'];

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

$relatorio = new relatorio();
$pdf = new MEUPDF();

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(''. $_SESSION['usuario']->getNomeUsuario());
$pdf->SetTitle('Sistema Biblioteca Digital');
$pdf->SetSubject('Relatorio de'. $tipo);
$pdf->SetKeywords('Biblioteca, PDF, Relatório,'. $tipo );
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();

//$html = '<style>'.file_get_contents('../assets/css/bootstrap.min.css').'</style>';

switch ($tipo) {
    case 'Autores':
        $html = $relatorio->listaAutores();
        break;
    case 'Categorias':
        $html = $relatorio->listaCategorias();
        break;
    case 'Editoras':
        $html = $relatorio->listaEditoras();
        break;
    case 'Emprestimos':
        break;
    case 'Exemplares':
        $html = $relatorio->listaExemplares();
        break;
    case 'Livros':
        $html = $relatorio->listaLivros();
        break;
    case 'Usuários':
        $html = $relatorio->listaUsuarios();
        break;
    default:
        break;
}

$html.= '<pre>'. $_SESSION['usuario']->getNomeUsuario() .'</pre>';

$pdf->writeHTML($html);

ob_end_clean();
$pdf->Output('autores.pdf', 'I');

?>