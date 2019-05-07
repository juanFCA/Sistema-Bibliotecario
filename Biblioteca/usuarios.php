<?php

require_once "view/template.php";
require_once "dao/usuarioDAO.php";
require_once "modelo/usuario.php";
require_once "db/conexao.php";

$object = new usuarioDAO();
$tipos = $object->tipos();

template::header();
template::sidebar("usuarios");
template::mainpanel();

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $usuario = new usuario("",
        $_POST["nome"],
        $_POST["tipo"],
        $_POST["email"],
        md5($_POST["senha"]));
    if(isset($_POST["id"])){
        $usuario->setIdtbUsuario($_POST["id"]);
    }
    $msg = $object->salvarAtualizar($usuario);
    unset($usuario);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $usuario = $object->buscarUsuario($id);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $usuario = $object->buscarUsuario($id);
    $msg = $object->remover($usuario);
    unset($usuario);
}
?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Usuários</h4>
                            <p class='category'>Lista de Usuários do Sistema</p>

                        </div>
                        <div class='content table-responsive'>
                            <form action="?act=save&id=" method="POST" name="form1">

                                <input type="hidden" name="id" value="<?php if(!empty($usuario)) {echo $usuario->getIdtbUsuario();}?>"/>
                                <Label>Nome</Label>
                                <input class="form-control" type="text" size="50" name="nome" value="<?php if(!empty($usuario)) {echo $usuario->getNomeUsuario();}?>" required/>
                                <br/>
                                <Label>Tipo</Label>
                                <div class="form-group">
                                    <select class="form-control" name="tipo" required>
                                        <option value="" selected disabled hidden >Selecione o Tipo</option>
                                        <option value="1" <?php if(!empty($usuario)) {echo ($usuario->getTipo() == 1) ? 'selected':'';}?>><?php echo $tipos[1] ?></option>
                                        <option value="2" <?php if(!empty($usuario)) {echo ($usuario->getTipo() == 2) ? 'selected':'';}?>><?php echo $tipos[2] ?></option>
                                        <option value="3" <?php if(!empty($usuario)) {echo ($usuario->getTipo() == 3) ? 'selected':'';}?>><?php echo $tipos[3] ?></option>
                                        <option value="4" <?php if(!empty($usuario)) {echo ($usuario->getTipo() == 4) ? 'selected':'';}?>><?php echo $tipos[4] ?></option>
                                    </select>
                                </div>
                                <br/>
                                <Label>Email</Label>
                                <input class="form-control" type="text" size="100" name="email" value="<?php if(!empty($usuario)) {echo $usuario->getEmail();}?>" required/>
                                <br/>
                                <Label>Senha</Label>
                                <input class="form-control" type="password" size="20" name="senha" value="<?php if(!empty($usuario)) {echo $usuario->getSenha();}?>" required/>
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