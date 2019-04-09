<?php

    class editora
    {
        private $idtb_editora;
        private $nomeEditora;

        public function __construct()
        {
        }

        public function __construct1($idtb_editora, $nomeEditora)
        {
            $this->idtb_editora = $idtb_editora;
            $this->nomeEditora = $nomeEditora;
        }

        public function getIdtbEditora()
        {
            return $this->idtb_editora;
        }

        public function setIdtbEditora($idtb_editora)
        {
            $this->idtb_editora = $idtb_editora;
        }

        public function getNomeEditora()
        {
            return $this->nomeEditora;
        }

        public function setNomeEditora($nomeEditora)
        {
            $this->nomeEditora = $nomeEditora;
        }

    }

?>