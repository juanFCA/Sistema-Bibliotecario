<?php

    class emprestimo
    {
        private $tb_usuario_idtb_usuario;
        private $tb_exemplar_idtb_exemplar;
        private $dataEmprestimo;
        private $observacoes;

        public function __construct($tb_usuario_idtb_usuario, $tb_exemplar_idtb_exemplar, $dataEmprestimo, $observacoes)
        {
            $this->tb_usuario_idtb_usuario = $tb_usuario_idtb_usuario;
            $this->tb_exemplar_idtb_exemplar = $tb_exemplar_idtb_exemplar;
            $this->dataEmprestimo = $dataEmprestimo;
            $this->observacoes = $observacoes;
        }

        public function getTbUsuarioIdtbUsuario()
        {
            return $this->tb_usuario_idtb_usuario;
        }

        public function setTbUsuarioIdtbUsuario($tb_usuario_idtb_usuario)
        {
            $this->tb_usuario_idtb_usuario = $tb_usuario_idtb_usuario;
        }

        public function getTbExemplarIdtbExemplar()
        {
            return $this->tb_exemplar_idtb_exemplar;
        }

        public function setTbExemplarIdtbExemplar($tb_exemplar_idtb_exemplar)
        {
            $this->tb_exemplar_idtb_exemplar = $tb_exemplar_idtb_exemplar;
        }

        public function getDataEmprestimo()
        {
            return $this->dataEmprestimo;
        }

        public function setDataEmprestimo($dataEmprestimo)
        {
            $this->dataEmprestimo = $dataEmprestimo;
        }

        public function getObservacoes()
        {
            return $this->observacoes;
        }

        public function setObservacoes($observacoes)
        {
            $this->observacoes = $observacoes;
        }
    }

?>