-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 31-Out-2016 às 01:58
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
-- Estrutura da tabela `abertura_caixa`
--

CREATE TABLE IF NOT EXISTS `abertura_caixa` (
`id_abertura_caixa` int(11) NOT NULL,
  `id_caixa` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `saldo_inicial` decimal(10,2) DEFAULT NULL,
  `saldo_final` decimal(10,2) NOT NULL,
  `data_abertura_caixa` datetime NOT NULL,
  `data_fechamento_caixa` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `abertura_caixa`
--

INSERT INTO `abertura_caixa` (`id_abertura_caixa`, `id_caixa`, `id_usuario`, `saldo_inicial`, `saldo_final`, `data_abertura_caixa`, `data_fechamento_caixa`, `timestamp`) VALUES
(63, 1, 1, '1000.00', '0.00', '2016-10-31 01:52:58', '0000-00-00 00:00:00', '2016-10-31 03:52:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `acesso_action`
--

CREATE TABLE IF NOT EXISTS `acesso_action` (
`id_acesso_action` int(11) NOT NULL,
  `id_nivel_acesso` int(11) DEFAULT NULL,
  `id_action` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `acesso_action`
--

INSERT INTO `acesso_action` (`id_acesso_action`, `id_nivel_acesso`, `id_action`) VALUES
(129, 4, 45),
(130, 4, 12),
(131, 4, 48),
(132, 2, 19),
(133, 2, 23),
(134, 2, 24),
(135, 2, 54),
(136, 2, 20),
(137, 2, 21),
(138, 2, 22),
(139, 2, 1),
(140, 2, 2),
(141, 2, 3),
(142, 2, 4),
(143, 2, 50),
(144, 2, 6),
(145, 2, 5),
(146, 2, 36),
(147, 2, 41),
(148, 2, 18),
(149, 2, 26),
(150, 2, 38),
(151, 2, 51),
(152, 2, 27),
(153, 2, 35),
(154, 2, 37),
(155, 2, 10),
(156, 2, 25),
(157, 2, 28),
(158, 2, 29),
(159, 2, 52),
(160, 2, 53),
(161, 2, 42),
(162, 2, 43),
(163, 2, 47),
(164, 2, 44),
(165, 2, 11),
(166, 2, 45),
(167, 2, 12),
(168, 2, 48),
(169, 2, 15),
(170, 2, 31),
(171, 2, 34),
(172, 2, 39),
(173, 2, 32),
(174, 2, 33),
(175, 2, 46),
(176, 2, 30),
(177, 2, 49),
(178, 5, 5),
(179, 5, 36),
(180, 5, 41),
(181, 5, 18),
(182, 5, 26),
(183, 5, 38),
(184, 5, 51),
(185, 5, 27),
(186, 5, 35),
(187, 5, 37),
(188, 5, 10),
(189, 5, 25),
(190, 5, 28),
(191, 5, 29),
(192, 5, 52),
(193, 5, 53),
(194, 5, 31),
(195, 5, 34),
(196, 5, 39),
(197, 5, 32),
(198, 5, 33),
(199, 5, 46),
(200, 5, 30);

-- --------------------------------------------------------

--
-- Estrutura da tabela `acesso_modulo`
--

CREATE TABLE IF NOT EXISTS `acesso_modulo` (
`id_acesso_modulo` int(11) NOT NULL,
  `id_nivel_acesso` int(11) DEFAULT NULL,
  `id_modulo` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `acesso_modulo`
--

INSERT INTO `acesso_modulo` (`id_acesso_modulo`, `id_nivel_acesso`, `id_modulo`) VALUES
(79, 4, 11),
(80, 4, 28),
(81, 2, 5),
(82, 2, 17),
(83, 2, 18),
(84, 2, 6),
(85, 2, 31),
(86, 2, 8),
(87, 2, 9),
(88, 2, 19),
(89, 2, 20),
(90, 2, 10),
(91, 2, 25),
(92, 2, 26),
(93, 2, 27),
(94, 2, 11),
(95, 2, 28),
(96, 2, 14),
(97, 2, 21),
(98, 2, 22),
(99, 2, 23),
(100, 2, 24),
(101, 2, 29),
(102, 2, 30),
(103, 5, 8),
(104, 5, 9),
(105, 5, 19),
(106, 5, 20),
(107, 5, 21),
(108, 5, 22),
(109, 5, 23),
(110, 5, 24),
(111, 5, 29);

-- --------------------------------------------------------

--
-- Estrutura da tabela `acesso_pagina`
--

CREATE TABLE IF NOT EXISTS `acesso_pagina` (
`id_acesso_pagina` int(11) NOT NULL,
  `id_nivel_acesso` int(11) DEFAULT NULL,
  `id_pagina` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `acesso_pagina`
--

INSERT INTO `acesso_pagina` (`id_acesso_pagina`, `id_nivel_acesso`, `id_pagina`) VALUES
(92, 4, 27),
(93, 4, 9),
(94, 2, 16),
(95, 2, 17),
(96, 2, 1),
(97, 2, 30),
(98, 2, 2),
(99, 2, 6),
(100, 2, 15),
(101, 2, 18),
(102, 2, 19),
(103, 2, 7),
(104, 2, 24),
(105, 2, 25),
(106, 2, 26),
(107, 2, 8),
(108, 2, 27),
(109, 2, 9),
(110, 2, 12),
(111, 2, 21),
(112, 2, 22),
(113, 2, 23),
(114, 2, 28),
(115, 2, 20),
(116, 2, 29),
(117, 5, 6),
(118, 5, 15),
(119, 5, 18),
(120, 5, 19),
(121, 5, 7),
(122, 5, 21),
(123, 5, 22),
(124, 5, 23),
(125, 5, 28),
(126, 5, 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `caixas`
--

CREATE TABLE IF NOT EXISTS `caixas` (
`id_caixa` int(11) NOT NULL,
  `codigo_caixa` varchar(255) DEFAULT NULL,
  `ip_maquina` varchar(255) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `caixas`
--

INSERT INTO `caixas` (`id_caixa`, `codigo_caixa`, `ip_maquina`, `data_cadastro`, `timestamp`) VALUES
(1, 'CAIXA 1', '::1', '2016-07-21 00:00:00', '2016-10-23 16:40:07');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargos`
--

CREATE TABLE IF NOT EXISTS `cargos` (
`id_cargo` int(11) NOT NULL,
  `nome_cargo` varchar(255) DEFAULT NULL,
  `setor_cargo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cargos`
--

INSERT INTO `cargos` (`id_cargo`, `nome_cargo`, `setor_cargo`) VALUES
(2, 'estoquista', 'suprimentos'),
(3, 'Gerente', 'TI');

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
(1, 'Limpezas', 'ATIVO', '2016-02-23 01:22:31', '2016-05-16 02:44:55'),
(2, 'Aliment&iacute;cios', 'ATIVO', '2016-02-23 01:27:31', '2016-02-23 03:27:31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cotacoes`
--

CREATE TABLE IF NOT EXISTS `cotacoes` (
`id_cotacao` int(11) NOT NULL,
  `id_requisicao` int(11) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
`id_email` int(11) NOT NULL,
  `endereco_email` varchar(255) DEFAULT NULL,
  `tipo_email` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `emails`
--

INSERT INTO `emails` (`id_email`, `endereco_email`, `tipo_email`, `timestamp`) VALUES
(4, 'wellington-cezar@hotmail.com', 'Profissional', '2016-01-18 23:50:32'),
(5, 'email@email.com', 'Profissional', '2016-06-26 03:02:35'),
(6, 'wellington-cezar@hotmail.com', 'Profissional', '2016-07-14 19:46:37'),
(7, 'fulano@empresa.com', '', '2016-07-14 20:05:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `emails_fornecedores`
--

CREATE TABLE IF NOT EXISTS `emails_fornecedores` (
  `id_fornecedor` int(11) DEFAULT NULL,
  `id_email` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `emails_fornecedores`
--

INSERT INTO `emails_fornecedores` (`id_fornecedor`, `id_email`) VALUES
(10, 6),
(18, 7);

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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `enderecos`
--

INSERT INTO `enderecos` (`id_endereco`, `cep_endereco`, `rua_endereco`, `numero_endereco`, `complemento_endereco`, `bairro_endereco`, `cidade_endereco`, `estado_endereco`, `data_cadastro_endereco`, `timestamp`) VALUES
(34, '08580-300', 'Rua Maresias', 23, '', 'Jardim Maragogipe', 'Itaquaquecetuba', 'SP', '2016-09-24 06:42:52', '2016-09-08 21:09:39'),
(35, '08580-300', 'Rua Maresias', 196, '', 'Jardim Maragogipe', 'Itaquaquecetuba', 'SP', '2016-09-11 11:57:07', '2016-09-12 02:56:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos_fornecedores`
--

CREATE TABLE IF NOT EXISTS `enderecos_fornecedores` (
  `id_fornecedor` int(11) DEFAULT NULL,
  `id_endereco` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(59, 34),
(97, 35);

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE IF NOT EXISTS `estoque` (
`id_estoque` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `estoque`
--

INSERT INTO `estoque` (`id_estoque`, `id_produto`, `timestamp`) VALUES
(39, 59, '2016-10-10 04:15:19'),
(40, 58, '2016-10-31 01:21:47');

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id_fornecedor`, `foto_fornecedor`, `razao_social_fornecedor`, `nome_fantasia_fornecedor`, `cnpj_fornecedor`, `cpf_fornecedor`, `pessoa_fornecedor`, `site_fornecedor`, `observacoes_fornecedor`, `nome_contato_fornecedor`, `data_visita_fornecedor`, `retorno_fornecedor`, `status_fornecedor`, `data_cadastro_fornecedor`, `timestamp`) VALUES
(10, 'a513bddece9f293c4fd3227b32e92d7c.jpg', 'Razao', 'Nome fantasia', '58.674.154/0001-49', '932.681.097-64', 'PF', '', '', 'nome do contato', '0000-00-00', 0, 'INATIVO', '2015-11-30 02:28:26', '2016-07-22 04:19:47'),
(11, '', 'teste', 'teste', '23.434.234/2342-34', '234.234.234-23', 'PF', '', '', '', '0000-00-00', 0, 'INATIVO', '2016-01-18 10:22:38', '2016-07-22 04:19:46'),
(12, '', 'teste', 'teste', '23.434.234/2342-34', '234.234.234-23', 'PF', '', '', '', '0000-00-00', 0, 'INATIVO', '2016-01-18 10:23:21', '2016-07-22 04:19:45'),
(13, '', 'teste', 'teste', '23.434.234/2342-34', '234.234.234-23', 'PF', '', '', '', '0000-00-00', 0, 'ATIVO', '2016-01-18 10:24:05', '2016-10-17 01:33:15'),
(14, '', 'teste', 'stes', '23.423.423/4234-23', '234.234.234-23', 'PF', '', '', '', '0000-00-00', 0, 'INATIVO', '2016-01-18 10:25:01', '2016-07-22 04:19:42'),
(15, '', 'aaaaaaaaaaa', 'aaaaaaa', '22.222.222/2222-22', '111.111.111-11', 'PJ', '', '', 'alguem', '0000-00-00', 0, 'INATIVO', '2016-01-20 09:47:08', '2016-07-22 04:19:41'),
(16, '', 'ttrtertert', 'treterte', '34.534.534/5345-34', '345.345.345', 'PF', '', '', '', '0000-00-00', 0, 'ATIVO', '2016-02-09 02:36:16', '2016-10-17 01:33:13'),
(17, '2d94ec1702ea1eb2f533ab17cb964fa2.png', 'razao', 'nome', '12.354.698/7984-56', '121.111.213-21', 'PF', 'teste', '', '', '2016-05-17', 0, 'INATIVO', '2016-05-06 01:31:03', '2016-07-22 04:19:38'),
(18, 'logo-winrar[1].gif', 'razao social', 'nome fantasia', '58.674.154/0001-49', '036.941.765-86', 'PJ', 'TESTE', 'teste', 'fulano', NULL, NULL, 'ATIVO', '2016-07-14 05:05:10', '2016-10-17 01:33:08');

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
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id_funcionario`, `foto_funcionario`, `nome_funcionario`, `sobrenome_funcionario`, `data_nascimento_funcionario`, `sexo_funcionario`, `rg_funcionario`, `cpf_funcionario`, `estado_civil_funcionario`, `escolaridade_funcionario`, `codigo_funcionario`, `id_cargo`, `data_admissao_funcionario`, `data_demissao_funcionario`, `status_funcionario`, `data_cadastro_funcionario`, `timestamp`) VALUES
(59, 'c1d693986ded7c8d7aa41e6939ae036e.png', 'Usu&aacute;rio', 'Administrador', '2001-03-13', 'M', '21.331.313-2', '151.847.942-12', 'Solteiro', 'Ensino Superior Completo', '', 3, '2016-03-13', '0000-00-00', 'ATIVO', '2016-03-13 04:49:17', '2016-09-24 21:42:51'),
(82, 'ac28f76281ab9fb0b4a3c466e30b9dd0.jpg', 'alguem', 'sobrenome', '2016-05-17', 'M', '144.462.607-82', '144.462.607-82', 'Casado', 'Ensino Fundamental Completo', '080516.2222', 2, '0000-00-00', '0000-00-00', 'EXCLUIDO', '2016-05-08 11:15:24', '2016-06-27 01:59:35'),
(87, '346a031daaf4fe5da45668e6f03936c3.png', 'Diego', 'hernandes', '2016-05-10', 'M', '12.342.342-3', '795.239.567-01', 'Casado', 'Ensino Fundamental Incompleto', '220516.2275', 2, '2016-05-11', '2016-05-11', 'EXCLUIDO', '2016-05-22 03:05:45', '2016-09-08 21:09:27'),
(92, 'be76f66e9229b6979dd1d7d53b1edda7.png', 'wellington cezar', 'targino', '2016-06-01', 'M', '', '309.380.689-54', '', '', '260616.5230', 3, '0000-00-00', '0000-00-00', 'EXCLUIDO', '2016-06-26 05:17:46', '2016-09-08 21:09:25'),
(95, 'ace81456757dd91acaed98d87642ec43.png', 'Suzana', 'oliveira', '2016-06-17', 'M', '', '475.403.818-50', '', '', '260616.6237', 2, '0000-00-00', '0000-00-00', 'ATIVO', '2016-06-26 10:58:15', '2016-09-12 03:01:12'),
(96, '', 'testando', 'endereco', '2016-09-08', 'M', '23.132.423-4', '001.720.669-30', 'Casado', 'Ensino Fundamental Incompleto', '080916.9513', 2, '2016-09-15', '2016-10-27', 'EXCLUIDO', '2016-09-08 06:03:23', '2016-09-08 21:09:20'),
(97, 'f9f3300d69a34c55226813c92d44bd49.png', 'Wellington', 'Cezar', '1991-02-04', 'M', '12.312.132-3', '961.134.972-67', 'Solteiro', 'Ensino Superior Incompleto', '110916.7796', 3, '2016-09-11', '0000-00-00', 'ATIVO', '2016-09-11 11:56:08', '2016-09-12 02:57:07');

-- --------------------------------------------------------

--
-- Estrutura da tabela `localizacao_lote`
--

CREATE TABLE IF NOT EXISTS `localizacao_lote` (
`id_localizacao_lote` int(11) NOT NULL,
  `id_produto_lote` int(11) DEFAULT NULL,
  `id_unidade_medida_produto` int(11) DEFAULT NULL,
  `localizacao` enum('ARMAZEM','PRATELEIRA','DESCARTADOS') NOT NULL DEFAULT 'ARMAZEM',
  `quantidade_localizacao` decimal(10,2) DEFAULT NULL,
  `observacoes_localizacao_lote` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `localizacao_lote`
--

INSERT INTO `localizacao_lote` (`id_localizacao_lote`, `id_produto_lote`, `id_unidade_medida_produto`, `localizacao`, `quantidade_localizacao`, `observacoes_localizacao_lote`, `timestamp`) VALUES
(74, 80, 47, 'PRATELEIRA', '0.00', '', '2016-10-31 03:26:57'),
(75, 81, 48, 'PRATELEIRA', '-2.00', '', '2016-10-31 03:53:40'),
(76, 81, 47, 'DESCARTADOS', '10.00', '', '2016-10-17 00:19:24'),
(77, 84, 46, 'ARMAZEM', '80.00', '', '2016-10-31 01:22:52'),
(78, 84, 46, 'PRATELEIRA', '15.00', '', '2016-10-31 03:53:11');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `marcas`
--

INSERT INTO `marcas` (`id_marca`, `nome_marca`, `status_marca`, `data_cadastro_marca`, `timestamp`) VALUES
(1, 'Nestl&eacute;', 'ATIVO', '2016-04-29 05:29:48', '2016-06-06 02:57:56'),
(2, 'Coca Cola', 'ATIVO', '2016-06-05 11:59:48', '2016-06-06 02:59:48'),
(3, 'Dolce Gusto', 'ATIVO', '2016-06-06 12:00:21', '2016-06-06 03:11:22'),
(4, 'Perdig&atilde;o', 'ATIVO', '2016-06-06 12:01:18', '2016-06-06 03:01:18'),
(5, 'Uni&atilde;o', 'ATIVO', '2016-06-06 12:01:42', '2016-06-06 03:01:42'),
(6, 'Colgate', 'ATIVO', '2016-06-06 12:01:51', '2016-06-06 03:01:51'),
(7, 'Knorr', 'ATIVO', '2016-06-06 12:02:19', '2016-06-06 03:02:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel_acesso`
--

CREATE TABLE IF NOT EXISTS `nivel_acesso` (
`id_nivel_acesso` int(11) NOT NULL,
  `nome_nivel_acesso` varchar(255) DEFAULT NULL,
  `tipo_permissao` enum('ADMINISTRADOR','USUARIO') NOT NULL,
  `index_access_db_name` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `nivel_acesso`
--

INSERT INTO `nivel_acesso` (`id_nivel_acesso`, `nome_nivel_acesso`, `tipo_permissao`, `index_access_db_name`, `timestamp`) VALUES
(1, 'Administrativo', 'ADMINISTRADOR', 'default', '2016-10-14 00:49:01'),
(2, 'Gerência', 'USUARIO', 'gerencia', '2016-10-14 00:49:06'),
(4, 'Caixa', 'USUARIO', 'caixa', '2016-10-14 00:49:12'),
(5, 'Suprimentos', 'USUARIO', 'suprimentos', '2016-10-14 00:49:16'),
(6, 'Estoquista', 'USUARIO', 'estoquista', '2016-10-14 00:49:23');

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel_estoque`
--

CREATE TABLE IF NOT EXISTS `nivel_estoque` (
`id_nivel_estoque` int(11) NOT NULL,
  `id_estoque` int(11) DEFAULT NULL,
  `quantidade_minima` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantidade_maxima` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id_unidade_medida_produto` int(11) DEFAULT NULL,
  `localizacao_estoque` enum('ARMAZEM','PRATELEIRA','DESCARTADOS') DEFAULT 'ARMAZEM'
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `nivel_estoque`
--

INSERT INTO `nivel_estoque` (`id_nivel_estoque`, `id_estoque`, `quantidade_minima`, `quantidade_maxima`, `id_unidade_medida_produto`, `localizacao_estoque`) VALUES
(34, 39, '0.00', '0.00', NULL, 'ARMAZEM'),
(35, 39, '0.00', '0.00', NULL, 'PRATELEIRA'),
(36, 39, '0.00', '0.00', NULL, 'DESCARTADOS'),
(37, 40, '0.00', '0.00', NULL, 'ARMAZEM'),
(38, 40, '0.00', '0.00', NULL, 'PRATELEIRA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamentos`
--

CREATE TABLE IF NOT EXISTS `orcamentos` (
`id_orcamento` int(11) NOT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `id_requisicao` int(11) NOT NULL,
  `status_orcamento` enum('APROVADO','REPROVADO') DEFAULT NULL,
  `data_cadastro_orcamento` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento_produto`
--

CREATE TABLE IF NOT EXISTS `orcamento_produto` (
`id_orcamento_produto` int(11) NOT NULL,
  `id_orcamento` int(11) DEFAULT NULL,
  `id_requisicao_produto` int(11) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
`id_produto` int(11) NOT NULL,
  `foto_produto` varchar(255) DEFAULT NULL,
  `codigo_barra_gti` varchar(20) DEFAULT NULL,
  `nome_produto` varchar(255) DEFAULT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `descricao_produto` text,
  `unidade_medida_venda` int(11) NOT NULL,
  `fator_unidade_medida_venda` decimal(10,2) NOT NULL,
  `status_produto` enum('ATIVO','INATIVO','EXCLUIDO') NOT NULL,
  `data_validade_controlada` tinyint(1) NOT NULL DEFAULT '0',
  `data_cadastro_produto` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `foto_produto`, `codigo_barra_gti`, `nome_produto`, `id_marca`, `id_categoria`, `descricao_produto`, `unidade_medida_venda`, `fator_unidade_medida_venda`, `status_produto`, `data_validade_controlada`, `data_cadastro_produto`, `timestamp`) VALUES
(58, '6b7a3503b14def03a9402a1a00e26dd7.jpg', '7896006752837', 'Arroz Camil 5kg - tipo1', 7, 2, 'Arroz Camil 5kg, tipo 1.\r\nArroz classe longo fino', 7, '1.00', 'ATIVO', 1, '2016-08-28 02:01:50', '2016-10-01 21:20:13'),
(59, 'aac8f908e99d06fec36efe840b996137.png', '3432234322424', 'A&ccedil;ucar', 5, 2, '', 7, '1.00', 'ATIVO', 0, '2016-10-02 12:52:01', '2016-10-02 03:53:36');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos_preco`
--

INSERT INTO `produtos_preco` (`id_produto_preco`, `id_produto`, `preco_produto`, `data_inicio`, `data_fim`, `preco_padrao`, `data_cadastro`, `timestamp`) VALUES
(8, 58, '10.00', '0000-00-00', '0000-00-00', 1, '2016-09-25', '2016-09-25 16:11:59'),
(9, 58, '9.45', '2016-09-25', '2016-09-27', 0, '2016-09-25', '2016-09-25 16:12:36'),
(10, 58, '9.00', '2016-09-25', '2016-10-25', 0, '2016-09-25', '2016-09-25 16:36:03'),
(11, 59, '10.30', '0000-00-00', '0000-00-00', 1, '2016-10-09', '2016-10-09 16:06:54');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_vendidos`
--

CREATE TABLE IF NOT EXISTS `produtos_vendidos` (
`id_produto_vendido` int(11) NOT NULL,
  `id_venda` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade_produto_vendido` decimal(10,2) DEFAULT NULL,
  `unidade_medida_vendido` varchar(255) DEFAULT NULL,
  `preco_vendido` decimal(10,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos_vendidos`
--

INSERT INTO `produtos_vendidos` (`id_produto_vendido`, `id_venda`, `id_produto`, `quantidade_produto_vendido`, `unidade_medida_vendido`, `preco_vendido`, `timestamp`) VALUES
(33, 35, 58, '1.00', '', '10.00', '2016-10-31 03:53:11'),
(34, 36, 59, '1.00', '', '10.30', '2016-10-31 03:53:40'),
(35, 36, 59, '5.00', '', '10.30', '2016-10-31 03:53:40');

--
-- Acionadores `produtos_vendidos`
--
DELIMITER //
CREATE TRIGGER `atualizaNivelEstoque` AFTER INSERT ON `produtos_vendidos`
 FOR EACH ROW begin
	DECLARE idlocalLote int;
    DECLARE qtdLocalAtual decimal;
    DECLARE qtdVendido decimal;
    SET qtdVendido = NEW.quantidade_produto_vendido;
	qtd_loop: LOOP
    	IF qtdVendido > 0 THEN
			SELECT localizacao_lote.id_localizacao_lote, localizacao_lote.quantidade_localizacao
			INTO idlocalLote, qtdLocalAtual
			FROM localizacao_lote 
		    INNER JOIN produtos ON produtos.id_produto = NEW.id_produto 
		    inner join estoque on estoque.id_produto = produtos.id_produto 
		    inner join produto_lote on produto_lote.id_estoque = estoque.id_estoque 
		    WHERE 
			localizacao_lote.localizacao = 'PRATELEIRA' 
		    AND localizacao_lote.id_produto_lote = produto_lote.id_produto_lote
		    AND localizacao_lote.quantidade_localizacao > 0
		    LIMIT 1;
		    
		    
		    IF qtdLocalAtual >= qtdVendido THEN /*se a quantidade for o suficiente para retirada*/
		        update localizacao_lote set quantidade_localizacao = quantidade_localizacao-qtdVendido 
		        	WHERE localizacao = 'PRATELEIRA' AND id_localizacao_lote = idlocalLote;
		        LEAVE qtd_loop;
		    ELSE /*senao faz o loop para pegar os proximas quantidades*/
		        set qtdVendido = qtdVendido-qtdLocalAtual;
		        update localizacao_lote set quantidade_localizacao = quantidade_localizacao-qtdLocalAtual WHERE localizacao = 'PRATELEIRA' AND id_localizacao_lote = idlocalLote;
		    end IF;
		ELSE
			LEAVE qtd_loop;
		END IF; 

   	END LOOP qtd_loop;
	
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_fornecedores`
--

CREATE TABLE IF NOT EXISTS `produto_fornecedores` (
`id_produto_fornecedor` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `id_fornecedor` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto_fornecedores`
--

INSERT INTO `produto_fornecedores` (`id_produto_fornecedor`, `id_produto`, `id_fornecedor`) VALUES
(21, 58, 18),
(22, 58, 17),
(23, 58, 16),
(24, 59, 18),
(25, 59, 17),
(26, 59, 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_lote`
--

CREATE TABLE IF NOT EXISTS `produto_lote` (
`id_produto_lote` int(11) NOT NULL,
  `id_estoque` int(11) DEFAULT NULL,
  `codigo_lote` varchar(255) DEFAULT NULL,
  `codigo_barras_gti` varchar(15) DEFAULT NULL,
  `codigo_barras_gst` varchar(255) DEFAULT NULL,
  `data_validade` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto_lote`
--

INSERT INTO `produto_lote` (`id_produto_lote`, `id_estoque`, `codigo_lote`, `codigo_barras_gti`, `codigo_barras_gst`, `data_validade`, `timestamp`) VALUES
(80, 39, '1', '', '', '0000-00-00', '2016-10-10 04:15:19'),
(81, 39, '2', '', '', '0000-00-00', '2016-10-10 04:15:35'),
(82, 39, '3', '', '', '0000-00-00', '2016-10-10 04:55:44'),
(83, 39, '4', '', '', '0000-00-00', '2016-10-10 05:03:44'),
(84, 40, '001111', '', '', '2016-10-31', '2016-10-31 01:21:47');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `requisicao_produto`
--

INSERT INTO `requisicao_produto` (`id_requisicao_produto`, `id_requisicao`, `id_produto`, `id_unidade_medida_produto`, `quantidade_produto`, `status_requisicao_produto`, `timestam`) VALUES
(6, 25, 58, 46, '20.00', 'APROVADO', '2016-09-11 13:36:24');

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisicao_usuario`
--

CREATE TABLE IF NOT EXISTS `requisicao_usuario` (
`id_requisicao_usuario` int(11) NOT NULL,
  `id_requisicao` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `requisicao_usuario`
--

INSERT INTO `requisicao_usuario` (`id_requisicao_usuario`, `id_requisicao`, `id_usuario`, `timestamp`) VALUES
(1, 13, 1, '2016-06-05 16:51:20'),
(2, 14, 1, '2016-06-06 02:54:48'),
(3, 15, 1, '2016-06-06 03:18:10'),
(4, 16, 1, '2016-06-06 03:19:43'),
(5, 22, 1, '2016-07-27 00:37:38'),
(6, 23, 1, '2016-07-27 00:38:16'),
(7, 24, 1, '2016-07-27 00:38:19'),
(8, 25, 1, '2016-09-11 13:34:43');

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `requisicoes`
--

INSERT INTO `requisicoes` (`id_requisicao`, `codigo_requisicao`, `titulo_requisicao`, `observacoes_requisicao`, `data_requisicao`, `status_requisicao`, `timestamp`) VALUES
(15, '0001', 'Produtos em falta', 'Requisi&ccedil;&atilde;o de produtos em falta', '2016-06-06 00:18:10', 'NOVO', '2016-06-06 03:18:10'),
(16, '00002', 'Nova requisi&ccedil;&atilde;o de produto', '', '2016-06-06 00:19:43', 'NOVO', '2016-06-06 03:19:43'),
(17, '12345678', 'falta de produtos em estoque', '', '2016-07-26 21:29:04', 'NOVO', '2016-07-27 00:29:04'),
(18, '12345678', 'falta de produtos em estoque', '', '2016-07-26 21:31:04', 'NOVO', '2016-07-27 00:31:04'),
(19, '12345678', 'falta de produtos em estoque', '', '2016-07-26 21:31:45', 'NOVO', '2016-07-27 00:31:45'),
(20, '12345678', 'falta de produtos em estoque', '', '2016-07-26 21:32:04', 'NOVO', '2016-07-27 00:32:04'),
(21, '12345678', 'falta de produtos em estoque', '', '2016-07-26 21:36:07', 'NOVO', '2016-07-27 00:36:07'),
(22, '12345678', 'falta de produtos em estoque', '', '2016-07-26 21:37:38', 'NOVO', '2016-07-27 00:37:38'),
(23, '32232', 'falta de produtos', '', '2016-07-26 21:38:16', 'NOVO', '2016-07-27 00:38:16'),
(24, '32232', 'falta de produtos', '', '2016-07-26 21:38:19', 'NOVO', '2016-07-27 00:38:19'),
(25, '112233', 'Falta do arroz camil', '', '2016-09-11 10:34:43', 'NOVO', '2016-09-11 13:34:43');

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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

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
(11, 'index', 'Home', 'ATIVO', 'INATIVO', 8, NULL, '2016-01-23 16:20:46'),
(12, 'index', NULL, 'ATIVO', 'INATIVO', 9, NULL, '2016-01-23 16:21:21'),
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
(37, 'editar', NULL, 'INATIVO', 'INATIVO', 19, NULL, '2016-05-07 14:40:33'),
(38, 'editar', NULL, 'INATIVO', 'INATIVO', 18, NULL, '2016-05-16 04:40:08'),
(39, 'editar', NULL, 'INATIVO', 'INATIVO', 21, NULL, '2016-06-05 13:51:38'),
(40, 'editar', NULL, 'INATIVO', 'INATIVO', 13, NULL, '2016-06-06 00:48:14'),
(41, 'editar', NULL, 'INATIVO', 'INATIVO', 6, NULL, '2016-07-14 15:43:25'),
(42, 'index', NULL, 'ATIVO', 'INATIVO', 24, NULL, '2016-07-20 14:34:06'),
(43, 'index', NULL, 'ATIVO', 'INATIVO', 25, NULL, '2016-07-20 14:35:33'),
(44, 'index', NULL, 'ATIVO', 'INATIVO', 26, NULL, '2016-07-20 14:35:41'),
(45, 'index', 'Home', 'ATIVO', 'INATIVO', 27, NULL, '2016-07-22 16:33:39'),
(46, 'index', NULL, 'ATIVO', 'INATIVO', 28, NULL, '2016-08-20 18:17:49'),
(47, 'entrada', NULL, 'INATIVO', 'INATIVO', 25, NULL, '2016-08-27 21:43:08'),
(48, 'cadastrar', NULL, 'INATIVO', 'INATIVO', 9, NULL, '2016-09-11 10:38:20'),
(49, 'index', 'Home', 'INATIVO', 'ATIVO', 29, NULL, '2016-09-12 00:05:32'),
(50, 'index', NULL, 'INATIVO', 'INATIVO', 30, NULL, '2016-09-12 00:20:59'),
(51, 'cadastrar', NULL, 'INATIVO', 'INATIVO', 18, NULL, '2016-09-24 16:09:37'),
(52, 'precos', 'Tabela de pre&ccedil;os', 'INATIVO', 'INATIVO', 7, NULL, '2016-09-24 17:02:29'),
(53, 'cadastrarprecos', 'Cadastrar pre&ccedil;os', 'INATIVO', 'INATIVO', 7, NULL, '2016-09-24 17:02:33'),
(54, 'excluir', NULL, 'INATIVO', 'INATIVO', 16, NULL, '2016-10-13 23:26:13'),
(55, 'editar', NULL, 'INATIVO', 'INATIVO', 9, NULL, '2016-10-23 14:08:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_modulos`
--

CREATE TABLE IF NOT EXISTS `sys_modulos` (
`id_modulo` int(11) NOT NULL,
  `url_modulo` varchar(255) NOT NULL,
  `nome_modulo` varchar(255) DEFAULT NULL,
  `posicao_modulo` int(255) DEFAULT NULL,
  `status_modulo` enum('ATIVO','INATIVO','EXCLUIDO') DEFAULT NULL,
  `status_selecao_modulo` enum('ATIVO','INATIVO','EXCLUIDO') DEFAULT NULL,
  `id_modulo_pai` int(11) DEFAULT NULL,
  `icone_modulo` varchar(255) DEFAULT NULL,
  `data_criacao_modulo` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_modulos`
--

INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES
(0, '', 'ROOT', 0, 'ATIVO', 'INATIVO', NULL, NULL, '2016-01-20 00:00:00'),
(5, 'funcionarios', 'Funcion&aacute;rios', 0, 'ATIVO', 'ATIVO', 0, 'glyphicons glyphicons-group', '2016-01-20 15:15:22'),
(6, 'configuracoes', 'Configura&ccedil;&otilde;es', 8, 'ATIVO', 'ATIVO', 0, 'glyphicons glyphicons-cogwheels', '2016-01-20 15:24:33'),
(7, 'modulos', 'M&oacute;dulos', 0, 'ATIVO', 'INATIVO', 6, NULL, '2016-01-20 15:24:40'),
(8, 'fornecedores', 'Fornecedores', 1, 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-handshake', '2016-01-20 20:55:14'),
(9, 'produtos', 'Produtos', 2, 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-package', '2016-01-23 16:19:53'),
(10, 'estoque', 'Estoque', 3, 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-cargo', '2016-01-23 16:20:46'),
(11, 'caixa', 'Caixa', 4, 'ATIVO', 'ATIVO', 0, 'glyphicons glyphicons-calculator', '2016-01-23 16:21:21'),
(14, 'relatorios', 'Relat&oacute;rios', 6, 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-stats', '2016-01-23 16:23:17'),
(15, 'niveis_acesso', 'N&iacute;veis de acesso', NULL, 'ATIVO', 'INATIVO', 6, NULL, '2016-01-30 15:00:29'),
(17, 'usuarios', 'Usu&aacute;rios', NULL, 'ATIVO', 'INATIVO', 5, NULL, '2016-03-03 23:16:41'),
(18, 'cargos', 'Cargos', NULL, 'ATIVO', 'INATIVO', 5, NULL, '2016-03-13 03:31:55'),
(19, 'categorias', 'Categorias', NULL, 'INATIVO', 'INATIVO', 9, NULL, '2016-03-22 00:01:40'),
(20, 'marcas', 'Marcas', NULL, 'INATIVO', 'INATIVO', 9, NULL, '2016-03-22 00:01:50'),
(21, 'suprimentos', 'Suprimentos', 5, 'ATIVO', 'ATIVO', 0, 'glyphicons glyphicons-transfer', '2016-04-26 01:13:32'),
(22, 'requisicoes', 'Requisi&ccedil;&otilde;es', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-04-26 01:17:25'),
(23, 'cotacoes', 'Cota&ccedil;&otilde;es', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-04-26 01:17:40'),
(24, 'pedidos', 'Pedidos', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-04-26 01:17:52'),
(25, 'prateleira', 'Prateleira', NULL, 'ATIVO', 'INATIVO', 10, NULL, '2016-07-20 14:34:06'),
(26, 'armazem', 'Armaz&eacute;m', NULL, 'ATIVO', 'INATIVO', 10, NULL, '2016-07-20 14:35:33'),
(27, 'descartados', 'Descartados', NULL, 'ATIVO', 'INATIVO', 10, NULL, '2016-07-20 14:35:41'),
(28, 'checkout', 'Checkout', NULL, 'ATIVO', 'INATIVO', 11, NULL, '2016-07-22 16:33:39'),
(29, 'orcamentos', 'Or&ccedil;amentos', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-08-20 18:17:49'),
(30, 'agenda', 'Agenda', 7, 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-calendar', '2016-09-12 00:05:32'),
(31, 'empresa', NULL, NULL, 'INATIVO', 'INATIVO', 6, NULL, '2016-09-12 00:20:59');

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

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
(8, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'INATIVO', 10, '2016-01-23 16:20:46'),
(9, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'INATIVO', 11, '2016-01-23 16:21:21'),
(12, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 14, '2016-01-23 16:23:17'),
(13, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 15, '2016-01-30 15:00:29'),
(15, 'Agenda', 'Agenda', NULL, 'INATIVO', 'INATIVO', 8, '2016-02-09 14:13:25'),
(16, 'gerenciar', NULL, NULL, 'INATIVO', 'INATIVO', 17, '2016-03-03 23:16:41'),
(17, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 18, '2016-03-13 03:31:55'),
(18, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 19, '2016-03-22 00:01:40'),
(19, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 20, '2016-03-22 00:01:50'),
(20, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 21, '2016-04-26 01:13:32'),
(21, 'gerenciar', NULL, NULL, 'ATIVO', 'INATIVO', 22, '2016-04-26 01:17:25'),
(22, 'gerenciar', NULL, NULL, 'ATIVO', 'INATIVO', 23, '2016-04-26 01:17:40'),
(23, 'gerenciar', NULL, NULL, 'ATIVO', 'INATIVO', 24, '2016-04-26 01:17:53'),
(24, 'gerenciar', NULL, NULL, 'ATIVO', 'INATIVO', 25, '2016-07-20 14:34:06'),
(25, 'gerenciar', NULL, NULL, 'ATIVO', 'INATIVO', 26, '2016-07-20 14:35:33'),
(26, 'gerenciar', NULL, NULL, 'ATIVO', 'INATIVO', 27, '2016-07-20 14:35:41'),
(27, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'INATIVO', 28, '2016-07-22 16:33:39'),
(28, 'gerenciar', NULL, NULL, 'ATIVO', 'INATIVO', 29, '2016-08-20 18:17:49'),
(29, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 30, '2016-09-12 00:05:32'),
(30, 'gerenciar', NULL, NULL, 'INATIVO', 'INATIVO', 31, '2016-09-12 00:20:59');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_usuarios`
--

INSERT INTO `sys_usuarios` (`id_usuario`, `id_funcionario`, `id_nivel_acesso`, `email_usuario`, `login_usuario`, `senha_usuario`, `hash_acesso`, `status_usuario`, `data_criacao_usuario`, `timestamp`) VALUES
(1, 59, 1, 'admin@prysmarket.com.br', 'admin', '$2a$08$MTY2MjMyMDcyMTU3MmJjNe4RI1/LIguX39aJwjjJ374Tx2TdxfSXe', '$2a$08$NTI2NDYzMDY2NTgxNWViN.Qlonhz2W3NenSyrIhSJvqeMVn4oPXKm', 'ATIVO', NULL, '2016-05-05 22:17:49'),
(3, 95, 2, 'wellingtomn@teste.com', 'teste', '$2a$08$NTAwNjMzMTU3NTc4NDI5YO6ViD6tpsjCgUetSgJl2qr8zzKBO.5Ne', '$2a$08$MTAwNTg0OTYyNzU4MDNiMuK9BMepdRv6./rWCa8ZgJN/ST93GMCK6', 'ATIVO', '2016-07-11 08:20:13', '2016-07-11 23:20:13'),
(5, 97, 2, 'wellington-cezar@hotmail.com', 'wellington', '$2a$08$MTU1NzE1MDA1ODU3ZDYxYOip.buZKDLvmlUy0HuRMCJSTGDRCD1Ea', '$2a$08$MTg0NDM0NDA4MDU3ZDYxYOkbMSwvLWcFffBEv33OJiDYs7EX81R1C', 'EXCLUIDO', '2016-09-12 12:00:14', '2016-09-12 03:00:14');

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
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=latin1;

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
(175, 1, '2016-05-08', '13:19:53', '::1'),
(176, 1, '2016-05-10', '01:24:39', '::1'),
(177, 1, '2016-05-12', '23:55:13', '::1'),
(178, 1, '2016-05-12', '23:55:35', '::1'),
(179, 1, '2016-05-15', '18:54:18', '::1'),
(180, 1, '2016-05-20', '00:26:22', '::1'),
(181, 1, '2016-05-21', '21:03:22', '::1'),
(182, 1, '2016-05-22', '17:04:34', '::1'),
(183, 1, '2016-05-22', '17:18:53', '::1'),
(184, 4, '2016-05-22', '17:22:49', '::1'),
(185, 1, '2016-05-22', '18:18:53', '::1'),
(186, 1, '2016-05-23', '04:42:35', '::1'),
(187, 1, '2016-05-24', '00:21:03', '::1'),
(188, 1, '2016-05-27', '19:37:31', '::1'),
(189, 1, '2016-05-29', '04:09:44', '::1'),
(190, 1, '2016-05-29', '04:48:03', '::1'),
(191, 1, '2016-05-29', '05:16:16', '::1'),
(192, 1, '2016-06-03', '00:31:22', '::1'),
(193, 1, '2016-06-05', '13:50:19', '::1'),
(194, 1, '2016-06-05', '14:57:41', '::1'),
(195, 1, '2016-06-20', '23:17:53', '::1'),
(196, 1, '2016-06-23', '20:50:14', '::1'),
(197, 1, '2016-06-25', '22:27:20', '::1'),
(198, 1, '2016-06-26', '12:22:17', '::1'),
(199, 1, '2016-06-26', '17:12:22', '::1'),
(200, 1, '2016-06-27', '21:43:55', '::1'),
(201, 1, '2016-06-28', '22:33:18', '::1'),
(202, 1, '2016-06-29', '20:47:46', '::1'),
(203, 1, '2016-06-30', '22:55:41', '::1'),
(204, 1, '2016-07-03', '00:03:01', '::1'),
(205, 1, '2016-07-05', '20:21:47', '::1'),
(206, 1, '2016-07-11', '13:46:39', '::1'),
(207, 1, '2016-07-11', '20:03:53', '::1'),
(208, 1, '2016-07-13', '14:16:14', '::1'),
(209, 1, '2016-07-14', '12:50:20', '::1'),
(210, 1, '2016-07-15', '13:28:14', '::1'),
(211, 1, '2016-07-15', '20:01:55', '::1'),
(212, 1, '2016-07-18', '17:42:27', '::1'),
(213, 1, '2016-07-19', '13:21:32', '::1'),
(214, 1, '2016-07-20', '13:20:07', '::1'),
(215, 1, '2016-07-21', '00:46:05', '::1'),
(216, 1, '2016-07-21', '01:25:51', '::1'),
(217, 1, '2016-07-21', '01:26:12', '::1'),
(218, 1, '2016-07-21', '13:32:14', '::1'),
(219, 1, '2016-07-21', '21:03:30', '::1'),
(220, 1, '2016-07-21', '23:56:31', '192.168.0.108'),
(221, 1, '2016-07-22', '16:05:31', '::1'),
(222, 1, '2016-07-23', '00:28:57', '192.168.0.153'),
(223, 1, '2016-07-25', '21:32:54', '::1'),
(224, 1, '2016-07-26', '21:00:31', '::1'),
(225, 1, '2016-07-26', '21:13:39', '::1'),
(226, 1, '2016-07-27', '20:05:10', '::1'),
(227, 1, '2016-08-03', '01:01:14', '::1'),
(228, 1, '2016-08-09', '00:38:31', '::1'),
(229, 1, '2016-08-10', '01:05:38', '::1'),
(230, 1, '2016-08-12', '00:45:45', '::1'),
(231, 1, '2016-08-16', '00:20:20', '::1'),
(232, 1, '2016-08-17', '00:35:36', '::1'),
(233, 1, '2016-08-19', '00:21:44', '::1'),
(234, 1, '2016-08-20', '23:16:40', '::1'),
(235, 1, '2016-08-21', '12:40:13', '::1'),
(236, 1, '2016-08-27', '16:08:21', '::1'),
(237, 1, '2016-08-27', '19:29:17', '::1'),
(238, 1, '2016-08-28', '12:59:31', '::1'),
(239, 1, '2016-08-28', '22:34:16', '::1'),
(240, 1, '2016-09-08', '17:57:00', '::1'),
(241, 1, '2016-09-11', '10:18:19', '::1'),
(242, 1, '2016-09-11', '22:55:56', '::1'),
(243, 1, '2016-09-11', '22:56:48', '::1'),
(244, 1, '2016-09-11', '23:54:07', '::1'),
(245, 1, '2016-09-11', '23:54:09', '::1'),
(246, 1, '2016-09-11', '23:54:11', '::1'),
(247, 5, '2016-09-12', '00:03:07', '::1'),
(248, 1, '2016-09-12', '00:04:23', '::1'),
(249, 1, '2016-09-24', '15:10:07', '::1'),
(250, 1, '2016-09-24', '18:43:07', '::1'),
(251, 1, '2016-09-25', '12:20:56', '::1'),
(252, 1, '2016-10-01', '17:26:48', '::1'),
(253, 1, '2016-10-02', '01:06:02', '::1'),
(254, 1, '2016-10-08', '17:13:59', '::1'),
(255, 1, '2016-10-09', '12:05:49', '::1'),
(256, 1, '2016-10-09', '13:37:02', '::1'),
(257, 1, '2016-10-12', '11:57:27', '::1'),
(258, 1, '2016-10-13', '21:45:03', '::1'),
(259, 1, '2016-10-13', '21:45:05', '::1'),
(260, 1, '2016-10-13', '22:32:20', '::1'),
(261, 1, '2016-10-13', '22:32:29', '::1'),
(262, 1, '2016-10-13', '22:33:17', '::1'),
(263, 1, '2016-10-13', '22:35:41', '::1'),
(264, 1, '2016-10-13', '22:39:56', '::1'),
(265, 1, '2016-10-13', '22:48:48', '::1'),
(266, 3, '2016-10-13', '23:40:22', '::1'),
(267, 3, '2016-10-16', '14:54:35', '::1'),
(268, 1, '2016-10-16', '15:02:03', '::1'),
(269, 3, '2016-10-16', '15:05:51', '::1'),
(270, 1, '2016-10-16', '17:16:54', '::1'),
(271, 1, '2016-10-22', '23:46:35', '::1'),
(272, 1, '2016-10-23', '12:37:49', '::1'),
(273, 1, '2016-10-23', '12:42:27', '::1'),
(274, 1, '2016-10-23', '12:57:01', '::1'),
(275, 1, '2016-10-30', '10:44:57', '::1');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `telefones`
--

INSERT INTO `telefones` (`id_telefone`, `categoria_telefone`, `numero_telefone`, `tipo_telefone`, `operadora_telefone`, `timestamp`) VALUES
(4, 'celular', '(13) 21321-3213', 'Pessoal', 'operadora', '2016-01-10 18:40:44'),
(5, 'celular', '(77) 77777-7777', 'Pessoal', 'op', '2016-01-10 18:42:04'),
(6, 'telefone', '(22) 22222-2222', 'Profissional', '333', '2016-01-10 19:02:00'),
(8, 'celular', '(42) 34234-2342', 'Pessoal', '33333333333333333333333', '2016-01-11 01:24:51'),
(9, 'telefone', '(23) 4', 'Pessoal', '234', '2016-01-19 00:29:54'),
(10, 'telefone', '(11) 32838-3838', 'Pessoal', 'tim', '2016-03-13 16:48:42'),
(11, 'celular', '(12) 31212-3123', 'Pessoal', 'oi', '2016-05-15 19:39:24'),
(15, 'telefone', '(11) 11111-1111', 'Residencial', 'Tim', '2016-06-05 18:55:51');

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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `unidade_medida_produto`
--

INSERT INTO `unidade_medida_produto` (`id_unidade_medida_produto`, `id_produto`, `id_unidade_medida`, `fator_unidade_medida`, `para_venda`, `para_estoque`, `ordem`, `timestamp`) VALUES
(46, 58, 7, '1.00', 1, 1, 0, '2016-08-28 17:01:50'),
(47, 59, 7, '1.00', 1, 1, 0, '2016-10-10 03:09:58'),
(48, 59, 11, '10.00', 0, 0, 1, '2016-10-10 03:10:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE IF NOT EXISTS `vendas` (
`id_venda` int(11) NOT NULL,
  `id_abertura_caixa` int(11) DEFAULT NULL,
  `data_venda` date DEFAULT NULL,
  `hora_venda` time DEFAULT NULL,
  `forma_pagamento` enum('DINHEIRO','CARTAODEBITO','CARTAOCREDITO','') NOT NULL,
  `valor_pago` decimal(10,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `id_abertura_caixa`, `data_venda`, `hora_venda`, `forma_pagamento`, `valor_pago`, `timestamp`) VALUES
(35, 63, '2016-10-31', '01:53:11', 'DINHEIRO', '10.00', '2016-10-31 03:53:11'),
(36, 63, '2016-10-31', '01:53:40', 'DINHEIRO', '0.00', '2016-10-31 03:53:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abertura_caixa`
--
ALTER TABLE `abertura_caixa`
 ADD PRIMARY KEY (`id_abertura_caixa`), ADD KEY `id_checkout` (`id_caixa`), ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `acesso_action`
--
ALTER TABLE `acesso_action`
 ADD PRIMARY KEY (`id_acesso_action`), ADD KEY `id_nivel_acesso` (`id_nivel_acesso`), ADD KEY `id_action` (`id_action`);

--
-- Indexes for table `acesso_modulo`
--
ALTER TABLE `acesso_modulo`
 ADD PRIMARY KEY (`id_acesso_modulo`), ADD KEY `id_nivel_acesso` (`id_nivel_acesso`), ADD KEY `id_modulo` (`id_modulo`);

--
-- Indexes for table `acesso_pagina`
--
ALTER TABLE `acesso_pagina`
 ADD PRIMARY KEY (`id_acesso_pagina`), ADD KEY `id_pagina` (`id_pagina`), ADD KEY `id_nivel_acesso` (`id_nivel_acesso`);

--
-- Indexes for table `caixas`
--
ALTER TABLE `caixas`
 ADD PRIMARY KEY (`id_caixa`), ADD UNIQUE KEY `ip_maquina` (`ip_maquina`);

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
-- Indexes for table `cotacoes`
--
ALTER TABLE `cotacoes`
 ADD PRIMARY KEY (`id_cotacao`), ADD KEY `id_requisicao` (`id_requisicao`);

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
 ADD PRIMARY KEY (`id_funcionario`), ADD UNIQUE KEY `cpf_funcionario` (`cpf_funcionario`), ADD UNIQUE KEY `codigo_funcionario` (`codigo_funcionario`), ADD KEY `id_estado_civil` (`estado_civil_funcionario`), ADD KEY `id_escolaridade` (`escolaridade_funcionario`), ADD KEY `id_cargo` (`id_cargo`), ADD KEY `id_cargo_2` (`id_cargo`);

--
-- Indexes for table `localizacao_lote`
--
ALTER TABLE `localizacao_lote`
 ADD PRIMARY KEY (`id_localizacao_lote`), ADD KEY `id_produto_lote` (`id_produto_lote`), ADD KEY `id_unidade_medida_produto` (`id_unidade_medida_produto`);

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
-- Indexes for table `nivel_estoque`
--
ALTER TABLE `nivel_estoque`
 ADD PRIMARY KEY (`id_nivel_estoque`), ADD KEY `id_estoque` (`id_estoque`), ADD KEY `id_unidade_medida_produto` (`id_unidade_medida_produto`);

--
-- Indexes for table `orcamentos`
--
ALTER TABLE `orcamentos`
 ADD PRIMARY KEY (`id_orcamento`), ADD KEY `id_fornecedor` (`id_fornecedor`), ADD KEY `id_requisicao` (`id_requisicao`);

--
-- Indexes for table `orcamento_produto`
--
ALTER TABLE `orcamento_produto`
 ADD PRIMARY KEY (`id_orcamento_produto`), ADD KEY `id_orcamento` (`id_orcamento`), ADD KEY `id_requisicao_produto` (`id_requisicao_produto`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
 ADD PRIMARY KEY (`id_produto`);

--
-- Indexes for table `produtos_preco`
--
ALTER TABLE `produtos_preco`
 ADD PRIMARY KEY (`id_produto_preco`), ADD KEY `id_produto` (`id_produto`);

--
-- Indexes for table `produtos_vendidos`
--
ALTER TABLE `produtos_vendidos`
 ADD PRIMARY KEY (`id_produto_vendido`), ADD KEY `id_venda` (`id_venda`), ADD KEY `id_produto` (`id_produto`);

--
-- Indexes for table `produto_fornecedores`
--
ALTER TABLE `produto_fornecedores`
 ADD PRIMARY KEY (`id_produto_fornecedor`), ADD KEY `id_produto` (`id_produto`), ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- Indexes for table `produto_lote`
--
ALTER TABLE `produto_lote`
 ADD PRIMARY KEY (`id_produto_lote`), ADD UNIQUE KEY `codigo_lote` (`codigo_lote`), ADD KEY `id_estoque` (`id_estoque`);

--
-- Indexes for table `requisicao_produto`
--
ALTER TABLE `requisicao_produto`
 ADD PRIMARY KEY (`id_requisicao_produto`), ADD KEY `id_produto` (`id_produto`), ADD KEY `id_requisicao` (`id_requisicao`), ADD KEY `id_unidade_medida_produto` (`id_unidade_medida_produto`);

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
 ADD PRIMARY KEY (`id_usuario`), ADD UNIQUE KEY `email_usuario` (`email_usuario`), ADD UNIQUE KEY `login_usuario` (`login_usuario`), ADD UNIQUE KEY `id_funcionario_2` (`id_funcionario`), ADD KEY `id_funcionario` (`id_funcionario`), ADD KEY `id_usuarios_grupo` (`id_nivel_acesso`), ADD KEY `id_nivel_acesso` (`id_nivel_acesso`);

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
 ADD PRIMARY KEY (`id_unidade_medida`), ADD UNIQUE KEY `abreviacao_unidade_medida` (`abreviacao_unidade_medida`);

--
-- Indexes for table `unidade_medida_produto`
--
ALTER TABLE `unidade_medida_produto`
 ADD PRIMARY KEY (`id_unidade_medida_produto`), ADD KEY `id_produto` (`id_produto`), ADD KEY `id_produto_2` (`id_produto`), ADD KEY `id_unidade_medida` (`id_unidade_medida`);

--
-- Indexes for table `vendas`
--
ALTER TABLE `vendas`
 ADD PRIMARY KEY (`id_venda`), ADD KEY `id_abertura_caixa` (`id_abertura_caixa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abertura_caixa`
--
ALTER TABLE `abertura_caixa`
MODIFY `id_abertura_caixa` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `acesso_action`
--
ALTER TABLE `acesso_action`
MODIFY `id_acesso_action` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=201;
--
-- AUTO_INCREMENT for table `acesso_modulo`
--
ALTER TABLE `acesso_modulo`
MODIFY `id_acesso_modulo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=112;
--
-- AUTO_INCREMENT for table `acesso_pagina`
--
ALTER TABLE `acesso_pagina`
MODIFY `id_acesso_pagina` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT for table `caixas`
--
ALTER TABLE `caixas`
MODIFY `id_caixa` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cargos`
--
ALTER TABLE `cargos`
MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cotacoes`
--
ALTER TABLE `cotacoes`
MODIFY `id_cotacao` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
MODIFY `id_email` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `estoque`
--
ALTER TABLE `estoque`
MODIFY `id_estoque` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `fornecedores`
--
ALTER TABLE `fornecedores`
MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
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
MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT for table `localizacao_lote`
--
ALTER TABLE `localizacao_lote`
MODIFY `id_localizacao_lote` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `marcas`
--
ALTER TABLE `marcas`
MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
MODIFY `id_nivel_acesso` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `nivel_estoque`
--
ALTER TABLE `nivel_estoque`
MODIFY `id_nivel_estoque` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `orcamentos`
--
ALTER TABLE `orcamentos`
MODIFY `id_orcamento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orcamento_produto`
--
ALTER TABLE `orcamento_produto`
MODIFY `id_orcamento_produto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `produtos_preco`
--
ALTER TABLE `produtos_preco`
MODIFY `id_produto_preco` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `produtos_vendidos`
--
ALTER TABLE `produtos_vendidos`
MODIFY `id_produto_vendido` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `produto_fornecedores`
--
ALTER TABLE `produto_fornecedores`
MODIFY `id_produto_fornecedor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `produto_lote`
--
ALTER TABLE `produto_lote`
MODIFY `id_produto_lote` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `requisicao_produto`
--
ALTER TABLE `requisicao_produto`
MODIFY `id_requisicao_produto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `requisicao_usuario`
--
ALTER TABLE `requisicao_usuario`
MODIFY `id_requisicao_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `requisicoes`
--
ALTER TABLE `requisicoes`
MODIFY `id_requisicao` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `sys_actions`
--
ALTER TABLE `sys_actions`
MODIFY `id_action` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `sys_modulos`
--
ALTER TABLE `sys_modulos`
MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `sys_paginas`
--
ALTER TABLE `sys_paginas`
MODIFY `id_pagina` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `sys_usuarios`
--
ALTER TABLE `sys_usuarios`
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `sys_usuarios_acessos`
--
ALTER TABLE `sys_usuarios_acessos`
MODIFY `id_usuarios_acesso` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=276;
--
-- AUTO_INCREMENT for table `sys_usuarios_grupo`
--
ALTER TABLE `sys_usuarios_grupo`
MODIFY `id_usuarios_grupo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `telefones`
--
ALTER TABLE `telefones`
MODIFY `id_telefone` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `unidade_medida`
--
ALTER TABLE `unidade_medida`
MODIFY `id_unidade_medida` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `unidade_medida_produto`
--
ALTER TABLE `unidade_medida_produto`
MODIFY `id_unidade_medida_produto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `vendas`
--
ALTER TABLE `vendas`
MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `abertura_caixa`
--
ALTER TABLE `abertura_caixa`
ADD CONSTRAINT `abertura_caixa_ibfk_1` FOREIGN KEY (`id_caixa`) REFERENCES `caixas` (`id_caixa`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `abertura_caixa_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `sys_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `acesso_action`
--
ALTER TABLE `acesso_action`
ADD CONSTRAINT `acesso_action_ibfk_1` FOREIGN KEY (`id_nivel_acesso`) REFERENCES `nivel_acesso` (`id_nivel_acesso`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `acesso_action_ibfk_2` FOREIGN KEY (`id_action`) REFERENCES `sys_actions` (`id_action`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `acesso_modulo`
--
ALTER TABLE `acesso_modulo`
ADD CONSTRAINT `acesso_modulo_ibfk_1` FOREIGN KEY (`id_nivel_acesso`) REFERENCES `nivel_acesso` (`id_nivel_acesso`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `acesso_modulo_ibfk_2` FOREIGN KEY (`id_modulo`) REFERENCES `sys_modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `acesso_pagina`
--
ALTER TABLE `acesso_pagina`
ADD CONSTRAINT `acesso_pagina_ibfk_1` FOREIGN KEY (`id_nivel_acesso`) REFERENCES `nivel_acesso` (`id_nivel_acesso`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `acesso_pagina_ibfk_2` FOREIGN KEY (`id_pagina`) REFERENCES `sys_paginas` (`id_pagina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `cotacoes`
--
ALTER TABLE `cotacoes`
ADD CONSTRAINT `cotacoes_ibfk_1` FOREIGN KEY (`id_requisicao`) REFERENCES `requisicoes` (`id_requisicao`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Limitadores para a tabela `localizacao_lote`
--
ALTER TABLE `localizacao_lote`
ADD CONSTRAINT `localizacao_lote_ibfk_1` FOREIGN KEY (`id_produto_lote`) REFERENCES `produto_lote` (`id_produto_lote`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `localizacao_lote_ibfk_2` FOREIGN KEY (`id_unidade_medida_produto`) REFERENCES `unidade_medida_produto` (`id_unidade_medida_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `nivel_estoque`
--
ALTER TABLE `nivel_estoque`
ADD CONSTRAINT `nivel_estoque_ibfk_1` FOREIGN KEY (`id_estoque`) REFERENCES `estoque` (`id_estoque`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `nivel_estoque_ibfk_2` FOREIGN KEY (`id_unidade_medida_produto`) REFERENCES `unidade_medida_produto` (`id_unidade_medida_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `orcamentos`
--
ALTER TABLE `orcamentos`
ADD CONSTRAINT `orcamentos_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `orcamentos_ibfk_2` FOREIGN KEY (`id_requisicao`) REFERENCES `requisicoes` (`id_requisicao`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `orcamento_produto`
--
ALTER TABLE `orcamento_produto`
ADD CONSTRAINT `orcamento_produto_ibfk_1` FOREIGN KEY (`id_orcamento`) REFERENCES `orcamentos` (`id_orcamento`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `orcamento_produto_ibfk_2` FOREIGN KEY (`id_requisicao_produto`) REFERENCES `requisicao_produto` (`id_requisicao_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `produtos_preco`
--
ALTER TABLE `produtos_preco`
ADD CONSTRAINT `produtos_preco_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `produtos_vendidos`
--
ALTER TABLE `produtos_vendidos`
ADD CONSTRAINT `produtos_vendidos_ibfk_1` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id_venda`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `produtos_vendidos_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `produto_fornecedores`
--
ALTER TABLE `produto_fornecedores`
ADD CONSTRAINT `produto_fornecedores_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `produto_fornecedores_ibfk_2` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `produto_lote`
--
ALTER TABLE `produto_lote`
ADD CONSTRAINT `produto_lote_ibfk_1` FOREIGN KEY (`id_estoque`) REFERENCES `estoque` (`id_estoque`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `requisicao_produto`
--
ALTER TABLE `requisicao_produto`
ADD CONSTRAINT `requisicao_produto_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `requisicao_produto_ibfk_2` FOREIGN KEY (`id_requisicao`) REFERENCES `requisicoes` (`id_requisicao`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `requisicao_produto_ibfk_3` FOREIGN KEY (`id_unidade_medida_produto`) REFERENCES `unidade_medida_produto` (`id_unidade_medida_produto`);

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
ADD CONSTRAINT `sys_usuarios_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE,
ADD CONSTRAINT `sys_usuarios_ibfk_2` FOREIGN KEY (`id_nivel_acesso`) REFERENCES `nivel_acesso` (`id_nivel_acesso`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Limitadores para a tabela `unidade_medida_produto`
--
ALTER TABLE `unidade_medida_produto`
ADD CONSTRAINT `unidade_medida_produto_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `unidade_medida_produto_ibfk_2` FOREIGN KEY (`id_unidade_medida`) REFERENCES `unidade_medida` (`id_unidade_medida`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `vendas`
--
ALTER TABLE `vendas`
ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_abertura_caixa`) REFERENCES `abertura_caixa` (`id_abertura_caixa`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
