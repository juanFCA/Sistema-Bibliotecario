<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 18/03/19
 * Time: 15:28
 */

require_once "db/conexao.php";
require_once "modelo/editora.php";

class editoraDAO
{

    public function remover($editora)
    {
        try {
            $statement = Conexao::getInstance()->prepare("DELETE FROM tb_editora WHERE idtb_editora=:id");
            $statement->bindValue(":id", $editora->getIdtbEditora());
            if ($statement->execute()) {
                return "<script> alert('Registro foi excluído com êxito!'); </script>";
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar($editora)
    {
        try {
            if ($editora->getIdtbEditora() != "") {
                $statement = Conexao::getInstance()->prepare("UPDATE tb_editora SET nomeEditora=:nomeEditora WHERE idtb_editora=:id");
                $statement->bindValue(":id", $editora->getIdtbEditora());
            } else {
                $statement = Conexao::getInstance()->prepare("INSERT INTO tb_editora(nomeEditora) VALUES (:nomeEditora)");
            }
            $statement->bindValue(":nomeEditora", $editora->getNomeEditora());

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

    public function atualizar($editora)
    {
        try {
            $statement = Conexao::getInstance()->prepare("SELECT idtb_editora, nomeEditora FROM tb_editora WHERE idtb_editora=:id");
            $statement->bindValue(":id", $editora->getIdtbEditora());

            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $editora->setIdtbEditora($rs->idtb_editora);
                $editora->setNomeEditora($rs->nomeEditora);
                return $editora;
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
        $sql = "SELECT idtb_editora, nomeEditora FROM tb_editora LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = Conexao::getInstance()->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_editora";
        $statement = Conexao::getInstance()->prepare($sqlContador);
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
                <th style='text-align: center; font-weight: bolder;'>Nome</th>
                <th style='text-align: center; font-weight: bolder;' colspan='2'>Ações</th>
               </tr>
             </thead>
             <tbody>";
            foreach ($dados as $acti):
                echo "<tr>
                    <td style='text-align: center'>$acti->idtb_editora</td>
                    <td style='text-align: center'>$acti->nomeEditora</td>
                    <td style='text-align: center'><a href='?act=upd&id=$acti->idtb_editora' title='Alterar'><i class='ti-reload'></i></a></td>
                    <td style='text-align: center'><a href='?act=del&id=$acti->idtb_editora' title='Remover'><i class='ti-close'></i></a></td>
                   </tr>";
            endforeach;
            echo "
             </tbody>
             </table>
                <nav>
                <ul class='pagination justify-content-center' style='text-align: center'>
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