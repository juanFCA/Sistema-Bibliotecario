<?php

    class autor
    {
        private $idtb_autor;
        private $nomeAutor;

        public function __construct($idtb_autor, $nomeAutor)
        {
            $this->idtb_autor = $idtb_autor;
            $this->nomeAutor = $nomeAutor;
        }

        public function getIdtbAutor()
        {
            return $this->idtb_autor;
        }

        public function setIdtbAutor($idtb_autor)
        {
            $this->idtb_autor = $idtb_autor;
        }

        public function getNomeAutor()
        {
            return $this->nomeAutor;
        }

        public function setNomeAutor($nomeAutor)
        {
            $this->nomeAutor = $nomeAutor;
        }

    }
?>