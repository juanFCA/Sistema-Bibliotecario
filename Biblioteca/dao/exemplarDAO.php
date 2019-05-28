<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 18/03/19
 * Time: 15:28
 */

require_once "db/conexao.php";
require_once "modelo/exemplar.php";
require_once "dao/livroDAO.php";

class exemplarDAO
{

    public function tipos() {
        return array( 1 => 'Circular', 
                      2 => 'Não Circular');
    }

    public function remover(exemplar $exemplar)
    {
        try {
            $statement = conexao::getInstance()->prepare("DELETE FROM tb_exemplar WHERE idtb_exemplar=:idExemplar AND tb_livro_idtb_livro=:idLivro");
            $statement->bindValue(":idExemplar", $exemplar->getIdtbExemplar());
            $statement->bindValue(":idLivro", $exemplar->getTbLivroIdtbLivro());
            if ($statement->execute()) {
                return "<script> notificacao('pe-7s-info', 'Exemplar', 'Registro foi removido com êxito', 'success'); </script>";                
            } else {
                return "<script> notificacao('pe-7s-info', 'Exemplar', 'Falha ao tentar remover o Registro', 'danger'); </script>";              
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvarAtualizar(exemplar $exemplar)
    {
        try {
            if ($exemplar->getIdtbExemplar() != "") {
                $statement = conexao::getInstance()->prepare("UPDATE tb_exemplar SET tipoExemplar=:tipoExemplar, tb_livro_idtb_livro=:idLivro WHERE idtb_exemplar=:idExemplar");
                $statement->bindValue(":idExemplar", $exemplar->getIdtbExemplar());
                var_dump($exemplar);
            } else {
                $statement = conexao::getInstance()->prepare("INSERT INTO tb_exemplar(tipoExemplar, tb_livro_idtb_livro) VALUES (:tipoExemplar, :idLivro)");
            }
            $statement->bindValue(":idLivro", $exemplar->getTbLivroIdtbLivro());
            $statement->bindValue(":tipoExemplar", $exemplar->getTipoExemplar());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "<script> notificacao('pe-7s-info', 'Exemplar', 'Registro foi inserido com êxito', 'success'); </script>";
                } else {
                    return "<script> notificacao('pe-7s-info', 'Exemplar', 'Falha ao tentar inserir o Registro', 'danger'); </script>";                
                }
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL!'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " .$erro->getMessage();
        }
    }

    public function buscarExemplar($id)
    {
        try {
            $statement = conexao::getInstance()->prepare("SELECT idtb_exemplar, tb_livro_idtb_livro, tipoExemplar 
                                                            FROM tb_exemplar WHERE idtb_exemplar=:id");
            $statement->bindValue(":id", $id);
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $exemplar = new exemplar($rs->idtb_exemplar, $rs->tb_livro_idtb_livro, $rs->tipoExemplar);
                return $exemplar;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function buscarTodos(){
        try {
            $statement = conexao::getInstance()->prepare("SELECT * FROM tb_exemplar");
            if ($statement->execute()) {
                $exemplares = [];
                while($rs = $statement->fetch(PDO::FETCH_OBJ)) {
                    $exemplar = new exemplar($rs->idtb_exemplar, $rs->tb_livro_idtb_livro, $rs->tipoExemplar);
                    array_push($exemplares, $exemplar);
                }
                return $exemplares;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function totalExemplares() {
        try {
            $statement = conexao::getInstance()->prepare("SELECT COUNT(*) AS total FROM tb_exemplar");
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                return $rs->total;
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
        
        /* Verifica nome do livro */
        $livroDAO = new livroDAO();

        if (!empty($dados)):
            echo "<div class='row'>
                 <div class='col-md-12'>
                 <div class='card'>
                 <div class='header'>
                    <p class='category'>Lista de Exemplares do Sistema</p>
                 </div>
                 <div class='content table-responsive table-full-width'>
             <table class='table table-hover table-striped'>
             <thead>
               <tr style='text-transform: uppercase;'>
                <th>ID</th>
                <th>Livro</th>
                <th>Tipo</th>
                <th class='col-xs-1 col-sm-1 col-md-1 col-lg-1' colspan='2'>Ações</th>
               </tr>
             </thead>
             <tbody>";
            foreach ($dados as $acti):
                $livro = $livroDAO->buscarLivro($acti->tb_livro_idtb_livro);
                echo "<tr>
                    <td>$acti->idtb_exemplar</td>
                    <td>". $livro->getTitulo() ."</td>
                    <td>" . $this->tipos()[$acti->tipoExemplar] . "</td>
                    <td><a href='?act=upd&id=$acti->idtb_exemplar' title='Alterar'><i class='pe-7s-refresh'></i></a></td>
                    <td><a href='?act=del&id=$acti->idtb_exemplar' title='Remover'><i class='pe-7s-trash'></i></a></td>
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