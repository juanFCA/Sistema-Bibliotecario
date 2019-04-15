<?php

require_once "view/template.php";
require_once "dao/livroDAO.php";
require_once "modelo/livro.php";
require_once "db/conexao.php";
require_once "modelo/categoria.php";
require_once "dao/categoriaDAO.php";
require_once "modelo/editora.php";
require_once "dao/editoraDAO.php";

$object = new livroDAO();

template::header();
template::sidebar("livros");
template::mainpanel();

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $livro = new livro("",
                        $_POST["titulo"],
                        $_POST["isbn"],
                        $_POST["edicao"],
                        $_POST["ano"],
                        $_POST["upload"],
                        $_POST["categoria"],
                        $_POST["editora"]);
    if(isset($_POST["id"])){
        $livro->setIdtbLivro($_POST["id"]);
    }
    $object->salvarAtualizar($livro);
    unset($livro);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $livro = $object->buscarLivro($id);

}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $livro = $object->buscarLivro($id);
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

                            <input type="hidden" name="id" value="<?php if(!empty($livro)) {echo $livro->getIdtbLivro();}?>"/>
                            <Label>Título</Label>
                            <input class="form-control" type="text" size="50" name="titulo" value="<?php if(!empty($livro)) {echo $livro->getTitulo();}?>" required/>
                            <br/>
                            <Label>ISBN</Label>
                            <input class="form-control" type="text" size="50" name="isbn" value="<?php if(!empty($livro)) {echo $livro->getIsbn();}?>" required/>
                            <br/>
                            <Label>Edição</Label>
                            <input class="form-control" type="text" size="50" name="edicao" value="<?php if(!empty($livro)) {echo $livro->getEdicao();}?>" required/>
                            <br/>
                            <Label>Ano</Label>
                            <input class="form-control" type="number" size="4" name="ano" value="<?php if(!empty($livro)) {echo $livro->getAno();}?>" required/>
                            <br/>
                            <label>Editora</label>
                            <select name="editora" class="form-control">
                                <option value="" selected disabled hidden >Selecione a Editora</option>
                                <?php
                                $editoraDAO = new editoraDAO();
                                $editoras = $editoraDAO->buscarTodos();
                                foreach($editoras as $editora){
                                    if( !empty($livro) && $editora->getIdtbEditora() == $livro->getTbEditoraIdtbEditora()){
                                        ?>
                                        <option value="<?php echo $editora->getIdtbEditora() ?>" selected><?php echo $editora->getNomeEditora()?></option>
                                        <?php
                                    }else{ ?>
                                        <option value="<?php echo $editora->getIdtbEditora() ?>"><?php echo $editora->getNomeEditora()?></option>
                                    <?php }} ?>
                            </select>
                            <br/>
                            <label>Categoria</label>
                            <select name="categoria" class="form-control">
                                <option value="" selected disabled hidden >Selecione a Categoria</option>
                                <?php
                                $categoriaDAO = new categoriaDAO();
                                $categorias = $categoriaDAO->buscarTodos();
                                foreach($categorias as $categoria){
                                    if(!empty($livro) && $categoria->getIdtbCategoria() == $livro->getTbCategoriaIdtbCategoria()){
                                        ?>
                                        <option value="<?php echo $categoria->getIdtbCategoria() ?>" selected><?php echo $categoria->getNomeCategoria()?></option>
                                        <?php
                                    }else{ ?>
                                        <option value="<?php echo $categoria->getIdtbCategoria() ?>"><?php echo $categoria->getNomeCategoria()?></option>
                                    <?php }} ?>
                            </select>
                            <br/>
                            <Label>Upload de Arquivo Digital</Label>
                            <input class="form-control" type="file" name="upload" value="<?php if(isset($livro) && $livro != null) {echo $livro->getUpload();}?>"/>
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
