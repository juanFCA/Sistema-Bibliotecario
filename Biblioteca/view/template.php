<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 02/03/2018
 * Time: 11:23
 */

class Template
{
    public static function session() {
        return session_start();
    }

    public static function header()
    {
        Template::session();

        if(!isset ($_SESSION['usuario']) == true)
        {
            unset($_SESSION['usuario']);
            header('location:login.php');
        }

        echo "<!doctype html>
        <html lang='en'>
        <head>
            <meta charset='utf-8' />
            <link rel='icon' type='image/png' sizes='96x96' href='assets/img/favicon.jpg'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
        
            <title>Biblioteca</title>
        
            <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
            <meta name='viewport' content='width=device-width' />

            <!-- Bootstrap core CSS     -->
            <link href=\"assets/css/bootstrap.min.css\" rel=\"stylesheet\" />
        
            <!-- Animation library for notifications   -->
            <link href=\"assets/css/animate.min.css\" rel=\"stylesheet\"/>
        
            <!--  Light Bootstrap Table core CSS    -->
            <link href=\"assets/css/light-bootstrap-dashboard.css?v=1.4.0\" rel=\"stylesheet\"/>
        
            <!--     Fonts and icons     -->
            <link href=\"http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css\" rel=\"stylesheet\">
            <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
            <link href=\"assets/css/pe-icon-7-stroke.css\" rel=\"stylesheet\" />
                    
            <!-- Bootstrap multiselection -->
            <link href='vendor/mrohnstock/bootstrap-multiselect/css/bootstrap-multiselect.css' rel='stylesheet'/>
            
            <link href=\"assets/css/rendered.css\" rel=\"stylesheet\" />

            </head>
        <body>";

    }

    public static function footer($janela)
    {
        echo " <footer class=\"footer\">
                <div class=\"container-fluid\">
                    <nav class=\"pull-left\">
                        <ul>
                            <li>
                                <a>
                                    ". $janela ."
                                </a>
                            </li>
    
                        </ul>
                    </nav>
                    <p class=\"copyright pull-right\">
                        &copy; <script>document.write(new Date().getFullYear())</script> <a href=\"http://www.creative-tim.com\">Creative Tim</a>, made with love for a better web
                    </p>
                </div>
                </footer>
        
            </div>
        </div>
        
        
        </body>
        
            <!--   Core JS Files   -->
            <script src=\"assets/js/jquery.3.2.1.min.js\" type=\"text/javascript\"></script>
            <script src=\"assets/js/bootstrap.min.js\" type=\"text/javascript\"></script>
        
            <!--  Charts Plugin -->
            <script src=\"assets/js/charts.min.js\" type=\"text/javascript\"></script>
        
            <!--  Notifications Plugin    -->
            <script src=\"assets/js/bootstrap-notify.js\" type=\"text/javascript\"></script>
        
            <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
            <script src=\"assets/js/light-bootstrap-dashboard.js\" type=\"text/javascript\"></script>
        
            <!-- Bootstrap multiselection -->
            <script src=\"vendor/mrohnstock/bootstrap-multiselect/js/bootstrap-multiselect.js\" type=\"text/javascript\"></script>
            
            <script src=\"assets/js/rendered.js\" type=\"text/javascript\"></script>
        
        </html>";

    }

    public static function sidebar($janela)
    {
        echo "<div class=\"wrapper\">
           <div class=\"sidebar\" data-color=\"blue\" data-image=\"assets/img/sidebar-5.jpg\">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color=\"blue | azure | green | orange | red | purple\"
        Tip 2: you can also add an image using data-image tag

    -->
    	    <div class=\"sidebar-wrapper\">
                <div class=\"logo\">
                    <a href='index.php' class=\"simple-text\">
                        Biblioteca Digital
                    </a>
                </div>
                <ul class=\"nav\">
                    <li class="; echo (!empty($janela) && $janela == "autores") ? "active" : "deactive"; echo">
                        <a href='autores.php'>
                            <i class=\"pe-7s-id\"></i>
                            <p>Autores</p>
                        </a>
                    </li>
                    <li class="; echo (!empty($janela) && $janela == "categorias") ? "active" : "deactive"; echo">
                        <a href='categorias.php'>
                            <i class=\"pe-7s-albums\"></i>
                            <p>Categorias</p>
                        </a>
                    </li>
                    <li class="; echo (!empty($janela) && $janela == "editoras") ? "active" : "deactive"; echo">
                        <a href='editoras.php'>
                            <i class=\"pe-7s-culture\"></i>
                            <p>Editoras</p>
                        </a>
                    </li>
                    <li class="; echo (!empty($janela) && $janela == "livros") ? "active" : "deactive"; echo">
                        <a href='livros.php'>
                            <i class=\"pe-7s-bookmarks\"></i>
                            <p>Livros</p>
                        </a>
                    </li>
                    <li class="; echo (!empty($janela) && $janela == "exemplares") ? "active" : "deactive"; echo">
                        <a href='exemplares.php'>
                            <i class=\"pe-7s-notebook\"></i>
                            <p>Exemplares</p>
                        </a>
                    </li>
                    <li class="; echo (!empty($janela) && $janela == "emprestimos") ? "active" : "deactive"; echo">
                        <a href='emprestimos.php'>
                            <i class=\"pe-7s-news-paper\"></i>
                            <p>Empréstimos</p>
                        </a>
                    </li>
                    <li class="; echo (!empty($janela) && $janela == "reservas") ? "active" : "deactive"; echo">
                        <a href='reservas.php'>
                            <i class=\"pe-7s-news-paper\"></i>
                            <p>Reservas</p>
                        </a>
                    </li>
                    <li class="; echo (!empty($janela) && $janela == "usuarios") ? "active" : "deactive"; echo">
                        <a href='usuarios.php'>
                            <i class=\"pe-7s-users\"></i>
                            <p>Usuários</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>";
    }

