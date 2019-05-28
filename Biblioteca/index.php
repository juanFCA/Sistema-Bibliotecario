<?php

require_once "view/template.php";
require_once "dao/livroDAO.php";
require_once "dao/autorDAO.php";
require_once "dao/editoraDAO.php";
require_once "dao/exemplarDAO.php";
require_once "dao/usuarioDAO.php";
require_once "dao/categoriaDAO.php";

template::header();
template::sidebar("index");
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

            <div class="col-md-4">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Livros / Categoria</h4>
                    </div>
                    <div class="content">
                        <div id="chartPreferences" class="ct-chart ct-perfect-fourth"></div>

                        <div class="footer">
                            <div class="legend">
                                <i class="fa fa-circle text-info"></i> Open
                                <i class="fa fa-circle text-danger"></i> Bounce
                                <i class="fa fa-circle text-warning"></i> Unsubscribe
                            </div>
                            <hr>
                            <div class="stats">
                                <i class="fa fa-clock-o"></i> Campaign sent 2 days ago
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Users Behavior</h4>
                        <p class="category">24 Hours performance</p>
                    </div>
                    <div class="content">
                        <div id="chartHours" class="ct-chart"></div>
                        <div class="footer">
                            <div class="legend">
                                <i class="fa fa-circle text-info"></i> Open
                                <i class="fa fa-circle text-danger"></i> Click
                                <i class="fa fa-circle text-warning"></i> Click Second Time
                            </div>
                            <hr>
                            <div class="stats">
                                <i class="fa fa-history"></i> Updated 3 minutes ago
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
template::footer("Principal");
?>