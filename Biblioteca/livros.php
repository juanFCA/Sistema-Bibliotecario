<?php
use Hamcrest\Type\IsArray;

require_once "view/template.php";
require_once "dao/livroDAO.php";
require_once "modelo/livro.php";
require_once "db/conexao.php";
require_once "modelo/categoria.php";
require_once "dao/categoriaDAO.php";
require_once "modelo/editora.php";
require_once "dao/editoraDAO.php";
require_once "modelo/autor.php";
require_once "dao/autorDAO.php";
require_once "dao/autoriaDAO.php";
require_once "modelo/usuario.php";

$livroDAO = new livroDAO();
$autoriaDAO = new autoriaDAO();
$autorDAO = new autorDAO();
$categoriaDAO = new categoriaDAO();
$editoraDAO = new editoraDAO();

template::header();
template::sidebar("livros");
template::mainpanel("Livros");

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $upload_directory='uploads/livros/';
    $file = $_FILES["upload"];
    $ext = substr($file['name'], strrpos($file['name'], '.') + 1);
    $path=md5(microtime()).'.'.$ext;
    if (isset($_POST['MAX_FILE_SIZE'])){
        // Move o arquivo da pasta temporaria de upload para a pasta de destino
        if (move_uploaded_file($file["tmp_name"], $upload_directory.$path)) {
            $msg3 = "<script> notificacao('pe-7s-info', 'Livro', 'Upload de Arquivo Realizado com Êxito', 'success'); </script>";
        } else {
            $msg3 = "<script> notificacao('pe-7s-info', 'Livro', 'Falha ao tentar realizar Upload de Arquivo', 'danger'); </script>";
        }
    }
    $livro = new livro("",
                        $_POST["titulo"],
                        $_POST["isbn"],
                        $_POST["edicao"],
                        $_POST["ano"],
                       "$upload_directory"."$path",
                        $_POST["editora"],
                        $_POST["categoria"]);
    if(isset($_POST["id"])){
        $livro->setIdtbLivro($_POST["id"]);
    } 
    
    $autoresPost = $_POST["autores"];
    $msg = $livroDAO->salvarAtualizar($livro);
    $idLivro = ($livro->getIdtbLivro()!="") ? $livro->getIdtbLivro() : $livroDAO->ultimoIdInserido();
    $autoresBD = $autoriaDAO->buscarAutores($idLivro);
    
    if(is_array($autoresBD)) {
        $adicionados = array_diff($autoresPost, $autoresBD);
        $removidos = array_diff($autoresBD, $autoresPost);
    } else {
        $adicionados = $removidos = null;   
    }

    $msg1 = ($removidos != null) ? $autoriaDAO->remover($idLivro, $removidos) : null;
    $msg2 = ($adicionados != null) ? $autoriaDAO->salvar($idLivro, $adicionados) : $autoriaDAO->salvar($idLivro, $autoresPost);
    unset($livro);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $livro = $livroDAO->buscarLivro($id);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $livro = $livroDAO->buscarLivro($id);
    $autoresAutoria = $autoriaDAO->buscarAutores($id);
    $msg1 = $autoriaDAO->remover($id, $autoresAutoria);
    $msg = $livroDAO->remover($livro);
    unset($livro);
}
?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Dados do Livro</h4>
                    </div>
                    <div class='content'>
                        <form action="?act=save&id=" method="POST" enctype="multipart/form-data" name="form1">
                            <input type="hidden" name="id" value="<?php if(!empty($livro)) {echo $livro->getIdtbLivro();}?>" required/>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <Label>Título</Label>
                                        <input class="form-control" type="text" size="50" name="titulo" value="<?php if(!empty($livro)) {echo $livro->getTitulo();}?>" required/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <Label>ISBN</Label>
                                        <input class="form-control" type="text" size="50" name="isbn" value="<?php if(!empty($livro)) {echo $livro->getIsbn();}?>" required/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <Label>Edição</Label>
                                        <input class="form-control" type="text" size="50" name="edicao" value="<?php if(!empty($livro)) {echo $livro->getEdicao();}?>" required/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <Label>Ano</Label>
                                        <input class="form-control" type="number" size="4" min="0000" max="9999" name="ano" value="<?php if(!empty($livro)) {echo $livro->getAno();}?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Editora</label>
                                        <select id="editora" name="editora" class="form-control" required>
                                            <option value="" selected disabled hidden >Selecione a Editora</option>
                                            <?php
                                            $editoras = $editoraDAO->buscarTodos();
                                            foreach($editoras as $editora){
                                                if( !empty($livro) && $editora->getIdtbEditora() == $livro->getTbEditoraIdtbEditora()){
                                                    ?>
                                                    <option value="<?php echo $editora->getIdtbEditora() ?>" selected><?php echo $editora->getNomeEditora()?></option>
                                                    <?php
                                                }else{ ?>
                                                    <option value="<?php echo $editora->getIdtbEditora() ?>"><?php echo $editora->getNomeEditora()?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Categoria</label>
                                        <select id="categoria" name="categoria" class="form-control" required>
                                            <option value="" selected disabled hidden >Selecione a Categoria</option>
                                            <?php
                                            $categorias = $categoriaDAO->buscarTodos();
                                            foreach($categorias as $categoria){
                                                if(!empty($livro) && $categoria->getIdtbCategoria() == $livro->getTbCategoriaIdtbCategoria()){
                                                    ?>
                                                    <option value="<?php echo $categoria->getIdtbCategoria() ?>" selected><?php echo $categoria->getNomeCategoria()?></option>
                                                    <?php
                                                }else{ ?>
                                                    <option value="<?php echo $categoria->getIdtbCategoria() ?>"><?php echo $categoria->getNomeCategoria()?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Autor(es)</label>
                                        <select id="autores" name="autores[]" class="form-control" aria-multiselectable="true" multiple required>
                                            <?php
                                            $autores = $autorDAO->buscarTodos();
                                            if(!empty($livro)) {
                                                $autoria = $autoriaDAO->buscarAutores($livro->getIdtbLivro());
                                            }
                                            foreach($autores as $autor){
                                                if(!empty($livro)){
                                                    ?>
                                                    <option value="<?php echo $autor->getIdtbAutor()?>"<?php if (in_array($autor->getIdtbAutor(), $autoria)) { echo "selected"; }?>>
                                                        <?php echo $autor->getNomeAutor()?></option>
                                                    <?php
                                                }else{ ?>
                                                    <option value="<?php echo $autor->getIdtbAutor() ?>"><?php echo $autor->getNomeAutor()?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                                        <Label>Upload de Arquivo Digital</Label>
                                        <input type="file" name="upload" value="<?php if(isset($livro) && $livro != null) {echo $livro->getUpload();}?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="form-group">
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
            $livroDAO->tabelapaginada();
        ?>
    </div>
</div>

<?php
template::footer("Livros");
echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
echo (isset($msg1) && ($msg1 != null || $msg1 != "")) ? $msg1 : '';
echo (isset($msg2) && ($msg2 != null || $msg2 != "")) ? $msg2 : '';
echo (isset($msg3) && ($msg3 != null || $msg3 != "")) ? $msg3 : '';
?>
