-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09-Maio-2016 às 01:40
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
-- Estrutura da tabela `cargos`
--

CREATE TABLE IF NOT EXISTS `cargos` (
`id_cargo` int(11) NOT NULL,
  `nome_cargo` varchar(255) DEFAULT NULL,
  `setor_cargo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cargos`
--

INSERT INTO `cargos` (`id_cargo`, `nome_cargo`, `setor_cargo`) VALUES
(2, 'estoquista', 'suprimentos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
`id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(255) DEFAULT NULL,
  `status_categoria` enum('ATIVO','INATIVO','EXCLUIDO') DEFAULT NULL,
  `data_cadastro_categoria` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nome_categoria`, `status_categoria`, `data_cadastro_categoria`, `timestamp`) VALUES
(1, 'Limpeza', 'ATIVO', '2016-02-23 01:22:31', '2016-02-23 03:45:38'),
(2, 'Aliment&iacute;cios', 'ATIVO', '2016-02-23 01:27:31', '2016-02-23 03:27:31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
`id_email` int(11) NOT NULL,
  `endereco_email` varchar(255) DEFAULT NULL,
  `tipo_email` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `emails`
--

INSERT INTO `emails` (`id_email`, `endereco_email`, `tipo_email`, `timestamp`) VALUES
(4, 'wellington-cezar@hotmail.com', 'Profissional', '2016-01-18 23:50:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `emails_fornecedores`
--

CREATE TABLE IF NOT EXISTS `emails_fornecedores` (
  `id_fornecedor` int(11) DEFAULT NULL,
  `id_email` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `emails_funcionarios`
--

CREATE TABLE IF NOT EXISTS `emails_funcionarios` (
  `id_funcionario` int(11) DEFAULT NULL,
  `id_email` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos`
--

CREATE TABLE IF NOT EXISTS `enderecos` (
`id_endereco` int(11) NOT NULL,
  `cep_endereco` varchar(255) DEFAULT NULL,
  `rua_endereco` varchar(255) DEFAULT NULL,
  `numero_endereco` int(11) DEFAULT NULL,
  `complemento_endereco` varchar(255) DEFAULT NULL,
  `bairro_endereco` varchar(255) DEFAULT NULL,
  `cidade_endereco` varchar(255) DEFAULT NULL,
  `estado_endereco` varchar(255) DEFAULT NULL,
  `data_cadastro_endereco` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `enderecos`
--

INSERT INTO `enderecos` (`id_endereco`, `cep_endereco`, `rua_endereco`, `numero_endereco`, `complemento_endereco`, `bairro_endereco`, `cidade_endereco`, `estado_endereco`, `data_cadastro_endereco`, `timestamp`) VALUES
(5, '08580-300', 'Rua Maresias', 234, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-01-31 02:34:10', '2016-01-10 18:21:11'),
(6, '08580-300', 'Rua Maresias', 123, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-01-10 05:02:00', '2016-01-10 18:29:48'),
(7, '08580-300', 'Rua Maresias', 23441444, '244', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-01-10 05:09:29', '2016-01-10 19:03:29'),
(8, '08580-300', 'Rua Maresias', 123, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-01-18 09:50:32', '2016-01-11 01:15:11'),
(9, '08580-300', 'Rua Maresias', 23441444, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-01-18 10:29:54', '2016-01-19 00:29:38'),
(10, '08580-300', 'Rua Maresias', 234, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-01-20 09:43:51', '2016-01-20 23:43:03'),
(11, '08580-300', 'Rua Maresias', 33, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-01-20 09:57:01', '2016-01-20 23:47:10'),
(12, '08580-300', 'Rua Maresias', 2345, '34', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-02-09 02:36:16', '2016-02-09 16:36:16'),
(13, '08580-300', 'logradouro', 123, '', 'bairro', 'cidade', 'SP', '2016-05-09 01:16:45', '2016-03-13 15:49:17'),
(14, '08580-300', 'rua maresias', 196, '', 'maragogipe', 'itaquaquecetuba', 'SP', '2016-03-21 03:53:35', '2016-03-13 16:48:42'),
(15, '08572-290', 'Rua Resende', 35, '', 'Vila S&atilde;o Roberto', 'Itaquaquecetuba', 'SP', '2016-03-14 11:50:51', '2016-03-14 22:50:51'),
(16, '08580-300', 'Rua Maresias', 123, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-05-08 11:17:45', '2016-05-05 05:04:28'),
(17, '08572-290', 'Rua Resende', 123, '', 'Vila S&atilde;o Roberto', 'Itaquaquecetuba', 'SP', '2016-05-05 07:05:26', '2016-05-05 05:05:26'),
(18, '08580-300', 'Rua Maresias', 213, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-05-05 07:08:37', '2016-05-05 05:08:37'),
(19, '08580-300', 'Rua Maresias', 123, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-05-06 01:31:03', '2016-05-05 23:31:03'),
(20, '08580-300', 'Rua Maresias', 234, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-05-08 11:15:24', '2016-05-09 02:15:24'),
(21, '08580-300', 'Rua Maresias', 234, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-05-08 11:16:45', '2016-05-09 02:16:45'),
(22, '08580-300', 'Rua Maresias', 234, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-05-08 11:17:06', '2016-05-09 02:17:06'),
(23, '08572-290', 'Rua Resende', 323232, '', 'Vila S&atilde;o Roberto', 'Itaquaquecetuba', 'SP', '2016-05-08 11:32:42', '2016-05-09 02:32:42');

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos_fornecedores`
--

CREATE TABLE IF NOT EXISTS `enderecos_fornecedores` (
  `id_fornecedor` int(11) DEFAULT NULL,
  `id_endereco` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `enderecos_fornecedores`
--

INSERT INTO `enderecos_fornecedores` (`id_fornecedor`, `id_endereco`) VALUES
(14, 9),
(15, 11),
(16, 12),
(17, 19);

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos_funcionarios`
--

CREATE TABLE IF NOT EXISTS `enderecos_funcionarios` (
  `id_funcionario` int(11) DEFAULT NULL,
  `id_endereco` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `enderecos_funcionarios`
--

INSERT INTO `enderecos_funcionarios` (`id_funcionario`, `id_endereco`) VALUES
(59, 13),
(79, 16),
(80, 17),
(81, 18),
(82, 20),
(83, 21),
(84, 22),
(85, 23);

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE IF NOT EXISTS `estoque` (
`id_estoque` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade_estoque` decimal(10,2) DEFAULT NULL,
  `quantidade_armazem` decimal(10,2) DEFAULT NULL,
  `quantidade_minima` decimal(10,2) DEFAULT NULL,
  `quantidade_maxima` decimal(10,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

CREATE TABLE IF NOT EXISTS `fornecedores` (
`id_fornecedor` int(11) NOT NULL,
  `foto_fornecedor` varchar(255) DEFAULT NULL,
  `razao_social_fornecedor` varchar(255) DEFAULT NULL,
  `nome_fantasia_fornecedor` varchar(255) DEFAULT NULL,
  `cnpj_fornecedor` varchar(255) DEFAULT NULL,
  `cpf_fornecedor` varchar(255) DEFAULT NULL,
  `pessoa_fornecedor` varchar(255) DEFAULT NULL,
  `site_fornecedor` varchar(255) DEFAULT NULL,
  `observacoes_fornecedor` text,
  `nome_contato_fornecedor` varchar(255) DEFAULT NULL,
  `data_visita_fornecedor` date DEFAULT NULL,
  `retorno_fornecedor` int(11) DEFAULT NULL,
  `status_fornecedor` enum('ATIVO','INATIVO','EXCLUIDO') DEFAULT NULL,
  `data_cadastro_fornecedor` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id_fornecedor`, `foto_fornecedor`, `razao_social_fornecedor`, `nome_fantasia_fornecedor`, `cnpj_fornecedor`, `cpf_fornecedor`, `pessoa_fornecedor`, `site_fornecedor`, `observacoes_fornecedor`, `nome_contato_fornecedor`, `data_visita_fornecedor`, `retorno_fornecedor`, `status_fornecedor`, `data_cadastro_fornecedor`, `timestamp`) VALUES
(10, '', 'Razao de teste', 'Nome fantasia', '13.123.213/1231-23', '131.231.231-23', 'PF', '', '', 'Fulano de tal', '2015-12-04', 1, 'INATIVO', '2015-11-30 02:28:26', '2016-01-19 00:33:42'),
(11, '', 'teste', 'teste', '23.434.234/2342-34', '234.234.234-23', 'PF', '', '', '', '0000-00-00', 0, 'ATIVO', '2016-01-18 10:22:38', '2016-02-09 16:12:59'),
(12, '', 'teste', 'teste', '23.434.234/2342-34', '234.234.234-23', 'PF', '', '', '', '0000-00-00', 0, 'ATIVO', '2016-01-18 10:23:21', '2016-01-19 00:23:21'),
(13, '', 'teste', 'teste', '23.434.234/2342-34', '234.234.234-23', 'PF', '', '', '', '0000-00-00', 0, 'ATIVO', '2016-01-18 10:24:05', '2016-01-19 00:24:05'),
(14, '', 'teste', 'stes', '23.423.423/4234-23', '234.234.234-23', 'PF', '', '', '', '0000-00-00', 0, 'ATIVO', '2016-01-18 10:25:01', '2016-01-19 00:25:01'),
(15, '', 'aaaaaaaaaaa', 'aaaaaaa', '22.222.222/2222-22', '111.111.111-11', 'PJ', '', '', 'alguem', '0000-00-00', 0, 'ATIVO', '2016-01-20 09:47:08', '2016-01-20 23:47:54'),
(16, '', 'ttrtertert', 'treterte', '34.534.534/5345-34', '345.345.345', 'PF', '', '', '', '0000-00-00', 0, 'ATIVO', '2016-02-09 02:36:16', '2016-02-09 16:36:16'),
(17, '2d94ec1702ea1eb2f533ab17cb964fa2.png', 'razao', 'nome', '12.354.698/7984-56', '121.111.213-21', 'PF', 'teste', '', '', '2016-05-17', 0, 'ATIVO', '2016-05-06 01:31:03', '2016-05-05 23:31:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores_agenda`
--

CREATE TABLE IF NOT EXISTS `fornecedores_agenda` (
`id_fornecedor_agenda` int(11) NOT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `titulo_agenda` varchar(255) DEFAULT NULL,
  `observacoes_agenda` text,
  `data_agenda` date DEFAULT NULL,
  `data_cadastro_agenda` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fornecedores_agenda`
--

INSERT INTO `fornecedores_agenda` (`id_fornecedor_agenda`, `id_fornecedor`, `titulo_agenda`, `observacoes_agenda`, `data_agenda`, `data_cadastro_agenda`, `timestamp`) VALUES
(10, 10, 'agendamento de teste', 'Testando...', '2015-12-07', '2015-11-30 02:29:18', '2015-11-30 04:29:18'),
(11, 10, 'teste', 'teste', '2016-02-10', '2016-02-09 02:13:53', '2016-02-09 16:13:53'),
(12, 10, 'teste', '', '2016-03-23', '2016-03-13 09:15:07', '2016-03-13 20:15:07'),
(13, 12, 'teste', 'teste', '2016-04-09', '2016-04-09 02:27:26', '2016-04-09 00:27:26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores_agenda_notificado`
--

CREATE TABLE IF NOT EXISTS `fornecedores_agenda_notificado` (
`id_agenda_notificado` int(11) NOT NULL,
  `id_fornecedor_agenda` int(11) DEFAULT NULL,
  `data_notificacao` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fornecedores_agenda_notificado`
--

INSERT INTO `fornecedores_agenda_notificado` (`id_agenda_notificado`, `id_fornecedor_agenda`, `data_notificacao`) VALUES
(1, 10, '2015-11-30'),
(2, 11, '2016-02-09'),
(3, 12, '2016-03-13'),
(4, 12, '2016-03-14'),
(5, 12, '2016-03-20'),
(6, 12, '2016-03-21'),
(7, 13, '2016-04-09'),
(8, 13, '2016-04-09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE IF NOT EXISTS `funcionarios` (
`id_funcionario` int(11) NOT NULL,
  `foto_funcionario` varchar(255) DEFAULT NULL,
  `nome_funcionario` varchar(255) NOT NULL,
  `sobrenome_funcionario` varchar(255) NOT NULL,
  `data_nascimento_funcionario` date NOT NULL,
  `sexo_funcionario` char(1) NOT NULL,
  `rg_funcionario` varchar(255) DEFAULT NULL,
  `cpf_funcionario` varchar(255) NOT NULL,
  `estado_civil_funcionario` varchar(255) DEFAULT NULL,
  `escolaridade_funcionario` varchar(255) DEFAULT NULL,
  `codigo_funcionario` varchar(255) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `data_admissao_funcionario` date DEFAULT NULL,
  `data_demissao_funcionario` date DEFAULT NULL,
  `status_funcionario` enum('ATIVO','INATIVO','EXCLUIDO') NOT NULL DEFAULT 'ATIVO',
  `data_cadastro_funcionario` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id_funcionario`, `foto_funcionario`, `nome_funcionario`, `sobrenome_funcionario`, `data_nascimento_funcionario`, `sexo_funcionario`, `rg_funcionario`, `cpf_funcionario`, `estado_civil_funcionario`, `escolaridade_funcionario`, `codigo_funcionario`, `id_cargo`, `data_admissao_funcionario`, `data_demissao_funcionario`, `status_funcionario`, `data_cadastro_funcionario`, `timestamp`) VALUES
(59, 'c1d693986ded7c8d7aa41e6939ae036e.jpg', 'wellington cezar', 'de s&aacute;', '2001-03-13', 'M', '21.331.313-2', '123.123.123-13', 'Solteiro', 'Ensino Superior Incompleto', '', 2, '2016-03-13', '2016-03-14', 'ATIVO', '2016-03-13 04:49:17', '2016-05-09 04:16:45'),
(79, '651cf18f6a4cdfff6a3efe6eccb1f480.png', 'wellington cezar', 'cezar', '1991-02-04', 'M', '', '', '', '', '050516.5613', 2, '0000-00-00', '0000-00-00', 'ATIVO', '2016-05-05 07:04:28', '2016-05-09 02:17:45'),
(80, '105d91ce4b34f32d3b9facc55751d476', 'sdlkafj', 'aksjdf', '2016-05-16', 'F', '', '', '', '', '050516.6314', 2, '0000-00-00', '0000-00-00', 'EXCLUIDO', '2016-05-05 07:05:26', '2016-05-05 22:48:36'),
(81, '', 'kjf''', 'jfasldjf', '2016-05-24', 'M', '', '', '', '', '050516.1918', 2, '0000-00-00', '0000-00-00', 'EXCLUIDO', '2016-05-05 07:08:37', '2016-05-05 22:48:42'),
(82, 'ac28f76281ab9fb0b4a3c466e30b9dd0.jpg', 'alguem', 'sobrenome', '2016-05-17', 'M', '42.334.234-3', '234.234.234-23', 'Casado', 'Ensino Fundamental Completo', '080516.2222', 2, '0000-00-00', '0000-00-00', 'ATIVO', '2016-05-08 11:15:24', '2016-05-09 02:15:24'),
(83, '', 'wqrqwe', 'qwer', '2016-05-03', 'M', '', '', 'Solteiro', 'Ensino M&eacute;dio Incompleto', '080516.6578', 2, '0000-00-00', '0000-00-00', 'ATIVO', '2016-05-08 11:16:45', '2016-05-09 02:16:45'),
(84, '', 'wqrqwe', 'qwer', '2016-05-03', 'M', '', '', 'Solteiro', 'Ensino M&eacute;dio Incompleto', '080516.6436', 2, '0000-00-00', '0000-00-00', 'ATIVO', '2016-05-08 11:17:06', '2016-05-09 02:17:06'),
(85, '89e7bf07eec1366a87836c256b029fd1.png', 'funcionario', 'teste', '2016-05-02', 'M', '', '', '', '', '080516.8071', 2, '0000-00-00', '0000-00-00', 'ATIVO', '2016-05-08 11:32:42', '2016-05-09 02:32:42');

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas`
--

CREATE TABLE IF NOT EXISTS `marcas` (
`id_marca` int(11) NOT NULL,
  `nome_marca` varchar(255) DEFAULT NULL,
  `status_marca` enum('ATIVO','INATIVO','EXCLUIDO') NOT NULL DEFAULT 'ATIVO',
  `data_cadastro_marca` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `marcas`
--

INSERT INTO `marcas` (`id_marca`, `nome_marca`, `status_marca`, `data_cadastro_marca`, `timestamp`) VALUES
(1, 'teste', 'ATIVO', '2016-04-29 05:29:48', '2016-04-29 03:29:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel_acesso`
--

CREATE TABLE IF NOT EXISTS `nivel_acesso` (
`id_nivel_acesso` int(11) NOT NULL,
  `nome_nivel_acesso` varchar(255) DEFAULT NULL,
  `permissoes` text NOT NULL,
  `index_access_db_name` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `nivel_acesso`
--

INSERT INTO `nivel_acesso` (`id_nivel_acesso`, `nome_nivel_acesso`, `permissoes`, `index_access_db_name`, `timestamp`) VALUES
(1, 'Administrativo', '*', 'default', '2016-03-13 20:00:24'),
(2, 'Gerência', '{&quot;funcionarios&quot;:{&quot;submodulos&quot;:{&quot;usuarios&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;,&quot;cadastrar&quot;:&quot;&quot;,&quot;editar&quot;:&quot;&quot;}},&quot;cargos&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;,&quot;cadastrar&quot;:&quot;&quot;,&quot;editar&quot;:&quot;&quot;}}},&quot;paginas&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;,&quot;cadastrar&quot;:&quot;&quot;,&quot;editar&quot;:&quot;&quot;,&quot;excluir&quot;:&quot;&quot;}}},&quot;produtos&quot;:{&quot;submodulos&quot;:{},&quot;paginas&quot;:{&quot;gerenciar&quot;:{},&quot;undefined&quot;:{}}},&quot;estoque&quot;:{&quot;submodulos&quot;:{},&quot;paginas&quot;:{&quot;gerenciar&quot;:{}}},&quot;caixa&quot;:{&quot;submodulos&quot;:{},&quot;paginas&quot;:{&quot;gerenciar&quot;:{}}}}', 'gerencia', '2016-04-11 22:40:32'),
(4, 'Caixa', '{&quot;funcionarios&quot;:{&quot;submodulos&quot;:{&quot;grupo_funcionarios&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;}},&quot;usuarios&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;}},&quot;cargos&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;,&quot;cadastrar&quot;:&quot;&quot;,&quot;editar&quot;:&quot;&quot;}}},&quot;paginas&quot;:{&quot;Gerenciar&quot;:{&quot;index&quot;:&quot;&quot;,&quot;cadastrar&quot;:&quot;&quot;,&quot;editar&quot;:&quot;&quot;,&quot;excluir&quot;:&quot;&quot;}}},&quot;caixa&quot;:{&quot;submodulos&quot;:{},&quot;paginas&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;}}}}', 'caixa', '2016-03-13 18:46:47'),
(5, 'Suprimentos', '{&quot;fornecedores&quot;:{&quot;submodulos&quot;:{},&quot;paginas&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;},&quot;Agenda&quot;:{&quot;index&quot;:&quot;&quot;}}},&quot;produtos&quot;:{&quot;submodulos&quot;:{},&quot;paginas&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;}}},&quot;estoque&quot;:{&quot;submodulos&quot;:{},&quot;paginas&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;}}},&quot;caixa&quot;:{&quot;submodulos&quot;:{},&quot;paginas&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;}}},&quot;vendas&quot;:{&quot;submodulos&quot;:{},&quot;paginas&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;}}},&quot;orcamentos&quot;:{&quot;submodulos&quot;:{},&quot;paginas&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;}}}}', 'suprimentos', '2016-03-13 19:15:40');

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
  `status_produto` enum('ATIVO','INATIVO','EXCLUIDO') NOT NULL,
  `data_cadastro_produto` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `foto_produto`, `nome_produto`, `id_marca`, `id_categoria`, `descricao_produto`, `status_produto`, `data_cadastro_produto`, `timestamp`) VALUES
(17, NULL, 'nome do produto', 3, 1, 'descri&ccedil;ao de teste', 'ATIVO', '2016-03-28 03:49:30', '2016-04-28 22:43:17'),
(18, NULL, 'nome do produto', 3, 1, 'descri&ccedil;ao de teste', 'INATIVO', '2016-03-28 03:57:15', '2016-04-09 00:26:16'),
(19, NULL, 'teste', 1, 1, 'teste', 'INATIVO', '2016-05-08 01:31:01', '2016-05-09 03:41:15'),
(20, NULL, 'sfgasdfasd', 1, 1, 'asdf', 'INATIVO', '2016-05-08 01:45:32', '2016-05-09 03:41:16'),
(21, '', 'nome do produtos', 1, 1, 'teste', 'INATIVO', '2016-05-08 11:36:12', '2016-05-09 03:41:17'),
(22, '', 'nome do produtos', 1, 1, 'teste', 'INATIVO', '2016-05-08 11:36:53', '2016-05-09 03:39:39'),
(23, '', 'produto de teste', 1, 1, '', 'INATIVO', '2016-05-08 11:39:16', '2016-05-09 03:41:18'),
(24, '', 'product', 1, 2, '', 'ATIVO', '2016-05-08 11:40:50', '2016-05-09 02:40:50'),
(25, '04628e9659719586539914ee1f911c95.png', 'aaaaa', 1, 1, 'teste', 'ATIVO', '2016-05-08 11:43:34', '2016-05-09 02:43:34'),
(26, 'e82538c07bbd634d26f37ee5f6a7754f.png', 'algo', 1, 2, 'teste', 'ATIVO', '2016-05-08 11:44:40', '2016-05-09 02:44:40'),
(27, '', 'nome', 1, 1, '', 'ATIVO', '2016-05-09 12:53:47', '2016-05-09 03:53:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_fornecedores`
--

CREATE TABLE IF NOT EXISTS `produto_fornecedores` (
`id_produto_fornecedor` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `fornecedor_principal` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto_fornecedores`
--

INSERT INTO `produto_fornecedores` (`id_produto_fornecedor`, `id_produto`, `id_fornecedor`, `fornecedor_principal`) VALUES
(19, 17, 13, 1),
(20, 17, 15, 0),
(21, 18, 13, 1),
(22, 18, 15, 0),
(23, 18, 16, 0),
(24, 19, 11, 1),
(25, 20, 11, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisicao_produto`
--

CREATE TABLE IF NOT EXISTS `requisicao_produto` (
`id_requisicao_produto` int(11) NOT NULL,
  `id_requisicao` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade_produto` decimal(10,2) DEFAULT NULL,
  `timestam` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisicao_usuario`
--

CREATE TABLE IF NOT EXISTS `requisicao_usuario` (
`id_requisicao_usuario` int(11) NOT NULL,
  `id_requisicao` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisicoes`
--

CREATE TABLE IF NOT EXISTS `requisicoes` (
`id_requisicao` int(11) NOT NULL,
  `codigo_requisicao` varchar(255) NOT NULL,
  `titulo_requisicao` varchar(255) DEFAULT NULL,
  `descricao_requisicao` text NOT NULL,
  `data_requisicao` datetime DEFAULT NULL,
  `status_requisicao` enum('NOVO','PENDENTE','APROVADO','REPROVADO','CANCELADO') DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_actions`
--

CREATE TABLE IF NOT EXISTS `sys_actions` (
`id_action` int(11) NOT NULL,
  `url_action` varchar(255) DEFAULT NULL,
  `nome_action` varchar(255) DEFAULT NULL,
  `status_action` varchar(255) DEFAULT NULL,
  `status_selecao_action` varchar(255) DEFAULT NULL,
  `id_pagina` int(11) DEFAULT NULL,
  `posicao_action` int(11) DEFAULT NULL,
  `data_criacao_action` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_actions`
--

INSERT INTO `sys_actions` (`id_action`, `url_action`, `nome_action`, `status_action`, `status_selecao_action`, `id_pagina`, `posicao_action`, `data_criacao_action`) VALUES
(1, 'index', 'Home', 'INATIVO', 'ATIVO', 1, NULL, '2016-01-20 21:14:22'),
(2, 'cadastrar', 'Cadastrar', 'INATIVO', 'ATIVO', 1, NULL, '2016-01-20 21:15:30'),
(3, 'editar', 'Editar', 'INATIVO', 'ATIVO', 1, NULL, '2016-01-20 21:16:11'),
(4, 'excluir', 'Excluir', 'INATIVO', 'ATIVO', 1, NULL, '2016-01-20 21:16:48'),
(5, 'index', 'Home', 'INATIVO', 'ATIVO', 6, NULL, '2016-01-20 21:44:57'),
(6, 'index', NULL, 'INATIVO', 'INATIVO', 2, NULL, '2016-01-20 22:05:41'),
(7, 'index', NULL, 'INATIVO', 'INATIVO', 4, NULL, '2016-01-20 22:05:44'),
(9, 'index', NULL, 'INATIVO', 'INATIVO', 3, NULL, '2016-01-21 20:36:13'),
(10, 'index', 'Home', 'INATIVO', 'INATIVO', 7, NULL, '2016-01-23 16:19:53'),
(11, 'index', NULL, 'INATIVO', 'INATIVO', 8, NULL, '2016-01-23 16:20:46'),
(12, 'index', NULL, 'INATIVO', 'INATIVO', 9, NULL, '2016-01-23 16:21:21'),
(15, 'index', NULL, 'INATIVO', 'INATIVO', 12, NULL, '2016-01-23 16:23:17'),
(16, 'index', NULL, 'INATIVO', 'INATIVO', 13, NULL, '2016-01-30 15:00:29'),
(18, 'index', 'Home', 'INATIVO', 'INATIVO', 15, NULL, '2016-02-09 14:13:25'),
(19, 'index', NULL, 'INATIVO', 'INATIVO', 16, NULL, '2016-03-03 23:16:41'),
(20, 'index', 'Home', 'INATIVO', 'INATIVO', 17, NULL, '2016-03-13 03:31:55'),
(21, 'cadastrar', 'Cadastrar', 'INATIVO', 'INATIVO', 17, NULL, '2016-03-13 03:32:03'),
(22, 'editar', NULL, 'INATIVO', 'INATIVO', 17, NULL, '2016-03-13 03:55:10'),
(23, 'cadastrar', NULL, 'INATIVO', 'INATIVO', 16, NULL, '2016-03-13 20:19:12'),
(24, 'editar', NULL, 'INATIVO', 'INATIVO', 16, NULL, '2016-03-13 21:05:16'),
(25, 'cadastrar', 'Cadastrar', 'INATIVO', 'INATIVO', 7, NULL, '2016-03-15 01:07:21'),
(26, 'index', NULL, 'INATIVO', 'INATIVO', 18, NULL, '2016-03-22 00:01:40'),
(27, 'index', NULL, 'INATIVO', 'INATIVO', 19, NULL, '2016-03-22 00:01:50'),
(28, 'excluir', 'Excluir', 'INATIVO', 'INATIVO', 7, NULL, '2016-03-29 02:08:38'),
(29, 'editar', 'Editar', 'INATIVO', 'INATIVO', 7, NULL, '2016-03-29 02:19:13'),
(30, 'index', NULL, 'INATIVO', 'INATIVO', 20, NULL, '2016-04-26 01:13:33'),
(31, 'index', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-04-26 01:17:26'),
(32, 'index', NULL, 'ATIVO', 'INATIVO', 22, NULL, '2016-04-26 01:17:40'),
(33, 'index', NULL, 'ATIVO', 'INATIVO', 23, NULL, '2016-04-26 01:17:53'),
(34, 'cadastrar', NULL, 'INATIVO', 'INATIVO', 21, NULL, '2016-04-26 01:20:58'),
(35, 'cadastrar', NULL, 'INATIVO', 'INATIVO', 19, NULL, '2016-04-29 05:28:58'),
(36, 'cadastrar', NULL, 'INATIVO', 'INATIVO', 6, NULL, '2016-05-06 01:26:24'),
(37, 'editar', NULL, 'INATIVO', 'INATIVO', 19, NULL, '2016-05-07 14:40:33');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_modulos`
--

CREATE TABLE IF NOT EXISTS `sys_modulos` (
`id_modulo` int(11) NOT NULL,
  `url_modulo` varchar(255) NOT NULL,
  `nome_modulo` varchar(255) DEFAULT NULL,
  `posicao_modulo` varchar(255) DEFAULT NULL,
  `status_modulo` enum('ATIVO','INATIVO','EXCLUIDO') DEFAULT NULL,
  `status_selecao_modulo` varchar(255) DEFAULT NULL,
  `id_modulo_pai` int(11) DEFAULT NULL,
  `icone_modulo` varchar(255) DEFAULT NULL,
  `data_criacao_modulo` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_modulos`
--

INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES
(0, '', 'ROOT', '0', 'ATIVO', 'INATIVO', NULL, NULL, '2016-01-20 00:00:00'),
(5, 'funcionarios', 'Funcion&aacute;rios', '0', 'ATIVO', 'ATIVO', 0, 'glyphicons glyphicons-group', '2016-01-20 15:15:22'),
(6, 'configuracoes', 'Configura&ccedil;&otilde;es', '7', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-cogwheels', '2016-01-20 15:24:33'),
(7, 'modulos', 'M&oacute;dulos', '', 'ATIVO', 'INATIVO', 6, NULL, '2016-01-20 15:24:40'),
(8, 'fornecedores', 'Fornecedores', '1', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-handshake', '2016-01-20 20:55:14'),
(9, 'produtos', 'Produtos', '2', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-package', '2016-01-23 16:19:53'),
(10, 'estoque', 'Estoque', '3', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-cargo', '2016-01-23 16:20:46'),
(11, 'caixa', 'Caixa', '4', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-calculator', '2016-01-23 16:21:21'),
(14, 'relatorios', 'Relat&oacute;rios', '6', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-stats', '2016-01-23 16:23:17'),
(15, 'niveis_acesso', 'N&iacute;veis de acesso', NULL, 'ATIVO', 'INATIVO', 6, NULL, '2016-01-30 15:00:29'),
(17, 'usuarios', 'Usu&aacute;rios', NULL, 'ATIVO', 'INATIVO', 5, NULL, '2016-03-03 23:16:41'),
(18, 'cargos', 'Cargos', NULL, 'ATIVO', 'INATIVO', 5, NULL, '2016-03-13 03:31:55'),
(19, 'categorias', 'Categorias', NULL, 'ATIVO', 'INATIVO', 9, NULL, '2016-03-22 00:01:40'),
(20, 'marcas', 'Marcas', NULL, 'ATIVO', 'INATIVO', 9, NULL, '2016-03-22 00:01:50'),
(21, 'suprimentos', 'Suprimentos', '5', 'ATIVO', 'ATIVO', 0, 'glyphicons glyphicons-transfer', '2016-04-26 01:13:32'),
(22, 'requisicoes', 'Requisi&ccedil;&otilde;es', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-04-26 01:17:25'),
(23, 'cotacoes', 'Cota&ccedil;&otilde;es', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-04-26 01:17:40'),
(24, 'pedidos', 'Pedidos', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-04-26 01:17:52');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_paginas`
--

CREATE TABLE IF NOT EXISTS `sys_paginas` (
`id_pagina` int(11) NOT NULL,
  `url_pagina` varchar(255) DEFAULT NULL,
  `nome_pagina` varchar(255) DEFAULT NULL,
  `posicao_pagina` int(11) DEFAULT NULL,
  `status_pagina` varchar(255) DEFAULT NULL,
  `status_selecao_pagina` varchar(255) DEFAULT NULL,
  `id_modulo` int(11) DEFAULT NULL,
  `data_criacao_pagina` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_paginas`
--

INSERT INTO `sys_paginas` (`id_pagina`, `url_pagina`, `nome_pagina`, `posicao_pagina`, `status_pagina`, `status_selecao_pagina`, `id_modulo`, `data_criacao_pagina`) VALUES
(1, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'ATIVO', 5, '2016-01-20 15:16:52'),
(2, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'INATIVO', 6, '2016-01-20 15:24:33'),
(3, 'gerenciar', NULL, NULL, 'INATIVO', 'INATIVO', 0, '2016-01-20 15:24:38'),
(4, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 7, '2016-01-20 15:24:41'),
(6, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'ATIVO', 8, '2016-01-20 20:55:14'),
(7, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'INATIVO', 9, '2016-01-23 16:19:53'),
(8, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 10, '2016-01-23 16:20:46'),
(9, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 11, '2016-01-23 16:21:21'),
(12, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 14, '2016-01-23 16:23:17'),
(13, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 15, '2016-01-30 15:00:29'),
(15, 'Agenda', 'Agenda', NULL, 'ATIVO', 'ATIVO', 8, '2016-02-09 14:13:25'),
(16, 'gerenciar', NULL, NULL, 'INATIVO', 'INATIVO', 17, '2016-03-03 23:16:41'),
(17, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 18, '2016-03-13 03:31:55'),
(18, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 19, '2016-03-22 00:01:40'),
(19, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 20, '2016-03-22 00:01:50'),
(20, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 21, '2016-04-26 01:13:32'),
(21, 'gerenciar', NULL, NULL, 'ATIVO', 'INATIVO', 22, '2016-04-26 01:17:25'),
(22, 'gerenciar', NULL, NULL, 'ATIVO', 'INATIVO', 23, '2016-04-26 01:17:40'),
(23, 'gerenciar', NULL, NULL, 'ATIVO', 'INATIVO', 24, '2016-04-26 01:17:53');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_usuarios`
--

CREATE TABLE IF NOT EXISTS `sys_usuarios` (
`id_usuario` int(11) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_nivel_acesso` int(11) DEFAULT NULL,
  `email_usuario` varchar(255) NOT NULL,
  `login_usuario` varchar(255) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `hash_acesso` text,
  `status_usuario` varchar(255) DEFAULT NULL,
  `data_criacao_usuario` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_usuarios`
--

INSERT INTO `sys_usuarios` (`id_usuario`, `id_funcionario`, `id_nivel_acesso`, `email_usuario`, `login_usuario`, `senha_usuario`, `hash_acesso`, `status_usuario`, `data_criacao_usuario`, `timestamp`) VALUES
(1, 59, 1, 'wellington-cezar@hotmail.com', 'admin', '$2a$08$MTY2MjMyMDcyMTU3MmJjNe4RI1/LIguX39aJwjjJ374Tx2TdxfSXe', '$2a$08$MTI5MTEyMzQwNzU3MmY2NudBeS6z2TsA8hKRLT3jPwnWbA1dOKK7m', 'ATIVO', NULL, '2016-05-05 22:17:49');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_usuarios_acessos`
--

CREATE TABLE IF NOT EXISTS `sys_usuarios_acessos` (
`id_usuarios_acesso` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `data_acesso` date DEFAULT NULL,
  `hora_acesso` time DEFAULT NULL,
  `ip_acesso` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_usuarios_acessos`
--

INSERT INTO `sys_usuarios_acessos` (`id_usuarios_acesso`, `id_usuario`, `data_acesso`, `hora_acesso`, `ip_acesso`) VALUES
(1, 1, '2016-03-14', '03:46:40', '::1'),
(2, 1, '2016-03-14', '03:54:20', '::1'),
(3, 1, '2016-03-14', '03:57:38', '::1'),
(4, 1, '2016-03-14', '04:12:37', '::1'),
(5, 1, '2016-03-14', '04:39:22', '::1'),
(6, 1, '2016-03-14', '04:41:10', '::1'),
(7, 1, '2016-03-14', '04:55:54', '::1'),
(8, 3, '2016-03-14', '05:00:11', '::1'),
(9, 3, '2016-03-14', '05:01:13', '::1'),
(10, 1, '2016-03-14', '05:09:38', '::1'),
(11, 3, '2016-03-14', '05:11:12', '::1'),
(12, 1, '2016-03-14', '23:17:42', '::1'),
(13, 3, '2016-03-14', '23:19:46', '::1'),
(14, 1, '2016-03-14', '23:20:21', '::1'),
(15, 1, '2016-03-14', '23:36:39', '::1'),
(16, 3, '2016-03-14', '23:37:24', '::1'),
(17, 1, '2016-03-14', '23:40:20', '::1'),
(18, 1, '2016-03-14', '23:47:25', '::1'),
(19, 4, '2016-03-14', '23:55:56', '::1'),
(20, 4, '2016-03-14', '23:56:33', '::1'),
(21, 1, '2016-03-14', '23:56:58', '::1'),
(22, 4, '2016-03-15', '00:01:24', '::1'),
(23, 1, '2016-03-15', '01:11:49', '::1'),
(24, 3, '2016-03-15', '01:16:26', '::1'),
(25, 4, '2016-03-15', '01:23:50', '::1'),
(26, 1, '2016-03-20', '03:12:52', '::1'),
(27, 1, '2016-03-20', '05:16:46', '::1'),
(28, 1, '2016-03-20', '05:17:08', '::1'),
(29, 1, '2016-03-20', '05:17:41', '::1'),
(30, 1, '2016-03-20', '05:17:50', '::1'),
(31, 1, '2016-03-20', '05:18:37', '::1'),
(32, 1, '2016-03-20', '05:20:13', '::1'),
(33, 1, '2016-03-20', '05:27:44', '::1'),
(34, 1, '2016-03-20', '05:28:12', '::1'),
(35, 1, '2016-03-20', '05:33:18', '::1'),
(36, 1, '2016-03-20', '05:34:59', '::1'),
(37, 1, '2016-03-20', '05:35:22', '::1'),
(38, 1, '2016-03-20', '05:35:56', '::1'),
(39, 1, '2016-03-20', '05:36:56', '::1'),
(40, 1, '2016-03-20', '05:37:16', '::1'),
(41, 1, '2016-03-20', '05:37:46', '::1'),
(42, 1, '2016-03-20', '05:37:59', '::1'),
(43, 1, '2016-03-20', '05:38:28', '::1'),
(44, 1, '2016-03-20', '05:39:18', '::1'),
(45, 1, '2016-03-20', '05:39:20', '::1'),
(46, 1, '2016-03-20', '05:39:28', '::1'),
(47, 1, '2016-03-20', '05:40:00', '::1'),
(48, 1, '2016-03-20', '05:40:04', '::1'),
(49, 1, '2016-03-20', '05:45:32', '::1'),
(50, 1, '2016-03-20', '05:46:04', '::1'),
(51, 1, '2016-03-20', '05:46:19', '::1'),
(52, 1, '2016-03-20', '05:46:38', '::1'),
(53, 1, '2016-03-20', '05:47:19', '::1'),
(54, 1, '2016-03-20', '17:26:58', '::1'),
(55, 1, '2016-03-20', '17:27:44', '::1'),
(56, 1, '2016-03-20', '17:28:39', '::1'),
(57, 1, '2016-03-20', '17:28:51', '::1'),
(58, 1, '2016-03-20', '17:29:52', '::1'),
(59, 1, '2016-03-20', '17:31:12', '::1'),
(60, 1, '2016-03-20', '17:31:37', '::1'),
(61, 1, '2016-03-20', '17:31:48', '::1'),
(62, 1, '2016-03-20', '17:31:59', '::1'),
(63, 1, '2016-03-20', '17:32:33', '::1'),
(64, 1, '2016-03-20', '17:32:58', '::1'),
(65, 1, '2016-03-20', '17:33:04', '::1'),
(66, 1, '2016-03-20', '17:33:40', '::1'),
(67, 1, '2016-03-20', '17:34:00', '::1'),
(68, 1, '2016-03-20', '17:35:11', '::1'),
(69, 1, '2016-03-20', '17:35:43', '::1'),
(70, 1, '2016-03-20', '17:35:59', '::1'),
(71, 1, '2016-03-20', '17:36:15', '::1'),
(72, 1, '2016-03-20', '17:43:34', '::1'),
(73, 1, '2016-03-20', '17:44:06', '::1'),
(74, 1, '2016-03-20', '17:44:40', '::1'),
(75, 1, '2016-03-20', '17:46:19', '::1'),
(76, 1, '2016-03-20', '17:46:37', '::1'),
(77, 1, '2016-03-20', '17:46:43', '::1'),
(78, 1, '2016-03-20', '17:47:26', '::1'),
(79, 1, '2016-03-20', '17:48:28', '::1'),
(80, 1, '2016-03-20', '17:48:43', '::1'),
(81, 1, '2016-03-20', '17:48:46', '::1'),
(82, 1, '2016-03-20', '17:48:56', '::1'),
(83, 1, '2016-03-20', '17:48:58', '::1'),
(84, 1, '2016-03-20', '17:51:59', '::1'),
(85, 1, '2016-03-20', '17:52:20', '::1'),
(86, 1, '2016-03-20', '17:52:55', '::1'),
(87, 1, '2016-03-20', '17:53:54', '::1'),
(88, 1, '2016-03-20', '17:54:25', '::1'),
(89, 1, '2016-03-20', '17:55:13', '::1'),
(90, 1, '2016-03-20', '17:55:28', '::1'),
(91, 1, '2016-03-20', '17:58:14', '::1'),
(92, 1, '2016-03-20', '17:58:33', '::1'),
(93, 1, '2016-03-20', '17:59:29', '::1'),
(94, 1, '2016-03-20', '18:00:17', '::1'),
(95, 1, '2016-03-20', '18:00:29', '::1'),
(96, 1, '2016-03-20', '18:00:46', '::1'),
(97, 1, '2016-03-20', '18:01:07', '::1'),
(98, 1, '2016-03-20', '18:01:15', '::1'),
(99, 1, '2016-03-20', '18:01:25', '::1'),
(100, 1, '2016-03-20', '18:01:41', '::1'),
(101, 1, '2016-03-20', '18:01:46', '::1'),
(102, 1, '2016-03-20', '18:02:01', '::1'),
(103, 1, '2016-03-20', '18:02:19', '::1'),
(104, 1, '2016-03-20', '18:02:27', '::1'),
(105, 1, '2016-03-20', '18:04:19', '::1'),
(106, 1, '2016-03-20', '18:17:54', '::1'),
(107, 1, '2016-03-20', '18:18:04', '::1'),
(108, 1, '2016-03-20', '18:18:24', '::1'),
(109, 1, '2016-03-20', '18:18:39', '::1'),
(110, 1, '2016-03-20', '18:18:45', '::1'),
(111, 1, '2016-03-20', '18:18:56', '::1'),
(112, 1, '2016-03-20', '18:19:32', '::1'),
(113, 1, '2016-03-20', '18:21:25', '::1'),
(114, 1, '2016-03-20', '18:21:56', '::1'),
(115, 1, '2016-03-20', '18:22:20', '::1'),
(116, 1, '2016-03-20', '18:22:23', '::1'),
(117, 1, '2016-03-20', '18:24:12', '::1'),
(118, 1, '2016-03-20', '18:24:16', '::1'),
(119, 1, '2016-03-20', '18:26:17', '::1'),
(120, 1, '2016-03-20', '18:34:21', '::1'),
(121, 3, '2016-03-20', '19:29:31', '::1'),
(122, 1, '2016-03-20', '20:39:51', '::1'),
(123, 3, '2016-03-20', '20:40:46', '::1'),
(124, 3, '2016-03-20', '21:20:55', '::1'),
(125, 1, '2016-03-21', '02:39:36', '::1'),
(126, 1, '2016-03-21', '02:41:19', '::1'),
(127, 3, '2016-03-21', '02:42:49', '::1'),
(128, 1, '2016-03-21', '03:40:14', '::1'),
(129, 1, '2016-03-21', '03:41:00', '::1'),
(130, 3, '2016-03-21', '03:41:15', '::1'),
(131, 1, '2016-03-21', '03:44:27', '::1'),
(132, 3, '2016-03-21', '03:46:10', '::1'),
(133, 3, '2016-03-21', '03:53:04', '::1'),
(134, 3, '2016-03-21', '04:42:59', '::1'),
(135, 3, '2016-03-21', '04:45:35', '::1'),
(136, 3, '2016-03-21', '04:49:20', '::1'),
(137, 3, '2016-03-21', '04:52:55', '::1'),
(138, 3, '2016-03-21', '23:46:22', '::1'),
(139, 3, '2016-03-21', '23:46:34', '::1'),
(140, 1, '2016-03-21', '23:46:54', '::1'),
(141, 3, '2016-03-22', '00:02:41', '::1'),
(142, 3, '2016-03-22', '00:05:13', '::1'),
(143, 1, '2016-03-26', '17:09:48', '::1'),
(144, 1, '2016-03-29', '00:26:06', '::1'),
(145, 1, '2016-04-01', '00:09:06', '::1'),
(146, 1, '2016-04-01', '01:04:32', '::1'),
(147, 1, '2016-04-01', '01:07:44', '::1'),
(148, 1, '2016-04-01', '01:07:45', '::1'),
(149, 1, '2016-04-01', '01:09:29', '::1'),
(150, 3, '2016-04-01', '01:11:17', '::1'),
(151, 1, '2016-04-01', '01:38:34', '::1'),
(152, 1, '2016-04-02', '14:51:01', '::1'),
(153, 3, '2016-04-02', '16:01:04', '::1'),
(154, 1, '2016-04-02', '16:03:34', '::1'),
(155, 3, '2016-04-02', '16:04:40', '::1'),
(156, 1, '2016-04-03', '17:04:42', '::1'),
(157, 1, '2016-04-05', '00:48:35', '::1'),
(158, 3, '2016-04-05', '00:50:13', '::1'),
(159, 3, '2016-04-05', '00:51:02', '::1'),
(160, 1, '2016-04-07', '07:01:28', '::1'),
(161, 1, '2016-04-09', '02:21:38', '::1'),
(162, 3, '2016-04-09', '02:28:21', '::1'),
(163, 1, '2016-04-09', '02:30:14', '::1'),
(164, 1, '2016-04-09', '14:49:42', '::1'),
(165, 1, '2016-04-12', '00:34:04', '::1'),
(166, 3, '2016-04-12', '00:40:01', '::1'),
(167, 3, '2016-04-12', '00:40:49', '::1'),
(168, 1, '2016-04-15', '00:20:07', '::1'),
(169, 1, '2016-04-26', '01:06:52', '::1'),
(170, 1, '2016-04-29', '00:35:06', '::1'),
(171, 1, '2016-05-04', '00:43:27', '::1'),
(172, 1, '2016-05-05', '06:03:25', '::1'),
(173, 1, '2016-05-06', '00:17:56', '::1'),
(174, 1, '2016-05-07', '13:39:36', '::1'),
(175, 1, '2016-05-08', '13:19:53', '::1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_usuarios_grupo`
--

CREATE TABLE IF NOT EXISTS `sys_usuarios_grupo` (
`id_usuarios_grupo` int(11) NOT NULL,
  `id_nivel_acesso` int(11) NOT NULL,
  `nome_usuarios_grupo` varchar(255) DEFAULT NULL,
  `permissao` text NOT NULL,
  `data_criacao_grupo` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefones`
--

CREATE TABLE IF NOT EXISTS `telefones` (
`id_telefone` int(11) NOT NULL,
  `categoria_telefone` varchar(255) DEFAULT NULL,
  `numero_telefone` varchar(255) DEFAULT NULL,
  `tipo_telefone` varchar(255) DEFAULT NULL,
  `operadora_telefone` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `telefones`
--

INSERT INTO `telefones` (`id_telefone`, `categoria_telefone`, `numero_telefone`, `tipo_telefone`, `operadora_telefone`, `timestamp`) VALUES
(4, 'celular', '(13) 21321-3213', 'Pessoal', 'operadora', '2016-01-10 18:40:44'),
(5, 'celular', '(77) 77777-7777', 'Pessoal', 'op', '2016-01-10 18:42:04'),
(6, 'telefone', '(22) 22222-2222', 'Profissional', '333', '2016-01-10 19:02:00'),
(8, 'celular', '(42) 34234-2342', 'Pessoal', '33333333333333333333333', '2016-01-11 01:24:51'),
(9, 'telefone', '(23) 4', 'Pessoal', '234', '2016-01-19 00:29:54'),
(10, 'telefone', '(11) 32838-3838', 'Pessoal', 'tim', '2016-03-13 16:48:42');

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefones_fornecedores`
--

CREATE TABLE IF NOT EXISTS `telefones_fornecedores` (
  `id_fornecedor` int(11) DEFAULT NULL,
  `id_telefone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `telefones_fornecedores`
--

INSERT INTO `telefones_fornecedores` (`id_fornecedor`, `id_telefone`) VALUES
(14, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefones_funcionarios`
--

CREATE TABLE IF NOT EXISTS `telefones_funcionarios` (
  `id_funcionario` int(11) DEFAULT NULL,
  `id_telefone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade_medida`
--

CREATE TABLE IF NOT EXISTS `unidade_medida` (
`id_unidade_medida` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `nome_unidade_medida` varchar(255) DEFAULT NULL,
  `codigo_unidade_medida` varchar(255) DEFAULT NULL,
  `fator_unidade_medida` decimal(10,2) NOT NULL,
  `ordem` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `unidade_medida`
--

INSERT INTO `unidade_medida` (`id_unidade_medida`, `id_produto`, `nome_unidade_medida`, `codigo_unidade_medida`, `fator_unidade_medida`, `ordem`, `timestamp`) VALUES
(7, 23, 'unidade', 'uni', '0.00', 0, '2016-05-09 02:39:16'),
(8, 24, 'unidade', 'uni', '0.00', 0, '2016-05-09 02:40:50'),
(9, 24, 'caixa', 'cx', '0.00', 1, '2016-05-09 02:40:50'),
(10, 25, '1', '1', '0.00', 0, '2016-05-09 02:43:34'),
(11, 26, '2', '3', '0.00', 0, '2016-05-09 02:44:40'),
(12, 27, 'aa', 'ss', '10.00', 0, '2016-05-09 03:53:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargos`
--
ALTER TABLE `cargos`
 ADD PRIMARY KEY (`id_cargo`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
 ADD PRIMARY KEY (`id_categoria`), ADD UNIQUE KEY `nome_categoria` (`nome_categoria`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
 ADD PRIMARY KEY (`id_email`);

--
-- Indexes for table `emails_fornecedores`
--
ALTER TABLE `emails_fornecedores`
 ADD KEY `id_email` (`id_email`), ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- Indexes for table `emails_funcionarios`
--
ALTER TABLE `emails_funcionarios`
 ADD KEY `id_email` (`id_email`), ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indexes for table `enderecos`
--
ALTER TABLE `enderecos`
 ADD PRIMARY KEY (`id_endereco`);

--
-- Indexes for table `enderecos_fornecedores`
--
ALTER TABLE `enderecos_fornecedores`
 ADD KEY `id_fornecedor` (`id_fornecedor`), ADD KEY `id_endereco` (`id_endereco`);

--
-- Indexes for table `enderecos_funcionarios`
--
ALTER TABLE `enderecos_funcionarios`
 ADD KEY `id_funcionario` (`id_funcionario`), ADD KEY `id_endereco` (`id_endereco`);

--
-- Indexes for table `estoque`
--
ALTER TABLE `estoque`
 ADD PRIMARY KEY (`id_estoque`), ADD KEY `id_produto` (`id_produto`);

--
-- Indexes for table `fornecedores`
--
ALTER TABLE `fornecedores`
 ADD PRIMARY KEY (`id_fornecedor`);

--
-- Indexes for table `fornecedores_agenda`
--
ALTER TABLE `fornecedores_agenda`
 ADD PRIMARY KEY (`id_fornecedor_agenda`), ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- Indexes for table `fornecedores_agenda_notificado`
--
ALTER TABLE `fornecedores_agenda_notificado`
 ADD PRIMARY KEY (`id_agenda_notificado`), ADD KEY `id_fornecedor_agenda` (`id_fornecedor_agenda`);

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
 ADD PRIMARY KEY (`id_funcionario`), ADD UNIQUE KEY `codigo_funcionario` (`codigo_funcionario`), ADD KEY `id_estado_civil` (`estado_civil_funcionario`), ADD KEY `id_escolaridade` (`escolaridade_funcionario`), ADD KEY `id_cargo` (`id_cargo`), ADD KEY `id_cargo_2` (`id_cargo`);

--
-- Indexes for table `marcas`
--
ALTER TABLE `marcas`
 ADD PRIMARY KEY (`id_marca`);

--
-- Indexes for table `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
 ADD PRIMARY KEY (`id_nivel_acesso`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
 ADD PRIMARY KEY (`id_produto`);

--
-- Indexes for table `produto_fornecedores`
--
ALTER TABLE `produto_fornecedores`
 ADD PRIMARY KEY (`id_produto_fornecedor`), ADD KEY `id_produto` (`id_produto`), ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- Indexes for table `requisicao_produto`
--
ALTER TABLE `requisicao_produto`
 ADD PRIMARY KEY (`id_requisicao_produto`);

--
-- Indexes for table `requisicao_usuario`
--
ALTER TABLE `requisicao_usuario`
 ADD PRIMARY KEY (`id_requisicao_usuario`);

--
-- Indexes for table `requisicoes`
--
ALTER TABLE `requisicoes`
 ADD PRIMARY KEY (`id_requisicao`);

--
-- Indexes for table `sys_actions`
--
ALTER TABLE `sys_actions`
 ADD PRIMARY KEY (`id_action`), ADD KEY `id_pagina` (`id_pagina`);

--
-- Indexes for table `sys_modulos`
--
ALTER TABLE `sys_modulos`
 ADD PRIMARY KEY (`id_modulo`), ADD KEY `id_modulo_pai` (`id_modulo_pai`);

--
-- Indexes for table `sys_paginas`
--
ALTER TABLE `sys_paginas`
 ADD PRIMARY KEY (`id_pagina`), ADD KEY `id_modulo` (`id_modulo`);

--
-- Indexes for table `sys_usuarios`
--
ALTER TABLE `sys_usuarios`
 ADD PRIMARY KEY (`id_usuario`), ADD UNIQUE KEY `email_usuario` (`email_usuario`), ADD UNIQUE KEY `login_usuario` (`login_usuario`), ADD KEY `id_funcionario` (`id_funcionario`), ADD KEY `id_usuarios_grupo` (`id_nivel_acesso`), ADD KEY `id_nivel_acesso` (`id_nivel_acesso`);

--
-- Indexes for table `sys_usuarios_acessos`
--
ALTER TABLE `sys_usuarios_acessos`
 ADD PRIMARY KEY (`id_usuarios_acesso`);

--
-- Indexes for table `sys_usuarios_grupo`
--
ALTER TABLE `sys_usuarios_grupo`
 ADD PRIMARY KEY (`id_usuarios_grupo`), ADD KEY `id_nivel_acesso` (`id_nivel_acesso`);

--
-- Indexes for table `telefones`
--
ALTER TABLE `telefones`
 ADD PRIMARY KEY (`id_telefone`);

--
-- Indexes for table `telefones_fornecedores`
--
ALTER TABLE `telefones_fornecedores`
 ADD KEY `id_telefone` (`id_telefone`), ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- Indexes for table `telefones_funcionarios`
--
ALTER TABLE `telefones_funcionarios`
 ADD KEY `id_telefone` (`id_telefone`), ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indexes for table `unidade_medida`
--
ALTER TABLE `unidade_medida`
 ADD PRIMARY KEY (`id_unidade_medida`), ADD KEY `id_produto` (`id_produto`), ADD KEY `id_produto_2` (`id_produto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargos`
--
ALTER TABLE `cargos`
MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
MODIFY `id_email` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `estoque`
--
ALTER TABLE `estoque`
MODIFY `id_estoque` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fornecedores`
--
ALTER TABLE `fornecedores`
MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `fornecedores_agenda`
--
ALTER TABLE `fornecedores_agenda`
MODIFY `id_fornecedor_agenda` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `fornecedores_agenda_notificado`
--
ALTER TABLE `fornecedores_agenda_notificado`
MODIFY `id_agenda_notificado` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `marcas`
--
ALTER TABLE `marcas`
MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
MODIFY `id_nivel_acesso` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `produto_fornecedores`
--
ALTER TABLE `produto_fornecedores`
MODIFY `id_produto_fornecedor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `requisicao_produto`
--
ALTER TABLE `requisicao_produto`
MODIFY `id_requisicao_produto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `requisicao_usuario`
--
ALTER TABLE `requisicao_usuario`
MODIFY `id_requisicao_usuario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `requisicoes`
--
ALTER TABLE `requisicoes`
MODIFY `id_requisicao` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_actions`
--
ALTER TABLE `sys_actions`
MODIFY `id_action` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `sys_modulos`
--
ALTER TABLE `sys_modulos`
MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `sys_paginas`
--
ALTER TABLE `sys_paginas`
MODIFY `id_pagina` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `sys_usuarios`
--
ALTER TABLE `sys_usuarios`
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sys_usuarios_acessos`
--
ALTER TABLE `sys_usuarios_acessos`
MODIFY `id_usuarios_acesso` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=176;
--
-- AUTO_INCREMENT for table `sys_usuarios_grupo`
--
ALTER TABLE `sys_usuarios_grupo`
MODIFY `id_usuarios_grupo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `telefones`
--
ALTER TABLE `telefones`
MODIFY `id_telefone` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `unidade_medida`
--
ALTER TABLE `unidade_medida`
MODIFY `id_unidade_medida` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `emails_fornecedores`
--
ALTER TABLE `emails_fornecedores`
ADD CONSTRAINT `emails_fornecedores_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `emails_fornecedores_ibfk_2` FOREIGN KEY (`id_email`) REFERENCES `emails` (`id_email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `emails_funcionarios`
--
ALTER TABLE `emails_funcionarios`
ADD CONSTRAINT `emails_funcionarios_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `emails_funcionarios_ibfk_2` FOREIGN KEY (`id_email`) REFERENCES `emails` (`id_email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `enderecos_fornecedores`
--
ALTER TABLE `enderecos_fornecedores`
ADD CONSTRAINT `enderecos_fornecedores_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `enderecos_fornecedores_ibfk_2` FOREIGN KEY (`id_endereco`) REFERENCES `enderecos` (`id_endereco`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `enderecos_funcionarios`
--
ALTER TABLE `enderecos_funcionarios`
ADD CONSTRAINT `enderecos_funcionarios_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `enderecos_funcionarios_ibfk_2` FOREIGN KEY (`id_endereco`) REFERENCES `enderecos` (`id_endereco`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `estoque`
--
ALTER TABLE `estoque`
ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `fornecedores_agenda`
--
ALTER TABLE `fornecedores_agenda`
ADD CONSTRAINT `fornecedores_agenda_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `fornecedores_agenda_notificado`
--
ALTER TABLE `fornecedores_agenda_notificado`
ADD CONSTRAINT `fornecedores_agenda_notificado_ibfk_1` FOREIGN KEY (`id_fornecedor_agenda`) REFERENCES `fornecedores_agenda` (`id_fornecedor_agenda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `funcionarios`
--
ALTER TABLE `funcionarios`
ADD CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id_cargo`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `produto_fornecedores`
--
ALTER TABLE `produto_fornecedores`
ADD CONSTRAINT `produto_fornecedores_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `produto_fornecedores_ibfk_2` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `sys_actions`
--
ALTER TABLE `sys_actions`
ADD CONSTRAINT `sys_actions_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `sys_paginas` (`id_pagina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `sys_modulos`
--
ALTER TABLE `sys_modulos`
ADD CONSTRAINT `sys_modulos_ibfk_1` FOREIGN KEY (`id_modulo_pai`) REFERENCES `sys_modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `sys_paginas`
--
ALTER TABLE `sys_paginas`
ADD CONSTRAINT `sys_paginas_ibfk_1` FOREIGN KEY (`id_modulo`) REFERENCES `sys_modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `sys_usuarios`
--
ALTER TABLE `sys_usuarios`
ADD CONSTRAINT `sys_usuarios_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `sys_usuarios_ibfk_2` FOREIGN KEY (`id_nivel_acesso`) REFERENCES `nivel_acesso` (`id_nivel_acesso`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `sys_usuarios_grupo`
--
ALTER TABLE `sys_usuarios_grupo`
ADD CONSTRAINT `sys_usuarios_grupo_ibfk_1` FOREIGN KEY (`id_nivel_acesso`) REFERENCES `nivel_acesso` (`id_nivel_acesso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `telefones_fornecedores`
--
ALTER TABLE `telefones_fornecedores`
ADD CONSTRAINT `telefones_fornecedores_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `telefones_fornecedores_ibfk_2` FOREIGN KEY (`id_telefone`) REFERENCES `telefones` (`id_telefone`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `telefones_funcionarios`
--
ALTER TABLE `telefones_funcionarios`
ADD CONSTRAINT `telefones_funcionarios_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `telefones_funcionarios_ibfk_2` FOREIGN KEY (`id_telefone`) REFERENCES `telefones` (`id_telefone`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `unidade_medida`
--
ALTER TABLE `unidade_medida`
ADD CONSTRAINT `unidade_medida_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
