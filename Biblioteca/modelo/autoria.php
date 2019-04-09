<?php

    class autoria
    {
        private $tb_livro_idtb_livro;
        private $tb_autores_idtb_autores;

        public function __construct($tb_livro_idtb_livro, $tb_autores_idtb_autores)
        {
            $this->tb_livro_idtb_livro = $tb_livro_idtb_livro;
            $this->tb_autores_idtb_autores = $tb_autores_idtb_autores;
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
            return $this->tb_autores_idtb_autores;
        }

        public function setTbAutoresIdtbAutores($tb_autores_idtb_autores)
        {
            $this->tb_autores_idtb_autores = $tb_autores_idtb_autores;
        }
    }

?>