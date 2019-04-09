-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 02/04/2019 às 21:33
-- Versão do servidor: 10.1.38-MariaDB
-- Versão do PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bibliotecaLPAW`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_autor`
--

CREATE TABLE `tb_autor` (
  `idtb_autor` int(11) NOT NULL,
  `nomeAutor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tb_autor`
--

INSERT INTO `tb_autor` (`idtb_autor`, `nomeAutor`) VALUES
(1, 'Monteiro Lobato'),
(2, 'Agatha Christie'),
(3, 'José Saramago'),
(4, 'Machado de Assis'),
(7, 'Gomes de Castro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_autoria`
--

CREATE TABLE `tb_autoria` (
  `tb_livro_idtb_livro` int(11) NOT NULL,
  `tb_autores_idtb_autores` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_categoria`
--

CREATE TABLE `tb_categoria` (
  `idtb_categoria` int(11) NOT NULL,
  `nomeCategoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`idtb_categoria`, `nomeCategoria`) VALUES
(1, 'Ação'),
(3, 'Aventura'),
(5, 'Comédia'),
(6, 'Romance');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_editora`
--

CREATE TABLE `tb_editora` (
  `idtb_editora` int(11) NOT NULL,
  `nomeEditora` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tb_editora`
--

INSERT INTO `tb_editora` (`idtb_editora`, `nomeEditora`) VALUES
(2, 'Saraiva'),
(3, 'Saramago');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_emprestimo`
--

CREATE TABLE `tb_emprestimo` (
  `tb_usuario_idtb_usuario` int(11) NOT NULL,
  `tb_exemplar_idtb_exemplar` int(11) NOT NULL,
  `dataEmprestimo` date NOT NULL,
  `observacoes` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_exemplar`
--

CREATE TABLE `tb_exemplar` (
  `idtb_exemplar` int(11) NOT NULL,
  `tipoExemplar` int(11) NOT NULL,
  `tb_livro_idtb_livro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_livro`
--

CREATE TABLE `tb_livro` (
  `idtb_livro` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `edicao` varchar(4) DEFAULT NULL,
  `ano` year(4) NOT NULL,
  `upload` varchar(45) DEFAULT NULL,
  `tb_editora_idtb_editora` int(11) NOT NULL,
  `tb_categoria_idtb_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `idtb_usuario` int(11) NOT NULL,
  `nomeUsuario` varchar(255) NOT NULL,
  `tipo` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`idtb_usuario`, `nomeUsuario`, `tipo`, `email`, `senha`) VALUES
(1, 'admin', 1, 'admin@admin.com', 'admin');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `tb_autor`
--
ALTER TABLE `tb_autor`
  ADD PRIMARY KEY (`idtb_autor`);

--
-- Índices de tabela `tb_autoria`
--
ALTER TABLE `tb_autoria`
  ADD PRIMARY KEY (`tb_livro_idtb_livro`,`tb_autores_idtb_autores`),
  ADD KEY `fk_tb_livro_has_tb_autores_tb_autores1_idx` (`tb_autores_idtb_autores`),
  ADD KEY `fk_tb_livro_has_tb_autores_tb_livro_idx` (`tb_livro_idtb_livro`);

--
-- Índices de tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`idtb_categoria`);

--
-- Índices de tabela `tb_editora`
--
ALTER TABLE `tb_editora`
  ADD PRIMARY KEY (`idtb_editora`);

--
-- Índices de tabela `tb_emprestimo`
--
ALTER TABLE `tb_emprestimo`
  ADD PRIMARY KEY (`tb_usuario_idtb_usuario`,`tb_exemplar_idtb_exemplar`),
  ADD KEY `fk_tb_usuario_has_tb_exemplar_tb_usuario1_idx` (`tb_usuario_idtb_usuario`),
  ADD KEY `fk_tb_usuario_has_tb_exemplar_tb_exemplar1_idx` (`tb_exemplar_idtb_exemplar`);

--
-- Índices de tabela `tb_exemplar`
--
ALTER TABLE `tb_exemplar`
  ADD PRIMARY KEY (`idtb_exemplar`),
  ADD KEY `fk_tb_exemplar_tb_livro1_idx` (`tb_livro_idtb_livro`);

--
-- Índices de tabela `tb_livro`
--
ALTER TABLE `tb_livro`
  ADD PRIMARY KEY (`idtb_livro`),
  ADD UNIQUE KEY `isbn_UNIQUE` (`isbn`),
  ADD KEY `fk_tb_livro_tb_editora1_idx` (`tb_editora_idtb_editora`),
  ADD KEY `fk_tb_livro_tb_categoria1_idx` (`tb_categoria_idtb_categoria`);

--
-- Índices de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`idtb_usuario`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `tb_autor`
--
ALTER TABLE `tb_autor`
  MODIFY `idtb_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_categoria`
--
ALTER TABLE `tb_categoria`
  MODIFY `idtb_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tb_editora`
--
ALTER TABLE `tb_editora`
  MODIFY `idtb_editora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tb_livro`
--
ALTER TABLE `tb_livro`
  MODIFY `idtb_livro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `idtb_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `tb_autoria`
--
ALTER TABLE `tb_autoria`
  ADD CONSTRAINT `fk_tb_livro_has_tb_autores_tb_autores1` FOREIGN KEY (`tb_autores_idtb_autores`) REFERENCES `tb_autor` (`idtb_autor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_livro_has_tb_autores_tb_livro` FOREIGN KEY (`tb_livro_idtb_livro`) REFERENCES `tb_livro` (`idtb_livro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tb_emprestimo`
--
ALTER TABLE `tb_emprestimo`
  ADD CONSTRAINT `fk_tb_usuario_has_tb_exemplar_tb_exemplar1` FOREIGN KEY (`tb_exemplar_idtb_exemplar`) REFERENCES `tb_exemplar` (`idtb_exemplar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_usuario_has_tb_exemplar_tb_usuario1` FOREIGN KEY (`tb_usuario_idtb_usuario`) REFERENCES `tb_usuario` (`idtb_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tb_exemplar`
--
ALTER TABLE `tb_exemplar`
  ADD CONSTRAINT `fk_tb_exemplar_tb_livro1` FOREIGN KEY (`tb_livro_idtb_livro`) REFERENCES `tb_livro` (`idtb_livro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `tb_livro`
--
ALTER TABLE `tb_livro`
  ADD CONSTRAINT `fk_tb_livro_tb_categoria1` FOREIGN KEY (`tb_categoria_idtb_categoria`) REFERENCES `tb_categoria` (`idtb_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_livro_tb_editora1` FOREIGN KEY (`tb_editora_idtb_editora`) REFERENCES `tb_editora` (`idtb_editora`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
