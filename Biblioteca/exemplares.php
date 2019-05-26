<?php

require_once "view/template.php";
require_once "db/conexao.php";
require_once "dao/exemplarDAO.php";
require_once "modelo/exemplar.php";
require_once "dao/livroDAO.php";
require_once "modelo/livro.php";

$exemplarDAO = new exemplarDAO();
$livroDAO = new livroDAO();

$tipos =$exemplarDAO->tipos();

template::header();
template::sidebar("exemplares");
template::mainpanel("Exemplares");

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $exemplar = new exemplar("",
        $_POST["livro"],
        $_POST["tipo"]);
    if(isset($_POST["id"])){
        $exemplar->setIdtbExemplar($_POST["id"]);
    }
    $msg = $exemplarDAO->salvarAtualizar($exemplar);
    unset($exemplar);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $exemplar = $exemplarDAO->buscarExemplar($id);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $exemplar = $exemplarDAO->buscarExemplar($id);
    $msg = $exemplarDAO->remover($exemplar);
    unset($exemplar);
}
?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Exemplares</h4>
                        </div>
                        <div class='content table-responsive'>
                            <form action="?act=save&id=" method="POST" name="form1">

                                <input type="hidden" name="id" value="<?php if(!empty($exemplar)) {echo $exemplar->getIdtbExemplar();}?>"/>
                                <Label>Livro</Label>
                                <select name="livro" class="form-control">
                                    <option value="" selected disabled hidden >Selecione o Livro</option>
                                    <?php
                                    $livros = $livroDAO->buscarTodos();
                                    foreach($livros as $livro){
                                        if(!empty($exemplar) && $exemplar->getTbLivroIdtbLivro()== $livro->getIdtbLivro()){
                                            ?>
                                            <option value="<?php echo $livro->getIdtbLivro() ?>" selected><?php echo $livro->getTitulo()?></option>
                                            <?php
                                        }else{ ?>
                                            <option value="<?php echo $livro->getIdtbLivro() ?>"><?php echo $livro->getTitulo()?></option>
                                        <?php }} ?>
                                </select>
                                <br/>
                                <label>Tipo</label>
                                <div class="form-group">
                                    <select class="form-control" name="tipo" required>
                                        <option value="" selected disabled hidden >Selecione o Tipo</option>
                                        <option value="1" <?php if(!empty($exemplar)) {echo ($exemplar->getTipoExemplar() == 1) ? 'selected':'';}?>><?php echo $tipos[1] ?></option>
                                        <option value="2" <?php if(!empty($exemplar)) {echo ($exemplar->getTipoExemplar() == 2) ? 'selected':'';}?>><?php echo $tipos[2] ?></option>
                                    </select>
                                </div>
                                <input class="btn btn-success" type="submit" value="REGISTRAR">
                            </form>
                            <?php
                                echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                //chamada a paginação
                $exemplarDAO->tabelapaginada();
            ?>
        </div>
    </div>

<?php
template::footer("Exemplares");
?>
