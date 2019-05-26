<?php

require_once "view/template.php";
require_once "db/conexao.php";
require_once "dao/emprestimoDAO.php";
require_once "modelo/emprestimo.php";
require_once "dao/usuarioDAO.php";
require_once "modelo/usuario.php";
require_once "dao/exemplarDAO.php";
require_once "modelo/exemplar.php";

template::header();
template::sidebar("emprestimos");
template::mainpanel("Emprestimos");



?>

<?php
template::footer("Emprestimos");
?>
