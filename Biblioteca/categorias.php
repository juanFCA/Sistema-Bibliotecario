<?php

require_once "view/template.php";
require_once "dao/categoriaDAO.php";
require_once "modelo/categoria.php";
require_once "db/conexao.php";
require_once "modelo/usuario.php";

$categoriaDAO = new categoriaDAO();

template::header();
template::sidebar("categorias");
template::mainpanel("Categorias");

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (!empty($_POST["id"])) ? $_POST["id"] : "";
    $nome = (!empty($_POST["nome"])) ? $_POST["nome"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (!empty($_GET["id"])) ? $_GET["id"] : "";
    $nome = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    $resultado = $categoriaDAO->buscarCategoria($id);
    $id = $resultado->getIdtbCategoria();
    $nome = $resultado->getNomeCategoria();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "" ) {
    $categoria = new categoria($id, $nome);
    $msg = $categoriaDAO->salvarAtualizar($categoria);
    $id = null;
    $nome = null;

}
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $categoria = $categoriaDAO->buscarCategoria($id);
    $msg = $categoriaDAO->remover($categoria);
    $id = null;
}
?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Dados da Categoria</h4>
                        </div>
                        <div class='content table-responsive'>
                            <form action="?act=save&id=" method="POST" name="form1">
                                <input type="hidden" name="id" value="<?php
                                // Preenche o id no campo id com um valor "value"
                                echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                                ?>"/>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <Label>Nome</Label>
                                            <input class="form-control" type="text" size="50" name="nome" value="<?php
                                            // Preenche o nome no campo nome com um valor "value"
                                            echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                                            ?>" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <div class="form-group">
                                            <br>
                                            <input class="btn btn-success" type="submit" value="REGISTRAR">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                //chamada a paginação
                $categoriaDAO->tabelapaginada();
            ?>
        </div>
    </div>

<?php
template::footer("Categorias");
echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
?>