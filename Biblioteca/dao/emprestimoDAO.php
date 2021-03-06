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
    public function situacao() {
        return array( 1 => 'EM ABERTO', 
                2 => 'FINALIZADO',
                3 => 'EM ATRASO');
    }

    public function salvar(emprestimo $emprestimo)
    {
        try {
            $statement = conexao::getInstance()->prepare("INSERT INTO tb_emprestimo(tb_usuario_idtb_usuario, 
                                                                                    tb_exemplar_idtb_exemplar, 
                                                                                    dataEmprestimo, 
                                                                                    observacoes,
                                                                                    dataVencimento,
                                                                                    dataDevolucao,
                                                                                    situacao) 
                                                                             VALUES (:idUsuario,
                                                                                     :idExemplar,
                                                                                     :dataEmprestimo, 
                                                                                     :observacoes,
                                                                                     :dataVencimento,
                                                                                     :dataDevolucao,
                                                                                     :situacao)");

            $statement->bindValue(":idUsuario", $emprestimo->getTbUsuarioIdtbUsuario());
            $statement->bindValue(":idExemplar", $emprestimo->getTbExemplarIdtbExemplar());
            $statement->bindValue(":dataEmprestimo", $emprestimo->getDataEmprestimo());
            $statement->bindValue(":observacoes", $emprestimo->getObservacoes());
            $statement->bindValue(":dataVencimento", $emprestimo->getDataVencimento());
            $statement->bindValue(":dataDevolucao", $emprestimo->getDataDevolucao());
            $statement->bindValue(":situacao", $emprestimo->getSituacao());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Registro foi inserido com êxito', 'success'); </script>";
                } else {
                    return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Falha ao tentar inserir o Registro', 'danger'); </script>";
                }
            } else {
                throw new PDOException("<script> notificacao('pe-7s-info', 'Emprestimo', 'Não foi possível executar a declaração SQL!', 'danger'); </script>");
            }
        } catch (PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function devolver(emprestimo $emprestimo) {
        try {
            $statement = Conexao::getInstance()->prepare("UPDATE tb_emprestimo SET dataDevolucao=NOW(),
                                                                                   situacao=:situacao
                                                                             WHERE idtb_emprestimo=:id
                                                                               AND tb_usuario_idtb_usuario=:idUsuario 
                                                                               AND tb_exemplar_idtb_exemplar=:idExemplar");
        
            $statement->bindValue(":id", $emprestimo->getIdtbEmprestimo());
            $statement->bindValue(":idUsuario", $emprestimo->getTbUsuarioIdtbUsuario());
            $statement->bindValue(":idExemplar", $emprestimo->getTbExemplarIdtbExemplar());
            $statement->bindValue(":situacao", $emprestimo->getSituacao());
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Devolução Realizada com Sucesso', 'success'); </script>";
                }else{
                    return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Falha ao tentar Realizar a Devolução', 'danger'); </script>";
                }
            }else{
                throw new PDOException("<script> notificacao('pe-7s-info', 'Emprestimo', 'Não foi possível executar a declaração SQL!', 'danger'); </script>");
            }
        } catch (PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function emAtraso(emprestimo $emprestimo) {
        try {
            $statement = Conexao::getInstance()->prepare("UPDATE tb_emprestimo SET situacao=:situacao
                                                                             WHERE idtb_emprestimo=:id
                                                                               AND tb_usuario_idtb_usuario=:idUsuario 
                                                                               AND tb_exemplar_idtb_exemplar=:idExemplar");

            $statement->bindValue(":id", $emprestimo->getIdtbEmprestimo());
            $statement->bindValue(":idUsuario", $emprestimo->getTbUsuarioIdtbUsuario());
            $statement->bindValue(":idExemplar", $emprestimo->getTbExemplarIdtbExemplar());
            $statement->bindValue(":situacao", $emprestimo->getSituacao());
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    return 1;
                }else{
                    return 0;
                }
            }else{
                throw new PDOException("<script> notificacao('pe-7s-info', 'Emprestimo', 'Não foi possível executar a declaração SQL!', 'danger'); </script>");
            }
        } catch (PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function consultaSituacaoTodos() {
        try {
            $acerto = 0;
            $statement = conexao::getInstance()->prepare("SELECT * FROM tb_emprestimo e 
                                                                            WHERE e.dataVencimento < NOW() 
                                                                              AND e.dataDevolucao IS null 
                                                                              AND e.situacao <> 3");
            if ($statement->execute()) {
                $emprestimos = [];
                while($rs = $statement->fetch(PDO::FETCH_OBJ)) {
                    $emprestimo = new emprestimo($rs->idtb_emprestimo, $rs->tb_usuario_idtb_usuario, $rs->tb_exemplar_idtb_exemplar,
                        $rs->dataEmprestimo, $rs->observacoes, $rs->dataVencimento, $rs->dataDevolucao, $rs->situacao);
                    $emprestimo->setSituacao(3);
                    array_push($emprestimos, $emprestimo);
                }
                foreach ($emprestimos as $objeto) {
                    $acerto += $this->emAtraso($objeto);
                }
                if (count($emprestimos) == $acerto) {
                    return "<script> notificacao('pe-7s-info', 'Emprestimos', 'Situações Atualizadas', 'success'); </script>";
                } else {
                    return "<script> notificacao('pe-7s-info', 'Emprestimos', 'Falha ao tentar atualizar Situações', 'danger'); </script>";
                }
            } else {
                throw new PDOException("<script> notificacao('pe-7s-info', 'Emprestimo', 'Não foi possível executar a declaração SQL!', 'danger'); </script>");
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
                       em.dataEmprestimo AS dataEmprestimo, 
                       em.dataDevolucao AS dataDevolucao,
                       em.observacoes AS observacoes,
                       em.dataVencimento AS dataVencimento,
                       em.situacao AS situacao,
                       em.tb_usuario_idtb_usuario AS idUsuario,
                       em.tb_exemplar_idtb_exemplar AS idExemplar,
                       em.idtb_emprestimo AS id
                   FROM tb_emprestimo em
             INNER JOIN tb_usuario u 
                     ON em.tb_usuario_idtb_usuario = u.idtb_usuario
             INNER JOIN tb_exemplar ex
                     ON em.tb_exemplar_idtb_exemplar = ex.idtb_exemplar
             INNER JOIN tb_livro l
                     ON ex.tb_livro_idtb_livro = l.idtb_livro
               ORDER BY em.dataEmprestimo DESC
                 LIMIT {$linha_inicial}," . QTDE_REGISTROS;

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
            echo "<div class='row'>
                 <div class='col-md-12'>
                 <div class='card'>
                 <div class='header'>
                    <p class='category'>Lista de Emprestimos do Sistema</p>
                 </div>
                 <div class='content table-responsive table-full-width'>
                 <table class='table table-hover table-striped'>
             <table class='table table-hover table-striped'>
             <thead>
               <tr style='text-transform: uppercase;' class='active'>
                <th>ID</th>
                <th>Usuário</th>
                <th>Livro</th>
                <th>Data Emprestimo</th>
                <th>Data Vencimento</th>
                <th>Data Devolução</th> 
                <th>Situação</th>   
                <th>Observações</th>
                <th>Ação</th>
               </tr>
             </thead>
             <tbody>";
            foreach ($dados as $acti):
                echo "<tr>
                    <td>$acti->id</td>
                    <td>$acti->usuario</td>
                    <td>$acti->livro</td>
                    <td>$acti->dataEmprestimo</td>
                    <td>$acti->dataVencimento</td>
                    <td>$acti->dataDevolucao</td>
                    <td>" . $this->situacao()[$acti->situacao] . "</td>
                    <td>$acti->observacoes</td>";
                    echo ($acti->situacao == 1 || $acti->situacao == 3) ? 
                    '<td class="text-center"><a href="?act=upd&id='.$acti->id.'&idUsuario='.$acti->idUsuario.'&idExemplar='.$acti->idExemplar.'" title="Devolver Emprestimo"><i class="pe-7s-refresh text-warning"></i></a></td>'
                    :'<td></td>';
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