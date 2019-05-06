<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 18/03/19
 * Time: 15:28
 */

require_once "db/conexao.php";
require_once "modelo/exemplar.php";

class exemplarDAO
{

    public function remover(exemplar $exemplar)
    {
        try {
            $statement = conexao::getInstance()->prepare("DELETE FROM tb_exemplar WHERE idtb_exemplar=:idExemplar AND tb_livro_idtb_livro=:idLivro");
            $statement->bindValue(":idExemplar", $exemplar->getIdtbExemplar());
            $statement->bindValue(":idLivro", $exemplar->getTbLivroIdtbLivro());
            if ($statement->execute()) {
                return "<script> alert('Registro foi excluído com êxito!'); </script>";
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar(exemplar $exemplar)
    {
        try {
            if ($exemplar->getIdtbExemplar() != "" or $exemplar->getTbLivroIdtbLivro() != "") {
                $statement = conexao::getInstance()->prepare("UPDATE tb_exemplar SET tipoExemplar=:tipoExemplar  WHERE idtb_exemplar=:idExemplar AND tb_livro_idtb_livro=:idLivro");
                $statement->bindValue(":idExemplar", $exemplar->getIdtbExemplar());
                $statement->bindValue(":idLivro", $exemplar->getTbLivroIdtbLivro());
            } else {
                $statement = conexao::getInstance()->prepare("INSERT INTO tb_exemplar(tipoExemplar) VALUES (:tipoExemplar)");
            }
            $statement->bindValue(":tipoExemplar", $exemplar->getTipoExemplar());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> alert('Dados cadastrados com sucesso!'); </script>";
                } else {
                    return "<script> alert('Erro ao tentar efetivar cadastro!'); </script>";
                }
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL!'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " .$erro->getMessage();
        }
    }

    public function atualizar(exemplar $exemplar)
    {
        try {
            $statement = conexao::getInstance()->prepare("SELECT idtb_exemplar, tb_livro_idtb_livro, tipoExemplar FROM tb_exemplar WHERE idtb_exemplar=:idExemplar AND tb_livro_idtb_livro=:idLivro");
            $statement->bindValue(":idExemplar", $exemplar->getIdtbExemplar());
            $statement->bindValue(":idLivro", $exemplar->getTbLivroIdtbLivro());

            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $exemplar->setIdtbExemplar($rs->idtb_exemplar);
                $exemplar->setTbLivroIdtbLivro($rs->tb_livro_idtb_livro);
                $exemplar->setTipoExemplar($rs->tipoExemplar);
                return $exemplar;
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
        $sql = "SELECT idtb_exemplar, tb_livro_idtb_livro, tipoExemplar FROM tb_exemplar LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = conexao::getInstance()->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_exemplar";
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
            echo "
             <table class='table table-striped table-bordered'>
             <thead>
               <tr style='text-transform: uppercase;' class='active'>
                <th style='text-align: center; font-weight: bolder;'>ID</th>
                <th style='text-align: center; font-weight: bolder;'>ID Livro</th>
                <th style='text-align: center; font-weight: bolder;'>Tipo</th>
                <th style='text-align: center; font-weight: bolder;' colspan='2'>Ações</th>
               </tr>
             </thead>
             <tbody>";
            foreach ($dados as $acti):
                echo "<tr>
                    <td style='text-align: center'>$acti->idtb_exemplar</td>
                    <td style='text-align: center'>$acti->tb_livro_idtb_livro</td>
                    <td style='text-align: center'>$acti->tipoExemplar</td>
                    <td style='text-align: center'><a href='?act=upd&id=$acti->id_action' title='Alterar'><i class='ti-reload'></i></a></td>
                    <td style='text-align: center'><a href='?act=del&id=$acti->id_action' title='Remover'><i class='ti-close'></i></a></td>
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