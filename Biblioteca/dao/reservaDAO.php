<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 12/06/19
 * Time: 22:28
 */

require_once "db/conexao.php";
require_once "modelo/reserva.php";
require_once "usuarioDAO.php";
require_once "emprestimoDAO.php";

class reservaDAO
{
    public function situacao() {
        return array( 1 => 'EM ABERTO',
            2 => 'FINALIZADO',
            3 => 'CANCELADO');
    }

    public function salvar(reserva $reserva)
    {
        try {
            $statement = conexao::getInstance()->prepare("INSERT INTO tb_reserva(tb_usuario_idtb_usuario, 
                                                                                    tb_exemplar_idtb_exemplar, 
                                                                                    dataReserva, 
                                                                                    observacoes,
                                                                                    situacao) 
                                                                             VALUES (:idUsuario,
                                                                                     :idExemplar,
                                                                                     :dataReserva, 
                                                                                     :observacoes,
                                                                                     :situacao)");

            $statement->bindValue(":idUsuario", $reserva->getTbUsuarioIdtbUsuario());
            $statement->bindValue(":idExemplar", $reserva->getTbExemplarIdtbExemplar());
            $statement->bindValue(":dataReserva", $reserva->getDataReserva());
            $statement->bindValue(":observacoes", $reserva->getObservacoes());
            $statement->bindValue(":situacao", $reserva->getSituacao());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> notificacao('pe-7s-info', 'Reserva', 'Registro foi inserido com êxito', 'success'); </script>";
                } else {
                    return "<script> notificacao('pe-7s-info', 'Reserva', 'Falha ao tentar inserir o Registro', 'danger'); </script>";
                }
            } else {
                throw new PDOException("<script> notificacao('pe-7s-info', 'Reserva', 'Não foi possível executar a declaração SQL!', 'danger'); </script>");
            }
        } catch (PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function cancelar(reserva $reserva)
    {
        try {
            $statement = conexao::getInstance()->prepare("UPDATE tb_reserva SET situacao=:situacao
                                                                                    WHERE idtb_reserva=:id
                                                                                      AND tb_usuario_idtb_usuario=:idUsuario 
                                                                                      AND tb_exemplar_idtb_exemplar=:idExemplar");

            $statement->bindValue(":id", $reserva->getIdtbReserva());
            $statement->bindValue(":idUsuario", $reserva->getTbUsuarioIdtbUsuario());
            $statement->bindValue(":idExemplar", $reserva->getTbExemplarIdtbExemplar());
            $statement->bindValue(":situacao", $reserva->getSituacao());
            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> notificacao('pe-7s-info', 'Reserva', 'Registro foi cancelado com êxito', 'success'); </script>";
                } else {
                    return "<script> notificacao('pe-7s-info', 'Reserva', 'Falha ao tentar cancelar o Registro', 'danger'); </script>";
                }
            } else {
                throw new PDOException("<script> notificacao('pe-7s-info', 'Reserva', 'Não foi possível executar a declaração SQL!', 'danger'); </script>");
            }
        } catch (PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function emprestar(reserva $reserva, $dias) {
        try {
            $statement = conexao::getInstance()->prepare("UPDATE tb_reserva SET situacao=:situacao
                                                                                    WHERE idtb_reserva=:id
                                                                                      AND tb_usuario_idtb_usuario=:idUsuario 
                                                                                      AND tb_exemplar_idtb_exemplar=:idExemplar;
                                                                                      
                                                                    INSERT INTO tb_emprestimo(tb_usuario_idtb_usuario, 
                                                                                    tb_exemplar_idtb_exemplar, 
                                                                                    dataEmprestimo, 
                                                                                    observacoes,
                                                                                    dataVencimento,
                                                                                    dataDevolucao,
                                                                                    situacao) 
                                                                             VALUES (:idUsuario,
                                                                                     :idExemplar,
                                                                                     NOW(), 
                                                                                     :observacoes,
                                                                                     NOW() + INTERVAL :dias DAY,
                                                                                     null ,
                                                                                     1);");

            $statement->bindValue(":id", $reserva->getIdtbReserva());
            $statement->bindValue(":idUsuario", $reserva->getTbUsuarioIdtbUsuario());
            $statement->bindValue(":idExemplar", $reserva->getTbExemplarIdtbExemplar());
            $statement->bindValue(":observacoes", $reserva->getObservacoes());
            $statement->bindValue(":situacao", $reserva->getSituacao());
            $statement->bindValue(":dias", $dias);
            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> notificacao('pe-7s-info', 'Reserva', 'Registro foi emprestado com êxito', 'success'); </script>";
                } else {
                    return "<script> notificacao('pe-7s-info', 'Reserva', 'Falha ao tentar emprestar o Registro', 'danger'); </script>";
                }
            } else {
                throw new PDOException("<script> notificacao('pe-7s-info', 'Reserva', 'Não foi possível executar a declaração SQL!', 'danger'); </script>");
            }
        } catch (PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function tabelapaginada()
    {
        //carrega o banco

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 2);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual - 1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "SELECT u.nomeUsuario AS usuario, 
                       l.titulo AS livro, 
                       r.dataReserva AS dataReserva, 
                       r.observacoes AS observacoes,
                       r.situacao AS situacao,
                       r.tb_usuario_idtb_usuario AS idUsuario,
                       r.tb_exemplar_idtb_exemplar AS idExemplar,
                       r.idtb_reserva AS id
                   FROM tb_reserva r
             INNER JOIN tb_usuario u 
                     ON r.tb_usuario_idtb_usuario = u.idtb_usuario
             INNER JOIN tb_exemplar ex
                     ON r.tb_exemplar_idtb_exemplar = ex.idtb_exemplar
             INNER JOIN tb_livro l
                     ON ex.tb_livro_idtb_livro = l.idtb_livro
               ORDER BY r.dataReserva DESC
                 LIMIT {$linha_inicial}," . QTDE_REGISTROS;

        $statement = conexao::getInstance()->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_reserva";
        $statement = conexao::getInstance()->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 : 0;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 : 0;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;

        /* Cálcula qual será a página final do nosso range */
        $range_final = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? '' : 'disabled';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? '' : 'disabled';

        if (!empty($dados)):
            echo "<div class='row'>
                 <div class='col-md-12'>
                 <div class='card'>
                 <div class='header'>
                    <p class='category'>Lista de Reservas do Sistema</p>
                 </div>
                 <div class='content table-responsive table-full-width'>
                 <table class='table table-hover table-striped'>
             <table class='table table-hover table-striped'>
             <thead>
               <tr style='text-transform: uppercase;' class='active'>
                <th>ID</th>
                <th>Usuário</th>
                <th>Livro</th>
                <th>Data Reserva</th>
                <th>Situação</th>   
                <th>Observações</th>
                <th class='col-xs-1 col-sm-1 col-md-1 col-lg-1' colspan='2'>Ações</th>
               </tr>
             </thead>
             <tbody>";
            foreach ($dados as $acti):
                echo "<tr>
                    <td>$acti->id</td>
                    <td>$acti->usuario</td>
                    <td>$acti->livro</td>
                    <td>$acti->dataReserva</td>
                    <td>" . $this->situacao()[$acti->situacao] . "</td>
                    <td>$acti->observacoes</td>";
                echo ($acti->situacao == 1) ? '<td><a href="?act=upd&id='.$acti->id.'&idUsuario='.$acti->idUsuario.'&idExemplar='.$acti->idExemplar.'&observacoes='.$acti->observacoes.'" title="Realizar Emprestimo"><i class="pe-7s-refresh text-warning"></i></a></td>' : '<td></td>';
                echo ($acti->situacao == 1) ? '<td><a href="?act=del&id='.$acti->id.'&idUsuario='.$acti->idUsuario.'&idExemplar='.$acti->idExemplar.'" title="Cancelar Reserva"><i class="pe-7s-trash text-danger"></i></a></td>' : '<td></td>';
                echo "</tr>";
            endforeach;
            echo "
             </tbody>
             </table>
             <nav class='text-center'>
                <ul class='pagination' style='text-align: center'>
                    <li class='page-item  $exibir_botao_inicio' ><a class='page-link pe-7s-prev $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'></a></li>
                    <li class='page-item  $exibir_botao_inicio' ><a class='page-link pe-7s-left-arrow $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'></a></li>
             ";
            /* Loop para montar a páginação central com os números */
            for ($i = $range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'active' : '';
                echo "<li class='page-item $destaque' ><a class='page-link' href='$endereco?page=$i'> $i </a></li>";
            endfor;
            echo "<li class='page-item $exibir_botao_final' ><a  class='page-link pe-7s-right-arrow $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'></a></li>
                  <li class='page-item $exibir_botao_final' ><a  class='page-link pe-7s-next $exibir_botao_final' href='$endereco?page=$ultima_pagina'  title='Última Página'></a></li>
                </ul>
             <nav/>";
        else:
            echo "<div class='alert alert-danger text-center' role='alert'>Nenhum registro foi encontrado!</div>
                </div>
                </div>
                </div>
                </div>";
        endif;
    }

}

?>