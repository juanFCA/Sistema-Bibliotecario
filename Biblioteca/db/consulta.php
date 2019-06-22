<?php

require_once "conexao.php";

class consulta
{
    public function nomeMeses() {
        return array('Janeiro',
                    'Fevereiro',
                    'Março',
                    'Abril',
                    'Maio',
                    'Junho',
                    'Julho',
                    'Agosto',
                    'Setembro',
                    'Outubro',
                    'Novembro',
                    'Dezembro');
    }

    //Variavel de intervalo que 0 e mes atual 1 e mes atual e anterior e assim sucessivamente
    public function retornaTotalResEmp($intervalo){
        try {
            $statement = Conexao::getInstance()->prepare("CREATE TEMPORARY TABLE res AS SELECT EXTRACT(MONTH FROM r.dataReserva) AS mes, 
                                                                                                         COUNT(r.idtb_reserva) AS livrosRes
                                                                                                    FROM tb_reserva r
                                                                                                   WHERE EXTRACT(MONTH FROM r.dataReserva) 
                                                                                                 BETWEEN EXTRACT(MONTH FROM CURDATE() - INTERVAL :intervalo MONTH) 
                                                                                                     AND EXTRACT(MONTH FROM CURDATE()) GROUP BY mes;");
            $statement2 = Conexao::getInstance()->prepare("CREATE TEMPORARY TABLE emp AS SELECT EXTRACT(MONTH FROM e.dataEmprestimo) AS mes, 
                                                                                                         COUNT(e.idtb_emprestimo) AS livrosEmp
                                                                                                    FROM tb_emprestimo e
                                                                                                   WHERE EXTRACT(MONTH FROM e.dataEmprestimo) 
                                                                                                 BETWEEN EXTRACT(MONTH FROM CURDATE() - INTERVAL :intervalo MONTH) 
                                                                                                     AND EXTRACT(MONTH FROM CURDATE()) GROUP BY mes;");
            $statement3 = Conexao::getInstance()->prepare("SELECT IF(LENGTH(r.mes) > LENGTH(e.mes) , r.mes, e.mes) AS mes,
                                                                          CASE WHEN r.livrosRes IS NOT null THEN r.livrosRes ELSE 0 END AS livrosReservas,
                                                                          CASE WHEN e.livrosEmp IS NOT null THEN e.livrosEmp ELSE 0 END AS livrosEmprestimos
                                                                          FROM emp e LEFT JOIN res r ON e.mes = r.mes GROUP BY mes");
            $statement->bindValue(":intervalo", $intervalo);
            $statement2->bindValue(":intervalo", $intervalo);
            if($statement->execute() && $statement2->execute() && $statement3->execute()){
                if($statement3->rowCount() > 0){
                    $labels = array();
                    $seriesRes = array();
                    $seriesEmp = array();
                    while($rs = $statement3->fetch(PDO::FETCH_OBJ)){
                        array_push($labels, $this->nomeMeses()[$rs->mes -1]);
                        array_push($seriesRes, $rs->livrosReservas);
                        array_push($seriesEmp, $rs->livrosEmprestimos);
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
            $statement = Conexao::getInstance()->prepare("SELECT EXTRACT(MONTH FROM dataReserva) AS mes, 
                                                                           COUNT(idtb_reserva) AS livrosMes 
                                                                      FROM tb_reserva
                                                                     WHERE EXTRACT(MONTH FROM dataReserva) 
                                                                   BETWEEN EXTRACT(MONTH FROM CURDATE() - INTERVAL :intervalo MONTH) 
                                                                       AND EXTRACT(MONTH FROM CURDATE()) 
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
                                                                           COUNT(idtb_emprestimo) AS livrosMes 
                                                                      FROM tb_emprestimo 
                                                                     WHERE EXTRACT(MONTH FROM dataEmprestimo) 
                                                                   BETWEEN EXTRACT(MONTH FROM CURDATE() - INTERVAL :intervalo MONTH) 
                                                                       AND EXTRACT(MONTH FROM CURDATE()) 
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
                                                                           COUNT(r.idtb_reserva) AS total FROM tb_reserva r 
                                                                INNER JOIN tb_exemplar ex 
                                                                        ON r.tb_exemplar_idtb_exemplar = ex.idtb_exemplar
                                                                INNER JOIN tb_livro l 
                                                                        ON ex.tb_livro_idtb_livro = l.idtb_livro
                                                                INNER JOIN tb_categoria c 
                                                                        ON l.tb_categoria_idtb_categoria = c.idtb_categoria
                                                                     WHERE EXTRACT(MONTH FROM r.dataReserva) 
                                                                   BETWEEN EXTRACT(MONTH FROM CURDATE() - INTERVAL :intervalo MONTH) 
                                                                       AND EXTRACT(MONTH FROM CURDATE()) 
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
                                                                          COUNT(em.idtb_emprestimo) AS total FROM tb_emprestimo em 
                                                               INNER JOIN tb_exemplar ex 
                                                                       ON em.tb_exemplar_idtb_exemplar = ex.idtb_exemplar
                                                               INNER JOIN tb_livro l 
                                                                       ON ex.tb_livro_idtb_livro = l.idtb_livro
                                                               INNER JOIN tb_categoria c 
                                                                       ON l.tb_categoria_idtb_categoria = c.idtb_categoria
                                                                    WHERE EXTRACT(MONTH FROM em.dataEmprestimo) 
                                                                  BETWEEN EXTRACT(MONTH FROM CURDATE() - INTERVAL :intervalo MONTH) 
                                                                      AND EXTRACT(MONTH FROM CURDATE()) 
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