<?php

require_once "view/template.php";
require_once "dao/livroDAO.php";
require_once "dao/autorDAO.php";
require_once "dao/editoraDAO.php";
require_once "dao/exemplarDAO.php";
require_once "dao/usuarioDAO.php";
require_once "dao/categoriaDAO.php";
require_once "modelo/usuario.php";

template::header();
template::sidebar("Dashboard");
template::mainpanel("Dashboard");

$livroDAO = new livroDAO();
$autorDAO = new autorDAO();
$editoraDAO = new editoraDAO();
$exemplarDAO = new exemplarDAO();
$usuarioDAO = new usuarioDAO();
$categoriaDAO = new categoriaDAO();

$totalLivros = $livroDAO->totalLivros();
$totalAutores = $autorDAO->totalAutores();
$totalEditoras = $editoraDAO->totalEditoras();
$totalExemplares = $exemplarDAO->totalExemplares();
$totalUsuarios = $usuarioDAO->totalUsuarios();
$totalCategorias = $categoriaDAO->totalCategorias();

?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-md-2">
                    <div class="card">
                        <div class="header">
                            <h5 class="title text-center">Livros</h5>
                        </div>
                        <div class="content">
                            <div class="stats">
                                <div class="row">
                                    <div class="col-md-4">
                                        <i class="pe-7s-bookmarks fa-3x"></i>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="title text-center text-info"><?php  echo $totalLivros; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="header">
                            <h5 class="title text-center">Categorias</h5>
                        </div>
                        <div class="content">
                            <div class="stats">
                                <div class="row">
                                    <div class="col-md-4">
                                        <i class="pe-7s-albums fa-3x"></i>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="title text-center text-info"><?php  echo $totalCategorias; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="header">
                            <h5 class="title text-center">Exemplares</h5>
                        </div>
                        <div class="content">
                            <div class="stats">
                                <div class="row">
                                    <div class="col-md-4">
                                        <i class="pe-7s-notebook fa-3x"></i>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="title text-center text-info"><?php  echo $totalExemplares; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="header">
                            <h5 class="title text-center">Autores</h5>
                        </div>
                        <div class="content">
                            <div class="stats">
                                <div class="row">
                                    <div class="col-md-4">
                                        <i class="pe-7s-id fa-3x"></i>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="title text-center text-info"><?php  echo $totalAutores; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="header">
                            <h5 class="title text-center">Editoras</h5>
                        </div>
                        <div class="content">
                            <div class="stats">
                                <div class="row">
                                    <div class="col-md-4">
                                        <i class="pe-7s-culture fa-3x"></i>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="title text-center text-info"><?php  echo $totalEditoras; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="header">
                            <h5 class="title text-center">Usuários</h5>
                        </div>
                        <div class="content">
                            <div class="stats">
                                <div class="row">
                                    <div class="col-md-4">
                                        <i class="pe-7s-users fa-3x"></i>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="title text-center text-info"><?php  echo $totalUsuarios; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Reservas de Livros por Mês</h4>
                        </div>
                        <div class="content">
                            <canvas id="chartreservames"></canvas>
                            <div class="footer">
                                <div class="stats">
                                    <i class="fa fa-clock-o"></i> Considerando apemas os 3 últimos Meses!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Emprestimos de Livros por Mês</h4>
                        </div>
                        <div class="content">
                            <canvas id="chartemprestimomes"></canvas>
                            <div class="footer">
                                <div class="stats">
                                    <i class="fa fa-clock-o"></i> Considerando apemas os 3 últimos Meses!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
template::footer("Dashboard");
?>