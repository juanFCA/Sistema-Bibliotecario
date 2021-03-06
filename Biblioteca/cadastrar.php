<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 04/01/2018
 * Time: 16:31
 */

require_once 'dao/usuarioDAO.php';
require_once 'modelo/usuario.php';

// session_start inicia a sessão https://pt.stackoverflow.com/questions/247026/exibir-um-alert-e-redirecionar-a-p%C3%A1gina
session_start();

$usuarioDAO = new usuarioDAO();

// as variáveis login e senha recebem os dados digitados na página anterior
$login = $_POST['login'];
$email = $_POST['email'];
$senha = md5($_POST['senha']);

$usuario = new usuario('', $login, 5, $email, $senha,0);

$validado = $usuarioDAO->salvarAtualizar($usuario);

if ($validado == true) {
    unset($_SESSION['login']);
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('location:login.php?mensagem=Usuário cadastrado com sucesso! Faça seu Login para Continuar!&alerttype=alert-success');
}
else{
    unset($_SESSION['login']);
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('location:login.php?mensagem=Erro ao tentar efetivar o seu cadastro! Nome de Usuário ou Email Inválidos!&alerttype=alert-danger');
}
?>