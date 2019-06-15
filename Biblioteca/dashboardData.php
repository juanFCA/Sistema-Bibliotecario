<?php
require_once 'db/consulta.php';

if(isset($_GET['tipo']) && $_GET['tipo'] == 'totalResEmp'){
    $consulta = new consulta();
    $retorno = $consulta->retornaTotalResEmp(3);
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['tipo']) && $_GET['tipo'] == 'reservaMes'){
    $consulta = new consulta();
    $retorno = $consulta->retornaReservasMes(2);
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['tipo']) && $_GET['tipo'] == 'emprestimoMes'){
    $consulta = new consulta();
    $retorno = $consulta->retornaEmprestimosMes(2);
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['tipo']) && $_GET['tipo'] == 'reservaCategoria'){
    $consulta = new consulta();
    $retorno = $consulta->retornaReservasCategoria(2);
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

if(isset($_GET['tipo']) && $_GET['tipo'] == 'emprestimoCategoria'){
    $consulta = new consulta();
    $retorno = $consulta->retornaEmprestimosCategoria(2);
    header('Content-type: application/json');
    echo json_encode( $retorno );
}

?>