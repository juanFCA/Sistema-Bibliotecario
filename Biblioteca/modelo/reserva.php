<?php

    class reserva
    {
        private $idtb_reserva;
        private $tb_usuario_idtb_usuario;
        private $tb_exemplar_idtb_exemplar;
        private $dataReserva;
        private $observacoes;
        private $situacao;

        public function __construct($idtb_reserva, $tb_usuario_idtb_usuario, $tb_exemplar_idtb_exemplar, $dataReserva, $observacoes, $situacao)
        {
            $this->idtb_reserva = $idtb_reserva;
            $this->tb_usuario_idtb_usuario = $tb_usuario_idtb_usuario;
            $this->tb_exemplar_idtb_exemplar = $tb_exemplar_idtb_exemplar;
            $this->dataReserva = $dataReserva;
            $this->observacoes = $observacoes;
            $this->situacao = $situacao;
        }

        public function getIdtbReserva()
        {
            return $this->idtb_reserva;
        }

        public function setIdtbReserva($idtb_reserva)
        {
            $this->idtb_reserva = $idtb_reserva;
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

        public function getDataReserva()
        {
            return $this->dataReserva;
        }

        public function setDataReserva($dataReserva)
        {
            $this->dataReserva = $dataReserva;
        }

        public function getObservacoes()
        {
            return $this->observacoes;
        }

        public function setObservacoes($observacoes)
        {
            $this->observacoes = $observacoes;
        }

        public function getSituacao()
        {
            return $this->situacao;
        }

        public function setSituacao($situacao)
        {
            $this->situacao = $situacao;
        }


    }

?>