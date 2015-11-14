-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 07-Nov-2015 às 00:09
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
-- Estrutura da tabela `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id_email` int(11) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `endereco_email` varchar(255) DEFAULT NULL,
  `tipo_email` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `emails`
--

INSERT INTO `emails` (`id_email`, `id_funcionario`, `endereco_email`, `tipo_email`, `timestamp`) VALUES
(1, 21, 'jessica@gmail.com', 'Pessoal', '2015-11-06 22:49:34');

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos`
--

CREATE TABLE IF NOT EXISTS `enderecos` (
  `id_endereco` int(11) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `cep_endereco` varchar(255) DEFAULT NULL,
  `rua_endereco` varchar(255) DEFAULT NULL,
  `numero_endereco` int(11) DEFAULT NULL,
  `complemento_endereco` varchar(255) DEFAULT NULL,
  `bairro_endereco` varchar(255) DEFAULT NULL,
  `cidade_endereco` varchar(255) DEFAULT NULL,
  `estado_endereco` varchar(255) DEFAULT NULL,
  `data_cadastro_endereco` datetime DEFAULT NULL,
  `data_atualizacao_endereco` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `enderecos`
--

INSERT INTO `enderecos` (`id_endereco`, `id_funcionario`, `cep_endereco`, `rua_endereco`, `numero_endereco`, `complemento_endereco`, `bairro_endereco`, `cidade_endereco`, `estado_endereco`, `data_cadastro_endereco`, `data_atualizacao_endereco`) VALUES
(49, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:30:05', NULL),
(50, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:32:04', NULL),
(51, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:32:40', NULL),
(52, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:33:16', NULL),
(53, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:37:40', NULL),
(54, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:40:52', NULL),
(55, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:44:29', NULL),
(56, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:45:04', NULL),
(57, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:45:24', NULL),
(58, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:47:31', NULL),
(59, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:48:02', NULL),
(60, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 06:59:39', NULL),
(61, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 07:00:07', NULL),
(62, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 07:03:02', NULL),
(63, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 07:03:27', NULL),
(64, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 07:10:17', NULL),
(65, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 07:10:37', NULL),
(66, 20, '08580-300', 'Rua Maresias', 196, 'compl.', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 07:11:04', NULL),
(67, 21, '08580-300', 'Rua Maresias', 40, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-11-06 11:49:33', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolaridade`
--

CREATE TABLE IF NOT EXISTS `escolaridade` (
  `id_escolaridade` int(11) NOT NULL,
  `nome_escolaridade` varchar(255) DEFAULT NULL,
  `status_escolaridade` varchar(255) DEFAULT NULL,
  `data_criacao_escolaridade` datetime DEFAULT NULL,
  `data_atualizacao_escolaridade` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado_civil`
--

CREATE TABLE IF NOT EXISTS `estado_civil` (
  `id_estado_civil` int(11) NOT NULL,
  `nome_estado_civil` varchar(255) DEFAULT NULL,
  `status_estado_civil` varchar(255) DEFAULT NULL,
  `data_criacao_estado_civil` datetime DEFAULT NULL,
  `data_atualizacao_estado_civil` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id_funcionario`, `foto_funcionario`, `nome_funcionario`, `sobrenome_funcionario`, `data_nascimento_funcionario`, `sexo_funcionario`, `rg_funcionario`, `cpf_funcionario`, `estado_civil_funcionario`, `escolaridade_funcionario`, `codigo_funcionario`, `cargo_funcionario`, `data_admissao_funcionario`, `salario_funcionario`, `status_funcionario`, `data_cadastro_funcionario`, `timestamp`) VALUES
(20, 'wellington_07030006112015.jpg', 'Wellington', 'cezar', '2015-11-17', 'M', '22.222.233-3', '040.404.040-40', 'Solteiro', 'Ensino Superior Incompleto', 'ADADFDDD', 'Programador Jr', '2015-11-23', '3232.22', 'ATIVO', '2015-11-06 07:11:04', '2015-11-06 22:44:52'),
(21, '', 'Jéssica', 'Santos', '2015-11-27', 'F', '23.333.333-2', '444.444.444-44', 'Casado', 'Ensino Fundamental Incompleto', '12289388', 'TI', '2015-11-11', '1000.00', 'ATIVO', '2015-11-06 11:49:33', '2015-11-06 22:49:33');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_actions`
--

CREATE TABLE IF NOT EXISTS `sys_actions` (
  `id_action` int(11) NOT NULL,
  `slug_action` varchar(255) DEFAULT NULL,
  `nome_action` varchar(255) DEFAULT NULL,
  `status_action` varchar(255) DEFAULT NULL,
  `status_selecao_action` varchar(255) DEFAULT NULL,
  `id_pagina` int(11) DEFAULT NULL,
  `posicao_action` int(11) DEFAULT NULL,
  `data_criacao_pagina` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_modulos`
--

