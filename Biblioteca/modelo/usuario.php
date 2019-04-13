<?php 

    class usuario
    {

        private $idtb_usuario;
        private $nomeUsuario;
        private $tipo;
        private $email;
        private $senha;

        public function __construct($idtb_usuario, $nomeUsuario, $tipo, $email, $senha)
        {
            $this->idtb_usuario = $idtb_usuario;
            $this->nomeUsuario = $nomeUsuario;
            $this->tipo = $tipo;
            $this->email = $email;
            $this->senha = $senha;
        }

        public function getIdtbUsuario()
        {
            return $this->idtb_usuario;
        }

        public function setIdtbUsuario($idtb_usuario)
        {
            $this->idtb_usuario = $idtb_usuario;
        }

        public function getNomeUsuario()
        {
            return $this->nomeUsuario;
        }

        public function setNomeUsuario($nomeUsuario)
        {
            $this->nomeUsuario = $nomeUsuario;
        }

        public function getTipo()
        {
            return $this->tipo;
        }

        public function setTipo($tipo)
        {
            $this->tipo = $tipo;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setEmail($email)
        {
            $this->email = $email;
        }

        public function getSenha()
        {
            return $this->senha;
        }

        public function setSenha($senha)
        {
            $this->senha = $senha;
        }

    }

?>