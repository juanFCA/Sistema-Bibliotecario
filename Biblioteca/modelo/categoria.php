<?php

    class categoria
    {
        private $idtb_categoria;
        private $nomeCategoria;

        public function __construct()
        {
        }

        public function __construct1($idtb_categoria, $nomeCategoria)
        {
            $this->idtb_categoria = $idtb_categoria;
            $this->nomeCategoria = $nomeCategoria;
        }

        public function getIdtbCategoria()
        {
            return $this->idtb_categoria;
        }

        public function setIdtbCategoria($idtb_categoria)
        {
            $this->idtb_categoria = $idtb_categoria;
        }

        public function getNomeCategoria()
        {
            return $this->nomeCategoria;
        }

        public function setNomeCategoria($nomeCategoria)
        {
            $this->nomeCategoria = $nomeCategoria;
        }

    }

?>