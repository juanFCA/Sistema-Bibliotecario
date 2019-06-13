<?php

require_once "view/template.php";
require_once "db/consulta.php";
require_once "modelo/usuario.php";

template::header();
template::sidebar("Dashboard");
template::mainpanel("Dashboard");

$consulta = new consulta();
$numRegistros = $consulta->retornaCountRegistros();

?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>

            <div class="row">
                <div class="col-md-6">

                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="header">
                                    <h5 class="title text-center">Livros</h5>
                                </div>
                                <div class="content">
                                    <div class="stats">
                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <i class="pe-7s-bookmarks fa-3x"></i>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 class="title text-center text-info"><?php  echo $numRegistros[1][6]; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="header">
                                    <h5 class="title text-center">Categorias</h5>
                                </div>
                                <div class="content">
                                    <div class="stats">
                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <i class="pe-7s-albums fa-3x"></i>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 class="title text-center text-info"><?php  echo $numRegistros[1][2]; ?></h3>
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
                                    <h5 class="title text-center">Exemplares</h5>
                                </div>
                                <div class="content">
                                    <div class="stats">
                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <i class="pe-7s-notebook fa-3x"></i>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 class="title text-center text-info"><?php  echo $numRegistros[1][5]; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="header">
                                    <h5 class="title text-center">Autores</h5>
                                </div>
                                <div class="content">
                                    <div class="stats">
                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <i class="pe-7s-id fa-3x"></i>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 class="title text-center text-info"><?php  echo $numRegistros[1][0]; ?></h3>
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
                                    <h5 class="title text-center">Editoras</h5>
                                </div>
                                <div class="content">
                                    <div class="stats">
                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <i class="pe-7s-culture fa-3x"></i>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 class="title text-center text-info"><?php  echo $numRegistros[1][3]; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="header">
                                    <h5 class="title text-center">Usuários</h5>
                                </div>
                                <div class="content">
                                    <div class="stats">
                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <i class="pe-7s-users fa-3x"></i>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 class="title text-center text-info"><?php  echo $numRegistros[1][8]; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Total de Reservas e Emprestimos</h4>
                        </div>
                        <div class="content">
                            <canvas id="charttotalresemp"></canvas>
                            <div class="footer">
                                <div class="stats">
                                    <i class="fa fa-clock-o"></i> Considerando apenas o Mês Atual!
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
                            <h4 class="title">Reservas por Mês</h4>
                        </div>
                        <div class="content">
                            <canvas id="chartreservames"></canvas>
                            <div class="footer">
                                <div class="stats">
                                    <i class="fa fa-clock-o"></i> Considerando apenas os 3 últimos Meses!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Emprestimos por Mês</h4>
                        </div>
                        <div class="content">
                            <canvas id="chartemprestimomes"></canvas>
                            <div class="footer">
                                <div class="stats">
                                    <i class="fa fa-clock-o"></i> Considerando apenas os 3 últimos Meses!
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
                            <h4 class="title">Reservas por Categoria</h4>
                        </div>
                        <div class="content">
                            <canvas id="chartreservacategoria"></canvas>
                            <div class="footer">
                                <div class="stats">
                                    <i class="fa fa-clock-o"></i> Considerando apenas os 3 últimos Meses!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Emprestimos por Categoria</h4>
                        </div>
                        <div class="content">
                            <canvas id="chartemprestimocategoria"></canvas>
                            <div class="footer">
                                <div class="stats">
                                    <i class="fa fa-clock-o"></i> Considerando apenas os 3 últimos Meses!
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
<script src="assets/js/graphs.js" type="text/javascript"></script>