    public static function mainpanel($janela)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date("F j, Y");
        echo "<div class=\"main-panel\">
        <nav class=\"navbar navbar-default navbar-fixed\">
            <div class=\"container-fluid\">
                <div class=\"navbar-header\">
                    <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\">
                        <span class=\"sr-only\">Toggle navigation</span>
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                    </button>
                    <a class=\"navbar-brand\">$janela</a>
                </div>
                <div class=\"collapse navbar-collapse\">
                    <ul class=\"nav navbar-nav navbar-left\">
                        <li>
                            <a href=\"index.php\">
                                <i class=\"fa fa-home\" title=\"Principal\"></i>
                                <p class=\"hidden-lg hidden-md\">Principal</p>
                            </a>
                        </li>";
                    if ($_SESSION['usuario']->getTipo() == 1 || $_SESSION['usuario']->getTipo() == 2) {
                        echo "<li>
                            <a href=\"dashboard.php\">
                                <i class=\"fa fa-dashboard\" title=\"Dashboard\"></i>
                                    <p class=\"hidden-lg hidden-md\">Dashboard</p>
                             </a>
                        </li>";
                    }
                    if ($janela != "Principal" && $janela != "Dashboard" && $_SESSION['usuario']->getTipo() == 1) {
                        echo "<li>
                            <a href=\"relatorio/gerar.php?tipo=$janela\" target=\"_blank\">
                                <i class=\"fa fa-list-alt\" title=\"Relatório - $janela\"></i>
                                <p class=\"hidden-lg hidden-md\">Relatório - $janela</p>
                            </a>
                        </li>";
                    }
                    if ($janela == "Dashboard" && $_SESSION['usuario']->getTipo() == 1) {
                        echo "<li>
                                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" aria-expanded=\"false\">
                                    <i class=\"fa fa-list-alt\" title=\"Relatórios - $janela\"></i>
                                    <p class=\"hidden-lg hidden-md\">Relatórios - $janela</p>
                                </a>
                                <ul class=\"dropdown-menu\">
                                    <li><a href=\"relatorio/gerar.php?tipo=LivroExemplares\" target=\"_blank\">Total de Exemplares por Livro</a></li>
                                    <li><a href=\"relatorio/gerar.php?tipo=Emprestados\" target=\"_blank\">Livros Emprestados</a></li>
                                    <li><a href=\"relatorio/gerar.php?tipo=Reservados\" target=\"_blank\">Livros Reservados</a></li>
                                    <li><a href=\"relatorio/gerar.php?tipo=Atrasados\" target=\"_blank\">Livros com Devolução em Atraso</a></li>
                                    <li><a href=\"relatorio/gerar.php?tipo=Usuários\" target=\"_blank\">Usuários e seus Dados Cadastrais</a></li>
                                    <li class=\"divider\"></li>
                                    <li><a href=\"relatorio/gerar.php?tipo=Exportar\" target=\"_blank\">Exportar Todos os Gráficos</a></li>
                                </ul>
                        </li>";
                    }
                    echo " </ul>

                    <ul class=\"nav navbar-nav navbar-right\">
                        <li>
                            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" aria-expanded=\"false\">
                                <p>
								    ". $_SESSION['usuario']->getNomeUsuario() ."
								<b class=\"caret\"></b>
							    </p>
                            </a>
                            <ul class=\"dropdown-menu\">
                                <li><a href=\"#\">Perfil</a></li>
                                <li class=\"divider\"></li>
                                <li><a href=\"logout.php\">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>";

    }

}