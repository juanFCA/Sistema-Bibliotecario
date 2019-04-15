<?php

require_once 'dao/usuarioDAO.php';
require_once 'modelo/usuario.php';
require_once 'email/recuperacao.php';

// session_start inicia a sessão                                                               https://pt.stackoverflow.com/questions/247026/exibir-um-alert-e-redirecionar-a-p%C3%A1gina
session_start();

$email = $_POST['email'];

$usuarioDAO = new usuarioDAO();
$recuperacao = new recuperacao();
$usuario = $usuarioDAO->buscarPorEmail($email);

if (!empty($usuario)) {
    unset($_SESSION['email']);
    $validado = $recuperacao->recuperarSenha($usuario->getEmail(), $usuario->getNomeUsuario());
    if ($validado == true) {
        header('location:login.php?mensagem=E-mail de Recuperação enviado com sucesso! Faça seu Login para Continuar!&alerttype=alert-success');
    } else {
        header('location:login.php?mensagem=Erro ao tentar efetivar recuperação!&alerttype=alert-danger');
    }
}
else{
    unset($_SESSION['login']);
    header('location:login.php?mensagem=Erro ao tentar efetivar recuperação! Email Inválido!&alerttype=alert-danger');
}
?>
