<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 2019-05-29
 * Time: 11:30
 */

require_once "../view/template.php";
require_once "../db/conexao.php";

class relatorio {
        
    public function listaAutores() {

        $sqlLista = "SELECT * FROM tb_autor";
        $statement = conexao::getInstance()->prepare($sqlLista);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_ASSOC);

        $relatorio = '
            <div class=\'row\'>
                <div class=\'col-md-12\'>
                    <div class=\'card\'>
                        <div class=\'header\'>
                            <p class=\'category\'>Listagem de Autores no Sistema</p>
                        </div>
                        <div class=\'content\'>
                            <table class=\'table table-hover table-striped\'>
                                <thead>
                                    <tr style=\'text-transform: uppercase;\'>
                                        <th>ID</th>
                                        <th>NOME</th>
                                    </tr>
                                </thead>
                                <tbody>
        ';
        foreach ($dados as $key => $value) {
            $relatorio .= '
                                    <tr class=\'text-center\'>
                                        <td>'.$value['idtb_autor'].'</td>
                                        <td>'.$value['nomeAutor'].'</td>
                                    </tr>
            ';
        }
        $relatorio .= '    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <div>  
        ';

        return $relatorio;
    }

    public function listaCategorias() {

        $sqlLista = "SELECT * FROM tb_categoria";
        $statement = conexao::getInstance()->prepare($sqlLista);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_ASSOC);

        $relatorio = '
            <div class=\'row\'>
                <div class=\'col-md-12\'>
                    <div class=\'card\'>
                        <div class=\'header\'>
                            <p class=\'category\'>Listagem de Categorias no Sistema</p>
                        </div>
                        <div class=\'content\'>
                            <table class=\'table table-hover table-striped\'>
                                <thead>
                                    <tr style=\'text-transform: uppercase;\'>
                                        <th>ID</th>
                                        <th>NOME</th>
                                    </tr>
                                </thead>
                                <tbody>
        ';
        foreach ($dados as $key => $value) {
            $relatorio .= '
                                    <tr class=\'text-center\'>
                                        <td>'.$value['idtb_categoria'].'</td>
                                        <td>'.$value['nomeCategoria'].'</td>
                                    </tr>
            ';
        }
        $relatorio .= '    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <div>  
        ';

        return $relatorio;
    }

    public function listaEditoras() {

        $sqlLista = "SELECT * FROM tb_editora";
        $statement = conexao::getInstance()->prepare($sqlLista);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_ASSOC);

        $relatorio = '
            <div class=\'row\'>
                <div class=\'col-md-12\'>
                    <div class=\'card\'>
                        <div class=\'header\'>
                            <p class=\'category\'>Listagem de Editoras no Sistema</p>
                        </div>
                        <div class=\'content\'>
                            <table class=\'table table-hover table-striped\'>
                                <thead>
                                    <tr style=\'text-transform: uppercase;\'>
                                        <th>ID</th>
                                        <th>NOME</th>
                                    </tr>
                                </thead>
                                <tbody>
        ';
        foreach ($dados as $key => $value) {
            $relatorio .= '
                                    <tr class=\'text-center\'>
                                        <td>'.$value['idtb_editora'].'</td>
                                        <td>'.$value['nomeEditora'].'</td>
                                    </tr>
            ';
        }
        $relatorio .= '    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <div>  
        ';

        return $relatorio;
    }

    public function listaLivros() {

        $sqlLista = "SELECT a.idtb_livro AS id,
                            a.titulo AS titulo,
                            a.isbn AS isbn,
                            a.edicao AS edicao,
                            a.ano AS ano,
                            b.nomeEditora AS editora, 
                            c.nomeCategoria AS categoria
                       FROM tb_livro a 
                 INNER JOIN tb_editora b
                         ON a.tb_editora_idtb_editora = b.idtb_editora
                 INNER JOIN tb_categoria c
                         ON a.tb_categoria_idtb_categoria = c.idtb_categoria ";
        $statement = conexao::getInstance()->prepare($sqlLista);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_ASSOC);

        $relatorio = '
            <div class=\'row\'>
                <div class=\'col-md-12\'>
                    <div class=\'card\'>
                        <div class=\'header\'>
                            <p class=\'category\'>Listagem de Livros no Sistema</p>
                        </div>
                        <div class=\'content\'>
                            <table align="center" class=\'table table-hover table-striped\'>
                                <thead>
                                    <tr style=\'text-transform: uppercase;\'>
                                        <th width="15px">ID</th>
                                        <th width="195px">TITULO</th>
                                        <th width="60px">ISBN</th>
                                        <th width="70px">EDIÇÃO</th>
                                        <th width="30px">ANO</th>
                                        <th width="80px">EDITORA</th>
                                        <th width="80px">CATEGORIA</th>
                                    </tr>
                                </thead>
                                <tbody>
        ';
        foreach ($dados as $key => $value) {
            $relatorio .= '
                                    <tr class=\'text-center\'>
                                        <td width="15px">'.$value['id'].'</td>
                                        <td width="195px">'.$value['titulo'].'</td>
                                        <td width="60px">'.$value['isbn'].'</td>
                                        <td width="70px">'.$value['edicao'].'</td>
                                        <td width="30px">'.$value['ano'].'</td>
                                        <td width="80px">'.$value['editora'].'</td>
                                        <td width="80px">'.$value['categoria'].'</td>
                                    </tr>
            ';
        }
        $relatorio .= '    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <div>  
        ';

        return $relatorio;
    }

    public function listaExemplares() {

        $sqlLista = "SELECT e.idtb_exemplar AS id , 
                            l.titulo AS titulo,  
                       CASE e.tipoExemplar WHEN 1 THEN 'Circular' 
  					                       WHEN 2 THEN 'Não Circular' 
                        END AS tipo
                       FROM tb_exemplar e
                 INNER JOIN tb_livro l 
                         ON e.tb_livro_idtb_livro = l.idtb_livro";
        $statement = conexao::getInstance()->prepare($sqlLista);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_ASSOC);

        $relatorio = '
            <div class=\'row\'>
                <div class=\'col-md-12\'>
                    <div class=\'card\'>
                        <div class=\'header\'>
                            <p class=\'category\'>Listagem de Exemplares no Sistema</p>
                        </div>
                        <div class=\'content\'>
                            <table align="left" class=\'table table-hover table-striped\'>
                                <thead>
                                    <tr style=\'text-transform: uppercase;\'>
                                        <th width="50px">ID</th>
                                        <th width="300px">LIVRO</th>
                                        <th>TIPO</th>
                                    </tr>
                                </thead>
                                <tbody>
        ';
        foreach ($dados as $key => $value) {
            $relatorio .= '
                                    <tr class=\'text-center\'>
                                        <td width="50px">'.$value['id'].'</td>
                                        <td width="300px">'.$value['titulo'].'</td>
                                        <td>'.$value['tipo'].'</td>
                                    </tr>
            ';
        }
        $relatorio .= '    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <div>  
        ';

        return $relatorio;
    }

    public function listaUsuarios() {

        $sqlLista = "SELECT u.idtb_usuario AS id, 
                            u.nomeUsuario AS nome,
                            u.email AS email,
                       CASE u.tipo WHEN 1 THEN 'Administrador' 
  	                               WHEN 2 THEN 'Bibliotecário' 
                                   WHEN 3 THEN 'Funcionário' 
                                   WHEN 4 THEN 'Docente' 
                                   WHEN 5 THEN 'Discente' 
                        END AS tipo
                       FROM tb_usuario u";
        $statement = conexao::getInstance()->prepare($sqlLista);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_ASSOC);

        $relatorio = '
            <div class=\'row\'>
                <div class=\'col-md-12\'>
                    <div class=\'card\'>
                        <div class=\'header\'>
                            <p class=\'category\'>Listagem de Usuários no Sistema</p>
                        </div>
                        <div class=\'content\'>
                            <table align="left" class=\'table table-hover table-striped\'>
                                <thead>
                                    <tr style=\'text-transform: uppercase;\'>
                                        <th width="20px">ID</th>
                                        <th width="200px">NOME</th>
                                        <th width="90px">TIPO</th>
                                        <th width="200px">EMAIL</th>
                                    </tr>
                                </thead>
                                <tbody>
        ';
        foreach ($dados as $key => $value) {
            $relatorio .= '
                                    <tr class=\'text-center\'>
                                        <td width="20px">'.$value['id'].'</td>
                                        <td width="200px">'.$value['nome'].'</td>
                                        <td width="90px">'.$value['tipo'].'</td>
                                        <td width="200px">'.$value['email'].'</td>
                                    </tr>
            ';
        }
        $relatorio .= '    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <div>  
        ';

        return $relatorio;
    }
}

?>