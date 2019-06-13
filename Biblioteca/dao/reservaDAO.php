<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 12/06/19
 * Time: 22:28
 */

require_once "db/conexao.php";
require_once "modelo/reserva.php";

class reservaDAO
{
    
    public function realizarEmprestimo(emprestimo $emprestimo) {
        try {
            $statement = Conexao::getInstance()->prepare("UPDATE tb_emprestimo SET dataEmprestimo=:dataEmprestimo,
                                                                                             dataVencimento=:dataVencimento,
                                                                                             reserva=:reserva 
                                                                                       WHERE tb_usuario_idtb_usuario=:idUsuario AND tb_exemplar_idtb_exemplar=:idExemplar");
            $statement->bindValue(":idUsuario", $emprestimo->getTbUsuarioIdtbUsuario());
            $statement->bindValue(":idExemplar", $emprestimo->getTbExemplarIdtbExemplar());
            $statement->bindValue(":dataEmprestimo", $emprestimo->getDataEmprestimo());
            $statement->bindValue(":dataVencimento", $emprestimo->getDataVencimento());
            $statement->bindValue(":reserva", $emprestimo->getReserva());
            if($statement->execute()){
                if($statement->rowCount() > 0){
                    return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Emprestimo Realizado com Sucesso', 'success'); </script>";
                }else{
                    return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Falha ao tentar Realizar o Emprestimo', 'danger'); </script>";
                }
            }else{
                throw new PDOException("<script>alert('Não foi possível executar a declaração SQL !')</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
    
    public function cancelarReserva(emprestimo $emprestimo)
    {
        try {
            $statement = conexao::getInstance()->prepare("DELETE FROM tb_emprestimo 
                                                                          WHERE tb_usuario_idtb_usuario=:idUsuario 
                                                                            AND tb_exemplar_idtb_exemplar=:idExemplar");
            $statement->bindValue(":idUsuario", $emprestimo->getTbUsuarioIdtbUsuario());
            $statement->bindValue(":idExemplar", $emprestimo->getTbExemplarIdtbExemplar());
            if ($statement->execute()) {
                return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Registro foi removido com êxito', 'success'); </script>";                
            } else {
                return "<script> notificacao('pe-7s-info', 'Emprestimo', 'Falha ao tentar remover o Registro', 'danger'); </script>";              
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

}

?>