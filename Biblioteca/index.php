<?php

require_once "view/template.php";

template::header();
template::sidebar("index");
template::mainpanel("Dashboard");
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class="col-md-4">
            <div class="card">

                <div class="header">
                    <h4 class="title">Livros / Categoria</h4>
                    <p class="category">Total de Livros: <b>140</b></p>
                    <p class="category">Total de Categorias: <b>5</b></p>
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

<?php
template::footer("Principal");
?>