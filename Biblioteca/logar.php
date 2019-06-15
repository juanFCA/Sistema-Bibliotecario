<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 04/01/2018
 * Time: 16:31
 */

require_once 'dao/usuarioDAO.php';

// session_start inicia a sessão
session_start();
// as variáveis login e senha recebem os dados digitados na página anterior
$email = $_POST['email'];
$senha = md5($_POST['senha']);

$usuarioDAO = new usuarioDAO();
$valido = $usuarioDAO->logar($email, $senha);

if( $valido == true)
{
    $usuario = $usuarioDAO->buscarPorEmail($email);
    $_SESSION['usuario'] = $usuario;
    ($usuario->getTipo() == 1 || $usuario->getTipo() == 2) ? header('location:dashboard.php') : header('location:index.php');
}
else{
    unset ($_SESSION['usuario']);
    header('location:index.php');
}

?>