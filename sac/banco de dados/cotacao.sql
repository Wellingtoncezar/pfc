-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 03-Jun-2016 às 01:14
-- Versão do servidor: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sac`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int(11) NOT NULL,
  `foto_produto` varchar(255) DEFAULT NULL,
  `nome_produto` varchar(255) DEFAULT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `descricao_produto` text,
  `preco_venda_produto` decimal(10,2) NOT NULL,
  `markup_produto` decimal(10,2) NOT NULL,
  `status_produto` enum('ATIVO','INATIVO','EXCLUIDO') NOT NULL,
  `data_cadastro_produto` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `foto_produto`, `nome_produto`, `id_marca`, `id_categoria`, `descricao_produto`, `preco_venda_produto`, `markup_produto`, `status_produto`, `data_cadastro_produto`, `timestamp`) VALUES
(17, NULL, 'nome do produto', 3, 1, 'descri&ccedil;ao de teste', '0.00', '0.00', 'ATIVO', '2016-03-28 03:49:30', '2016-04-28 22:43:17'),
(18, NULL, 'nome do produto', 3, 1, 'descri&ccedil;ao de teste', '0.00', '0.00', 'INATIVO', '2016-03-28 03:57:15', '2016-04-09 00:26:16'),
(19, NULL, 'teste', 1, 1, 'teste', '0.00', '0.00', 'EXCLUIDO', '2016-05-08 01:31:01', '2016-05-23 23:34:31'),
(20, NULL, 'sfgasdfasd', 1, 1, 'asdf', '0.00', '0.00', 'EXCLUIDO', '2016-05-08 01:45:32', '2016-05-23 23:34:35'),
(21, '', 'nome do produtos', 1, 1, 'teste', '0.00', '0.00', 'EXCLUIDO', '2016-05-08 11:36:12', '2016-05-23 23:34:53'),
(22, '', 'nome do produtos', 1, 1, 'teste', '0.00', '0.00', 'EXCLUIDO', '2016-05-08 11:36:53', '2016-05-23 23:35:00'),
(23, '', 'produto de teste', 1, 1, '', '0.00', '0.00', 'EXCLUIDO', '2016-05-08 11:39:16', '2016-05-23 23:36:13'),
(24, '', 'product', 1, 2, '', '0.00', '0.00', 'EXCLUIDO', '2016-05-08 11:40:50', '2016-05-23 23:37:39'),
(25, '04628e9659719586539914ee1f911c95.png', 'aaaaa', 1, 1, 'teste', '0.00', '0.00', 'EXCLUIDO', '2016-05-08 11:43:34', '2016-05-23 23:49:48'),
(26, 'e82538c07bbd634d26f37ee5f6a7754f.png', 'algo', 1, 2, 'teste', '0.00', '0.00', 'EXCLUIDO', '2016-05-08 11:44:40', '2016-05-23 23:49:43'),
(27, '', 'nome', 1, 1, '', '0.00', '0.00', 'ATIVO', '2016-05-09 12:53:47', '2016-05-09 03:53:47'),
(28, '', 'nome', 1, 1, 'teste', '0.00', '0.00', 'EXCLUIDO', '2016-05-10 02:09:14', '2016-05-23 23:49:53'),
(29, '', 'aaaa', 1, 1, 'teste', '282.82', '0.00', 'ATIVO', '2016-05-10 02:24:46', '2016-05-10 00:24:47'),
(30, '', 'POST', 1, 1, 'desc', '2.34', '0.00', 'ATIVO', '2016-05-28 10:26:22', '2016-05-28 20:26:22'),
(31, '', 'weellll', 1, 1, 'asdf', '2.13', '0.00', 'ATIVO', '2016-05-28 11:54:39', '2016-05-28 21:54:39'),
(32, '', 'asdfsadfsdfds', 1, 2, 'asdf', '234.00', '0.00', 'ATIVO', '2016-05-28 11:57:43', '2016-05-28 21:57:43'),
(33, '', 'asdfsadfsdfds', 1, 2, 'asdf', '234.00', '0.00', 'ATIVO', '2016-05-28 11:58:15', '2016-05-28 21:58:15'),
(34, '', 'asdfsadfsdfds', 1, 2, 'asdf', '234.00', '0.00', 'ATIVO', '2016-05-28 11:58:40', '2016-05-28 21:58:40'),
(35, '', 'produto', 1, 1, 'teste', '1.34', '0.00', 'ATIVO', '2016-05-29 12:06:52', '2016-05-28 22:06:52'),
(36, '', 'Arroz tipo 1 5kg', 1, 2, 'Arroz tipo 1', '8.50', '0.00', 'ATIVO', '2016-05-29 12:11:48', '2016-05-28 22:11:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisicao_produto`
--

