-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26-Set-2016 às 00:09
-- Versão do servidor: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sac`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_preco`
--

CREATE TABLE IF NOT EXISTS `produtos_preco` (
`id_produto_preco` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `preco_produto` decimal(10,2) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `preco_padrao` tinyint(1) DEFAULT '0',
  `data_cadastro` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos_preco`
--

INSERT INTO `produtos_preco` (`id_produto_preco`, `id_produto`, `preco_produto`, `data_inicio`, `data_fim`, `preco_padrao`, `data_cadastro`, `timestamp`) VALUES
(6, 49, '3.44', '2016-10-08', '2016-11-01', 0, '2016-09-24', '2016-09-24 20:46:03'),
(7, 49, '12.20', '0000-00-00', '0000-00-00', 1, '2016-09-24', '2016-09-24 21:25:20'),
(8, 58, '10.00', '0000-00-00', '0000-00-00', 1, '2016-09-25', '2016-09-25 16:11:59'),
(9, 58, '9.45', '2016-09-25', '2016-09-27', 0, '2016-09-25', '2016-09-25 16:12:36'),
(10, 58, '9.00', '2016-09-25', '2016-10-25', 0, '2016-09-25', '2016-09-25 16:36:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produtos_preco`
--
ALTER TABLE `produtos_preco`
 ADD PRIMARY KEY (`id_produto_preco`), ADD KEY `id_produto` (`id_produto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produtos_preco`
--
ALTER TABLE `produtos_preco`
MODIFY `id_produto_preco` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `produtos_preco`
--
ALTER TABLE `produtos_preco`
ADD CONSTRAINT `produtos_preco_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
