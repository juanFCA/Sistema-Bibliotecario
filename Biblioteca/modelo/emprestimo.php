<?php

    class emprestimo
    {
        private $tb_usuario_idtb_usuario;
        private $tb_exemplar_idtb_exemplar;
        private $dataEmprestimo;
        private $observacoes;
        private $dataVencimento;
        private $dataDevolucao;
        private $reserva;

        public function __construct($tb_usuario_idtb_usuario, $tb_exemplar_idtb_exemplar, $dataEmprestimo, $observacoes, $dataVencimento, $dataDevolucao, $reserva)
        {
            $this->tb_usuario_idtb_usuario = $tb_usuario_idtb_usuario;
            $this->tb_exemplar_idtb_exemplar = $tb_exemplar_idtb_exemplar;
            $this->dataEmprestimo = $dataEmprestimo;
            $this->observacoes = $observacoes;
            $this->dataVencimento = $dataVencimento;
            $this->dataDevolucao = $dataDevolucao;
            $this->reserva = $reserva;
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

        public function getDataVencimento()
        {
            return $this->dataVencimento;
        }

        public function setDataVencimento($dataVencimento)
        {
            $this->dataVencimento = $dataVencimento;
        }

        public function getDataDevolucao()
        {
            return $this->dataDevolucao;
        }

        public function setDataDevolucao($dataDevolucao)
        {
            $this->dataDevolucao = $dataDevolucao;
        }

        public function getReserva()
        {
            return $this->reserva;
        }

        public function setReserva($reserva)
        {
            $this->reserva = $reserva;
        }
    }

?>