<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 18/03/19
 * Time: 15:27
 */

require_once "db/conexao.php";
require_once "modelo/autor.php";

class autorDAO
{

    public function remover(autor $autor)
    {
        try {
            $statement = conexao::getInstance()->prepare("DELETE FROM tb_autor WHERE idtb_autor=:id");
            $statement->bindValue(":id", $autor->getIdtbAutor());
            if ($statement->execute()) {
                return "<script> notificacao('pe-7s-info', 'Autor', 'Registro foi removido com êxito', 'success'); </script>";
            } else {
                return "<script> notificacao('pe-7s-info', 'Autor', 'Falha ao tentar remover o Registro', 'danger'); </script>";              
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvarAtualizar(autor $autor)
    {
        try {
            if ($autor->getIdtbAutor() != "") {
                $statement = conexao::getInstance()->prepare("UPDATE tb_autor SET nomeAutor=:nomeAutor WHERE idtb_autor=:id");
                $statement->bindValue(":id", $autor->getIdtbAutor());
            } else {
                $statement = conexao::getInstance()->prepare("INSERT INTO tb_autor(nomeAutor) VALUES (:nomeAutor)");
            }
            $statement->bindValue(":nomeAutor", $autor->getNomeAutor());
            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> notificacao('pe-7s-info', 'Autor', 'Registro foi inserido com êxito', 'success'); </script>";
                } else {
                    return "<script> notificacao('pe-7s-info', 'Autor', 'Falha ao tentar inserir o Registro', 'danger'); </script>";                
                }
            } else {
                throw new PDOException("<script> notificacao('pe-7s-info', 'Autor', 'Falha ao tentar inserir o Registro', 'danger'); </script>");
            }
        } catch (PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function buscarAutor($id)
    {
        try {
            $statement = conexao::getInstance()->prepare("SELECT idtb_autor, nomeAutor FROM tb_autor WHERE idtb_autor=". $id);
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $autor = new autor($rs->idtb_autor, $rs->nomeAutor);
                return $autor;
            } else {
                throw new PDOException("<script> notificacao('pe-7s-info', 'Autor', 'Não foi possível executar a declaração SQL!', 'danger'); </script>");
            }
        } catch (PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function buscarTodos(){
        try {
            $statement = conexao::getInstance()->prepare("SELECT * FROM tb_autor");
            if ($statement->execute()) {
                $autores = [];
                while($rs = $statement->fetch(PDO::FETCH_OBJ)) {
                    $autor = new autor($rs->idtb_autor, $rs->nomeAutor);
                    array_push($autores, $autor);
                }
                return $autores;
            } else {
                throw new PDOException("<script> notificacao('pe-7s-info', 'Autor', 'Não foi possível executar a declaração SQL!', 'danger'); </script>");
            }
        } catch (PDOException $erro) {
            return $erro->getMessage();
        }
    }

    public function totalAutores() {
        try {
            $statement = conexao::getInstance()->prepare("SELECT COUNT(*) AS total FROM tb_autor");
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                return $rs->total;
            } else {
                throw new PDOException("<script> notificacao('pe-7s-info', 'Autor', 'Não foi possível executar a declaração SQL!', 'danger'); </script>");
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
        $sql = "SELECT idtb_autor, nomeAutor FROM tb_autor LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = conexao::getInstance()->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_autor";
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
                    <p class='category'>Lista de Autores do Sistema</p>
                 </div>
                 <div class='content table-responsive table-full-width'>
                 <table class='table table-hover table-striped'>
                 <thead>
                    <tr style='text-transform: uppercase;'>
                    <th>ID</th>
                    <th>Nome</th>
                    <th class='col-xs-1 col-sm-1 col-md-1 col-lg-1' colspan='2'>Ações</th>
                   </tr>
                 </thead>
                 <tbody>";
            foreach ($dados as $acti):
                echo "<tr>
                    <td>$acti->idtb_autor</td>
                    <td>$acti->nomeAutor</td>
                    <td><a href='?act=upd&id=$acti->idtb_autor' title='Alterar'><i class='pe-7s-refresh text-warning'></i></a></td>
                    <td><a href='?act=del&id=$acti->idtb_autor' title='Remover'><i class='pe-7s-trash text-danger'></i></a></td>
                   </tr>";
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
            echo "<li class='page-item $exibir_botao_final' ><a class='page-link pe-7s-right-arrow $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'></a></li>
                  <li class='page-item $exibir_botao_final' ><a class='page-link pe-7s-next $exibir_botao_final' href='$endereco?page=$ultima_pagina'  title='Última Página'></a></li>
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