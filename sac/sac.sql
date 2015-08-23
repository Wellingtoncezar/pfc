-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 20-Ago-2015 às 05:55
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
-- Estrutura da tabela `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
`id_action` int(11) NOT NULL,
  `url_action` varchar(255) DEFAULT NULL,
  `nome_action` varchar(255) DEFAULT NULL,
  `status_action` varchar(255) DEFAULT 'Inativo',
  `status_selecao` varchar(255) NOT NULL DEFAULT 'Inativo',
  `id_pagina` int(11) DEFAULT NULL,
  `posicao_action` int(11) NOT NULL,
  `data_criacao` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `actions`
--

INSERT INTO `actions` (`id_action`, `url_action`, `nome_action`, `status_action`, `status_selecao`, `id_pagina`, `posicao_action`, `data_criacao`) VALUES
(1, 'index', NULL, 'Inativo', 'Inativo', 2, 0, '2015-08-20 05:41:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulos`
--

CREATE TABLE IF NOT EXISTS `modulos` (
`id_modulo` int(11) NOT NULL,
  `url_modulo` varchar(255) DEFAULT NULL,
  `nome_modulo` varchar(255) DEFAULT NULL,
  `posicao_modulo` int(11) DEFAULT NULL,
  `status_modulo` varchar(255) DEFAULT NULL,
  `status_selecao` varchar(255) NOT NULL,
  `id_modulo_pai` int(11) DEFAULT NULL,
  `foto_modulo` varchar(255) NOT NULL,
  `data_criacao` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao`, `id_modulo_pai`, `foto_modulo`, `data_criacao`) VALUES
(1, '', NULL, NULL, 'Inativo', '', 0, '', '2015-08-20 05:35:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `paginas`
--

CREATE TABLE IF NOT EXISTS `paginas` (
`id_pagina` int(11) NOT NULL,
  `url_pagina` varchar(255) DEFAULT NULL,
  `nome_pagina` varchar(255) DEFAULT NULL,
  `posicao_pagina` int(255) DEFAULT NULL,
  `status_pagina` varchar(255) DEFAULT NULL,
  `status_selecao` varchar(255) NOT NULL,
  `id_modulo` int(11) DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `paginas`
--

INSERT INTO `paginas` (`id_pagina`, `url_pagina`, `nome_pagina`, `posicao_pagina`, `status_pagina`, `status_selecao`, `id_modulo`, `data_criacao`) VALUES
(1, 'login', NULL, NULL, 'Inativo', '', 1, '2015-08-20 05:35:48'),
(2, 'home', NULL, NULL, 'Inativo', '', 1, '2015-08-20 05:41:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_adm`
--

CREATE TABLE IF NOT EXISTS `usuarios_adm` (
`id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(255) DEFAULT NULL,
  `sobrenome_usuario` varchar(255) DEFAULT NULL,
  `email_usuario` varchar(255) DEFAULT NULL,
  `login_usuario` varchar(255) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `permissao_usuario` varchar(255) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `token` text NOT NULL,
  `foto_usuario` varchar(255) NOT NULL,
  `status_usuario` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios_adm`
--

INSERT INTO `usuarios_adm` (`id_usuario`, `nome_usuario`, `sobrenome_usuario`, `email_usuario`, `login_usuario`, `senha_usuario`, `permissao_usuario`, `data_cadastro`, `token`, `foto_usuario`, `status_usuario`) VALUES
(1, 'Administrador', 'geral', 'wellington.infodahora@gmail.com', 'admin', '0192023a7bbd73250516f069df18b500', 'Administrador', '2015-03-09 00:00:00', '$2a$08$MTEzNDc1NzI3NjU1ZDU0YupEwaHh3kiO/UkBj26v1F77XQ2/1YgtO', '', 'Ativo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_adm_permissao`
--

CREATE TABLE IF NOT EXISTS `usuarios_adm_permissao` (
`id_permissao` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `permissao` text,
  `data_permissao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_adm_acesso`
--

CREATE TABLE IF NOT EXISTS `usuario_adm_acesso` (
`id_acesso` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `data_acesso` date DEFAULT NULL,
  `hora_acesso` time DEFAULT NULL,
  `ip_acesso` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario_adm_acesso`
--

INSERT INTO `usuario_adm_acesso` (`id_acesso`, `id_usuario`, `data_acesso`, `hora_acesso`, `ip_acesso`) VALUES
(1, 1, '2015-08-20', '05:41:22', '::1'),
(2, 1, '2015-08-20', '05:41:27', '::1'),
(3, 1, '2015-08-20', '05:42:29', '::1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_adm_grupo_permissao`
--

CREATE TABLE IF NOT EXISTS `usuario_adm_grupo_permissao` (
`id_grupo_permissao` int(11) NOT NULL,
  `nome_permissao` varchar(255) NOT NULL,
  `permissao` text,
  `data_cadastro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
 ADD PRIMARY KEY (`id_action`), ADD KEY `id_pagina` (`id_pagina`);

--
-- Indexes for table `modulos`
--
ALTER TABLE `modulos`
 ADD PRIMARY KEY (`id_modulo`);

--
-- Indexes for table `paginas`
--
ALTER TABLE `paginas`
 ADD PRIMARY KEY (`id_pagina`), ADD KEY `id_modulo` (`id_modulo`);

--
-- Indexes for table `usuarios_adm`
--
ALTER TABLE `usuarios_adm`
 ADD PRIMARY KEY (`id_usuario`), ADD UNIQUE KEY `login_usuario` (`login_usuario`), ADD UNIQUE KEY `email_usuario` (`email_usuario`);

--
-- Indexes for table `usuarios_adm_permissao`
--
ALTER TABLE `usuarios_adm_permissao`
 ADD PRIMARY KEY (`id_permissao`), ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `usuario_adm_acesso`
--
ALTER TABLE `usuario_adm_acesso`
 ADD PRIMARY KEY (`id_acesso`), ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `usuario_adm_grupo_permissao`
--
ALTER TABLE `usuario_adm_grupo_permissao`
 ADD PRIMARY KEY (`id_grupo_permissao`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
MODIFY `id_action` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `modulos`
--
ALTER TABLE `modulos`
MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `paginas`
--
ALTER TABLE `paginas`
MODIFY `id_pagina` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `usuarios_adm`
--
ALTER TABLE `usuarios_adm`
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuarios_adm_permissao`
--
ALTER TABLE `usuarios_adm_permissao`
MODIFY `id_permissao` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuario_adm_acesso`
--
ALTER TABLE `usuario_adm_acesso`
MODIFY `id_acesso` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `usuario_adm_grupo_permissao`
--
ALTER TABLE `usuario_adm_grupo_permissao`
MODIFY `id_grupo_permissao` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `actions`
--
ALTER TABLE `actions`
ADD CONSTRAINT `actions_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `paginas`
--
ALTER TABLE `paginas`
ADD CONSTRAINT `paginas_ibfk_1` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `usuario_adm_acesso`
--
ALTER TABLE `usuario_adm_acesso`
ADD CONSTRAINT `usuario_adm_acesso_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios_adm` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
