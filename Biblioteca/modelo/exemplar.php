<?php

    class exemplar
    {
        private $idtb_exemplar;
        private $tb_livro_idtb_livro;
        private $tipoExemplar;

        public function __construct()
        {
        }

        public function __construct1($idtb_exemplar, $tb_livro_idtb_livro, $tipoExemplar)
        {
            $this->idtb_exemplar = $idtb_exemplar;
            $this->tb_livro_idtb_livro = $tb_livro_idtb_livro;
            $this->tipoExemplar = $tipoExemplar;
        }

        public function getIdtbExemplar()
        {
            return $this->idtb_exemplar;
        }

        public function setIdtbExemplar($idtb_exemplar)
        {
            $this->idtb_exemplar = $idtb_exemplar;
        }

        public function getTbLivroIdtbLivro()
        {
            return $this->tb_livro_idtb_livro;
        }

        public function setTbLivroIdtbLivro($tb_livro_idtb_livro)
        {
            $this->tb_livro_idtb_livro = $tb_livro_idtb_livro;
        }

        public function getTipoExemplar()
        {
            return $this->tipoExemplar;
        }

        public function setTipoExemplar($tipoExemplar)
        {
            $this->tipoExemplar = $tipoExemplar;
        }

    }

?>