CREATE TABLE IF NOT EXISTS `sys_modulos` (
  `id_modulo` int(11) NOT NULL,
  `slug_modulo` varchar(255) NOT NULL,
  `nome_modulo` varchar(255) DEFAULT NULL,
  `posicao_modulo` varchar(255) DEFAULT NULL,
  `status_modulo` varchar(255) DEFAULT NULL,
  `status_selecao_modulo` varchar(255) DEFAULT NULL,
  `id_modulo_pai` int(11) DEFAULT NULL,
  `icone_modulo` varchar(255) DEFAULT NULL,
  `data_criacao_modulo` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_paginas`
--

CREATE TABLE IF NOT EXISTS `sys_paginas` (
  `id_pagina` int(11) NOT NULL,
  `slug_pagina` varchar(255) DEFAULT NULL,
  `nome_pagina` varchar(255) DEFAULT NULL,
  `posicao_pagina` int(11) DEFAULT NULL,
  `status_pagina` varchar(255) DEFAULT NULL,
  `status_selecao_pagina` varchar(255) DEFAULT NULL,
  `id_modulo` int(11) DEFAULT NULL,
  `data_criacao_pagina` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `data_atualizacao_usuario` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sys_usuarios`
--

INSERT INTO `sys_usuarios` (`id_usuario`, `id_funcionario`, `id_usuarios_grupo`, `email_usuario`, `login_usuario`, `senha_usuario`, `hash_acesso`, `status_usuario`, `data_criacao_usuario`, `data_atualizacao_usuario`) VALUES
(1, NULL, NULL, 'admin@admin.com', 'admin', 'admin', NULL, 'Ativo', '2015-09-20 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_usuarios_grupo`
--

CREATE TABLE IF NOT EXISTS `sys_usuarios_grupo` (
  `id_usuarios_grupo` int(11) NOT NULL,
  `nome_usuarios_grupo` varchar(255) DEFAULT NULL,
  `data_criacao_grupo` datetime DEFAULT NULL,
  `data_atualizacao_grupo` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefones`
--

CREATE TABLE IF NOT EXISTS `telefones` (
  `id_telefone` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `categoria_telefone` varchar(255) DEFAULT NULL,
  `numero_telefone` varchar(255) DEFAULT NULL,
  `operadora_telefone` varchar(255) DEFAULT NULL,
  `tipo_telefone` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `telefones`
--

INSERT INTO `telefones` (`id_telefone`, `id_funcionario`, `categoria_telefone`, `numero_telefone`, `operadora_telefone`, `tipo_telefone`, `timestamp`) VALUES
(29, 20, 'telefone', '(29) 29292-9292', 'sdjalçdj', '', '2015-11-06 05:45:04'),
(30, 21, 'celular', '(11) 3334-4556', 'oi', 'Pessoal', '2015-11-06 22:49:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id_email`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indexes for table `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id_endereco`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indexes for table `escolaridade`
--
ALTER TABLE `escolaridade`
  ADD PRIMARY KEY (`id_escolaridade`);

--
-- Indexes for table `estado_civil`
--
ALTER TABLE `estado_civil`
  ADD PRIMARY KEY (`id_estado_civil`);

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD KEY `id_estado_civil` (`estado_civil_funcionario`),
  ADD KEY `id_escolaridade` (`escolaridade_funcionario`),
  ADD KEY `id_cargo` (`cargo_funcionario`);

--
-- Indexes for table `sys_actions`
--
ALTER TABLE `sys_actions`
  ADD PRIMARY KEY (`id_action`),
  ADD KEY `id_pagina` (`id_pagina`);

--
-- Indexes for table `sys_modulos`
--
ALTER TABLE `sys_modulos`
  ADD PRIMARY KEY (`id_modulo`),
  ADD KEY `id_modulo_pai` (`id_modulo_pai`);

--
-- Indexes for table `sys_paginas`
--
ALTER TABLE `sys_paginas`
  ADD PRIMARY KEY (`id_pagina`),
  ADD KEY `id_modulo` (`id_modulo`);

--
-- Indexes for table `sys_usuarios`
--
ALTER TABLE `sys_usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email_usuario` (`email_usuario`),
  ADD UNIQUE KEY `login_usuario` (`login_usuario`),
  ADD KEY `id_funcionario` (`id_funcionario`),
  ADD KEY `id_usuarios_grupo` (`id_usuarios_grupo`);

--
-- Indexes for table `sys_usuarios_grupo`
--
ALTER TABLE `sys_usuarios_grupo`
  ADD PRIMARY KEY (`id_usuarios_grupo`);

--
-- Indexes for table `telefones`
--
ALTER TABLE `telefones`
  ADD PRIMARY KEY (`id_telefone`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id_email` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `escolaridade`
--
ALTER TABLE `escolaridade`
  MODIFY `id_escolaridade` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `estado_civil`
--
ALTER TABLE `estado_civil`
  MODIFY `id_estado_civil` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `sys_actions`
--
ALTER TABLE `sys_actions`
  MODIFY `id_action` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_modulos`
--
ALTER TABLE `sys_modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_paginas`
--
ALTER TABLE `sys_paginas`
  MODIFY `id_pagina` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_usuarios`
--
ALTER TABLE `sys_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sys_usuarios_grupo`
--
ALTER TABLE `sys_usuarios_grupo`
  MODIFY `id_usuarios_grupo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `telefones`
--
ALTER TABLE `telefones`
  MODIFY `id_telefone` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `emails`
--
ALTER TABLE `emails`
  ADD CONSTRAINT `email_id_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Limitadores para a tabela `telefones`
--
ALTER TABLE `telefones`
  ADD CONSTRAINT `telefones_id_func` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
