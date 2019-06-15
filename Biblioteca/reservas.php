<?php

require_once "view/template.php";
require_once "db/conexao.php";
require_once "dao/reservaDAO.php";
require_once "modelo/reserva.php";
require_once "dao/usuarioDAO.php";
require_once "modelo/usuario.php";
require_once "dao/exemplarDAO.php";
require_once "modelo/exemplar.php";
require_once "dao/livroDAO.php";
require_once "modelo/livro.php";

$reservaDAO = new reservaDAO();
$usuarioDAO = new usuarioDAO();
$exemplarDAO = new exemplarDAO();
$livroDAO = new livroDAO();

template::header();
template::sidebar("reservas");
template::mainpanel("Reservas");

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $reserva = new reserva("",
                            $_POST["idUsuario"],
                            $_POST["idExemplar"],
                            $_POST["dataReserva"],
                            $_POST["observacoes"],
                            1
    );
    $msg = $reservaDAO->salvar($reserva);
    unset($reserva);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && ($_REQUEST["id"] && $_REQUEST["idUsuario"] && $_REQUEST["idExemplar"])) {
    if ($_REQUEST["observacoes"]!="") {
        $reserva = new reserva($_GET["id"], $_GET["idUsuario"], $_GET["idExemplar"], null, $_GET["observacoes"], 2);
    } else {
        $reserva = new reserva($_GET["id"], $_GET["idUsuario"], $_GET["idExemplar"], null, "", 2);
    }

    $usuario = $usuarioDAO->buscarUsuario($_GET['idUsuario']);

    $dias = 10;
    if ($usuario->getTipo() == 4) {
        $dias = 15;
    }
    $msg = $reservaDAO->emprestar($reserva, $dias);
    unset($reserva, $dias, $usuario);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && ($_REQUEST["id"] && $_REQUEST["idUsuario"] && $_REQUEST["idExemplar"])) {
    $reserva = new reserva($_GET["id"], $_GET["idUsuario"], $_GET["idExemplar"], null, null, 3);
    $msg = $reservaDAO->cancelar($reserva);
    unset($reserva);
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Dados da Reserva</h4>
                    </div>
                    <div class='content table-responsive'>
                        <form action="?act=save&id=" method="POST" name="form1">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exemplar">Exemplar - Livro</label>
                                        <select id="exemplar" name="idExemplar" class="form-control" required>
                                            <option value="" selected disabled hidden >Selecione o Exemplar</option>
                                            <?php
                                            $exemplares = $exemplarDAO->buscarDisponiveisEmprestimo();
                                            foreach($exemplares as $exemplar){
                                                if( !empty($emprestimo) && $emprestimo->getTbExemplarIdtbExemplar() == $exemplar->getIdtbExemplar()){
                                                    ?>
                                                    <option value="<?php echo $exemplar->getIdtbExemplar() ?>" selected><?php echo $livroDAO->buscarLivro($exemplar->getTbLivroIdtbLivro())->getTitulo() ?></option>
                                                    <?php
                                                }else{ ?>
                                                    <option value="<?php echo $exemplar->getIdtbExemplar() ?>"><?php echo $livroDAO->buscarLivro($exemplar->getTbLivroIdtbLivro())->getTitulo() ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="usuario">Usuário</label>
                                        <select id="usuario" name="idUsuario" class="form-control" required>
                                            <option value="" selected disabled hidden >Selecione o Usuario</option>
                                            <?php
                                            $usuarios = $usuarioDAO->buscarTodos();
                                            foreach($usuarios as $usuario){
                                                if( !empty($emprestimo) && $emprestimo->getTbUsuarioIdtbUsuario() == $usuario->getIdtbUsuario()){
                                                    ?>
                                                    <option value="<?php echo $usuario->getIdtbUsuario() ?>" selected><?php echo $usuario->getNomeUsuario() ?></option>
                                                    <?php
                                                }else{ ?>
                                                    <option value="<?php echo $usuario->getIdtbUsuario() ?>"><?php echo $usuario->getNomeUsuario() ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <Label for="dataReserva">Data da Reserva</Label>
                                        <input id="dataReserva" type="date" class="form-control" name="dataReserva">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="observacoes">Observações</label>
                                        <textarea id="observacoes" style="resize: none" name="observacoes" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-2 text-right">
                                    <div class="form-group">
                                        <br><br><br>
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
        $reservaDAO->tabelapaginada();
        ?>
    </div>
</div>

<?php
template::footer("Emprestimos");
echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
?>
