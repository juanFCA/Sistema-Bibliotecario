<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 18/03/19
 * Time: 15:28
 */

require_once "db/conexao.php";
require_once "modelo/livro.php";
require_once "dao/editoraDAO.php";
require_once "dao/categoriaDAO.php";
require_once "dao/autoriaDAO.php";


class livroDAO
{
    public function remover(livro $livro)
    {
        try {
            $statement = conexao::getInstance()->prepare("DELETE FROM tb_livro WHERE idtb_livro=:id");
            $statement->bindValue(":id", $livro->getIdtbLivro());
            if ($statement->execute()) {
                return "<script> notificacao('pe-7s-info', 'Livro', 'Registro foi removido com êxito', 'success'); </script>";                
            } else {
                return "<script> notificacao('pe-7s-info', 'Livro', 'Falha ao tentar remover o Registro', 'danger'); </script>";              
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvarAtualizar(livro $livro)
    {
        try {
            if ($livro->getIdtbLivro() != "") {
                $statement = conexao::getInstance()->prepare("UPDATE tb_livro SET titulo=:titulo,
                                                                                            isbn=:isbn,
                                                                                            edicao=:edicao,
                                                                                            ano=:ano,
                                                                                            upload=:upload,
                                                                                            tb_editora_idtb_editora=:editora,
                                                                                            tb_categoria_idtb_categoria=:categoria
                                                                                            WHERE idtb_livro=:id");
                $statement->bindValue(":id", $livro->getIdtbLivro());
            } else {
                $statement = conexao::getInstance()->prepare("INSERT INTO tb_livro(titulo, isbn, edicao, ano, upload, tb_editora_idtb_editora, tb_categoria_idtb_categoria) 
                                                                        VALUES (:titulo, :isbn, :edicao, :ano, :upload, :editora, :categoria)");
            }
            $statement->bindValue(":titulo", $livro->getTitulo());
            $statement->bindValue(":isbn", $livro->getIsbn());
            $statement->bindValue(":edicao", $livro->getEdicao());
            $statement->bindValue(":ano", $livro->getAno());
            $statement->bindValue(":upload", $livro->getUpload());
            $statement->bindValue(":editora", $livro->getTbEditoraIdtbEditora());
            $statement->bindValue(":categoria", $livro->getTbCategoriaIdtbCategoria());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    if ($livro->getIdtbLivro() != "") {
                        return $livro->getIdtbLivro();
                    } else {
                        return conexao::getInstance()->lastInsertId();
                    }
                } 
                else {
                    return "Erro";
                }
            } else {
                var_dump($statement->errorInfo());
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL!'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " .$erro->getMessage();
        }
    }

    public function buscarTodos(){
        try {
            $statement = conexao::getInstance()->prepare("SELECT a.idtb_livro AS id,
                                                                           a.titulo AS titulo,
                                                                           a.isbn AS isbn,
                                                                           a.edicao AS edicao,
                                                                           a.ano AS ano,
                                                                           a.upload AS upload,
                                                                           b.idtb_editora AS editora, 
                                                                           c.idtb_categoria AS categoria
                                                                      FROM tb_livro a 
                                                                INNER JOIN tb_editora b 
                                                                        ON a.tb_editora_idtb_editora = b.idtb_editora
                                                                INNER JOIN tb_categoria c 
                                                                        ON a.tb_categoria_idtb_categoria = c.idtb_categoria ");
            if ($statement->execute()) {
                $livros = [];
                while($rs = $statement->fetch(PDO::FETCH_OBJ)) {
                    $livro = new livro($rs->id,
                                        $rs->titulo,
                                        $rs->isbn,
                                        $rs->edicao,
                                        $rs->ano,
                                        $rs->upload,
                                        $rs->editora,
                                        $rs->categoria);
                    array_push($livros, $livro);
                }
                return $livros;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function buscarLivro($id){
        try {
            $statement = conexao::getInstance()->prepare("SELECT a.idtb_livro AS id,
                                                                           a.titulo AS titulo,
                                                                           a.isbn AS isbn,
                                                                           a.edicao AS edicao,
                                                                           a.ano AS ano,
                                                                           a.upload AS upload,
                                                                           b.idtb_editora AS editora, 
                                                                           c.idtb_categoria AS categoria
                                                                      FROM tb_livro a 
                                                                INNER JOIN tb_editora b
                                                                        ON a.tb_editora_idtb_editora = b.idtb_editora
                                                                INNER JOIN tb_categoria c
                                                                        ON a.tb_categoria_idtb_categoria = c.idtb_categoria 
                                                                     WHERE a.idtb_livro = " . $id);
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $livro = new livro($rs->id,
                                        $rs->titulo,
                                        $rs->isbn,
                                        $rs->edicao,
                                        $rs->ano,
                                        $rs->upload,
                                        $rs->editora,
                                        $rs->categoria);
                return $livro;
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
        $sql = "SELECT idtb_livro, titulo, isbn, edicao, ano, upload, tb_editora_idtb_editora, tb_categoria_idtb_categoria FROM tb_livro LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = conexao::getInstance()->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_livro";
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

        //verifica nome de categoria e editora
        $categoriaDAO = new categoriaDAO();
        $editoraDAO = new editoraDAO();

        if (!empty($dados)):
            echo "<div class='row'>
                 <div class='col-md-12'>
                 <div class='card'>
                 <div class='header'>
                    <p class='category'>Lista de Livros do Sistema</p>
                 </div>
                 <div class='content table-responsive table-full-width'>
             <table class='table table-hover table-striped'>
             <thead>
               <tr style='text-transform: uppercase;'>
                <th>ID</th>
                <th>Titulo</th>
                <th>ISBN</th>
                <th>Edição</th>
                <th>Ano</th>
                <th>Upload</th>
                <th>Editora</th>
                <th>Categoria</th>
                <th class='col-xs-1 col-sm-1 col-md-1 col-lg-1' colspan='2'>Ações</th>
               </tr>
             </thead>
             <tbody>";
            foreach ($dados as $acti):
                $editora = $editoraDAO->buscarEditora($acti->tb_editora_idtb_editora);
                $categoria = $categoriaDAO->buscarCategoria($acti->tb_categoria_idtb_categoria);
                echo "<tr>
                    <td>$acti->idtb_livro</td>
                    <td>$acti->titulo</td>
                    <td>$acti->isbn</td>
                    <td>$acti->edicao</td>
                    <td>$acti->ano</td>
                    <td>$acti->upload</td>
                    <td>". $editora->getNomeEditora()."</td>
                    <td>". $categoria->getNomeCategoria() ."</td>
                    <td><a href='?act=upd&id=$acti->idtb_livro' title='Alterar'><i class='pe-7s-refresh'></i></a></td>
                    <td><a href='?act=del&id=$acti->idtb_livro' title='Remover'><i class='pe-7s-trash'></i></a></td>
                   </tr>";
            endforeach;
            echo "
             </tbody>
             </table>
             <nav class='text-center'>
                <ul class='pagination justify-content-center' style='text-align: center'>
                    <li class='page-item  $exibir_botao_inicio' ><a class='page-link pe-7s-prev' href='$endereco?page=$pagina_anterior' title='Página Anterior'></a></li>
             ";
            /* Loop para montar a páginação central com os números */
            for ($i = $range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'active' : '';
                echo "<li class='page-item $destaque' ><a class='page-link' href='$endereco?page=$i'> $i </a></li>";
            endfor;
            echo "<li class='page-item $exibir_botao_final' ><a  class='page-link pe-7s-right-arrow' href='$endereco?page=$proxima_pagina' title='Próxima Página'></a></li>
                  <li class='page-item $exibir_botao_final' ><a  class='page-link pe-7s-next' href='$endereco?page=$ultima_pagina'  title='Última Página'></a></li>
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