CREATE TABLE IF NOT EXISTS `requisicao_produto` (
  `id_requisicao_produto` int(11) NOT NULL,
  `id_requisicao` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `id_unidade_medida_produto` int(11) NOT NULL,
  `quantidade_produto` decimal(10,2) DEFAULT NULL,
  `status_requisicao_produto` enum('NOVO','APROVADO','REPROVADO') NOT NULL DEFAULT 'NOVO',
  `timestam` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `requisicao_produto`
--

INSERT INTO `requisicao_produto` (`id_requisicao_produto`, `id_requisicao`, `id_produto`, `id_unidade_medida_produto`, `quantidade_produto`, `status_requisicao_produto`, `timestam`) VALUES
(11, 12, 36, 23, '5.00', 'NOVO', '2016-05-29 04:04:19'),
(12, 12, 35, 20, '2.00', 'NOVO', '2016-05-29 04:04:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisicoes`
--

CREATE TABLE IF NOT EXISTS `requisicoes` (
  `id_requisicao` int(11) NOT NULL,
  `codigo_requisicao` varchar(255) NOT NULL,
  `titulo_requisicao` varchar(255) DEFAULT NULL,
  `observacoes_requisicao` text NOT NULL,
  `data_requisicao` datetime DEFAULT NULL,
  `status_requisicao` enum('NOVO','PENDENTE','APROVADO','REPROVADO','CANCELADO') DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `requisicoes`
--

INSERT INTO `requisicoes` (`id_requisicao`, `codigo_requisicao`, `titulo_requisicao`, `observacoes_requisicao`, `data_requisicao`, `status_requisicao`, `timestamp`) VALUES
(10, 'codigo', 'titulo', 'obs', '2016-05-23 05:11:58', 'NOVO', '2016-05-23 03:11:58'),
(11, '1234', 'nova requisi&ccedil;&atilde;o', 'nova requisi&ccedil;&atilde;o', '2016-05-24 00:22:18', 'NOVO', '2016-05-23 22:22:18'),
(12, 'codigo', 'titulo', 'obs', '2016-05-29 06:04:19', 'NOVO', '2016-05-29 04:04:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade_medida`
--

CREATE TABLE IF NOT EXISTS `unidade_medida` (
  `id_unidade_medida` int(11) NOT NULL,
  `nome_unidade_medida` varchar(255) NOT NULL,
  `abreviacao_unidade_medida` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `unidade_medida`
--

INSERT INTO `unidade_medida` (`id_unidade_medida`, `nome_unidade_medida`, `abreviacao_unidade_medida`) VALUES
(1, 'Grama(s)', 'g'),
(2, 'Quilograma(s)', 'Kg'),
(7, 'Pacote(s)', 'PC'),
(10, 'Unidade(s)', 'UN'),
(11, 'Caixa(s)', 'CX'),
(12, 'Lata(s)', 'LT'),
(13, 'Dúzia(s)', 'DZ'),
(14, 'Metro(s)', 'm'),
(15, 'Centímetro(s)', 'cm'),
(16, 'Litro(s)', 'L'),
(17, 'Fardo(s)', 'FD'),
(18, 'Kit', 'KT');

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade_medida_produto`
--

CREATE TABLE IF NOT EXISTS `unidade_medida_produto` (
  `id_unidade_medida_produto` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_unidade_medida` int(11) NOT NULL,
  `fator_unidade_medida` decimal(10,2) NOT NULL,
  `para_venda` tinyint(1) NOT NULL DEFAULT '0',
  `para_estoque` tinyint(1) NOT NULL DEFAULT '0',
  `ordem` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `unidade_medida_produto`
--

INSERT INTO `unidade_medida_produto` (`id_unidade_medida_produto`, `id_produto`, `id_unidade_medida`, `fator_unidade_medida`, `para_venda`, `para_estoque`, `ordem`, `timestamp`) VALUES
(17, 34, 1, '12.00', 1, 0, 0, '2016-05-28 21:58:40'),
(18, 34, 2, '13.00', 0, 1, 1, '2016-05-28 21:58:40'),
(19, 35, 1, '3.00', 1, 0, 0, '2016-05-28 22:06:52'),
(20, 35, 2, '33.00', 1, 1, 1, '2016-05-28 22:06:52'),
(21, 35, 7, '333.00', 1, 0, 2, '2016-05-28 22:06:52'),
(22, 36, 7, '1.00', 1, 0, 0, '2016-05-28 22:11:48'),
(23, 36, 17, '4.00', 0, 1, 1, '2016-05-28 22:11:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`);

--
-- Indexes for table `requisicao_produto`
--
ALTER TABLE `requisicao_produto`
  ADD PRIMARY KEY (`id_requisicao_produto`),
  ADD KEY `id_produto` (`id_produto`),
  ADD KEY `id_requisicao` (`id_requisicao`),
  ADD KEY `id_unidade_medida_produto` (`id_unidade_medida_produto`);

--
-- Indexes for table `requisicoes`
--
ALTER TABLE `requisicoes`
  ADD PRIMARY KEY (`id_requisicao`);

--
-- Indexes for table `unidade_medida`
--
ALTER TABLE `unidade_medida`
  ADD PRIMARY KEY (`id_unidade_medida`),
  ADD UNIQUE KEY `abreviacao_unidade_medida` (`abreviacao_unidade_medida`);

--
-- Indexes for table `unidade_medida_produto`
--
ALTER TABLE `unidade_medida_produto`
  ADD PRIMARY KEY (`id_unidade_medida_produto`),
  ADD KEY `id_produto` (`id_produto`),
  ADD KEY `id_produto_2` (`id_produto`),
  ADD KEY `id_unidade_medida` (`id_unidade_medida`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `requisicao_produto`
--
ALTER TABLE `requisicao_produto`
  MODIFY `id_requisicao_produto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `requisicoes`
--
ALTER TABLE `requisicoes`
  MODIFY `id_requisicao` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `unidade_medida`
--
ALTER TABLE `unidade_medida`
  MODIFY `id_unidade_medida` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `unidade_medida_produto`
--
ALTER TABLE `unidade_medida_produto`
  MODIFY `id_unidade_medida_produto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `requisicao_produto`
--
ALTER TABLE `requisicao_produto`
  ADD CONSTRAINT `requisicao_produto_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `requisicao_produto_ibfk_2` FOREIGN KEY (`id_requisicao`) REFERENCES `requisicoes` (`id_requisicao`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `requisicao_produto_ibfk_3` FOREIGN KEY (`id_unidade_medida_produto`) REFERENCES `unidade_medida_produto` (`id_unidade_medida_produto`);

--
-- Limitadores para a tabela `unidade_medida_produto`
--
ALTER TABLE `unidade_medida_produto`
  ADD CONSTRAINT `unidade_medida_produto_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `unidade_medida_produto_ibfk_2` FOREIGN KEY (`id_unidade_medida`) REFERENCES `unidade_medida` (`id_unidade_medida`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
