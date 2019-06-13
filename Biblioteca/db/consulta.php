<?php

require_once "conexao.php";

class consulta
{
    //Variavel de intervalo que 0 e mes atual 1 e mes atual e anterior e assim sucessivamente
    public function retornaTotalResEmp($intervalo){
        try {
            $statement = Conexao::getInstance()->prepare("SELECT EXTRACT(MONTH FROM dataEmprestimo) AS mes, 
                                                                           COUNT(IF(reserva=1,1,null)) AS livrosMesRes,
                                                                           COUNT(IF(reserva=0,1,null)) AS livrosMesEmp
                                                                      FROM tb_emprestimo 
                                                                     WHERE EXTRACT(MONTH FROM dataEmprestimo) 
                                                                   BETWEEN EXTRACT(MONTH FROM CURDATE() - INTERVAL :intervalo MONTH) 
                                                                       AND EXTRACT(MONTH FROM CURDATE()) 
                                                                  GROUP BY mes");
            $statement->bindValue(":intervalo", $intervalo);
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    $labels = array();
                    $seriesRes = array();
                    $seriesEmp = array();
                    while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                        array_push($labels, $this->nomeMeses()[$rs->mes -1]);
                        array_push($seriesRes, $rs->livrosMesRes);
                        array_push($seriesEmp, $rs->livrosMesEmp);
                    }
                    $dados = array($labels, $seriesRes, $seriesEmp);
                    return $dados;
                }else{
                    return "<script>alert('Erro ao buscar os Dados!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    //Variavel de intervalo que 0 e mes atual 1 e mes atual e anterior e assim sucessivamente
    public function retornaReservasMes($intervalo){
        try {
            $statement = Conexao::getInstance()->prepare("SELECT EXTRACT(MONTH FROM dataEmprestimo) AS mes, 
                                                                           COUNT(dataEmprestimo) AS livrosMes 
                                                                      FROM tb_emprestimo 
                                                                     WHERE EXTRACT(MONTH FROM dataEmprestimo) 
                                                                   BETWEEN EXTRACT(MONTH FROM CURDATE() - INTERVAL :intervalo MONTH) 
                                                                       AND EXTRACT(MONTH FROM CURDATE()) 
                                                                       AND reserva = 1 
                                                                  GROUP BY mes");
            $statement->bindValue(":intervalo", $intervalo);
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    $labels = array();
                    $series = array();
                    while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                        array_push($labels, $this->nomeMeses()[$rs->mes -1]);
                        array_push($series, $rs->livrosMes);
                    }
                    $dados = array($labels, $series);
                    return $dados;
                }else{
                    return "<script>alert('Erro ao buscar os Dados!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    //Variavel de intervalo que 0 e mes atual 1 e mes atual e anterior e assim sucessivamente
    public function retornaEmprestimosMes($intervalo){
        try {
            $statement = Conexao::getInstance()->prepare("SELECT EXTRACT(MONTH FROM dataEmprestimo) AS mes, 
                                                                           COUNT(dataEmprestimo) AS livrosMes 
                                                                      FROM tb_emprestimo 
                                                                     WHERE EXTRACT(MONTH FROM dataEmprestimo) 
                                                                   BETWEEN EXTRACT(MONTH FROM CURDATE() - INTERVAL :intervalo MONTH) 
                                                                       AND EXTRACT(MONTH FROM CURDATE()) 
                                                                       AND reserva = 0 
                                                                  GROUP BY mes");
            $statement->bindValue(":intervalo", $intervalo);
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    $labels = array();
                    $series = array();
                    while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                        array_push($labels, $this->nomeMeses()[$rs->mes -1]);
                        array_push($series, $rs->livrosMes);
                    }
                    $dados = array($labels, $series);
                    return $dados;
                }else{
                    return "<script>alert('Erro ao buscar os Dados!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    //Variavel de intervalo que 0 e mes atual 1 e mes atual e anterior e assim sucessivamente
    public function retornaReservasCategoria($intervalo){
        try {
            $statement = Conexao::getInstance()->prepare("SELECT c.nomeCategoria AS categoria, 
                                                                           COUNT(em.reserva) AS total FROM tb_emprestimo em 
                                                                INNER JOIN tb_exemplar ex 
                                                                        ON em.tb_exemplar_idtb_exemplar = ex.idtb_exemplar
                                                                INNER JOIN tb_livro l 
                                                                        ON ex.tb_livro_idtb_livro = l.idtb_livro
                                                                INNER JOIN tb_categoria c 
                                                                        ON l.tb_categoria_idtb_categoria = c.idtb_categoria
                                                                     WHERE EXTRACT(MONTH FROM em.dataEmprestimo) 
                                                                   BETWEEN EXTRACT(MONTH FROM CURDATE() - INTERVAL :intervalo MONTH) 
                                                                       AND EXTRACT(MONTH FROM CURDATE()) 
                                                                       AND em.reserva = 1 
                                                                  GROUP BY categoria");
            $statement->bindValue(":intervalo", $intervalo);
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    $labels = array();
                    $series = array();
                    while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                        array_push($labels, $rs->categoria);
                        array_push($series, $rs->total);
                    }
                    $dados = array($labels, $series);
                    return $dados;
                }else{
                    return "<script>alert('Erro ao buscar os Dados!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    //Variavel de intervalo que 0 e mes atual 1 e mes atual e anterior e assim sucessivamente
    public function retornaEmprestimosCategoria($intervalo){
        try {
            $statement = Conexao::getInstance()->prepare("SELECT c.nomeCategoria AS categoria, 
                                                                           COUNT(em.reserva) AS total FROM tb_emprestimo em 
                                                               INNER JOIN tb_exemplar ex 
                                                                       ON em.tb_exemplar_idtb_exemplar = ex.idtb_exemplar
                                                               INNER JOIN tb_livro l 
                                                                       ON ex.tb_livro_idtb_livro = l.idtb_livro
                                                               INNER JOIN tb_categoria c 
                                                                       ON l.tb_categoria_idtb_categoria = c.idtb_categoria
                                                                    WHERE EXTRACT(MONTH FROM em.dataEmprestimo) 
                                                                  BETWEEN EXTRACT(MONTH FROM CURDATE() - INTERVAL :intervalo MONTH) 
                                                                      AND EXTRACT(MONTH FROM CURDATE()) 
                                                                      AND em.reserva = 0 
                                                                 GROUP BY categoria");
            $statement->bindValue(":intervalo", $intervalo);
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    $labels = array();
                    $series = array();
                    while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                        array_push($labels, $rs->categoria);
                        array_push($series, $rs->total);
                    }
                    $dados = array($labels, $series);
                    return $dados;
                }else{
                    return "<script>alert('Erro ao buscar os Dados!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function retornaCountRegistros() {
        try {
            $statement = Conexao::getInstance()->prepare("SELECT table_name AS tabela, 
                                                                           table_rows AS quantidade
                                                                      FROM INFORMATION_SCHEMA.TABLES 
                                                                     WHERE TABLE_SCHEMA = 'bibliotecaLPAW'");
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    $tabela = array();
                    $quantidade = array();
                    while($rs = $statement->fetch(PDO::FETCH_OBJ)){
                        array_push($tabela, $rs->tabela);
                        array_push($quantidade, $rs->quantidade);
                    }
                    $dados = array($tabela, $quantidade);
                    return $dados;
                }else{
                    return "<script>alert('Erro ao buscar os Dados!')</script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
}

?>