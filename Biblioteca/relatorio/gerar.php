<?php

/**
 * Created by PhpStorm.
 * User: juan
 * Date: 2019-05-29
 * Time: 11:30
 */

require_once "../db/conexao.php";

class gerar {
        
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
                                        <th>Nome</th>
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

}

?>