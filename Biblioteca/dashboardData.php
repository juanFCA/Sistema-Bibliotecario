<?php
require_once 'dao/emprestimoDAO.php';

if(isset($_GET['tipo']) && $_GET['tipo'] == 'emprestimoMes'){
    $emprestimoDAO = new emprestimoDAO();
    $retorno = $emprestimoDAO->retornaEmprestimosMes();
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['tipo']) && $_GET['tipo'] == 'reservaMes'){
    $emprestimoDAO = new emprestimoDAO();
    $retorno = $emprestimoDAO->retornaReservasMes();
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

?>