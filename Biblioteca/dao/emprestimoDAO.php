<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 18/03/19
 * Time: 15:28
 */

require_once "db/conexao.php";
require_once "modelo/emprestimo.php";

class emprestimoDAO
{

    public function remover(emprestimo $emprestimo)
    {
        try {
            $statement = conexao::getInstance()->prepare("DELETE FROM tb_emprestimo WHERE tb_usuario_idtb_usuario=:idUsuario AND tb_exemplar_idtb_exemplar=:idExemplar");
            $statement->bindValue(":idUsuario", $emprestimo->getTbUsuarioIdtbUsuario());
            $statement->bindValue(":idExemplar", $emprestimo->getTbExemplarIdtbExemplar());
            if ($statement->execute()) {
                return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Registro foi removido com êxito', 'success'); </script>";                
            } else {
                return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Falha ao tentar remover o Registro', 'danger'); </script>";              
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar(emprestimo $emprestimo)
    {
        try {
            if ($emprestimo->getTbUsuarioIdtbUsuario() != "" or $emprestimo->getTbExemplarIdtbExemplar() != "") {
                $statement = conexao::getInstance()->prepare("UPDATE tb_emprestimo SET dataEmprestimo=:dataEmprestimo, observacoes=:observacoes WHERE tb_usuario_idtb_usuario=:idUsuario AND tb_exemplar_idtb_exemplar=:idExemplar");
                $statement->bindValue(":idUsuario", $emprestimo->getTbUsuarioIdtbUsuario());
                $statement->bindValue(":idExemplar", $emprestimo->getTbExemplarIdtbExemplar());
            } else {
                $statement = conexao::getInstance()->prepare("INSERT INTO tb_emprestimo(dataEmprestimo, observacoes) VALUES (:dataEnprestimo, :observacoes)");
            }
            $statement->bindValue(":dataEmprestimo", $emprestimo->getDataEmprestimo());
            $statement->bindValue(":observacoes", $emprestimo->getObservacoes());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Registro foi inserido com êxito', 'success'); </script>";
                } else {
                    return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Falha ao tentar inserir o Registro', 'danger'); </script>";                
                }
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL!'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " .$erro->getMessage();
        }
    }

    public function atualizar(emprestimo $emprestimo)
    {
        try {
            $statement = conexao::getInstance()->prepare("SELECT tb_usuario_idtb_usuario, tb_exemplar_idtb_exemplar, dataEmprestimo, observacoes FROM tb_emprestimo WHERE tb_usuario_idtb_usuario=:idUsuario AND tb_exemplar_idtb_exemplar=:idExemplar");
            $statement->bindValue(":idUsuario", $emprestimo->getTbUsuarioIdtbUsuario());
            $statement->bindValue(":idExemplar", $emprestimo->getTbExemplarIdtbExemplar());

            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $emprestimo->setTbUsuarioIdtbUsuario($rs->tb_usuario_idtb_usuario);
                $emprestimo->setTbExemplarIdtbExemplar($rs->tb_exemplar_idtb_exemplar);
                $emprestimo->setDataEmprestimo($rs->dataEmprestimo);
                $emprestimo->setObservacoes($rs->observacoes);
                return $emprestimo;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
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
        $sql = "SELECT tb_usuario_idtb_usuario, tb_exemplar_idtb_exemplar, dataEmprestimo, observacoes FROM tb_emprestimo LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = conexao::getInstance()->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_emprestimo";
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
            echo "<div class='content table-responsive table-full-width'>
             <table class='table table-hover table-striped'>
             <thead>
               <tr style='text-transform: uppercase;' class='active'>
                <th>ID Usuario</th>
                <th>ID Exemplar</th>
                <th>Data Emprestimo</th>
                <th>Observações</th>
                <th class='col-xs-1 col-sm-1 col-md-1 col-lg-1' colspan='2'>Ações</th>
               </tr>
             </thead>
             <tbody>";
            foreach ($dados as $acti):
                echo "<tr>
                    <td>$acti->tb_usuario_idtb_usuario</td>
                    <td>$acti->tb_exemplar_idtb_exemplar</td>
                    <td>$acti->dataEmprestimo</td>
                    <td>$acti->observacoes</td>
                    <td><a href='?act=upd&id=$acti->id_action' title='Alterar'><i class='pe-7s-refresh'></i></a></td>
                    <td><a href='?act=del&id=$acti->id_action' title='Remover'><i class='pe-7s-trash'></i></a></td>
                   </tr>";
            endforeach;
            echo "
             </tbody>
             </table>
             <nav class='text-center'>
                <ul class='pagination' style='text-align: center'>
                    <li class='page-item  $exibir_botao_inicio' ><a class='page-link' href='$endereco?page=$primeira_pagina' title='Primeira Página'>First</a></li>
                    <li class='page-item  $exibir_botao_inicio' ><a class='page-link' href='$endereco?page=$pagina_anterior' title='Página Anterior'>Previous</a></li>
             ";
            /* Loop para montar a páginação central com os números */
            for ($i = $range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'active' : '';
                echo "<li class='page-item $destaque' ><a class='page-link' href='$endereco?page=$i'> $i </a></li>";
            endfor;
            echo "<li class='page-item $exibir_botao_final' ><a  class='page-link' href='$endereco?page=$proxima_pagina' title='Próxima Página'>Next</a></li>
                  <li class='page-item $exibir_botao_final' ><a  class='page-link' href='$endereco?page=$ultima_pagina'  title='Última Página'>Last</a></li>
                </ul>
             <nav/>";
        else:
            echo "<div class='alert alert-danger text-center' role='alert'>Nenhum registro foi encontrado!</div>";
        endif;
    }

}