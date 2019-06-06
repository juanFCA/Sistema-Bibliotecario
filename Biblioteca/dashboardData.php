<?php
require_once 'dao/emprestimoDAO.php';

if(isset($_GET['tipo']) && $_GET['tipo'] == 'livroCategoria'){
    $emprestimoDAO = new emprestimoDAO();
    $retorno = $emprestimoDAO->retornaEmprestimosMes();
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

?>