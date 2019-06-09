<?php
require_once 'dao/emprestimoDAO.php';

if(isset($_GET['tipo']) && $_GET['tipo'] == 'totalResEmp'){
    $emprestimoDAO = new emprestimoDAO();
    $retorno = $emprestimoDAO->retornaTotalResEmp(0);
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['tipo']) && $_GET['tipo'] == 'reservaMes'){
    $emprestimoDAO = new emprestimoDAO();
    $retorno = $emprestimoDAO->retornaReservasMes(2);
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['tipo']) && $_GET['tipo'] == 'emprestimoMes'){
    $emprestimoDAO = new emprestimoDAO();
    $retorno = $emprestimoDAO->retornaEmprestimosMes(2);
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['tipo']) && $_GET['tipo'] == 'reservaCategoria'){
    $emprestimoDAO = new emprestimoDAO();
    $retorno = $emprestimoDAO->retornaReservasCategoria(2);
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['tipo']) && $_GET['tipo'] == 'emprestimoCategoria'){
    $emprestimoDAO = new emprestimoDAO();
    $retorno = $emprestimoDAO->retornaEmprestimosCategoria(2);
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

?>