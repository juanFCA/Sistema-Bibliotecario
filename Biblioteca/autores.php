<?php

require_once "view/template.php";
require_once "dao/autorDAO.php";
require_once "modelo/autor.php";
require_once "db/conexao.php";

$autorDAO = new autorDAO();

template::header();
template::sidebar("autores");
template::mainpanel("Autores");

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
    $autor = $autorDAO->buscarAutor($id);
    $id = $autor->getIdtbAutor();
    $nome = $autor->getNomeAutor();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "" ) {
    $autor = new autor($id, $nome);
    $msg = $autorDAO->salvarAtualizar($autor);
    $id = null;
    $nome = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $autor = $autorDAO->buscarAutor($id);
    $msg = $autorDAO->remover($autor);
    $id = null;
}
?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Dados do Autor</h4>
                        </div>
                        <div class='content table-responsive'>
                            <form action="?act=save&id=" method="POST" name="form1">
                                <input type="hidden" name="id" value="<?php
                                // Preenche o id no campo id com um valor "value"
                                echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                                ?>"/>
                                <Label>Nome</Label>
                                <input class="form-control" type="text" size="50" name="nome" value="<?php
                                // Preenche o nome no campo nome com um valor "value"
                                echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                                ?>" required/>
                                <br/>
                                <input class="btn btn-success" type="submit" value="REGISTRAR">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                //chamada a paginação
                $autorDAO->tabelapaginada();
            ?>
        </div>
    </div>

<?php
template::footer("Autores");
echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
?>