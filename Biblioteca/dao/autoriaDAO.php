<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 18/03/19
 * Time: 15:27
 */

require_once "db/conexao.php";
require_once "modelo/autoria.php";

class autoriaDAO
{
    public function remover($idLivro, $autores)
    {
        foreach($autores as $key => $idAutor) {
            try {
                $statement = conexao::getInstance()->prepare("DELETE FROM tb_autoria 
                                                                    WHERE tb_livro_idtb_livro=:idLivro
                                                                    AND tb_autor_idtb_autor=:idAutor");
                $statement->bindValue(":idLivro", $idLivro);
                $statement->bindValue(":idAutor", $idAutor);
                if ($statement->execute()) {
                    return "<script> alert('Registro foi excluído com êxito!'); </script>";
                } else {
                    throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
                }
            } catch (PDOException $erro) {
                return "Erro: " . $erro->getMessage();
            }
        }
    }

    public function salvar($idLivro, $autores)
    {
        foreach($autores as $key => $idAutor) {
            try {
                $statement = conexao::getInstance()->prepare("INSERT INTO tb_autoria(tb_livro_idtb_livro, tb_autor_idtb_autor) 
                                                                VALUES (:idLivro, :idAutor)");
                $statement->bindValue(":idLivro", $idLivro);
                $statement->bindValue(":idAutor", $idAutor);
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
    }

    public function atualizar($idLivro, $autores)
    {
        $adicionados = [];
        $removidos = [];

        $autoresBD = $this->buscarAutores($idLivro);
        $resultado = array_diff($autoresBD, $autores);
        foreach($resultado as $key => $idAutor) {
            if (!isEmpty($this->buscarAutoriaLivro($idLivro, $idAutor))) {
                $removidos = $idAutor;
            } else {
                $adicionados = $idAutor;
            }
        }

        $this->remover($idLivro, $removidos);
        $this->salvar($idLivro, $adicionados);
    }

    public function buscarAutoria($idLivro, $idAutor)
    {
        try {
            $statement = conexao::getInstance()->prepare("SELECT tb_livro_idtb_livro, tb_autor_idtb_autor 
                                                            FROM tb_autoria 
                                                           WHERE tb_livro_idtb_livro=". $idLivro ."
                                                             AND tb_autor_idtb_autor=". $idAutor);
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $autoria = new autoria($rs->tb_livro_idtb_livro, $rs->tb_autor_idtb_autor);
                return $autoria;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function buscarAutorias($idLivro)
    {
        try {
            $statement = conexao::getInstance()->prepare("SELECT tb_livro_idtb_livro, tb_autor_idtb_autor 
                                                            FROM tb_autoria 
                                                           WHERE tb_livro_idtb_livro=". $idLivro);
            if ($statement->execute()) {
                $autorias = [];
                while($rs = $statement->fetch(PDO::FETCH_OBJ)) {
                    $autoria = new autoria($rs->tb_livro_idtb_livro, $rs->tb_autor_idtb_autor);
                    array_push($autorias, $autoria);
                }
                return $autorias;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function buscarTodos(){
        try {
            $statement = conexao::getInstance()->prepare("SELECT * FROM tb_autoria");
            if ($statement->execute()) {
                $autorias = [];
                while($rs = $statement->fetch(PDO::FETCH_OBJ)) {
                    $autoria = new autoria($rs->tb_livro_idtb_livro, $rs->tb_autor_idtb_autor);
                    array_push($autorias, $autoria);
                }
                return $autorias;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function buscarAutores($idLivro)
    {
        try {
            $statement = conexao::getInstance()->prepare("SELECT tb_autor_idtb_autor 
                                                            FROM tb_autoria 
                                                           WHERE tb_livro_idtb_livro=". $idLivro);
            if ($statement->execute()) {
                $autores = [];
                while($rs = $statement->fetch(PDO::FETCH_OBJ)) {
                    array_push($autores, $rs->tb_autor_idtb_autor);
                }
                return $autores;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function buscarLivros($idAutor)
    {
        try {
            $statement = conexao::getInstance()->prepare("SELECT tb_livro_idtb_livro 
                                                            FROM tb_autoria 
                                                           WHERE tb_autor_idtb_autor=". $idAutor);
            if ($statement->execute()) {
                $livros = [];
                while($rs = $statement->fetch(PDO::FETCH_OBJ)) {
                    array_push($livros, $rs->tb_livro_idtb_livro);
                }
                return $livros;
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !'); </script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
}