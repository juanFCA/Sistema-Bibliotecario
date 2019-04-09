<?php

require_once "view/template.php";
require_once "dao/livroDAO.php";
require_once "modelo/livro.php";
require_once "db/conexao.php";
require_once "dao/categoriaDAO.php";

$object = new livroDAO();

template::header();
template::sidebar();
template::mainpanel();

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $livro = new livro();
    if(isset($_POST["id"])){
        $livro->setIdtbLivro($_POST["id"]);
    }
    $livro->setTitulo($_POST["titulo"]);
    $livro->setIsbn($_POST["isbn"]);
    $livro->setAno($_POST["ano"]);
    $livro->setEdicao($_POST["edicao"]);
    $livro->setUpload($_POST["upload"]);
    $livro->setTbCategoriaIdtbCategoria($_POST["categoria"]);
    $livro->setTbEditoraIdtbEditora($_POST["editora"]);
    $object->salvarAtualizar($livro);
    unset($livro);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $livro = new livro();
    $livro = $object->select($id);

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $livro = new livro();
    $livro = $object->select($id);
    $object->remover($livro);
    unset($livro);
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
                            <label>Categoria</label>
                            <select name="categoria" class="form-control">
                                <option value="0" selected>Selecione a Categoria</option>
                                <?php
                                $categoriaDAO = new categoriaDAO();
                                $categorias = $categoriaDAO->buscarTodos();
                                foreach($categorias as $categoria){
                                    if(isset($livro) && $livro != null && $categoria->getNomeCategoria() == $livro->getCategoria()){
                                        ?>
                                        <option value="<?php echo $categoria->getIdCategoria() ?>" selected><?php echo $categoria->getNomeCategoria()?></option>
                                        <?php
                                    }else{ ?>
                                        <option value="<?php echo $categoria->getIdCategoria() ?>"><?php echo $categoria->getNomeCategoria()?></option>
                                    <?php }} ?>
                            </select>
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
