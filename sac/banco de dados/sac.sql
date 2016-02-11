-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 11-Fev-2016 às 01:02
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

--
-- Extraindo dados da tabela `emails_funcionarios`
--

INSERT INTO `emails_funcionarios` (`id_funcionario`, `id_email`) VALUES
(55, 4);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

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
(12, '08580-300', 'Rua Maresias', 2345, '34', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2016-02-09 02:36:16', '2016-02-09 16:36:16');

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
(16, 12);

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
(56, 5),
(57, 6),
(53, 7),
(55, 8),
(58, 10);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

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
(16, '', 'ttrtertert', 'treterte', '34.534.534/5345-34', '345.345.345', 'PF', '', '', '', '0000-00-00', 0, 'ATIVO', '2016-02-09 02:36:16', '2016-02-09 16:36:16');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fornecedores_agenda`
--

INSERT INTO `fornecedores_agenda` (`id_fornecedor_agenda`, `id_fornecedor`, `titulo_agenda`, `observacoes_agenda`, `data_agenda`, `data_cadastro_agenda`, `timestamp`) VALUES
(10, 10, 'agendamento de teste', 'Testando...', '2015-12-07', '2015-11-30 02:29:18', '2015-11-30 04:29:18'),
(11, 10, 'teste', 'teste', '2016-02-10', '2016-02-09 02:13:53', '2016-02-09 16:13:53');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores_agenda_notificado`
--

CREATE TABLE IF NOT EXISTS `fornecedores_agenda_notificado` (
`id_agenda_notificado` int(11) NOT NULL,
  `id_fornecedor_agenda` int(11) DEFAULT NULL,
  `data_notificacao` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fornecedores_agenda_notificado`
--

INSERT INTO `fornecedores_agenda_notificado` (`id_agenda_notificado`, `id_fornecedor_agenda`, `data_notificacao`) VALUES
(1, 10, '2015-11-30'),
(2, 11, '2016-02-09');

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
  `cargo_funcionario` varchar(255) DEFAULT NULL,
  `data_admissao_funcionario` date DEFAULT NULL,
  `salario_funcionario` decimal(10,2) DEFAULT NULL,
  `status_funcionario` enum('ATIVO','INATIVO','EXCLUIDO') NOT NULL DEFAULT 'ATIVO',
  `data_cadastro_funcionario` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id_funcionario`, `foto_funcionario`, `nome_funcionario`, `sobrenome_funcionario`, `data_nascimento_funcionario`, `sexo_funcionario`, `rg_funcionario`, `cpf_funcionario`, `estado_civil_funcionario`, `escolaridade_funcionario`, `codigo_funcionario`, `cargo_funcionario`, `data_admissao_funcionario`, `salario_funcionario`, `status_funcionario`, `data_cadastro_funcionario`, `timestamp`) VALUES
(53, '', 'Fulano', 'de tal', '1987-04-16', 'M', '', '', '', '', '1221222', 'Gerente', '2015-12-04', '15000.00', 'ATIVO', '2016-01-10 05:09:29', '2016-01-20 23:03:10'),
(55, '', 'nome', 'sobrenome', '2016-01-19', 'M', '', '', '', '', '', '', '0000-00-00', '0.00', 'EXCLUIDO', '2016-01-18 09:50:32', '2016-01-20 23:16:48'),
(56, '', '&lt;script&gt;alert(''teste'')&lt;/script&gt;', 'asdf', '2016-01-25', 'M', '', '', '', '', '', '', '0000-00-00', '0.00', 'INATIVO', '2016-01-31 02:34:10', '2016-02-09 20:16:32'),
(57, '', 'teste', 'teste', '2016-01-13', 'M', '', '', '', '', '', '', '0000-00-00', '0.00', 'ATIVO', '2016-01-10 05:02:00', '2016-01-20 23:16:06'),
(58, 'nome_21434920012016.jpg', 'nome', 'sobrenome', '2016-01-19', 'M', '23.423.434-2', '234.234.234-23', 'Solteiro', 'Ensino Fundamental Completo', '', '', '0000-00-00', '0.00', 'ATIVO', '2016-01-20 09:43:49', '2016-01-20 23:43:50');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `nivel_acesso`
--

INSERT INTO `nivel_acesso` (`id_nivel_acesso`, `nome_nivel_acesso`, `permissoes`, `index_access_db_name`, `timestamp`) VALUES
(1, 'Administrador', '*', 'default', '2016-01-31 03:34:05'),
(2, 'Gerente', '{&quot;funcionarios&quot;:{&quot;submodulos&quot;:{&quot;grupo_funcionarios&quot;:{}}},&quot;fornecedores&quot;:{&quot;submodulos&quot;:{}},&quot;produtos&quot;:{&quot;submodulos&quot;:{}},&quot;estoque&quot;:{&quot;submodulos&quot;:{}},&quot;caixa&quot;:{&quot;submodulos&quot;:{}},&quot;vendas&quot;:{&quot;submodulos&quot;:{}},&quot;orcamentos&quot;:{&quot;submodulos&quot;:{}},&quot;relatorios&quot;:{&quot;submodulos&quot;:{}},&quot;configuracoes&quot;:{&quot;submodulos&quot;:{}}}', 'gerente', '2016-02-03 02:18:16'),
(3, 'Funcionários', '{&quot;fornecedores&quot;:{&quot;submodulos&quot;:{}},&quot;produtos&quot;:{&quot;submodulos&quot;:{}},&quot;estoque&quot;:{&quot;submodulos&quot;:{}},&quot;caixa&quot;:{&quot;submodulos&quot;:{}}}', 'funcionarios', '2016-01-31 03:35:17');

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_actions`
--

INSERT INTO `sys_actions` (`id_action`, `url_action`, `nome_action`, `status_action`, `status_selecao_action`, `id_pagina`, `posicao_action`, `data_criacao_action`) VALUES
(1, 'index', 'Home', 'ATIVO', 'ATIVO', 1, NULL, '2016-01-20 21:14:22'),
(2, 'cadastrar', 'Cadastrar', 'ATIVO', 'ATIVO', 1, NULL, '2016-01-20 21:15:30'),
(3, 'editar', 'Editar', 'ATIVO', 'ATIVO', 1, NULL, '2016-01-20 21:16:11'),
(4, 'excluir', 'Excluir', 'ATIVO', 'ATIVO', 1, NULL, '2016-01-20 21:16:48'),
(5, 'index', 'Home', 'ATIVO', 'ATIVO', 6, NULL, '2016-01-20 21:44:57'),
(6, 'index', NULL, 'INATIVO', 'INATIVO', 2, NULL, '2016-01-20 22:05:41'),
(7, 'index', NULL, 'INATIVO', 'INATIVO', 4, NULL, '2016-01-20 22:05:44'),
(9, 'index', NULL, 'INATIVO', 'INATIVO', 3, NULL, '2016-01-21 20:36:13'),
(10, 'index', NULL, 'ATIVO', 'INATIVO', 7, NULL, '2016-01-23 16:19:53'),
(11, 'index', NULL, 'ATIVO', 'INATIVO', 8, NULL, '2016-01-23 16:20:46'),
(12, 'index', NULL, 'ATIVO', 'INATIVO', 9, NULL, '2016-01-23 16:21:21'),
(13, 'index', NULL, 'ATIVO', 'INATIVO', 10, NULL, '2016-01-23 16:22:36'),
(14, 'index', NULL, 'ATIVO', 'INATIVO', 11, NULL, '2016-01-23 16:23:09'),
(15, 'index', NULL, 'ATIVO', 'INATIVO', 12, NULL, '2016-01-23 16:23:17'),
(16, 'index', NULL, 'INATIVO', 'INATIVO', 13, NULL, '2016-01-30 15:00:29'),
(17, 'index', NULL, 'INATIVO', 'INATIVO', 14, NULL, '2016-01-30 18:31:50'),
(18, 'index', 'Home', 'INATIVO', 'INATIVO', 15, NULL, '2016-02-09 14:13:25');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_modulos`
--

INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES
(0, '', 'ROOT', '0', 'ATIVO', 'INATIVO', NULL, NULL, '2016-01-20 00:00:00'),
(5, 'funcionarios', 'Funcion&aacute;rios', '0', 'ATIVO', 'ATIVO', 0, 'glyphicons glyphicons-group', '2016-01-20 15:15:22'),
(6, 'configuracoes', 'Configura&ccedil;&otilde;es', '8', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-cogwheels', '2016-01-20 15:24:33'),
(7, 'modulos', 'M&oacute;dulos', '', 'ATIVO', 'INATIVO', 6, NULL, '2016-01-20 15:24:40'),
(8, 'fornecedores', 'Fornecedores', '1', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-handshake', '2016-01-20 20:55:14'),
(9, 'produtos', 'Produtos', '2', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-package', '2016-01-23 16:19:53'),
(10, 'estoque', 'Estoque', '3', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-cargo', '2016-01-23 16:20:46'),
(11, 'caixa', 'Caixa', '4', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-calculator', '2016-01-23 16:21:21'),
(12, 'vendas', 'Vendas', '5', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-notes', '2016-01-23 16:22:36'),
(13, 'orcamentos', 'Or&ccedil;amentos', '6', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-coins', '2016-01-23 16:23:09'),
(14, 'relatorios', 'Relat&oacute;rios', '7', 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-stats', '2016-01-23 16:23:17'),
(15, 'niveis_acesso', 'N&iacute;veis de acesso', NULL, 'ATIVO', 'INATIVO', 6, NULL, '2016-01-30 15:00:29'),
(16, 'grupo_funcionarios', 'Grupo de funcionários', NULL, 'ATIVO', 'INATIVO', 5, NULL, '2016-01-30 18:31:50');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_paginas`
--

INSERT INTO `sys_paginas` (`id_pagina`, `url_pagina`, `nome_pagina`, `posicao_pagina`, `status_pagina`, `status_selecao_pagina`, `id_modulo`, `data_criacao_pagina`) VALUES
(1, 'Gerenciar', 'Gerenciar', NULL, 'ATIVO', 'ATIVO', 5, '2016-01-20 15:16:52'),
(2, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 6, '2016-01-20 15:24:33'),
(3, 'gerenciar', NULL, NULL, 'INATIVO', 'INATIVO', 0, '2016-01-20 15:24:38'),
(4, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 7, '2016-01-20 15:24:41'),
(6, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'ATIVO', 8, '2016-01-20 20:55:14'),
(7, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'INATIVO', 9, '2016-01-23 16:19:53'),
(8, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'INATIVO', 10, '2016-01-23 16:20:46'),
(9, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'INATIVO', 11, '2016-01-23 16:21:21'),
(10, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'INATIVO', 12, '2016-01-23 16:22:36'),
(11, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'INATIVO', 13, '2016-01-23 16:23:09'),
(12, 'gerenciar', 'Gerenciar', NULL, 'ATIVO', 'INATIVO', 14, '2016-01-23 16:23:17'),
(13, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 15, '2016-01-30 15:00:29'),
(14, 'gerenciar', 'Gerenciar', NULL, 'INATIVO', 'INATIVO', 16, '2016-01-30 18:31:50'),
(15, 'Agenda', 'Agenda', NULL, 'ATIVO', 'ATIVO', 8, '2016-02-09 14:13:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_usuarios`
--

CREATE TABLE IF NOT EXISTS `sys_usuarios` (
`id_usuario` int(11) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_usuarios_grupo` int(11) DEFAULT NULL,
  `email_usuario` varchar(255) NOT NULL,
  `login_usuario` varchar(255) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `hash_acesso` text,
  `status_usuario` varchar(255) DEFAULT NULL,
  `data_criacao_usuario` datetime DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_usuarios_grupo`
--

INSERT INTO `sys_usuarios_grupo` (`id_usuarios_grupo`, `id_nivel_acesso`, `nome_usuarios_grupo`, `permissao`, `data_criacao_grupo`, `timestamp`) VALUES
(7, 3, 'Testes', '{&quot;caixa&quot;:{&quot;submodulos&quot;:{},&quot;paginas&quot;:{&quot;gerenciar&quot;:{&quot;index&quot;:&quot;&quot;}}}}', '2016-02-09 17:35:27', '2016-02-09 19:36:54');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `telefones`
--

INSERT INTO `telefones` (`id_telefone`, `categoria_telefone`, `numero_telefone`, `tipo_telefone`, `operadora_telefone`, `timestamp`) VALUES
(4, 'celular', '(13) 21321-3213', 'Pessoal', 'operadora', '2016-01-10 18:40:44'),
(5, 'celular', '(77) 77777-7777', 'Pessoal', 'op', '2016-01-10 18:42:04'),
(6, 'telefone', '(22) 22222-2222', 'Profissional', '333', '2016-01-10 19:02:00'),
(8, 'celular', '(42) 34234-2342', 'Pessoal', '33333333333333333333333', '2016-01-11 01:24:51'),
(9, 'telefone', '(23) 4', 'Pessoal', '234', '2016-01-19 00:29:54');

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

--
-- Extraindo dados da tabela `telefones_funcionarios`
--

INSERT INTO `telefones_funcionarios` (`id_funcionario`, `id_telefone`) VALUES
(57, 4),
(57, 5),
(57, 6),
(55, 8);

--
-- Indexes for dumped tables
--

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
 ADD PRIMARY KEY (`id_funcionario`), ADD KEY `id_estado_civil` (`estado_civil_funcionario`), ADD KEY `id_escolaridade` (`escolaridade_funcionario`), ADD KEY `id_cargo` (`cargo_funcionario`);

--
-- Indexes for table `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
 ADD PRIMARY KEY (`id_nivel_acesso`);

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
 ADD PRIMARY KEY (`id_usuario`), ADD UNIQUE KEY `email_usuario` (`email_usuario`), ADD UNIQUE KEY `login_usuario` (`login_usuario`), ADD KEY `id_funcionario` (`id_funcionario`), ADD KEY `id_usuarios_grupo` (`id_usuarios_grupo`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
MODIFY `id_email` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `fornecedores`
--
ALTER TABLE `fornecedores`
MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `fornecedores_agenda`
--
ALTER TABLE `fornecedores_agenda`
MODIFY `id_fornecedor_agenda` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `fornecedores_agenda_notificado`
--
ALTER TABLE `fornecedores_agenda_notificado`
MODIFY `id_agenda_notificado` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
MODIFY `id_nivel_acesso` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sys_actions`
--
ALTER TABLE `sys_actions`
MODIFY `id_action` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `sys_modulos`
--
ALTER TABLE `sys_modulos`
MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `sys_paginas`
--
ALTER TABLE `sys_paginas`
MODIFY `id_pagina` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `sys_usuarios`
--
ALTER TABLE `sys_usuarios`
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_usuarios_grupo`
--
ALTER TABLE `sys_usuarios_grupo`
MODIFY `id_usuarios_grupo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `telefones`
--
ALTER TABLE `telefones`
MODIFY `id_telefone` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
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
ADD CONSTRAINT `sys_usuarios_ibfk_2` FOREIGN KEY (`id_usuarios_grupo`) REFERENCES `sys_usuarios_grupo` (`id_usuarios_grupo`) ON DELETE SET NULL ON UPDATE CASCADE;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
