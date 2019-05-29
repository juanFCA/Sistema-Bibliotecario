<?php

require_once "view/template.php";
require_once "dao/editoraDAO.php";
require_once "modelo/editora.php";
require_once "db/conexao.php";

$editoraDAO = new editoraDAO();

template::header();
template::sidebar("editoras");
template::mainpanel("Editoras");

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    $editora = $editoraDAO->buscarEditora($id);
    $id = $editora->getIdtbEditora();
    $nome = $editora->getNomeEditora();

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "" ) {
    $editora = new editora($id, $nome);
    $msg = $editoraDAO->salvarAtualizar($editora);
    $id = null;
    $nome = null;

}
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $editora = $editoraDAO->buscarEditora($id);
    $msg = $editoraDAO->remover($editora);
    $id = null;
}
?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Dados da Editora</h4>
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
                $editoraDAO->tabelapaginada();
            ?>
        </div>
    </div>

<?php
template::footer("Editoras");
echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
?>