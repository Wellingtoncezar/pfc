-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 20-Set-2015 às 13:02
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
  `status_cargo` varchar(255) DEFAULT NULL,
  `data_criacao_cargo` datetime DEFAULT NULL,
  `data_atualizacao_cargo` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
`id_email` int(11) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_tipo_email` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `data_cadastro_email` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `pais_endereco` varchar(255) DEFAULT NULL,
  `data_cadastro_endereco` datetime DEFAULT NULL,
  `data_atualizacao_endereco` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `naturalidade_funcionario` varchar(255) DEFAULT NULL,
  `nacionalidade_funcionario` varchar(255) DEFAULT NULL,
  `rg_funcionario` varchar(255) DEFAULT NULL,
  `cpf_funcionario` varchar(255) NOT NULL,
  `id_estado_civil` int(11) DEFAULT NULL,
  `id_escolaridade` int(11) DEFAULT NULL,
  `codigo_inscricao` varchar(255) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `data_admissao` date DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `data_criacao_funcionario` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_acesso_action`
--

CREATE TABLE IF NOT EXISTS `sys_acesso_action` (
`id_acesso_action` int(11) NOT NULL,
  `id_usuarios_grupo` int(11) DEFAULT NULL,
  `id_action` int(11) DEFAULT NULL,
  `id_acesso_pagina` int(11) DEFAULT NULL,
  `timestamp_acesso_modulo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_acesso_modulo`
--

CREATE TABLE IF NOT EXISTS `sys_acesso_modulo` (
`id_acesso_modulo` int(11) NOT NULL,
  `id_usuarios_grupo` int(11) DEFAULT NULL,
  `id_modulo` int(11) DEFAULT NULL,
  `timestamp_acesso_modulo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_acesso_pagina`
--

CREATE TABLE IF NOT EXISTS `sys_acesso_pagina` (
`id_acesso_pagina` int(11) NOT NULL,
  `id_usuarios_grupo` int(11) DEFAULT NULL,
  `id_pagina` int(11) DEFAULT NULL,
  `id_acesso_modulo` int(11) DEFAULT NULL,
  `timestamp_acesso_modulo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `id_funcionario` int(11) DEFAULT NULL,
  `numero_telefone` varchar(255) DEFAULT NULL,
  `categoria_telefone` varchar(255) DEFAULT NULL,
  `operadora_telefone` varchar(255) DEFAULT NULL,
  `tipo_telefone` int(11) DEFAULT NULL,
  `data_cadastro_telefone` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_email`
--

CREATE TABLE IF NOT EXISTS `tipo_email` (
`id_tipo_email` int(11) NOT NULL,
  `nome_tipo_email` varchar(255) DEFAULT NULL,
  `status_tipo_email` varchar(255) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_telefone`
--

CREATE TABLE IF NOT EXISTS `tipo_telefone` (
`id_tipo_telefone` int(11) NOT NULL,
  `nome_tipo_telefone` varchar(255) DEFAULT NULL,
  `status_tipo_telefone` varchar(255) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargos`
--
ALTER TABLE `cargos`
 ADD PRIMARY KEY (`id_cargo`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
 ADD PRIMARY KEY (`id_email`), ADD KEY `id_tipo_email` (`id_tipo_email`), ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indexes for table `enderecos`
--
ALTER TABLE `enderecos`
 ADD PRIMARY KEY (`id_endereco`), ADD KEY `id_funcionario` (`id_funcionario`);

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
 ADD PRIMARY KEY (`id_funcionario`), ADD KEY `id_estado_civil` (`id_estado_civil`), ADD KEY `id_escolaridade` (`id_escolaridade`), ADD KEY `id_cargo` (`id_cargo`);

--
-- Indexes for table `sys_acesso_action`
--
ALTER TABLE `sys_acesso_action`
 ADD PRIMARY KEY (`id_acesso_action`), ADD KEY `id_action` (`id_action`), ADD KEY `id_acesso_pagina` (`id_acesso_pagina`), ADD KEY `id_usuarios_grupo` (`id_usuarios_grupo`);

--
-- Indexes for table `sys_acesso_modulo`
--
ALTER TABLE `sys_acesso_modulo`
 ADD PRIMARY KEY (`id_acesso_modulo`), ADD KEY `id_modulo` (`id_modulo`), ADD KEY `id_usuarios_grupo` (`id_usuarios_grupo`);

--
-- Indexes for table `sys_acesso_pagina`
--
ALTER TABLE `sys_acesso_pagina`
 ADD PRIMARY KEY (`id_acesso_pagina`), ADD KEY `id_pagina` (`id_pagina`), ADD KEY `id_acesso_modulo` (`id_acesso_modulo`), ADD KEY `id_usuarios_grupo` (`id_usuarios_grupo`);

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
 ADD PRIMARY KEY (`id_usuarios_grupo`);

--
-- Indexes for table `telefones`
--
ALTER TABLE `telefones`
 ADD PRIMARY KEY (`id_telefone`), ADD KEY `tipo_telefone` (`tipo_telefone`), ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indexes for table `tipo_email`
--
ALTER TABLE `tipo_email`
 ADD PRIMARY KEY (`id_tipo_email`);

--
-- Indexes for table `tipo_telefone`
--
ALTER TABLE `tipo_telefone`
 ADD PRIMARY KEY (`id_tipo_telefone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargos`
--
ALTER TABLE `cargos`
MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
MODIFY `id_email` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT;
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
MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_acesso_action`
--
ALTER TABLE `sys_acesso_action`
MODIFY `id_acesso_action` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_acesso_modulo`
--
ALTER TABLE `sys_acesso_modulo`
MODIFY `id_acesso_modulo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_acesso_pagina`
--
ALTER TABLE `sys_acesso_pagina`
MODIFY `id_acesso_pagina` int(11) NOT NULL AUTO_INCREMENT;
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
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_usuarios_grupo`
--
ALTER TABLE `sys_usuarios_grupo`
MODIFY `id_usuarios_grupo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `telefones`
--
ALTER TABLE `telefones`
MODIFY `id_telefone` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipo_email`
--
ALTER TABLE `tipo_email`
MODIFY `id_tipo_email` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipo_telefone`
--
ALTER TABLE `tipo_telefone`
MODIFY `id_tipo_telefone` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `emails`
--
ALTER TABLE `emails`
ADD CONSTRAINT `emails_ibfk_1` FOREIGN KEY (`id_tipo_email`) REFERENCES `tipo_email` (`id_tipo_email`),
ADD CONSTRAINT `emails_ibfk_2` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `enderecos`
--
ALTER TABLE `enderecos`
ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `funcionarios`
--
ALTER TABLE `funcionarios`
ADD CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`id_estado_civil`) REFERENCES `estado_civil` (`id_estado_civil`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `funcionarios_ibfk_2` FOREIGN KEY (`id_escolaridade`) REFERENCES `escolaridade` (`id_escolaridade`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `funcionarios_ibfk_3` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id_cargo`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `sys_acesso_action`
--
ALTER TABLE `sys_acesso_action`
ADD CONSTRAINT `sys_acesso_action_ibfk_1` FOREIGN KEY (`id_action`) REFERENCES `sys_actions` (`id_action`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `sys_acesso_action_ibfk_2` FOREIGN KEY (`id_acesso_pagina`) REFERENCES `sys_acesso_pagina` (`id_acesso_pagina`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `sys_acesso_action_ibfk_3` FOREIGN KEY (`id_usuarios_grupo`) REFERENCES `sys_usuarios_grupo` (`id_usuarios_grupo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `sys_acesso_modulo`
--
ALTER TABLE `sys_acesso_modulo`
ADD CONSTRAINT `sys_acesso_modulo_ibfk_1` FOREIGN KEY (`id_modulo`) REFERENCES `sys_modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `sys_acesso_modulo_ibfk_2` FOREIGN KEY (`id_usuarios_grupo`) REFERENCES `sys_usuarios_grupo` (`id_usuarios_grupo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `sys_acesso_pagina`
--
ALTER TABLE `sys_acesso_pagina`
ADD CONSTRAINT `sys_acesso_pagina_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `sys_paginas` (`id_pagina`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `sys_acesso_pagina_ibfk_2` FOREIGN KEY (`id_acesso_modulo`) REFERENCES `sys_acesso_modulo` (`id_acesso_modulo`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `sys_acesso_pagina_ibfk_3` FOREIGN KEY (`id_usuarios_grupo`) REFERENCES `sys_usuarios_grupo` (`id_usuarios_grupo`) ON DELETE CASCADE ON UPDATE CASCADE;

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
ADD CONSTRAINT `telefones_ibfk_1` FOREIGN KEY (`tipo_telefone`) REFERENCES `tipo_telefone` (`id_tipo_telefone`) ON UPDATE CASCADE,
ADD CONSTRAINT `telefones_ibfk_2` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
