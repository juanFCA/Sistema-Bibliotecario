-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 25-Jun-2019 às 02:44
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bibliotecalpaw`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_autor`
--

CREATE TABLE `tb_autor` (
  `idtb_autor` int(11) NOT NULL,
  `nomeAutor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_autor`
--

INSERT INTO `tb_autor` (`idtb_autor`, `nomeAutor`) VALUES
(19, 'Adélia Prado'),
(16, 'Ana Maria Machado'),
(7, 'Carlos Drummond de Andrade'),
(8, 'Cecília Meirelesa'),
(10, 'Clarice Lispector'),
(3, 'Euclides da Cunha'),
(6, 'Graciliano Ramos'),
(13, 'Guimarães Rosa'),
(11, 'Hilda Hilst'),
(9, 'João Guimarães Rosa'),
(5, 'Jorge Amado'),
(20, 'José'),
(12, 'José de Alencar'),
(4, 'Lima Barreto'),
(15, 'Luis Fernando Veríssimo'),
(2, 'Machado de Assis'),
(17, 'Martha Medeiros'),
(1, 'Monteiro Lobato'),
(14, 'Ruth Rocha');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_autoria`
--

CREATE TABLE `tb_autoria` (
  `tb_livro_idtb_livro` int(11) NOT NULL,
  `tb_autor_idtb_autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_autoria`
--

INSERT INTO `tb_autoria` (`tb_livro_idtb_livro`, `tb_autor_idtb_autor`) VALUES
(1, 2),
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(6, 2),
(6, 4),
(6, 15);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categoria`
--

CREATE TABLE `tb_categoria` (
  `idtb_categoria` int(11) NOT NULL,
  `nomeCategoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`idtb_categoria`, `nomeCategoria`) VALUES
(8, 'Açãoo'),
(3, 'Aventura'),
(6, 'Biografia'),
(4, 'Comédia'),
(7, 'Comédia Romântica'),
(2, 'Romance'),
(5, 'Terror');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_editora`
--

CREATE TABLE `tb_editora` (
  `idtb_editora` int(11) NOT NULL,
  `nomeEditora` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_editora`
--

INSERT INTO `tb_editora` (`idtb_editora`, `nomeEditora`) VALUES
(1, 'Abril'),
(4, 'Eurobooks'),
(3, 'Europa'),
(2, 'Saramago');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_emprestimo`
--

CREATE TABLE `tb_emprestimo` (
  `idtb_emprestimo` int(11) NOT NULL,
  `tb_usuario_idtb_usuario` int(11) NOT NULL,
  `tb_exemplar_idtb_exemplar` int(11) NOT NULL,
  `dataEmprestimo` date NOT NULL,
  `observacoes` tinytext,
  `dataVencimento` date NOT NULL,
  `dataDevolucao` date DEFAULT NULL,
  `situacao` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_emprestimo`
--

INSERT INTO `tb_emprestimo` (`idtb_emprestimo`, `tb_usuario_idtb_usuario`, `tb_exemplar_idtb_exemplar`, `dataEmprestimo`, `observacoes`, `dataVencimento`, `dataDevolucao`, `situacao`) VALUES
(1, 1, 1, '2019-06-10', '', '2019-06-20', '2019-06-24', 2),
(2, 2, 2, '2019-06-24', '', '2019-07-04', NULL, 1),
(3, 3, 7, '2019-06-17', '', '2019-07-02', NULL, 1),
(4, 4, 6, '2019-06-16', '', '2019-06-26', NULL, 1),
(5, 5, 9, '2019-06-12', '', '2019-06-22', '2019-06-24', 2),
(6, 4, 11, '2019-05-28', '', '2019-06-07', '2019-06-24', 2),
(7, 4, 10, '2019-06-04', '', '2019-06-14', NULL, 3),
(8, 1, 15, '2019-04-16', '', '2019-04-26', NULL, 3),
(9, 3, 17, '2019-06-19', '', '2019-07-04', NULL, 1),
(10, 5, 11, '2019-06-10', '', '2019-06-20', NULL, 3),
(11, 1, 13, '2019-06-24', '', '2019-07-04', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_exemplar`
--

CREATE TABLE `tb_exemplar` (
  `idtb_exemplar` int(11) NOT NULL,
  `tipoExemplar` int(11) NOT NULL,
  `tb_livro_idtb_livro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_exemplar`
--

INSERT INTO `tb_exemplar` (`idtb_exemplar`, `tipoExemplar`, `tb_livro_idtb_livro`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 2, 1),
(4, 1, 2),
(5, 1, 2),
(6, 2, 2),
(7, 2, 3),
(8, 1, 3),
(9, 1, 3),
(10, 1, 3),
(11, 1, 4),
(12, 2, 4),
(13, 1, 5),
(14, 1, 5),
(15, 2, 5),
(16, 2, 5),
(17, 1, 6),
(18, 2, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_livro`
--

CREATE TABLE `tb_livro` (
  `idtb_livro` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `edicao` varchar(4) DEFAULT NULL,
  `ano` year(4) NOT NULL,
  `upload` varchar(255) DEFAULT NULL,
  `tb_editora_idtb_editora` int(11) NOT NULL,
  `tb_categoria_idtb_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_livro`
--

INSERT INTO `tb_livro` (`idtb_livro`, `titulo`, `isbn`, `edicao`, `ano`, `upload`, `tb_editora_idtb_editora`, `tb_categoria_idtb_categoria`) VALUES
(1, 'Memórias Póstumas de Brás Cubas', '12345678', '1ª', 2011, NULL, 1, 4),
(2, 'Os Sertões', '12345679', '1ª', 2000, 'uploads/livros/94ce4c04df63b30d483bc0ec75b5be53.pdf', 2, 6),
(3, 'Triste Fim de Policarpo Quaresma', '49898798', '2ª', 2008, NULL, 3, 5),
(4, 'Capitães de Areia', '79879878', '3ª', 1998, 'uploads/livros/93f4d7c14f6e04fc70f1343c8d41d065.doc', 3, 4),
(5, 'Vidas Secas', '49889799', '4ª', 2002, 'uploads/livros/3b46b06c72d081d3cb73828d4e0956f4.', 4, 4),
(6, 'Livro 6 ', '78979788', '3ª', 1998, 'uploads/livros/4ec9a137eb2e3bace6fa28b935c911d1.pdf', 3, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_reserva`
--

CREATE TABLE `tb_reserva` (
  `idtb_reserva` int(11) NOT NULL,
  `tb_usuario_idtb_usuario` int(11) NOT NULL,
  `tb_exemplar_idtb_exemplar` int(11) NOT NULL,
  `dataReserva` date NOT NULL,
  `observacoes` tinytext,
  `situacao` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_reserva`
--

INSERT INTO `tb_reserva` (`idtb_reserva`, `tb_usuario_idtb_usuario`, `tb_exemplar_idtb_exemplar`, `dataReserva`, `observacoes`, `situacao`) VALUES
(1, 1, 3, '2019-06-18', '', 1),
(2, 3, 4, '2019-06-17', '', 1),
(3, 1, 8, '2019-06-18', '', 1),
(4, 4, 5, '2019-06-19', '', 1),
(5, 1, 13, '2019-04-30', '', 2),
(6, 2, 14, '2019-05-27', '', 1),
(7, 4, 16, '2019-06-20', '', 1),
(8, 1, 12, '2019-05-27', '', 3),
(9, 2, 18, '2019-06-11', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `idtb_usuario` int(11) NOT NULL,
  `nomeUsuario` varchar(255) NOT NULL,
  `tipo` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `recuperar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`idtb_usuario`, `nomeUsuario`, `tipo`, `email`, `senha`, `recuperar`) VALUES
(1, 'Juan Ferreira Carlos', 1, 'juanfcarlos.93@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(2, 'Aluno', 5, 'aluno@aluno.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(3, 'Professor', 4, 'professor@professor.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(4, 'Bibliotecario', 2, 'bibliotecario@bibliotecario.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(5, 'Funcionario', 3, 'funcionario@funcionario.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(6, 'José', 5, 'jose@jose', 'e10adc3949ba59abbe56e057f20f883e', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_autor`
--
ALTER TABLE `tb_autor`
  ADD PRIMARY KEY (`idtb_autor`),
  ADD UNIQUE KEY `nomeAutor_UNIQUE` (`nomeAutor`);

--
-- Indexes for table `tb_autoria`
--
ALTER TABLE `tb_autoria`
  ADD PRIMARY KEY (`tb_livro_idtb_livro`,`tb_autor_idtb_autor`),
  ADD KEY `fk_tb_livro_has_tb_autores_tb_livro_idx` (`tb_livro_idtb_livro`),
  ADD KEY `fk_tb_autoria_tb_autor1_idx` (`tb_autor_idtb_autor`);

--
-- Indexes for table `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`idtb_categoria`),
  ADD UNIQUE KEY `nomeCategoria_UNIQUE` (`nomeCategoria`);

--
-- Indexes for table `tb_editora`
--
ALTER TABLE `tb_editora`
  ADD PRIMARY KEY (`idtb_editora`),
  ADD UNIQUE KEY `nomeEditora_UNIQUE` (`nomeEditora`);

--
-- Indexes for table `tb_emprestimo`
--
ALTER TABLE `tb_emprestimo`
  ADD PRIMARY KEY (`idtb_emprestimo`),
  ADD KEY `fk_tb_usuario_has_tb_exemplar_tb_usuario1_idx` (`tb_usuario_idtb_usuario`),
  ADD KEY `fk_tb_usuario_has_tb_exemplar_tb_exemplar1_idx` (`tb_exemplar_idtb_exemplar`);

--
-- Indexes for table `tb_exemplar`
--
ALTER TABLE `tb_exemplar`
  ADD PRIMARY KEY (`idtb_exemplar`),
  ADD KEY `fk_tb_exemplar_tb_livro1_idx` (`tb_livro_idtb_livro`);

--
-- Indexes for table `tb_livro`
--
ALTER TABLE `tb_livro`
  ADD PRIMARY KEY (`idtb_livro`),
  ADD UNIQUE KEY `isbn_UNIQUE` (`isbn`),
  ADD KEY `fk_tb_livro_tb_editora1_idx` (`tb_editora_idtb_editora`),
  ADD KEY `fk_tb_livro_tb_categoria1_idx` (`tb_categoria_idtb_categoria`);

--
-- Indexes for table `tb_reserva`
--
ALTER TABLE `tb_reserva`
  ADD PRIMARY KEY (`idtb_reserva`),
  ADD KEY `fk_tb_reserva_tb_usuario1_idx` (`tb_usuario_idtb_usuario`),
  ADD KEY `fk_tb_reserva_tb_exemplar1_idx` (`tb_exemplar_idtb_exemplar`);

--
-- Indexes for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`idtb_usuario`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_autor`
--
ALTER TABLE `tb_autor`
  MODIFY `idtb_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `tb_categoria`
--
ALTER TABLE `tb_categoria`
  MODIFY `idtb_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tb_editora`
--
ALTER TABLE `tb_editora`
  MODIFY `idtb_editora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tb_emprestimo`
--
ALTER TABLE `tb_emprestimo`
  MODIFY `idtb_emprestimo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tb_exemplar`
--
ALTER TABLE `tb_exemplar`
  MODIFY `idtb_exemplar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `tb_livro`
--
ALTER TABLE `tb_livro`
  MODIFY `idtb_livro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tb_reserva`
--
ALTER TABLE `tb_reserva`
  MODIFY `idtb_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `idtb_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_autoria`
--
ALTER TABLE `tb_autoria`
  ADD CONSTRAINT `fk_tb_autoria_tb_autor1` FOREIGN KEY (`tb_autor_idtb_autor`) REFERENCES `tb_autor` (`idtb_autor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_livro_has_tb_autores_tb_livro` FOREIGN KEY (`tb_livro_idtb_livro`) REFERENCES `tb_livro` (`idtb_livro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_emprestimo`
--
ALTER TABLE `tb_emprestimo`
  ADD CONSTRAINT `fk_tb_usuario_has_tb_exemplar_tb_exemplar1` FOREIGN KEY (`tb_exemplar_idtb_exemplar`) REFERENCES `tb_exemplar` (`idtb_exemplar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_usuario_has_tb_exemplar_tb_usuario1` FOREIGN KEY (`tb_usuario_idtb_usuario`) REFERENCES `tb_usuario` (`idtb_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_exemplar`
--
ALTER TABLE `tb_exemplar`
  ADD CONSTRAINT `fk_tb_exemplar_tb_livro1` FOREIGN KEY (`tb_livro_idtb_livro`) REFERENCES `tb_livro` (`idtb_livro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_livro`
--
ALTER TABLE `tb_livro`
  ADD CONSTRAINT `fk_tb_livro_tb_categoria1` FOREIGN KEY (`tb_categoria_idtb_categoria`) REFERENCES `tb_categoria` (`idtb_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_livro_tb_editora1` FOREIGN KEY (`tb_editora_idtb_editora`) REFERENCES `tb_editora` (`idtb_editora`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_reserva`
--
ALTER TABLE `tb_reserva`
  ADD CONSTRAINT `fk_tb_reserva_tb_exemplar1` FOREIGN KEY (`tb_exemplar_idtb_exemplar`) REFERENCES `tb_exemplar` (`idtb_exemplar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_reserva_tb_usuario1` FOREIGN KEY (`tb_usuario_idtb_usuario`) REFERENCES `tb_usuario` (`idtb_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
