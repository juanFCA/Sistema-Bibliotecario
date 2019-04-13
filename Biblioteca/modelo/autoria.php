<?php

    class autoria
    {
        private $tb_livro_idtb_livro;
        private $tb_autor_idtb_autor;

        public function __construct($tb_livro_idtb_livro, $tb_autor_idtb_autor)
        {
            $this->tb_livro_idtb_livro = $tb_livro_idtb_livro;
            $this->tb_autor_idtb_autor = $tb_autor_idtb_autor;
        }

        public function getTbLivroIdtbLivro()
        {
            return $this->tb_livro_idtb_livro;
        }

        public function setTbLivroIdtbLivro($tb_livro_idtb_livro)
        {
            $this->tb_livro_idtb_livro = $tb_livro_idtb_livro;
        }

        public function getTbAutoresIdtbAutores()
        {
            return $this->tb_autor_idtb_autor;
        }

        public function setTbAutoresIdtbAutores($tb_autor_idtb_autor)
        {
            $this->tb_autor_idtb_autor = $tb_autor_idtb_autor;
        }
    }

?>