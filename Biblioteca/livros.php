<?php

require_once "view/template.php";
require_once "dao/livroDAO.php";
require_once "modelo/livro.php";
require_once "db/conexao.php";

$object = new livroDAO();

template::header();
template::sidebar();
template::mainpanel();


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $titulo = (isset($_POST["titulo"]) && $_POST["titulo"] != null) ? $_POST["titulo"] : "";
    $isbn = (isset($_POST["isbn"]) && $_POST["isbn"] != null) ? $_POST["isbn"] : "";
    $edicao = (isset($_POST["edicao"]) && $_POST["edicao"] != null) ? $_POST["edicao"] : "";
    $ano = (isset($_POST["ano"]) && $_POST["ano"] != null) ? $_POST["ano"] : "";
    $upload = (isset($_POST["upload"]) && $_POST["upload"] != null) ? $_POST["upload"] : "";
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $titulo = null;
    $isbn = null;
    $edicao = null;
    $ano = null;
    $upload = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    $livro = new livro($id, "", "", "", "", "", "", "");
    $msg = $object->atualizar($livro);
    $id = $msg->getIdtbLivro();
    $titulo = $msg->getTitulo();
    $isbn = $msg->getIsbn();
    $edicao = $msg->getEdicao();
    $ano = $msg->getAno();
    $upload = $msg->getUpload();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $titulo != "" && $isbn != "" && $edicao != "" && $ano != "" && $upload != "") {
    $livro = new livro($id, $titulo, $isbn, $edicao, $ano, $upload);
    $msg = $object->salvar($livro);
    $id = null;
    $titulo = null;
    $isbn = null;
    $edicao = null;
    $ano = null;
    $upload = null;

}
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $livro = new livro($id, "", "", "", "", "", "", "");
    $msg = $object->remover($livro);
    $id = null;
    $titulo = null;
    $isbn = null;
    $edicao = null;
    $ano = null;
    $upload = null;
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Livros</h4>
                        <p class='category'>Lista de Livros do Sistema</p>

                    </div>
                    <div class='content table-responsive'>
                        <form action="?act=save&id=" method="POST" name="form1">

                            <input type="hidden" name="id" value="<?php
                            // Preenche o id no campo id com um valor "value"
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            <Label>Título</Label>
                            <input class="form-control" type="text" size="50" name="titulo" value="<?php
                            // Preenche o titulo no campo titulo com um valor "value"
                            echo (isset($titulo) && ($titulo != null || $titulo != "")) ? $titulo : '';
                            ?>" required/>
                            <br/>
                            <Label>ISBN</Label>
                            <input class="form-control" type="text" size="50" name="isbn" value="<?php
                            // Preenche o isbn no campo isbn com um valor "value"
                            echo (isset($isbn) && ($isbn != null || $isbn != "")) ? $isbn : '';
                            ?>" required/>
                            <br/>
                            <Label>Edição</Label>
                            <input class="form-control" type="text" size="50" name="edicao" value="<?php
                            // Preenche a edicao no campo edicao com um valor "value"
                            echo (isset($edicao) && ($edicao != null || $edicao != "")) ? $edicao : '';
                            ?>" required/>
                            <br/>
                            <Label>Ano</Label>
                            <input class="form-control" type="number" size="4" name="ano" value="<?php
                            // Preenche o ano no campo ano com um valor "value"
                            echo (isset($ano) && ($ano != null || $ano != "")) ? $ano : '';
                            ?>" required/>
                            <br/>
                            <Label>Upload de Arquivo</Label>
                            <input class="form-control" type="file" name="upload" value="<?php
                            // Preenche o upload no campo upload com um valor "value"
                            echo (isset($upload) && ($upload != null || $upload != "")) ? $upload : '';
                            ?>"/>
                            <br/>
                            <input class="btn btn-success" type="submit" value="REGISTRAR">
                            <hr>
                        </form>
                        <?php
                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
                        //chamada a paginação
                        $object->tabelapaginada();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
template::footer();
?>
