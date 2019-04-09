<?php

    class livro
    {
        private $idtb_livro;
        private $titulo;
        private $isbn;
        private $edicao;
        private $ano;
        private $upload;
        private $tb_editora_idtb_editora;
        private $tb_categoria_idtb_categoria;

        public function __construct()
        {
        }

        public function __construct1($idtb_livro, $titulo, $isbn, $edicao, $ano, $upload, $tb_editora_idtb_editora, $tb_categoria_idtb_categoria)
        {
            $this->idtb_livro = $idtb_livro;
            $this->titulo = $titulo;
            $this->isbn = $isbn;
            $this->edicao = $edicao;
            $this->ano = $ano;
            $this->upload = $upload;
            $this->tb_editora_idtb_editora = $tb_editora_idtb_editora;
            $this->tb_categoria_idtb_categoria = $tb_categoria_idtb_categoria;
        }

        public function getIdtbLivro()
        {
            return $this->idtb_livro;
        }

        public function setIdtbLivro($idtb_livro)
        {
            $this->idtb_livro = $idtb_livro;
        }

        public function getTitulo()
        {
            return $this->titulo;
        }

        public function setTitulo($titulo)
        {
            $this->titulo = $titulo;
        }

        public function getIsbn()
        {
            return $this->isbn;
        }

        public function setIsbn($isbn)
        {
            $this->isbn = $isbn;
        }

        public function getEdicao()
        {
            return $this->edicao;
        }

        public function setEdicao($edicao)
        {
            $this->edicao = $edicao;
        }

        public function getAno()
        {
            return $this->ano;
        }

        public function setAno($ano)
        {
            $this->ano = $ano;
        }

        public function getUpload()
        {
            return $this->upload;
        }

        public function setUpload($upload)
        {
            $this->upload = $upload;
        }

        public function getTbEditoraIdtbEditora()
        {
            return $this->tb_editora_idtb_editora;
        }

        public function setTbEditoraIdtbEditora($tb_editora_idtb_editora)
        {
            $this->tb_editora_idtb_editora = $tb_editora_idtb_editora;
        }

        public function getTbCategoriaIdtbCategoria()
        {
            return $this->tb_categoria_idtb_categoria;
        }

        public function setTbCategoriaIdtbCategoria($tb_categoria_idtb_categoria)
        {
            $this->tb_categoria_idtb_categoria = $tb_categoria_idtb_categoria;
        }
    }

?>