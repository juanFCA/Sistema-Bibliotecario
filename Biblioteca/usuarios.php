<?php

require_once "view/template.php";
require_once "dao/usuarioDAO.php";
require_once "modelo/usuario.php";
require_once "db/conexao.php";

$usuarioDAO = new usuarioDAO();
$tipos = $usuarioDAO->tipos();

template::header();
template::sidebar("usuarios");
template::mainpanel("Usuários");

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $usuario = new usuario("",
        $_POST["nome"],
        $_POST["tipo"],
        $_POST["email"],
        "",
        0);
    if(isset($_POST["id"])){
        $usuario->setIdtbUsuario($_POST["id"]);
    }
    if(isset($_POST["senha"])){
        $usuario->setSenha(md5($_POST["senha"]));
    }
    $msg = $usuarioDAO->salvarAtualizar($usuario);
    unset($usuario);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $usuario = $usuarioDAO->buscarUsuario($id);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $_REQUEST["id"]) {
    $id = $_REQUEST["id"];
    $usuario = $usuarioDAO->buscarUsuario($id);
    $msg = $usuarioDAO->remover($usuario);
    unset($usuario);
}
?>

    <div class='content' xmlns="http://www.w3.org/1999/html">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='card'>
                        <div class='header'>
                            <h4 class='title'>Dados do Usuário</h4>
                        </div>
                        <div class='content table-responsive'>
                            <form action="?act=save&id=" method="POST" name="form1">
                                <input type="hidden" name="id" value="<?php if(!empty($usuario)) {echo $usuario->getIdtbUsuario();}?>"/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <Label>Nome</Label>
                                            <input class="form-control" type="text" size="50" name="nome" value="<?php if(!empty($usuario)) {echo $usuario->getNomeUsuario();}?>" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <Label>E-mail</Label>
                                            <input class="form-control" type="email" name="email" value="<?php if(!empty($usuario)) {echo $usuario->getEmail();}?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <Label>Tipo</Label>
                                            <select class="form-control" name="tipo" required>
                                                <option value="" selected disabled hidden >Selecione o Tipo</option>
                                                <?php for ($i = 1; $i <= sizeof($tipos); $i++) {?>
                                                <option value=" <?=$i?>" <?php if(!empty($usuario)) {echo ($usuario->getTipo() == $i) ? 'selected':'';}?>><?php echo $tipos[$i] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <?php if(empty($usuario)) { ?>
                                                <Label>Senha</Label>
                                                <input class="form-control" type="password" size="20" name="senha" value="" required/>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-right">
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
                $usuarioDAO->tabelapaginada();
            ?>
        </div>
    </div>

<?php
template::footer("Usuários");
echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
?>