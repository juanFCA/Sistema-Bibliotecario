<?php

require_once "view/template.php";
require_once "db/conexao.php";
require_once "dao/emprestimoDAO.php";
require_once "modelo/emprestimo.php";
require_once "dao/usuarioDAO.php";
require_once "modelo/usuario.php";
require_once "dao/exemplarDAO.php";
require_once "modelo/exemplar.php";
require_once "dao/livroDAO.php";
require_once "modelo/livro.php";

$emprestimoDAO = new emprestimoDAO();
$usuarioDAO = new usuarioDAO();
$exemplarDAO = new exemplarDAO();
$livroDAO = new livroDAO();

template::header();
template::sidebar("reservas");
template::mainpanel("Reservas");

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save") {
    $emprestimo = new emprestimo($_POST["idUsuario"],
        $_POST["idExemplar"],
        $_POST["dataEmprestimo"],
        $_POST["observacoes"],
        null,
        null,
        $_POST["reserva"]
    );

    $usuario = $usuarioDAO->buscarUsuario($_POST['idUsuario']);

    if ($_POST["reserva"] == 0) {
        $date = new DateTime($_POST["dataEmprestimo"]);
        $interval = new DateInterval('P10D');
        if ($usuario->getTipo() == 4) {
            $interval = new DateInterval('P15D');
        }
        $date->add($interval);
        $emprestimo->setDataVencimento($date->format('Y-m-d'));
    }

    $msg = $emprestimoDAO->salvarAtualizar($emprestimo);
    unset($emprestimo);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $_REQUEST["id"] && $_REQUEST["idUsuario"] && $_REQUEST["idExemplar"]) {
    $emprestimo = new emprestimo($_GET["id"], $_GET["idUsuario"], $_GET["idExemplar"], null,null,null,null, 0);

    $dateNow = date('Y-m-d');
    $emprestimo->setDataEmprestimo($dateNow);
    $usuario = $usuarioDAO->buscarUsuario($_GET['idUsuario']);

    $date = new DateTime($dateNow);
    $interval = new DateInterval('P10D');
    if($usuario->getTipo() == 4) {
        $interval = new DateInterval('P15D');
    }
    $date->add($interval);

    $emprestimo->setDataVencimento($date->format('Y-m-d'));

    $msg = $emprestimoDAO->realizarEmprestimo($emprestimo);
    unset($emprestimo);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "emp" && $_REQUEST["idUsuario"] && $_REQUEST["idExemplar"]) {
    $emprestimo = new emprestimo($_GET["idUsuario"], $_GET["idExemplar"], "", "", "", "", "");
    $msg = $emprestimoDAO->devolverEmprestimo($emprestimo);
    unset($emprestimo);
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $_REQUEST["idUsuario"] && $_REQUEST["idExemplar"]) {
    $emprestimo = new emprestimo($_GET["idUsuario"], $_GET["idExemplar"], "", "", "", "", "");
    $msg = $emprestimoDAO->cancelarReserva($emprestimo);
    unset($emprestimo);
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Exemplar - Livro</label>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Usuário</label>
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Observações</label>
                                        <textarea style="resize: none" name="observacoes" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <Label>Data da Reserva</Label>
                                        <input type="date" class="form-control" name="dataEmprestimo">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Tipo</label><br>
                                        <label class="radio-inline">
                                            <input type="radio" name="reserva" value="0" checked> Emprestimo
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="reserva" value="1"> Reserva
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
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
        $emprestimoDAO->tabelapaginada();
        ?>
    </div>
</div>

<?php
template::footer("Emprestimos");
echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
?>
