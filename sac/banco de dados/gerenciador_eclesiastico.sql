-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Máquina: 127.0.0.1
-- Data de Criação: 03-Jul-2015 às 22:17
-- Versão do servidor: 5.5.32
-- versão do PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `gerenciador_eclesiastico`
--
CREATE DATABASE IF NOT EXISTS `gerenciador_eclesiastico` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gerenciador_eclesiastico`;

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getLastAdm`() RETURNS int(11)
    NO SQL
BEGIN
	DECLARE id int;
  	SELECT id_usuario INTO id FROM last_user_adm LIMIT 1;
  	RETURN id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `setLog`(`id` INT) RETURNS int(11)
BEGIN
  update last_user_adm set id_usuario = id;
  RETURN 0;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `id_action` int(11) NOT NULL AUTO_INCREMENT,
  `url_action` varchar(255) DEFAULT NULL,
  `nome_action` varchar(255) DEFAULT NULL,
  `status_action` varchar(255) DEFAULT 'Inativo',
  `status_selecao` varchar(255) NOT NULL DEFAULT 'Inativo',
  `id_pagina` int(11) DEFAULT NULL,
  `posicao_action` int(11) NOT NULL,
  `data_criacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_action`),
  KEY `id_pagina` (`id_pagina`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=230 ;

--
-- Extraindo dados da tabela `actions`
--

INSERT INTO `actions` (`id_action`, `url_action`, `nome_action`, `status_action`, `status_selecao`, `id_pagina`, `posicao_action`, `data_criacao`) VALUES
(105, 'cadastrar', 'Cadastrar', 'Ativo', 'Ativo', 23, 0, '2015-03-27 17:09:06'),
(106, 'editar', 'Editar', 'Ativo', 'Ativo', 23, 0, '2015-03-27 18:58:07'),
(107, 'index', 'Home', 'Ativo', 'Ativo', 23, 0, '2015-03-27 19:13:09'),
(108, 'excluir', 'Excluir', 'Ativo', 'Ativo', 23, 0, '2015-03-27 19:16:59'),
(109, 'index', 'Home', 'Ativo', 'Ativo', 25, 0, '2015-03-27 19:29:14'),
(110, 'cadastrar', 'Cadastrar', 'Ativo', 'Ativo', 25, 0, '2015-03-27 19:30:38'),
(111, 'editar', 'Editar', 'Ativo', 'Ativo', 25, 0, '2015-03-27 19:30:55'),
(112, 'excluir', 'Excluir', 'Ativo', 'Ativo', 25, 0, '2015-03-27 19:31:10'),
(113, 'index', 'Home', 'Ativo', 'Ativo', 27, 0, '2015-03-27 19:31:47'),
(114, 'cadastrar', 'Cadastrar', 'Ativo', 'Ativo', 27, 0, '2015-03-27 19:32:19'),
(115, 'editar', 'Editar', 'Ativo', 'Ativo', 27, 0, '2015-03-27 19:32:22'),
(116, 'excluir', 'Excluir', 'Ativo', 'Ativo', 27, 0, '2015-03-27 19:32:35'),
(117, 'index', 'Lista dos módulos', 'Ativo', 'Inativo', 33, 0, '2015-03-27 19:34:49'),
(118, 'index', 'Home', 'Ativo', 'Inativo', 34, 0, '2015-03-27 19:40:57'),
(119, 'index', 'Home', 'Ativo', 'Inativo', 31, 0, '2015-03-27 19:44:10'),
(120, 'index', 'Home', 'Ativo', 'Ativo', 21, 0, '2015-04-15 22:33:04'),
(121, 'index', NULL, 'Inativo', 'Inativo', 36, 0, '2015-04-16 13:41:09'),
(122, 'index', NULL, 'Inativo', 'Inativo', 22, 0, '2015-04-16 17:19:56'),
(123, 'cadastrar', 'Cadastrar', 'Ativo', 'Inativo', 21, 0, '2015-04-16 17:31:55'),
(125, 'index', 'Home', 'Ativo', 'Ativo', 38, 0, '2015-04-16 21:16:14'),
(126, 'cadastrar', 'Cadastrar', 'Ativo', 'Inativo', 38, 0, '2015-04-16 21:26:44'),
(127, 'editar', 'Editar', 'Ativo', 'Inativo', 38, 0, '2015-04-16 21:47:50'),
(128, 'excluir', 'Excluir', 'Ativo', 'Inativo', 38, 0, '2015-04-16 21:50:56'),
(129, 'index', 'home', 'Ativo', 'Inativo', 39, 0, '2015-04-22 17:52:21'),
(130, 'editar', 'Editar', 'Ativo', 'Inativo', 21, 0, '2015-04-24 21:02:14'),
(131, 'genealogia', 'Genealogia', 'Ativo', 'Inativo', 21, 0, '2015-04-27 20:09:09'),
(132, 'index', 'Home', 'Ativo', 'Inativo', 40, 0, '2015-04-29 19:53:43'),
(133, 'editar', 'Editar', 'Ativo', 'Inativo', 40, 0, '2015-04-29 19:55:50'),
(134, 'cadastrar', 'Cadastrar', 'Ativo', 'Inativo', 40, 0, '2015-04-29 19:56:09'),
(135, 'excluir', 'Excluir', 'Ativo', 'Inativo', 40, 0, '2015-04-29 19:57:24'),
(137, 'index', 'Index', 'Ativo', 'Ativo', 42, 0, '2015-05-04 14:05:47'),
(138, 'cadastrar', 'Cadastrar', 'Ativo', 'Ativo', 42, 0, '2015-05-04 15:17:04'),
(139, 'cadastrar', 'Cadastrar', 'Ativo', 'Ativo', 30, 0, '2015-05-05 15:23:50'),
(140, 'index', 'Home', 'Ativo', 'Ativo', 30, 0, '2015-05-05 15:24:56'),
(141, 'editar', 'Editar', 'Ativo', 'Ativo', 30, 0, '2015-05-05 15:24:58'),
(142, 'editar', 'Editar', 'Ativo', 'Ativo', 42, 0, '2015-05-11 15:17:28'),
(143, 'index', 'Home', 'Ativo', 'Inativo', 44, 0, '2015-05-11 21:07:35'),
(144, 'cadastrar', 'Cadastrar', 'Ativo', 'Inativo', 44, 0, '2015-05-11 21:19:39'),
(145, 'excluir', 'Excluir', 'Ativo', 'Inativo', 44, 0, '2015-05-12 15:25:57'),
(146, 'editar', 'Editar', 'Ativo', 'Inativo', 44, 0, '2015-05-12 15:26:42'),
(152, 'index', 'Home', 'Ativo', 'Inativo', 47, 0, '2015-05-15 19:48:05'),
(153, 'cadastrar', 'Cadastrar', 'Ativo', 'Inativo', 47, 0, '2015-05-15 19:48:14'),
(154, 'visualizar', 'Visualizar', 'Ativo', 'Inativo', 47, 0, '2015-05-18 13:34:21'),
(155, 'excluir', 'Excluir', 'Ativo', 'Inativo', 21, 0, '2015-05-19 17:16:05'),
(167, 'index', 'Home', 'Inativo', 'Inativo', 55, 0, '2015-06-02 15:05:53'),
(197, 'index', 'Home', 'Ativo', 'Inativo', 62, 0, '2015-06-05 19:41:09'),
(198, 'index', 'Home', 'Ativo', 'Inativo', 63, 0, '2015-06-05 19:43:17'),
(199, 'cadastrar', 'Cadastrar', 'Ativo', 'Inativo', 63, 0, '2015-06-05 19:43:22'),
(200, 'editar', 'Editar', 'Ativo', 'Inativo', 63, 0, '2015-06-05 19:43:27'),
(201, 'excluir', 'Excluir', 'Ativo', 'Inativo', 63, 0, '2015-06-05 19:43:35'),
(202, 'index', 'Home', 'Ativo', 'Inativo', 64, 0, '2015-06-05 19:45:06'),
(203, 'excluir', 'Excluir', 'Ativo', 'Inativo', 64, 0, '2015-06-05 19:53:50'),
(204, 'cadastrar', 'Cadastrar', 'Ativo', 'Inativo', 64, 0, '2015-06-05 20:18:19'),
(205, 'editar', 'Editar', 'Ativo', 'Inativo', 64, 0, '2015-06-05 20:18:22'),
(206, 'index', 'Home', 'Ativo', 'Inativo', 65, 0, '2015-06-05 20:24:48'),
(207, 'cadastrar', 'Cadastrar', 'Ativo', 'Inativo', 65, 0, '2015-06-05 20:24:57'),
(208, 'editar', 'Editar', 'Ativo', 'Inativo', 65, 0, '2015-06-05 20:25:05'),
(209, 'excluir', 'Excluir', 'Ativo', 'Inativo', 65, 0, '2015-06-05 20:25:43'),
(210, 'index', 'Home', 'Ativo', 'Inativo', 66, 0, '2015-06-05 20:27:57'),
(211, 'cadastrar', 'Cadastrar', 'Ativo', 'Inativo', 66, 0, '2015-06-05 20:28:00'),
(212, 'editar', 'Editar', 'Ativo', 'Inativo', 66, 0, '2015-06-05 20:28:46'),
(213, 'excluir', 'Excluir', 'Ativo', 'Inativo', 66, 0, '2015-06-05 20:28:52'),
(214, 'index', 'Home', 'Ativo', 'Inativo', 67, 0, '2015-06-05 20:30:55'),
(215, 'cadastrar', 'Cadastrar', 'Ativo', 'Inativo', 67, 0, '2015-06-05 20:31:40'),
(216, 'editar', 'Editar', 'Ativo', 'Inativo', 67, 0, '2015-06-05 20:32:53'),
(217, 'excluir', 'Excluir', 'Ativo', 'Inativo', 67, 0, '2015-06-05 20:33:16'),
(218, 'classe', 'lista dos alunos por classe', 'Ativo', 'Inativo', 68, 0, '2015-06-05 20:35:15'),
(219, 'index', 'Lista de todos os alunos', 'Ativo', 'Inativo', 68, 0, '2015-06-05 20:38:20'),
(220, 'cadastrar', 'Cadastrar', 'Ativo', 'Inativo', 68, 0, '2015-06-05 20:43:23'),
(221, 'excluir', 'Excluir', 'Ativo', 'Inativo', 68, 0, '2015-06-08 14:48:09'),
(223, 'visualizar', 'Visualizar', 'Ativo', 'Inativo', 68, 0, '2015-06-08 15:51:36'),
(224, 'chamadas', 'Chamadas', 'Ativo', 'Inativo', 67, 0, '2015-06-08 20:26:56'),
(225, 'index', NULL, 'Ativo', 'Inativo', 69, 0, '2015-06-08 21:25:08'),
(226, 'classe', NULL, 'Inativo', 'Inativo', 69, 0, '2015-06-11 17:25:41'),
(227, 'cadastrar', NULL, 'Inativo', 'Inativo', 69, 0, '2015-07-01 16:47:27'),
(228, 'visualizar', NULL, 'Inativo', 'Inativo', 69, 0, '2015-07-01 16:51:07'),
(229, 'excluir', NULL, 'Inativo', 'Inativo', 69, 0, '2015-07-01 16:52:05');

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos_ebd`
--

CREATE TABLE IF NOT EXISTS `alunos_ebd` (
  `id_aluno` int(11) NOT NULL AUTO_INCREMENT,
  `id_membro` int(11) DEFAULT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `status_aluno` varchar(255) NOT NULL,
  `data_cadastro_aluno` datetime DEFAULT NULL,
  PRIMARY KEY (`id_aluno`),
  KEY `id_membro` (`id_membro`),
  KEY `id_classe` (`id_classe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Extraindo dados da tabela `alunos_ebd`
--

INSERT INTO `alunos_ebd` (`id_aluno`, `id_membro`, `id_classe`, `status_aluno`, `data_cadastro_aluno`) VALUES
(1, 47, 1, 'Ativo', '2015-06-05 00:00:00'),
(6, 105, 1, 'Ativo', '2015-06-08 15:39:45'),
(7, 103, 2, 'Ativo', '2015-07-03 17:07:02'),
(8, 87, 2, 'Ativo', '2015-07-03 17:07:05'),
(9, 109, 2, 'Ativo', '2015-07-03 17:07:09'),
(10, 100, 2, 'Ativo', '2015-07-03 17:07:12'),
(11, 47, 2, 'Ativo', '2015-07-03 17:07:37'),
(12, 100, 2, 'Ativo', '2015-07-03 17:07:47'),
(13, 100, 2, 'Ativo', '2015-07-03 17:07:51');

-- --------------------------------------------------------

--
-- Estrutura da tabela `chamada_aulas_ebd`
--

CREATE TABLE IF NOT EXISTS `chamada_aulas_ebd` (
  `id_chamada_ebd` int(11) NOT NULL AUTO_INCREMENT,
  `id_aluno` int(11) DEFAULT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `id_data_aula_ebd` int(11) DEFAULT NULL,
  `obs_chamada_aulas_ebd` text NOT NULL,
  `data_cadastro_chamada_ebd` datetime DEFAULT NULL,
  PRIMARY KEY (`id_chamada_ebd`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `chamada_aulas_ebd`
--

INSERT INTO `chamada_aulas_ebd` (`id_chamada_ebd`, `id_aluno`, `id_classe`, `id_data_aula_ebd`, `obs_chamada_aulas_ebd`, `data_cadastro_chamada_ebd`) VALUES
(5, 6, 1, 7, '', '2015-07-02 21:06:48'),
(6, 1, 1, 7, '', '2015-07-02 21:06:48'),
(8, 6, 1, 9, '', '2015-07-02 22:47:58'),
(9, 1, 1, 9, '', '2015-07-02 22:47:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `classes_ebd`
--

CREATE TABLE IF NOT EXISTS `classes_ebd` (
  `id_classe_ebd` int(11) NOT NULL AUTO_INCREMENT,
  `nome_classe_ebd` varchar(255) DEFAULT NULL,
  `faixa_etaria_min` int(11) DEFAULT NULL,
  `faixa_etaria_max` int(11) DEFAULT NULL,
  `descricao_geral_curriculo` text,
  `id_departamento_ebd` int(11) DEFAULT NULL,
  `id_igreja` int(11) NOT NULL,
  `status_classe_ebd` varchar(255) NOT NULL,
  `data_cadastro_classe_ebd` datetime DEFAULT NULL,
  PRIMARY KEY (`id_classe_ebd`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `classes_ebd`
--

INSERT INTO `classes_ebd` (`id_classe_ebd`, `nome_classe_ebd`, `faixa_etaria_min`, `faixa_etaria_max`, `descricao_geral_curriculo`, `id_departamento_ebd`, `id_igreja`, `status_classe_ebd`, `data_cadastro_classe_ebd`) VALUES
(1, 'nome da classe', 5, 12, 'testess', 2, 1, 'Ativo', '2015-06-03 17:00:28'),
(2, 'Classe 2', 16, 50, 'Classe de adultos', 4, 1, 'Ativo', '2015-06-08 14:53:29');

--
-- Acionadores `classes_ebd`
--
DROP TRIGGER IF EXISTS `addLixoClasse`;
DELIMITER //
CREATE TRIGGER `addLixoClasse` AFTER UPDATE ON `classes_ebd`
 FOR EACH ROW BEGIN
  	IF NEW.status_classe_ebd = 'Excluído' THEN 
		BEGIN
    		INSERT INTO lixeira(tabela, campo_status,campo_id,nome_campo_id, nome,data_exclusao) VALUES('classes_ebd','status_classe_ebd',NEW.id_classe_ebd,'id_classe_ebd',NEW.nome_classe_ebd,NOW());
  		END; 
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `coordenadores_ebd`
--

CREATE TABLE IF NOT EXISTS `coordenadores_ebd` (
  `id_coordenador_ebd` int(11) NOT NULL AUTO_INCREMENT,
  `id_membro` int(11) DEFAULT NULL,
  `data_inicio_coordenador_ebd` date DEFAULT NULL,
  `data_fim_coordenador_ebd` date DEFAULT NULL,
  `status_coordenador_ebd` varchar(255) NOT NULL,
  `data_cadastro_coordenador` datetime DEFAULT NULL,
  PRIMARY KEY (`id_coordenador_ebd`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `coordenadores_ebd`
--

INSERT INTO `coordenadores_ebd` (`id_coordenador_ebd`, `id_membro`, `data_inicio_coordenador_ebd`, `data_fim_coordenador_ebd`, `status_coordenador_ebd`, `data_cadastro_coordenador`) VALUES
(1, 51, '2015-06-03', '2015-06-05', 'Ativo', '2015-06-02 00:00:00'),
(2, 51, '2015-06-17', '2015-06-26', 'Excluído', '2015-06-02 16:38:44'),
(3, 105, '2015-06-05', '2016-02-26', 'Ativo', '2015-06-05 20:22:57');

--
-- Acionadores `coordenadores_ebd`
--
DROP TRIGGER IF EXISTS `addLixoCoordenador`;
DELIMITER //
CREATE TRIGGER `addLixoCoordenador` AFTER UPDATE ON `coordenadores_ebd`
 FOR EACH ROW BEGIN
	declare nome_member varchar(255);
	
  	IF NEW.status_coordenador_ebd = 'Excluído' THEN 
		BEGIN
			
			SET @nome_member = (select nome_membro from membros where id_membro = NEW.id_membro);
	
    		INSERT INTO lixeira(tabela, campo_status,campo_id,nome_campo_id, nome,data_exclusao) VALUES('coordenadores_ebd','status_coordenador_ebd',NEW.id_coordenador_ebd,'id_coordenador_ebd',@nome_member,NOW());
  		END; 
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `data_aula_ebd`
--

CREATE TABLE IF NOT EXISTS `data_aula_ebd` (
  `id_data_aula_ebd` int(11) NOT NULL AUTO_INCREMENT,
  `id_classe` int(11) NOT NULL,
  `data_aula` date DEFAULT NULL,
  `hora_aula` time DEFAULT NULL,
  `data_cadastro_data_aula` datetime DEFAULT NULL,
  PRIMARY KEY (`id_data_aula_ebd`),
  KEY `id_classe` (`id_classe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `data_aula_ebd`
--

INSERT INTO `data_aula_ebd` (`id_data_aula_ebd`, `id_classe`, `data_aula`, `hora_aula`, `data_cadastro_data_aula`) VALUES
(7, 1, '2015-07-02', '05:15:00', '2015-07-02 21:06:48'),
(8, 2, '2015-07-02', '03:10:00', '2015-07-02 22:03:55'),
(9, 1, '2015-07-04', '13:54:00', '2015-07-02 22:47:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamentos_ebd`
--

CREATE TABLE IF NOT EXISTS `departamentos_ebd` (
  `id_departamento_ebd` int(11) NOT NULL AUTO_INCREMENT,
  `nome_departamento_ebd` varchar(255) DEFAULT NULL,
  `status_departamento_ebd` varchar(255) DEFAULT NULL,
  `id_coordenador_ebd` int(11) DEFAULT NULL,
  `data_cadastro_departamento` datetime DEFAULT NULL,
  PRIMARY KEY (`id_departamento_ebd`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `departamentos_ebd`
--

INSERT INTO `departamentos_ebd` (`id_departamento_ebd`, `nome_departamento_ebd`, `status_departamento_ebd`, `id_coordenador_ebd`, `data_cadastro_departamento`) VALUES
(2, 'Infantil', 'Ativo', 3, '2015-06-02 20:41:05'),
(3, 'tste', 'Excluído', 2, '2015-06-02 20:41:21'),
(4, 'Adultos', 'Ativo', 2, '2015-06-02 21:12:59');

--
-- Acionadores `departamentos_ebd`
--
DROP TRIGGER IF EXISTS `addLixoDepartamento`;
DELIMITER //
CREATE TRIGGER `addLixoDepartamento` AFTER UPDATE ON `departamentos_ebd`
 FOR EACH ROW BEGIN
  	IF NEW.status_departamento_ebd = 'Excluído' THEN 
		BEGIN
    		INSERT INTO lixeira(tabela, campo_status,campo_id,nome_campo_id, nome,data_exclusao) VALUES('departamentos_ebd','status_departamento_ebd',NEW.id_departamento_ebd,'id_departamento_ebd',NEW.nome_departamento_ebd,NOW());
  		END; 
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id_email` int(11) NOT NULL AUTO_INCREMENT,
  `id_membro` int(11) DEFAULT NULL,
  `id_tipo_email` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `data_cadastro_email` datetime DEFAULT NULL,
  PRIMARY KEY (`id_email`),
  KEY `id_membro` (`id_membro`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `emails`
--

INSERT INTO `emails` (`id_email`, `id_membro`, `id_tipo_email`, `email`, `data_cadastro_email`) VALUES
(1, 84, 3, 'wellington-cezar@hotmail.com', '2015-06-05 20:07:52'),
(2, 84, 4, 'wellington.infodahora@gmail.com', '2015-06-05 20:07:52'),
(3, 102, 0, 'wellington-cezar@hotmail.com', '2015-06-05 19:51:21'),
(4, 85, 4, 'wellington.infodahora@gmail.com', '2015-04-30 17:59:34'),
(5, 89, 3, 'wellington-cezar@hotmail.com', '2015-06-05 20:11:03'),
(6, 102, 0, '', '2015-06-05 19:51:21'),
(7, 102, 1, 'wellington-cezar@hotmail.com', '2015-06-05 19:51:21'),
(8, 100, 3, 'wellington-cezar@hotmail.com', '2015-07-01 15:48:43');

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos`
--

CREATE TABLE IF NOT EXISTS `enderecos` (
  `id_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `id_membro` int(11) DEFAULT NULL,
  `cep_endereco` varchar(255) DEFAULT NULL,
  `rua_endereco` varchar(255) DEFAULT NULL,
  `numero_endereco` int(11) DEFAULT NULL,
  `complemento_endereco` varchar(255) DEFAULT NULL,
  `bairro_endereco` varchar(255) DEFAULT NULL,
  `cidade_endereco` varchar(255) DEFAULT NULL,
  `estado_endereco` varchar(255) DEFAULT NULL,
  `data_cadastro_endereco` datetime DEFAULT NULL,
  PRIMARY KEY (`id_endereco`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `enderecos`
--

INSERT INTO `enderecos` (`id_endereco`, `id_membro`, `cep_endereco`, `rua_endereco`, `numero_endereco`, `complemento_endereco`, `bairro_endereco`, `cidade_endereco`, `estado_endereco`, `data_cadastro_endereco`) VALUES
(1, 47, '08580-300', 'Rua Maresias', 196, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-06-05 20:07:05'),
(2, 102, '08580-300', 'Rua Maresias', 123, 'complemento', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-06-05 19:51:21'),
(3, 104, '08450-161', 'Trav do Castelo', 5, 'São Paulo', 'Guaianases', 'SAO PAULO', 'SP', '2015-05-22 19:51:44'),
(4, 112, '08580-300', 'Rua Maresias', 196, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-05-29 16:43:13'),
(5, 100, '08580-300', 'Rua Maresias', 123, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', '2015-07-01 15:48:43');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado_civil`
--

CREATE TABLE IF NOT EXISTS `estado_civil` (
  `id_estado_civil` int(11) NOT NULL AUTO_INCREMENT,
  `nome_estado_civil` varchar(255) DEFAULT NULL,
  `status_estado_civil` varchar(255) DEFAULT 'Inativo',
  `data_cadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_estado_civil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Extraindo dados da tabela `estado_civil`
--

INSERT INTO `estado_civil` (`id_estado_civil`, `nome_estado_civil`, `status_estado_civil`, `data_cadastro`) VALUES
(1, 'Solteiro(a)', 'Ativo', NULL),
(7, 'Casado(a)', 'Ativo', NULL),
(9, 'Divorciado(a)', 'Ativo', '2015-03-20 16:32:23'),
(10, 'Viúvo(a)', 'Ativo', '2015-03-20 16:32:32'),
(11, 'Desquitado(a)', 'Ativo', '2015-03-20 16:32:44'),
(12, 'Separado(a)', 'Ativo', '2015-03-20 16:32:55'),
(13, 'Não Informado', 'Ativo', '2015-03-20 16:33:11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `genealogia`
--

CREATE TABLE IF NOT EXISTS `genealogia` (
  `id_genealogia` int(11) NOT NULL AUTO_INCREMENT,
  `id_membro` int(11) DEFAULT NULL,
  `id_pai` int(11) DEFAULT NULL,
  `id_mae` int(11) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_genealogia`),
  KEY `genealogia_ibfk_1` (`id_membro`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `genealogia`
--

INSERT INTO `genealogia` (`id_genealogia`, `id_membro`, `id_pai`, `id_mae`, `data_cadastro`) VALUES
(1, 102, 1, 86, '2015-06-05 19:51:21'),
(2, 100, 1, 86, '2015-07-01 15:48:43');

-- --------------------------------------------------------

--
-- Estrutura da tabela `igreja`
--

CREATE TABLE IF NOT EXISTS `igreja` (
  `id_igreja` int(11) NOT NULL AUTO_INCREMENT,
  `nome_igreja` varchar(255) DEFAULT NULL,
  `cep_igreja` varchar(255) DEFAULT NULL,
  `rua_igreja` varchar(255) DEFAULT NULL,
  `numero_igreja` int(11) DEFAULT NULL,
  `complemento_igreja` varchar(255) DEFAULT NULL,
  `bairro_igreja` varchar(255) DEFAULT NULL,
  `cidade_igreja` varchar(255) DEFAULT NULL,
  `estado_igreja` varchar(255) DEFAULT NULL,
  `pais_igreja` varchar(255) DEFAULT NULL,
  `data_fundacao` date DEFAULT NULL,
  `tipo_igreja` varchar(255) DEFAULT NULL,
  `cnpj` varchar(255) DEFAULT NULL,
  `pastor` varchar(255) DEFAULT NULL,
  `status_igreja` varchar(255) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_igreja`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `igreja`
--

INSERT INTO `igreja` (`id_igreja`, `nome_igreja`, `cep_igreja`, `rua_igreja`, `numero_igreja`, `complemento_igreja`, `bairro_igreja`, `cidade_igreja`, `estado_igreja`, `pais_igreja`, `data_fundacao`, `tipo_igreja`, `cnpj`, `pastor`, `status_igreja`, `data_cadastro`) VALUES
(1, 'IPBS', '08580-300', 'Rua Maresias', 196, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', 'Brasil', '2015-05-04', 'Sede', '123.456.789-79', 'pastor', 'Ativo', '2015-05-04 16:30:55'),
(2, 'asdf', '08580-300', 'Rua Maresias', 423, 'complemento', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', 'Brasil', '2015-05-21', 'Sede', '121.312.132-13', 'pastor', 'Inativo', '2015-05-04 16:48:46'),
(3, 'nome', '08580-300', 'Rua Maresias', 1231, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', 'Brasil', '2015-05-31', 'Sede', '111.111.111-11', 'pastor', 'Ativo', '2015-05-04 16:55:49'),
(4, 'nomeeee', '08580-300', 'Rua Maresias', 32, '2', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', 'Brasil', '2015-05-22', 'Sede', '111.111.111-11', 'pastor', 'Ativo', '2015-05-04 16:57:28'),
(5, 'nomeeee', '08580-300', 'Rua Maresias', 32, '2', 'Jardim Maragojipe', 'Itaquaquecetuba', 'SP', 'Brasil', '2015-05-22', 'Sede', '111.111.111-11', 'pastor', 'Ativo', '2015-05-04 16:58:04'),
(6, 'nome da congregação', '08580-300', 'Rua Maresias', 0, '', 'Jardim Maragojipe', 'Itaquaquecetuba', 'AC', 'Brasil', '2015-06-24', 'Congregação', '123.121.313-21', 'pastor', 'Inativo', '2015-05-15 21:44:00'),
(7, 'nome da igreja', '08552-200', 'Rua Limeira', 123, '', 'Vila Perreli', 'Poá', 'SP', 'Brasil', '2015-05-11', 'Congregação', '123.456.789-87', 'Nome do pastor', 'Ativo', '2015-05-11 15:44:23'),
(8, 'testeghjikghjkasdfasfd', '08580-300', 'Rua Maresias', 123, '123', 'Jardim Maragojipe', 'Itaquaquecetuba', 'AC', 'Brasil', '2015-05-11', 'Sede', '123.333.333-33', 'nome do pastor', 'Inativo', '2015-05-11 16:40:05'),
(9, 'teste', '08580-300', 'Rua Maresias', 123, '123', 'Jardim Maragojipe', 'Itaquaquecetuba', 'AC', 'Brasil', '2015-05-11', 'Sede', '123.333.333-33', 'nome do pastor', 'Ativo', '2015-05-11 16:21:40');

--
-- Acionadores `igreja`
--
DROP TRIGGER IF EXISTS `addLixoIgreja`;
DELIMITER //
CREATE TRIGGER `addLixoIgreja` AFTER UPDATE ON `igreja`
 FOR EACH ROW BEGIN
  	IF NEW.status_igreja = 'Excluído' THEN 
		BEGIN
    		INSERT INTO lixeira(tabela, campo_status,campo_id,nome_campo_id, nome, data_exclusao) VALUES('igreja','status_igreja',NEW.id_igreja,'id_igreja',NEW.nome_igreja,NOW());
  		END; 
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `last_user_adm`
--

CREATE TABLE IF NOT EXISTS `last_user_adm` (
  `id_lastUser` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_lastUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `last_user_adm`
--

INSERT INTO `last_user_adm` (`id_lastUser`, `id_usuario`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lixeira`
--

CREATE TABLE IF NOT EXISTS `lixeira` (
  `id_lixeira` int(11) NOT NULL AUTO_INCREMENT,
  `tabela` varchar(255) DEFAULT NULL,
  `campo_status` varchar(255) DEFAULT NULL,
  `campo_id` int(11) NOT NULL,
  `nome_campo_id` varchar(255) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `data_exclusao` datetime NOT NULL,
  PRIMARY KEY (`id_lixeira`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `lixeira`
--

INSERT INTO `lixeira` (`id_lixeira`, `tabela`, `campo_status`, `campo_id`, `nome_campo_id`, `nome`, `data_exclusao`) VALUES
(1, 'classes_ebd', 'status_classe_ebd', 1, 'id_classe_ebd', 'nome da classe', '2015-06-05 11:08:26'),
(3, 'classes_ebd', 'status_classe_ebd', 1, 'id_classe_ebd', 'nome da classe', '2015-06-05 11:32:53'),
(5, 'coordenadores_ebd', 'status_coordenador_ebd', 2, 'id_coordenador_ebd', 'nome', '2015-06-05 14:53:50'),
(8, 'superintendente_ebd', 'status_superintendente_ebd', 2, 'id_superintendente_ebd', 'wellington', '2015-06-05 15:28:52'),
(9, 'departamentos_ebd', 'status_departamento_ebd', 3, 'id_departamento_ebd', 'tste', '2015-06-09 11:31:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `log_operacoes`
--

CREATE TABLE IF NOT EXISTS `log_operacoes` (
  `id_log_operacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `acao_log_operacao` varchar(255) DEFAULT NULL,
  `tabela` varchar(255) DEFAULT NULL,
  `campo` varchar(255) NOT NULL,
  `id_registro` int(11) NOT NULL,
  `old_information` text,
  `new_information` text,
  `data_log_operacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_log_operacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `membros`
--

CREATE TABLE IF NOT EXISTS `membros` (
  `id_membro` int(11) NOT NULL AUTO_INCREMENT,
  `nome_membro` varchar(255) NOT NULL,
  `sobrenome_membro` varchar(255) NOT NULL,
  `data_nascimento_membro` date DEFAULT NULL,
  `sexo_membro` char(1) DEFAULT NULL,
  `filiacao_membro` varchar(255) DEFAULT NULL,
  `naturalidade_membro` varchar(255) DEFAULT NULL,
  `nacionalidade_membro` varchar(255) DEFAULT NULL,
  `rg_membro` varchar(255) DEFAULT NULL,
  `cpf_membro` varchar(255) NOT NULL,
  `id_estado_civil` int(11) DEFAULT NULL,
  `nome_conjuge_membro` varchar(255) DEFAULT NULL,
  `id_conjuge_membro` int(11) DEFAULT NULL,
  `data_casamento_membro` date DEFAULT NULL,
  `profissao_membro` varchar(255) DEFAULT NULL,
  `aptidoes_artisticas_membro` varchar(255) DEFAULT NULL,
  `docencia_membro` varchar(255) DEFAULT NULL,
  `outras_informacoes_membro` text,
  `numero_rol_membro` varchar(255) DEFAULT NULL,
  `data_recebimento_membro` date DEFAULT NULL,
  `data_batismo` date DEFAULT NULL,
  `data_profissao_fe_membro` date DEFAULT NULL,
  `celebrante_batismo` varchar(255) DEFAULT NULL,
  `local_batismo` varchar(255) DEFAULT NULL,
  `id_tipo_recebimento` int(11) DEFAULT NULL,
  `id_tipo_membro` int(11) NOT NULL,
  `oficial_igreja_membro` varchar(255) DEFAULT NULL,
  `id_tipo_oficio_igreja` int(11) DEFAULT NULL,
  `id_status_tipo_oficio_igreja` int(11) DEFAULT NULL,
  `dizimista_membro` varchar(255) DEFAULT NULL,
  `numero_dizimista` varchar(255) DEFAULT NULL,
  `status_membro` varchar(255) DEFAULT NULL,
  `id_igreja` int(11) DEFAULT NULL,
  `foto_membro` varchar(255) NOT NULL,
  `data_cadastro_membro` datetime DEFAULT NULL,
  `data_atualizacao_membro` datetime NOT NULL,
  PRIMARY KEY (`id_membro`),
  KEY `id_estado_civil` (`id_estado_civil`),
  KEY `id_tipo_recebimento` (`id_tipo_recebimento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

--
-- Extraindo dados da tabela `membros`
--

INSERT INTO `membros` (`id_membro`, `nome_membro`, `sobrenome_membro`, `data_nascimento_membro`, `sexo_membro`, `filiacao_membro`, `naturalidade_membro`, `nacionalidade_membro`, `rg_membro`, `cpf_membro`, `id_estado_civil`, `nome_conjuge_membro`, `id_conjuge_membro`, `data_casamento_membro`, `profissao_membro`, `aptidoes_artisticas_membro`, `docencia_membro`, `outras_informacoes_membro`, `numero_rol_membro`, `data_recebimento_membro`, `data_batismo`, `data_profissao_fe_membro`, `celebrante_batismo`, `local_batismo`, `id_tipo_recebimento`, `id_tipo_membro`, `oficial_igreja_membro`, `id_tipo_oficio_igreja`, `id_status_tipo_oficio_igreja`, `dizimista_membro`, `numero_dizimista`, `status_membro`, `id_igreja`, `foto_membro`, `data_cadastro_membro`, `data_atualizacao_membro`) VALUES
(1, 'wellington', 'cezar', '2015-04-04', 'M', '', '', '', '', '', 7, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'wellington(20060105062015).jpg', '2015-06-05 20:06:01', '0000-00-00 00:00:00'),
(47, 'wellington', 'cezar', '2015-04-27', 'M', 'filiação', 'naturalidade', 'nacionalidade', '', '', 7, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 4, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'wellington(20065205062015).png', '2015-06-05 20:07:05', '0000-00-00 00:00:00'),
(51, 'nome', 'sobrenome', '2015-04-22', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 4, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'nome(19524505062015).png', '2015-06-05 19:52:48', '0000-00-00 00:00:00'),
(84, 'wellington', 'cezar', '2015-04-30', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 4, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'wellington(20073905062015).png', '2015-06-05 20:07:52', '0000-00-00 00:00:00'),
(85, 'wellington', 'cezar', '2015-04-30', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 'Ativo', NULL, '', '2015-04-30 17:59:34', '0000-00-00 00:00:00'),
(86, 'sdgffg', 'dsfgsdfg', '2015-04-29', 'F', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'sdgffg(20035005062015).jpg', '2015-06-05 20:03:51', '0000-00-00 00:00:00'),
(87, 'asdfdsa', 'asdf', '2015-04-24', 'M', '', '', '', '', '', 9, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'asdfdsa(19593305062015).png', '2015-06-05 19:59:41', '0000-00-00 00:00:00'),
(89, 'nome', 'sobrenome', '2015-04-30', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'nome(20110105062015).jpg', '2015-06-05 20:11:03', '0000-00-00 00:00:00'),
(92, 'fffff', 'fff', '2015-04-30', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'fffff(20015405062015).png', '2015-06-05 20:02:04', '0000-00-00 00:00:00'),
(93, 'gfgsfdg', 'fdg', '2015-04-15', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'gfgsfdg(20023905062015).png', '2015-06-05 20:02:51', '0000-00-00 00:00:00'),
(94, 'okok', 'okok', '2015-04-01', 'M', '', '', '', '', '', 9, '', 0, '0000-00-00', 'profissão', 'aptidoes', 'Sim', 'testeeee', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'asdfdsafasdsdfasdf(20001905062015).png', '2015-06-05 20:14:06', '0000-00-00 00:00:00'),
(95, 'wellington', 'cezar', '2015-05-11', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', '', '', 'numero rol', '2015-05-13', '2015-05-20', '2015-05-14', 'celebrante', 'local batismo', 4, 1, NULL, NULL, NULL, NULL, NULL, 'Ativo', 5, '', '2015-05-11 20:54:43', '0000-00-00 00:00:00'),
(97, 'teste', 'teste', '2015-05-11', 'M', '', '', '', '', '', 13, '', 0, '0000-00-00', '', '', 'Não', 'teste', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 5, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 1, 'teste(20043605062015).jpg', '2015-06-05 20:04:37', '0000-00-00 00:00:00'),
(98, 'wellington', 'rwrewrwr', '2015-05-20', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 4, 0, 'Não', 13, 8, 'Não', '', 'Ativo', 1, 'wellington(16422829052015).png', '2015-05-29 16:42:33', '0000-00-00 00:00:00'),
(99, 'wellington', 'rwrewrwr', '2015-05-20', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', 'informações mais', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 5, 0, 'on', 13, 8, 'Sim', '123456789748978798787', 'Ativo', 1, '', '2015-05-12 17:23:51', '0000-00-00 00:00:00'),
(100, 'aaa', 'aaa', '2015-05-12', 'M', '', '', '', '21.321.321-3', '123.132.121-31', 1, '', 47, '0000-00-00', '', '', 'Não', 'mais', '', '2015-05-20', '2015-05-20', '2015-05-20', '', '', 4, 0, 'Não', 15, 0, 'Sim', '', 'Ativo', 0, 'aaa(19574105062015).jpg', '2015-07-01 15:48:43', '0000-00-00 00:00:00'),
(101, 'nome', 'sobrenome', '2015-05-12', 'M', 'filiação', 'naturalidade', 'nacionalidade', '11.111.111-1', '222.222.222-22', 1, '', 0, '0000-00-00', 'profissao de teste', '', 'Não', 'informações', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 7, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 1, 'nome(19500305062015).png', '2015-06-05 19:50:12', '0000-00-00 00:00:00'),
(102, 'nome', 'sobrenome', '2015-05-12', 'M', 'filiação', 'naturalidade', 'nacionalidade', '11.111.111-1', '222.222.222-22', 1, '', 1, '2015-05-12', 'profissão', 'aptidões artisticas', 'Sim', 'mais informações de teste', 'numero rol', '2015-05-12', '2015-05-17', '2015-05-14', 'celebrante batismo', 'local batismo', 4, 1, 'Sim', 13, 7, 'Sim', '', 'Ativo', 5, 'nome(19511505062015).png', '2015-06-05 19:51:21', '0000-00-00 00:00:00'),
(103, 'asdf', 'asdf', '2015-05-12', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 7, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 1, 'asdf(19585305062015).gif', '2015-06-05 19:58:54', '0000-00-00 00:00:00'),
(104, 'Marcelo', 'Marcondes', '1973-12-10', 'M', 'Dalva Carvalho dos Santos', 'São Paulo', 'brasileira', '22.965.238-4', '249.173.948-80', 7, 'Luciana Marcondes', 0, '0000-00-00', 'Empresario', 'Musica', 'Sim', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, '', 0, 0, 'Não', '', 'Ativo', 0, '', '2015-05-22 19:51:44', '0000-00-00 00:00:00'),
(105, 'Amanda', 'Souza', '2015-05-27', 'F', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'amanda(20120605062015).jpg', '2015-06-05 20:12:07', '0000-00-00 00:00:00'),
(106, 'wellington', 'cezar', '2015-05-27', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, '', 0, 0, 'Não', '', 'Ativo', 0, 'wellington(19580127052015).png', '2015-05-27 19:58:03', '0000-00-00 00:00:00'),
(107, 'wellington cezar', 'rerere', '2015-05-27', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, '', 0, 0, 'Não', '', 'Ativo', 0, 'wellington-cezar(19594527052015).png', '2015-05-27 19:59:50', '0000-00-00 00:00:00'),
(108, 'wellington cezar', 'rerere', '2015-05-27', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, '', 0, 0, 'Não', '', 'Ativo', 0, 'wellington-cezar(19595127052015).png', '2015-05-27 19:59:56', '0000-00-00 00:00:00'),
(109, 'fdsggsdfg', 'dsfgfdg', '2015-05-29', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'fdsggsdfg(19471105062015).gif', '2015-06-05 19:47:11', '0000-00-00 00:00:00'),
(110, 'fdsggsdfg', 'dsfgfdg', '2015-05-29', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'fdsggsdfg(20005905062015).png', '2015-06-05 20:01:10', '0000-00-00 00:00:00'),
(111, 'banana', 'minions', '2015-05-27', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 0, 'aaaaaaaaaabbbbbb(19582205062015).jpg', '2015-06-05 20:13:39', '0000-00-00 00:00:00'),
(112, 'wellington', 'cezar targino de sá', '1991-02-04', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '1', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, 'Não', 0, 0, 'Não', '', 'Ativo', 1, 'wellington(16430829052015).png', '2015-05-29 16:43:13', '0000-00-00 00:00:00'),
(113, 'wellington cezar', 'cezarr', '2015-06-17', 'M', '', '', '', '', '', 1, '', 0, '0000-00-00', '', '', 'Não', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', 0, 0, '', 0, 0, 'Não', '', 'Ativo', 0, 'wellington-cezar(19392903062015)', '2015-06-03 19:39:29', '0000-00-00 00:00:00');

--
-- Acionadores `membros`
--
DROP TRIGGER IF EXISTS `addLixoMembros`;
DELIMITER //
CREATE TRIGGER `addLixoMembros` AFTER UPDATE ON `membros`
 FOR EACH ROW BEGIN
IF NEW.status_membro = 'Excluído' THEN 
		BEGIN
    		INSERT INTO lixeira(tabela, campo_status,campo_id,nome_campo_id, nome,data_exclusao) VALUES('membros','status_membro',NEW.id_membro,'id_membro',NEW.nome_membro,NOW());
  		END; 
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulos`
--

CREATE TABLE IF NOT EXISTS `modulos` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `url_modulo` varchar(255) DEFAULT NULL,
  `nome_modulo` varchar(255) DEFAULT NULL,
  `posicao_modulo` int(11) DEFAULT NULL,
  `status_modulo` varchar(255) DEFAULT NULL,
  `status_selecao` varchar(255) NOT NULL,
  `id_modulo_pai` int(11) DEFAULT NULL,
  `foto_modulo` varchar(255) NOT NULL,
  `data_criacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Extraindo dados da tabela `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao`, `id_modulo_pai`, `foto_modulo`, `data_criacao`) VALUES
(0, '', '', NULL, 'Inativo', 'Inativo', 0, 'home.png', '2015-03-18 13:58:42'),
(6, 'configuracoes', 'Configurações', 3, 'Ativo', 'Ativo', 0, 'configuracoes.png', '2015-03-16 15:27:00'),
(7, 'tabelas', 'Tabelas', NULL, 'Ativo', 'Ativo', 6, '', '2015-03-16 15:27:00'),
(8, 'rol-de-membros', 'Rol de Membros', 1, 'Ativo', 'Ativo', 0, 'rol-de-membros-icone.png', '2015-03-18 13:57:40'),
(9, 'usuarios', 'Usuários', NULL, 'Ativo', 'Ativo', 6, '', '2015-03-24 19:52:10'),
(10, 'modulos', 'Módulos', NULL, 'Ativo', 'Ativo', 6, '', '2015-03-26 19:33:04'),
(11, 'igreja', 'Igrejas', 0, 'Ativo', 'Ativo', 0, 'patrimonio-icone.png', '2015-05-04 14:05:47'),
(13, 'relatorios', 'Relatórios', NULL, 'Ativo', 'Ativo', 8, '', '2015-05-15 19:48:05'),
(14, 'lixeira', 'Lixeira', 4, 'Ativo', 'Ativo', 0, 'lixeira.png', '2015-05-21 13:19:34'),
(15, 'ebd', 'EBD', 2, 'Ativo', 'Ativo', 0, 'ebd.png', '2015-06-05 19:41:09'),
(18, 'classes', 'Classes', NULL, 'Ativo', 'Ativo', 15, '', '2015-06-05 20:30:55');

-- --------------------------------------------------------

--
-- Estrutura da tabela `paginas`
--

CREATE TABLE IF NOT EXISTS `paginas` (
  `id_pagina` int(11) NOT NULL AUTO_INCREMENT,
  `url_pagina` varchar(255) DEFAULT NULL,
  `nome_pagina` varchar(255) DEFAULT NULL,
  `posicao_pagina` int(255) DEFAULT NULL,
  `status_pagina` varchar(255) DEFAULT NULL,
  `status_selecao` varchar(255) NOT NULL,
  `id_modulo` int(11) DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pagina`),
  KEY `id_modulo` (`id_modulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Extraindo dados da tabela `paginas`
--

INSERT INTO `paginas` (`id_pagina`, `url_pagina`, `nome_pagina`, `posicao_pagina`, `status_pagina`, `status_selecao`, `id_modulo`, `data_criacao`) VALUES
(21, 'home', 'Membros', NULL, 'Ativo', 'Ativo', 8, '2015-03-18 18:36:50'),
(22, 'home', 'Home', NULL, 'Ativo', 'Inativo', 0, '2015-03-18 18:37:09'),
(23, 'estado_civil', 'Estado Civil', NULL, 'Ativo', 'Ativo', 7, '2015-03-18 19:30:05'),
(24, 'login', 'Login', NULL, '', 'Inativo', 0, '2015-03-19 12:33:53'),
(25, 'tipo_recebimento', 'Tipo de Recebimento', NULL, 'Ativo', 'Ativo', 7, '2015-03-20 20:45:26'),
(26, 'home', 'Home', NULL, 'Ativo', 'Inativo', 7, '2015-03-24 18:39:27'),
(27, 'tipo_membro', 'Tipo de membro', NULL, 'Ativo', 'Ativo', 7, '2015-03-24 18:48:53'),
(30, 'grupo_usuarios', 'Grupo de usuários', NULL, 'Ativo', 'Ativo', 9, '2015-03-25 20:21:27'),
(31, 'home', 'Usuários', NULL, 'Ativo', 'Ativo', 9, '2015-03-26 13:43:34'),
(33, 'home', 'Módulos do sistema', NULL, 'Ativo', 'Ativo', 10, '2015-03-26 19:33:04'),
(34, 'usuarios', 'Home lista usuários', NULL, 'Ativo', 'Inativo', 9, '2015-03-27 19:40:57'),
(36, 'membros', 'Membros', NULL, 'Ativo', 'Ativo', 0, '2015-04-16 13:41:09'),
(38, 'tipo_telefone', 'Tipo de telefone', NULL, 'Ativo', 'Ativo', 7, '2015-04-16 21:16:14'),
(39, 'home', 'Home', NULL, 'Ativo', 'Ativo', 6, '2015-04-22 17:52:21'),
(40, 'tipo_email', 'Tipo de e-mail', NULL, 'Ativo', 'Ativo', 7, '2015-04-29 19:53:43'),
(42, 'home', 'Home', NULL, 'Ativo', 'Inativo', 11, '2015-05-04 14:05:47'),
(43, 'acesso_negado', NULL, NULL, 'Inativo', '', 0, '2015-05-05 16:04:05'),
(44, 'tipo_oficio_igreja', 'Tipo de ofício da igreja', NULL, 'Ativo', 'Ativo', 7, '2015-05-11 21:07:35'),
(47, 'relatorio_especifico', 'Relatórios específicos', NULL, 'Ativo', 'Ativo', 13, '2015-05-15 19:48:05'),
(55, 'home', 'Home', NULL, 'Inativo', 'Ativo', 14, '2015-06-02 15:05:53'),
(62, 'home', 'Home', NULL, 'Ativo', 'Ativo', 15, '2015-06-05 19:41:09'),
(63, 'departamentos', 'Departamentos', NULL, 'Ativo', 'Ativo', 15, '2015-06-05 19:43:17'),
(64, 'coordenadores', 'Coordenadores', NULL, 'Ativo', 'Ativo', 15, '2015-06-05 19:45:06'),
(65, 'secretaria', 'Secretaria', NULL, 'Ativo', 'Ativo', 15, '2015-06-05 20:24:48'),
(66, 'superintendentes', 'Superintendentes', NULL, 'Ativo', 'Ativo', 15, '2015-06-05 20:27:57'),
(67, 'home', 'Home', NULL, 'Ativo', 'Ativo', 18, '2015-06-05 20:30:55'),
(68, 'alunos', 'Alunos', NULL, 'Ativo', 'Ativo', 18, '2015-06-05 20:35:15'),
(69, 'professores', 'Professores', NULL, 'Ativo', 'Ativo', 18, '2015-06-08 21:25:07');

-- --------------------------------------------------------

--
-- Estrutura da tabela `professores_ebd`
--

CREATE TABLE IF NOT EXISTS `professores_ebd` (
  `id_professor` int(11) NOT NULL AUTO_INCREMENT,
  `id_membro` int(11) DEFAULT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `status_professor` varchar(255) NOT NULL,
  `data_cadastro_professor` datetime DEFAULT NULL,
  PRIMARY KEY (`id_professor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `professores_ebd`
--

INSERT INTO `professores_ebd` (`id_professor`, `id_membro`, `id_classe`, `status_professor`, `data_cadastro_professor`) VALUES
(1, 100, 1, 'Ativo', '2015-07-01 16:50:55');

-- --------------------------------------------------------

--
-- Estrutura da tabela `redes_sociais`
--

CREATE TABLE IF NOT EXISTS `redes_sociais` (
  `id_rede_social` int(11) NOT NULL AUTO_INCREMENT,
  `id_membro` int(11) DEFAULT NULL,
  `nome_rede_social` varchar(255) DEFAULT NULL,
  `link_rede_social` varchar(255) DEFAULT NULL,
  `data_cadastro_rede_social` datetime DEFAULT NULL,
  PRIMARY KEY (`id_rede_social`),
  KEY `id_membro` (`id_membro`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `redes_sociais`
--

INSERT INTO `redes_sociais` (`id_rede_social`, `id_membro`, `nome_rede_social`, `link_rede_social`, `data_cadastro_rede_social`) VALUES
(1, 102, 'Facebook', 'link do face', '2015-06-05 19:51:21'),
(2, 100, 'Pinterest', 'rede social teste', '2015-07-01 15:48:43');

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorio_especifico`
--

CREATE TABLE IF NOT EXISTS `relatorio_especifico` (
  `id_relatorio_especifico` int(11) NOT NULL AUTO_INCREMENT,
  `nome_relatorio` varchar(255) DEFAULT NULL,
  `content_relatorio` longtext NOT NULL,
  `autor_relatorio` varchar(255) NOT NULL,
  `status_relatorio` varchar(255) NOT NULL,
  `data_cadastro_relatorio` datetime DEFAULT NULL,
  PRIMARY KEY (`id_relatorio_especifico`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `relatorio_especifico`
--

INSERT INTO `relatorio_especifico` (`id_relatorio_especifico`, `nome_relatorio`, `content_relatorio`, `autor_relatorio`, `status_relatorio`, `data_cadastro_relatorio`) VALUES
(1, 'nome do relatorio', '{"thead":["Nome","Sobrenome","Data de Nascimento","Sexo"],"tbody":[["wellington","cezar","04\\/04\\/2015","M"],["wellington","cezar","27\\/04\\/2015","M"],["nome","sobrenome","22\\/04\\/2015","M"],["wellington","cezar","30\\/04\\/2015","M"],["wellington","cezar","30\\/04\\/2015","M"],["sdgffg","dsfgsdfg","29\\/04\\/2015","F"],["asdfdsa","asdf","24\\/04\\/2015","M"],["nome","sobrenome","30\\/04\\/2015","M"],["fffff","fff","30\\/04\\/2015","M"],["gfgsfdg","fdg","15\\/04\\/2015","M"],["asdfdsafasdsdfasdf","adsfsd","01\\/04\\/2015","M"],["wellington","cezar","11\\/05\\/2015","M"],["teste","teste","11\\/05\\/2015","M"],["wellington","rwrewrwr","20\\/05\\/2015","M"],["wellington","rwrewrwr","20\\/05\\/2015","M"],["aaa","aaa","12\\/05\\/2015","M"],["nome","sobrenome","12\\/05\\/2015","M"],["nome","sobrenome","12\\/05\\/2015","M"],["asdf","asdf","12\\/05\\/2015","M"]]}', 'Administrador', '', '2015-05-15 21:10:41'),
(2, 'teste', '{"thead":["Nome","Sobrenome","Data de Nascimento","Sexo","RG","CPF","Estado Civil","Data de Casamento","Endere\\u00e7o","Telefones","E-mails","Profiss\\u00e3o","Igreja","N\\u00ba Rol","Data de recebimento como membro","Data do batismo","Data da profiss\\u00e3o de f\\u00e9","Celebrante do batismo","Local do batismo","Tipo de recebimento","Tipo de membro","Oficial da Igreja","Dizimista","Data de cadastro","Status"],"tbody":[["wellington","cezar","04\\/04\\/2015","M",null,"","Casado(a)",null,false,false,false,null,null,null,null,null,null,null,null,null," - ",""," ","Ativo",null],["wellington","cezar","27\\/04\\/2015","M","","","Casado(a)","00\\/00\\/0000","Rua Maresias, 196 . Jardim Maragojipe - Itaquaquecetuba-SP. CEP: 08580-300",false,false,null,null,null,null,null,null,null,null,"Rol Separado"," - ","","27\\/04\\/2015 19:41","Ativo",null],["nome","sobrenome","22\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,"Rol Separado"," - ","","28\\/04\\/2015 17:09","Ativo",null],["wellington","cezar","30\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,"<p>Pessoal: 12345678 Op:Tim<\\/p><p>Residencial: 987654321 Op:Claro<\\/p>","<p>Residencial: wellington-cezar@hotmail.com<\\/p><p>Profissional: wellington.infodahora@gmail.com<\\/p>",null,null,null,null,null,null,null,null,"Rol Separado"," - ","","30\\/04\\/2015 17:58","Ativo",null],["wellington","cezar","30\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,"<p>Pessoal: 12345678 Op:Tim<\\/p><p>Residencial: 987654321 Op:Claro<\\/p>","<p>Profissional: wellington.infodahora@gmail.com<\\/p>",null,null,null,null,null,null,null,null,"Rol Separado"," - ","","30\\/04\\/2015 17:59","Ativo",null],["sdgffg","dsfgsdfg","29\\/04\\/2015","F","","","Solteiro(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 18:00","Ativo",null],["asdfdsa","asdf","24\\/04\\/2015","M","","","Divorciado(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 18:02","Ativo",null],["nome","sobrenome","30\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,"<p>Residencial: 12345 Op:op<\\/p>","<p>Residencial: wellington-cezar@hotmail.com<\\/p>",null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 19:43","Ativo",null],["fffff","fff","30\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 19:48","Inativo",null],["gfgsfdg","fdg","15\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 19:49","Ativo",null],["asdfdsafasdsdfasdf","adsfsd","01\\/04\\/2015","M","","","Divorciado(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 20:17","Ativo","profiss\\u00e3o"],["wellington","cezar","11\\/05\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,"nomeeee","numero rol","13\\/05\\/2015","20\\/05\\/2015","14\\/05\\/2015","celebrante","local batismo","Profiss\\u00e3o de F\\u00e9","Comungante"," - ","","11\\/05\\/2015 20:54","Ativo",""],["teste","teste","11\\/05\\/2015","M","","","N\\u00e3o Informado","00\\/00\\/0000",false,false,false,"IPBS","","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Profiss\\u00e3o de F\\u00e9 e Batismo",null," - ","","11\\/05\\/2015 21:16","",""],["wellington","rwrewrwr","20\\/05\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,"IPBS","","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Profiss\\u00e3o de F\\u00e9",null,"Di\\u00e1conos - Inativo","","12\\/05\\/2015 17:23","Ativo",""],["wellington","rwrewrwr","20\\/05\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,"IPBS","","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Profiss\\u00e3o de F\\u00e9 e Batismo",null,"Di\\u00e1conos - Inativo","Sim - N\\u00ba 123456789748978798787","12\\/05\\/2015 17:23","Ativo",""],["aaa","aaa","12\\/05\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,null,"","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Profiss\\u00e3o de F\\u00e9",null,"Pastor - ","Sim - N\\u00ba asdf3333","12\\/05\\/2015 17:25","Ativo",""],["nome","sobrenome","12\\/05\\/2015","M","11.111.111-1","222.222.222-22","Solteiro(a)","00\\/00\\/0000",false,false,false,"nome da congrega\\u00e7\\u00e3o","","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Jurisdi\\u00e7\\u00e3o a pedido",null," - ","N\\u00e3o","12\\/05\\/2015 17:30","Ativo","profissao de teste"],["nome","sobrenome","12\\/05\\/2015","M","11.111.111-1","222.222.222-22","Solteiro(a)","12\\/05\\/2015","Rua Maresias, 123 complemento. Jardim Maragojipe - Itaquaquecetuba-SP. CEP: 08580-300","<p>Pessoal: 12345678 Op:operadora<\\/p><p>Residencial: 123454645 Op:ope2<\\/p>","<p>Pessoal: wellington-cezar@hotmail.com<\\/p>","nomeeee","numero rol","12\\/05\\/2015","17\\/05\\/2015","14\\/05\\/2015","celebrante batismo","local batismo","Profiss\\u00e3o de F\\u00e9","Comungante","Di\\u00e1conos - Ativos","Sim - N\\u00ba n\\u00ba dizimista","12\\/05\\/2015 17:38","Ativo","profiss\\u00e3o"],["asdf","asdf","12\\/05\\/2015","M","","",null,"00\\/00\\/0000",false,false,false,"nome da congrega\\u00e7\\u00e3o","","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Jurisdi\\u00e7\\u00e3o a pedido",null," - ","N\\u00e3o","12\\/05\\/2015 17:38","Ativo",""]]}', '', 'Inativo', '2015-05-15 21:11:35'),
(3, 'dsfasdf', '{"thead":["Nome","Sobrenome","Data de Nascimento","Sexo","RG","CPF","Estado Civil"],"tbody":[["wellington","cezar","04\\/04\\/2015","M",null,"","Casado(a)"],["wellington","cezar","27\\/04\\/2015","M","","","Casado(a)"],["nome","sobrenome","22\\/04\\/2015","M","","","Solteiro(a)"],["wellington","cezar","30\\/04\\/2015","M","","","Solteiro(a)"],["wellington","cezar","30\\/04\\/2015","M","","","Solteiro(a)"],["sdgffg","dsfgsdfg","29\\/04\\/2015","F","","","Solteiro(a)"],["asdfdsa","asdf","24\\/04\\/2015","M","","","Divorciado(a)"],["nome","sobrenome","30\\/04\\/2015","M","","","Solteiro(a)"],["fffff","fff","30\\/04\\/2015","M","","","Solteiro(a)"],["gfgsfdg","fdg","15\\/04\\/2015","M","","","Solteiro(a)"],["asdfdsafasdsdfasdf","adsfsd","01\\/04\\/2015","M","","","Divorciado(a)"],["wellington","cezar","11\\/05\\/2015","M","","","Solteiro(a)"],["teste","teste","11\\/05\\/2015","M","","","N\\u00e3o Informado"],["wellington","rwrewrwr","20\\/05\\/2015","M","","","Solteiro(a)"],["wellington","rwrewrwr","20\\/05\\/2015","M","","","Solteiro(a)"],["aaa","aaa","12\\/05\\/2015","M","","","Solteiro(a)"],["nome","sobrenome","12\\/05\\/2015","M","11.111.111-1","222.222.222-22","Solteiro(a)"],["nome","sobrenome","12\\/05\\/2015","M","11.111.111-1","222.222.222-22","Solteiro(a)"],["asdf","asdf","12\\/05\\/2015","M","","",null]]}', 'Wellington', 'Excluído', '2015-05-15 21:18:17'),
(4, 'Relatório de membros do sexo masculino', '{"thead":["Nome","Sobrenome","Data de Nascimento","Sexo"],"tbody":[["wellington","cezar","04\\/04\\/2015","M"],["wellington","cezar","27\\/04\\/2015","M"],["nome","sobrenome","22\\/04\\/2015","M"],["wellington","cezar","30\\/04\\/2015","M"],["wellington","cezar","30\\/04\\/2015","M"],["asdfdsa","asdf","24\\/04\\/2015","M"],["nome","sobrenome","30\\/04\\/2015","M"],["fffff","fff","30\\/04\\/2015","M"],["gfgsfdg","fdg","15\\/04\\/2015","M"],["asdfdsafasdsdfasdf","adsfsd","01\\/04\\/2015","M"],["wellington","cezar","11\\/05\\/2015","M"],["teste","teste","11\\/05\\/2015","M"],["wellington","rwrewrwr","20\\/05\\/2015","M"],["wellington","rwrewrwr","20\\/05\\/2015","M"],["aaa","aaa","12\\/05\\/2015","M"],["nome","sobrenome","12\\/05\\/2015","M"],["nome","sobrenome","12\\/05\\/2015","M"],["asdf","ásãfç","12\\/05\\/2015","M"]]}', 'Wellington cezar', '', '2015-05-04 21:24:45'),
(5, NULL, '', '', 'Excluído', NULL),
(6, 'tudo', '{"thead":["Nome","Sobrenome","Data de Nascimento","Sexo","RG","CPF","Estado Civil","Data de Casamento","Endere\\u00e7o","Telefones","E-mails","Profiss\\u00e3o","Igreja","N\\u00ba Rol","Data de recebimento como membro","Data do batismo","Data da profiss\\u00e3o de f\\u00e9","Celebrante do batismo","Local do batismo","Tipo de recebimento","Tipo de membro","Oficial da Igreja","Dizimista","Data de cadastro","Status"],"tbody":[["wellington","cezar","04\\/04\\/2015","M",null,"","Casado(a)",null,false,false,false,null,null,null,null,null,null,null,null,null," - ",""," ","Ativo",null],["wellington","cezar","27\\/04\\/2015","M","","","Casado(a)","00\\/00\\/0000","Rua Maresias, 196 . Jardim Maragojipe - Itaquaquecetuba-SP. CEP: 08580-300",false,false,null,null,null,null,null,null,null,null,"Rol Separado"," - ","","27\\/04\\/2015 19:41","Ativo",null],["nome","sobrenome","22\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,"Rol Separado"," - ","","28\\/04\\/2015 17:09","Ativo",null],["wellington","cezar","30\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,"<p>Pessoal: 12345678 Op:Tim<\\/p><p>Residencial: 987654321 Op:Claro<\\/p>","<p>Residencial: wellington-cezar@hotmail.com<\\/p><p>Profissional: wellington.infodahora@gmail.com<\\/p>",null,null,null,null,null,null,null,null,"Rol Separado"," - ","","30\\/04\\/2015 17:58","Ativo",null],["wellington","cezar","30\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,"<p>Pessoal: 12345678 Op:Tim<\\/p><p>Residencial: 987654321 Op:Claro<\\/p>","<p>Profissional: wellington.infodahora@gmail.com<\\/p>",null,null,null,null,null,null,null,null,"Rol Separado"," - ","","30\\/04\\/2015 17:59","Ativo",null],["sdgffg","dsfgsdfg","29\\/04\\/2015","F","","","Solteiro(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 18:00","Ativo",null],["asdfdsa","asdf","24\\/04\\/2015","M","","","Divorciado(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 18:02","Ativo",null],["nome","sobrenome","30\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,"<p>Residencial: 12345 Op:op<\\/p>","<p>Residencial: wellington-cezar@hotmail.com<\\/p>",null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 19:43","Ativo",null],["fffff","fff","30\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 19:48","Inativo",null],["gfgsfdg","fdg","15\\/04\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 19:49","Ativo",null],["asdfdsafasdsdfasdf","adsfsd","01\\/04\\/2015","M","","","Divorciado(a)","00\\/00\\/0000",false,false,false,null,null,null,null,null,null,null,null,null," - ","","30\\/04\\/2015 20:17","Ativo","profiss\\u00e3o"],["wellington","cezar","11\\/05\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,"nomeeee","numero rol","13\\/05\\/2015","20\\/05\\/2015","14\\/05\\/2015","celebrante","local batismo","Profiss\\u00e3o de F\\u00e9","Comungante"," - ","","11\\/05\\/2015 20:54","Ativo",""],["teste","teste","11\\/05\\/2015","M","","","N\\u00e3o Informado","00\\/00\\/0000",false,false,false,"IPBS","","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Profiss\\u00e3o de F\\u00e9 e Batismo",null," - ","","11\\/05\\/2015 21:16","",""],["wellington","rwrewrwr","20\\/05\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,"IPBS","","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Profiss\\u00e3o de F\\u00e9",null,"Di\\u00e1conos - Inativo","","12\\/05\\/2015 17:23","Ativo",""],["wellington","rwrewrwr","20\\/05\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,"IPBS","","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Profiss\\u00e3o de F\\u00e9 e Batismo",null,"Di\\u00e1conos - Inativo","Sim - N\\u00ba 123456789748978798787","12\\/05\\/2015 17:23","Ativo",""],["aaa","aaa","12\\/05\\/2015","M","","","Solteiro(a)","00\\/00\\/0000",false,false,false,null,"","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Profiss\\u00e3o de F\\u00e9",null,"Pastor - ","Sim - N\\u00ba asdf3333","12\\/05\\/2015 17:25","Ativo",""],["nome","sobrenome","12\\/05\\/2015","M","11.111.111-1","222.222.222-22","Solteiro(a)","00\\/00\\/0000",false,false,false,"nome da congrega\\u00e7\\u00e3o","","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Jurisdi\\u00e7\\u00e3o a pedido",null," - ","N\\u00e3o","12\\/05\\/2015 17:30","Ativo","profissao de teste"],["nome","sobrenome","12\\/05\\/2015","M","11.111.111-1","222.222.222-22","Solteiro(a)","12\\/05\\/2015","Rua Maresias, 123 complemento. Jardim Maragojipe - Itaquaquecetuba-SP. CEP: 08580-300","<p>Pessoal: 12345678 Op:operadora<\\/p><p>Residencial: 123454645 Op:ope2<\\/p>","<p>Pessoal: wellington-cezar@hotmail.com<\\/p>","nomeeee","numero rol","12\\/05\\/2015","17\\/05\\/2015","14\\/05\\/2015","celebrante batismo","local batismo","Profiss\\u00e3o de F\\u00e9","Comungante","Di\\u00e1conos - Ativos","Sim - N\\u00ba n\\u00ba dizimista","12\\/05\\/2015 17:38","Ativo","profiss\\u00e3o"],["asdf","asdf","12\\/05\\/2015","M","","",null,"00\\/00\\/0000",false,false,false,"nome da congrega\\u00e7\\u00e3o","","00\\/00\\/0000","00\\/00\\/0000","00\\/00\\/0000","","","Jurisdi\\u00e7\\u00e3o a pedido",null," - ","N\\u00e3o","12\\/05\\/2015 17:38","Ativo",""]]}', 'Administrador geral', '', '2015-05-18 20:11:19');

--
-- Acionadores `relatorio_especifico`
--
DROP TRIGGER IF EXISTS `addLixoRelatorioEspecifico`;
DELIMITER //
CREATE TRIGGER `addLixoRelatorioEspecifico` AFTER UPDATE ON `relatorio_especifico`
 FOR EACH ROW BEGIN
  	IF NEW.status_relatorio = 'Excluído' THEN 
		BEGIN
    		INSERT INTO lixeira(tabela, campo_status,campo_id,nome_campo_id,nome,data_exclusao) VALUES('relatorio_especifico','status_relatorio',NEW.id_relatorio_especifico,'id_relatorio_especifico',NEW.nome_relatorio,NOW());
  		END; 
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `secretaria_ebd`
--

CREATE TABLE IF NOT EXISTS `secretaria_ebd` (
  `id_secretaria_ebd` int(11) NOT NULL AUTO_INCREMENT,
  `id_membro` int(11) DEFAULT NULL,
  `data_inicio_secretaria_ebd` date DEFAULT NULL,
  `data_fim_secretaria_ebd` date DEFAULT NULL,
  `status_secretaria_ebd` varchar(255) NOT NULL,
  `data_cadastro_secretaria` datetime DEFAULT NULL,
  PRIMARY KEY (`id_secretaria_ebd`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `secretaria_ebd`
--

INSERT INTO `secretaria_ebd` (`id_secretaria_ebd`, `id_membro`, `data_inicio_secretaria_ebd`, `data_fim_secretaria_ebd`, `status_secretaria_ebd`, `data_cadastro_secretaria`) VALUES
(1, 86, '2015-06-24', '2015-06-30', 'Ativo', '2015-06-02 16:59:17');

--
-- Acionadores `secretaria_ebd`
--
DROP TRIGGER IF EXISTS `addLixoSecretaria`;
DELIMITER //
CREATE TRIGGER `addLixoSecretaria` AFTER UPDATE ON `secretaria_ebd`
 FOR EACH ROW BEGIN
	declare nome_member varchar(255);
	
  	IF NEW.status_secretaria_ebd = 'Excluído' THEN 
		BEGIN
			
			SET @nome_member = (select nome_membro from membros where id_membro = NEW.id_membro);
	
    		INSERT INTO lixeira(tabela, campo_status,campo_id,nome_campo_id, nome,data_exclusao) VALUES('secretaria_ebd','status_secretaria_ebd',NEW.id_secretaria_ebd,'id_secretaria_ebd',@nome_member,NOW());
  		END; 
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_tipo_oficio_igreja`
--

CREATE TABLE IF NOT EXISTS `status_tipo_oficio_igreja` (
  `id_status_tipo_oficio_igreja` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_oficio_igreja` int(11) DEFAULT NULL,
  `nome_status_tipo_oficio_igreja` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_status_tipo_oficio_igreja`),
  KEY `id_tipo_oficio_igreja` (`id_tipo_oficio_igreja`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Extraindo dados da tabela `status_tipo_oficio_igreja`
--

INSERT INTO `status_tipo_oficio_igreja` (`id_status_tipo_oficio_igreja`, `id_tipo_oficio_igreja`, `nome_status_tipo_oficio_igreja`) VALUES
(7, 13, 'Ativos'),
(8, 13, 'Inativo'),
(39, 13, 'Disponível'),
(40, 13, 'Indisponível'),
(41, 14, 'Ativo'),
(42, 14, 'Inativo'),
(43, 14, 'Disponível'),
(44, 14, 'Indisponível');

-- --------------------------------------------------------

--
-- Estrutura da tabela `superintendente_ebd`
--

CREATE TABLE IF NOT EXISTS `superintendente_ebd` (
  `id_superintendente_ebd` int(11) NOT NULL AUTO_INCREMENT,
  `id_membro` int(11) DEFAULT NULL,
  `data_inicio_superintendente_ebd` date DEFAULT NULL,
  `data_fim_superintendente_ebd` date DEFAULT NULL,
  `status_superintendente_ebd` varchar(255) NOT NULL,
  `data_cadastro_superintendente` datetime DEFAULT NULL,
  PRIMARY KEY (`id_superintendente_ebd`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `superintendente_ebd`
--

INSERT INTO `superintendente_ebd` (`id_superintendente_ebd`, `id_membro`, `data_inicio_superintendente_ebd`, `data_fim_superintendente_ebd`, `status_superintendente_ebd`, `data_cadastro_superintendente`) VALUES
(1, 47, '0000-00-00', '0000-00-00', 'Ativo', '2015-06-02 00:00:00'),
(2, 85, '2015-06-02', '2016-06-25', 'Excluído', '2015-06-02 00:00:00'),
(3, 47, '2015-06-03', '2015-06-25', 'Ativo', '2015-06-02 16:58:51');

--
-- Acionadores `superintendente_ebd`
--
DROP TRIGGER IF EXISTS `addLixoSuperintendente`;
DELIMITER //
CREATE TRIGGER `addLixoSuperintendente` AFTER UPDATE ON `superintendente_ebd`
 FOR EACH ROW BEGIN
	declare nome_member varchar(255);
	
  	IF NEW.status_superintendente_ebd = 'Excluído' THEN 
		BEGIN
			
			SET @nome_member = (select nome_membro from membros where id_membro = NEW.id_membro);
	
    		INSERT INTO lixeira(tabela, campo_status,campo_id,nome_campo_id, nome,data_exclusao) VALUES('superintendente_ebd','status_superintendente_ebd',NEW.id_superintendente_ebd,'id_superintendente_ebd',@nome_member,NOW());
  		END; 
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefones`
--

CREATE TABLE IF NOT EXISTS `telefones` (
  `id_telefone` int(11) NOT NULL AUTO_INCREMENT,
  `id_membro` int(11) DEFAULT NULL,
  `telefone` varchar(255) NOT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `operadora` varchar(255) DEFAULT NULL,
  `id_tipo_telefone` int(11) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_telefone`),
  KEY `telefones_ibfk_1` (`id_membro`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Extraindo dados da tabela `telefones`
--

INSERT INTO `telefones` (`id_telefone`, `id_membro`, `telefone`, `categoria`, `operadora`, `id_tipo_telefone`, `data_cadastro`) VALUES
(11, 84, '(12) 3456-78', 'telefone', 'Tim', 1, '2015-06-05 20:07:52'),
(12, 84, '(98) 7654-321', 'celular', 'Claro', 3, '2015-06-05 20:07:52'),
(13, 85, '12345678', 'telefone', 'Tim', 1, '2015-04-30 17:59:34'),
(14, 85, '987654321', 'celular', 'Claro', 3, '2015-04-30 17:59:34'),
(15, 89, '(12) 345', 'telefone', 'op', 3, '2015-06-05 20:11:03'),
(16, 92, '', 'telefone', '', 0, '2015-06-05 20:02:04'),
(17, 102, '(12) 3456-78', 'celular', 'operadora', 1, '2015-06-05 19:51:21'),
(18, 102, '(12) 3454-645', 'telefone', 'ope2', 3, '2015-06-05 19:51:21'),
(19, 100, '(11) 11111-1111', 'celular', 'teste', 1, '2015-07-01 15:48:43'),
(22, 100, '(33) 33333-3333', 'celular', 'teste', 3, '2015-07-01 15:48:43');

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefones_igreja`
--

CREATE TABLE IF NOT EXISTS `telefones_igreja` (
  `id_telefone_igreja` int(11) NOT NULL AUTO_INCREMENT,
  `id_igreja` int(11) DEFAULT NULL,
  `telefone_igreja` varchar(255) NOT NULL,
  `operadora_igreja` varchar(255) DEFAULT NULL,
  `data_cadastro_igreja` datetime DEFAULT NULL,
  PRIMARY KEY (`id_telefone_igreja`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `telefones_igreja`
--

INSERT INTO `telefones_igreja` (`id_telefone_igreja`, `id_igreja`, `telefone_igreja`, `operadora_igreja`, `data_cadastro_igreja`) VALUES
(4, 9, '(12) 34567-8901', 'operadora', '2015-05-11 16:21:40'),
(9, 8, '(22) 22222-2222', 'teste', '2015-05-11 16:40:05'),
(10, 8, '(12) 3121-32212', 'teste', '2015-05-11 16:40:05'),
(11, 6, '(13) 45645-6546', 'op', '2015-05-15 21:44:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_email`
--

CREATE TABLE IF NOT EXISTS `tipo_email` (
  `id_tipo_email` int(11) NOT NULL AUTO_INCREMENT,
  `nome_tipo_email` varchar(255) DEFAULT NULL,
  `status_tipo_email` varchar(255) DEFAULT NULL,
  `data_cadastro_tipo_email` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tipo_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `tipo_email`
--

INSERT INTO `tipo_email` (`id_tipo_email`, `nome_tipo_email`, `status_tipo_email`, `data_cadastro_tipo_email`) VALUES
(1, 'Pessoal', 'Ativo', '2015-04-16 21:30:05'),
(3, 'Residencial', 'Ativo', '2015-04-16 21:51:09'),
(4, 'Profissional', 'Ativo', '2015-04-16 21:52:17'),
(5, 'Outros', 'Ativo', '2015-04-16 22:00:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_membro`
--

CREATE TABLE IF NOT EXISTS `tipo_membro` (
  `id_tipo_membro` int(11) NOT NULL AUTO_INCREMENT,
  `nome_tipo_membro` varchar(255) DEFAULT NULL,
  `status_tipo_membro` varchar(255) DEFAULT NULL,
  `data_cadastro_tipo_membro` date DEFAULT NULL,
  PRIMARY KEY (`id_tipo_membro`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `tipo_membro`
--

INSERT INTO `tipo_membro` (`id_tipo_membro`, `nome_tipo_membro`, `status_tipo_membro`, `data_cadastro_tipo_membro`) VALUES
(1, 'Comungante', 'Ativo', '2015-03-24'),
(2, 'Não-Comungante', 'Ativo', '2015-03-24'),
(3, 'Visitante assíduo', 'Ativo', '2015-03-24'),
(4, 'Rol Separado', 'Ativo', '2015-03-24'),
(6, 'Demitido', 'Ativo', '2015-03-24');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_oficio_igreja`
--

CREATE TABLE IF NOT EXISTS `tipo_oficio_igreja` (
  `id_tipo_oficio_igreja` int(11) NOT NULL AUTO_INCREMENT,
  `nome_tipo_oficio_igreja` varchar(255) DEFAULT NULL,
  `status_tipo_oficio_igreja` varchar(255) DEFAULT NULL,
  `data_cadastro_tipo_oficio_igreja` date DEFAULT NULL,
  PRIMARY KEY (`id_tipo_oficio_igreja`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Extraindo dados da tabela `tipo_oficio_igreja`
--

INSERT INTO `tipo_oficio_igreja` (`id_tipo_oficio_igreja`, `nome_tipo_oficio_igreja`, `status_tipo_oficio_igreja`, `data_cadastro_tipo_oficio_igreja`) VALUES
(13, 'Diáconos', 'Ativo', '2015-05-12'),
(14, 'Presbítero', 'Ativo', '2015-05-12'),
(15, 'Pastor', 'Ativo', '2015-05-12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_recebimento`
--

CREATE TABLE IF NOT EXISTS `tipo_recebimento` (
  `id_tipo_recebimento` int(11) NOT NULL AUTO_INCREMENT,
  `letra_tipo_recebimento` varchar(255) DEFAULT NULL,
  `nome_tipo_recebimento` varchar(255) DEFAULT NULL,
  `status_tipo_recebimento` varchar(255) DEFAULT NULL,
  `data_cadastro_tipo_recebimento` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tipo_recebimento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `tipo_recebimento`
--

INSERT INTO `tipo_recebimento` (`id_tipo_recebimento`, `letra_tipo_recebimento`, `nome_tipo_recebimento`, `status_tipo_recebimento`, `data_cadastro_tipo_recebimento`) VALUES
(4, 'Letra A', 'Profissão de Fé', 'Ativo', '2015-03-20 21:20:52'),
(5, 'Letra B', 'Profissão de Fé e Batismo', 'Ativo', '2015-03-20 21:21:00'),
(6, 'Letra C', 'Carta Transferência', 'Ativo', '2015-03-20 21:21:09'),
(7, 'Letra D', 'Jurisdição a pedido', 'Ativo', '2015-03-20 21:21:20'),
(8, 'Letra E', 'Jurisdição ex officio', 'Ativo', '2015-03-20 21:21:31'),
(9, 'Letra F', 'Restauração', 'Ativo', '2015-03-20 21:21:40'),
(10, 'Letra G', 'Designação Presb.', 'Ativo', '2015-03-20 21:21:56'),
(11, '', '', '', '2015-05-12 14:10:40'),
(12, '', '', '', '2015-05-12 14:10:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_telefone`
--

CREATE TABLE IF NOT EXISTS `tipo_telefone` (
  `id_tipo_telefone` int(11) NOT NULL AUTO_INCREMENT,
  `nome_tipo_telefone` varchar(255) DEFAULT NULL,
  `status_tipo_telefone` varchar(255) DEFAULT NULL,
  `data_cadastro_tipo_telefone` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tipo_telefone`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `tipo_telefone`
--

INSERT INTO `tipo_telefone` (`id_tipo_telefone`, `nome_tipo_telefone`, `status_tipo_telefone`, `data_cadastro_tipo_telefone`) VALUES
(1, 'Pessoal', 'Ativo', '2015-04-16 21:30:05'),
(3, 'Residencial', 'Ativo', '2015-04-16 21:51:09'),
(4, 'Profissional', 'Ativo', '2015-04-16 21:52:17'),
(5, 'Outros', 'Ativo', '2015-04-16 22:00:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_adm`
--

CREATE TABLE IF NOT EXISTS `usuarios_adm` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(255) DEFAULT NULL,
  `sobrenome_usuario` varchar(255) DEFAULT NULL,
  `email_usuario` varchar(255) DEFAULT NULL,
  `login_usuario` varchar(255) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `permissao_usuario` varchar(255) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `token` text NOT NULL,
  `foto_usuario` varchar(255) NOT NULL,
  `status_usuario` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `login_usuario` (`login_usuario`),
  UNIQUE KEY `email_usuario` (`email_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `usuarios_adm`
--

INSERT INTO `usuarios_adm` (`id_usuario`, `nome_usuario`, `sobrenome_usuario`, `email_usuario`, `login_usuario`, `senha_usuario`, `permissao_usuario`, `data_cadastro`, `token`, `foto_usuario`, `status_usuario`) VALUES
(1, 'Administrador', 'geral', 'wellington.infodahora@gmail.com', 'admin', '0192023a7bbd73250516f069df18b500', 'Administrador', '2015-03-09 00:00:00', '$2a$08$MTU0NTYxODIxMTU1OTZhNOfUywpJPaxl9JdhXDfgJyJQDfxiLLWs6', '', 'Ativo'),
(5, 'wellington', 'cezar', 'wellington-cezar@hotmail.com', 'wellington', '202cb962ac59075b964b07152d234b70', '50', '2015-05-04 20:01:52', '$2a$08$NjM2MjA0Mzg2NTU1ZjNhMeU6LQ6BNQJY1ZDj8Cfmi23Gj/CbNatXK', '', 'Ativo'),
(6, 'usuario excluido', 'teste', 'teste@teste.com', 'teste', '698dc19d489c4e4db73e28a713eab07b', '49', '2015-05-04 20:39:04', '$2a$08$MjAyNzE3NDk2NTU1NDhlMOCamkVLYj9rHHWD3W9ckWfUEy0i2Oo2W', '', 'Excluído'),
(7, 'Esdras', 'Junior', 'junior@infodahora.com.br', 'esdras', '202cb962ac59075b964b07152d234b70', '49', '2015-05-19 14:00:39', '$2a$08$MjAzMTU0ODM5OTU1NWI2N.XO5k4kgLWVIrzjrTdA.uW3sWXBTakMy', '', 'Inativo');

--
-- Acionadores `usuarios_adm`
--
DROP TRIGGER IF EXISTS `addLixoUsuariosAdm`;
DELIMITER //
CREATE TRIGGER `addLixoUsuariosAdm` AFTER UPDATE ON `usuarios_adm`
 FOR EACH ROW BEGIN
  	IF NEW.status_usuario = 'Excluído' THEN 
		BEGIN
    		INSERT INTO lixeira(tabela, campo_status,campo_id,nome_campo_id,nome,data_exclusao) VALUES('usuarios_adm','status_usuario',NEW.id_usuario,'id_usuario',NEW.nome_usuario,NOW());
  		END; 
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_adm_permissao`
--

CREATE TABLE IF NOT EXISTS `usuarios_adm_permissao` (
  `id_permissao` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `permissao` text,
  `data_permissao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_permissao`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_adm_acesso`
--

CREATE TABLE IF NOT EXISTS `usuario_adm_acesso` (
  `id_acesso` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `data_acesso` date DEFAULT NULL,
  `hora_acesso` time DEFAULT NULL,
  `ip_acesso` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_acesso`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=282 ;

--
-- Extraindo dados da tabela `usuario_adm_acesso`
--

INSERT INTO `usuario_adm_acesso` (`id_acesso`, `id_usuario`, `data_acesso`, `hora_acesso`, `ip_acesso`) VALUES
(108, 1, '2015-03-12', '15:04:59', '127.0.0.1'),
(109, 1, '2015-03-12', '15:05:36', '127.0.0.1'),
(110, 1, '2015-03-18', '13:19:10', '127.0.0.1'),
(111, 1, '2015-03-18', '13:25:34', '127.0.0.1'),
(112, 1, '2015-03-18', '13:25:36', '127.0.0.1'),
(113, 1, '2015-03-18', '13:27:05', '127.0.0.1'),
(114, 1, '2015-03-18', '13:27:06', '127.0.0.1'),
(115, 1, '2015-03-18', '13:27:14', '127.0.0.1'),
(116, 1, '2015-03-18', '13:28:50', '127.0.0.1'),
(117, 1, '2015-03-18', '13:29:12', '127.0.0.1'),
(118, 1, '2015-03-18', '13:29:30', '127.0.0.1'),
(119, 1, '2015-03-18', '13:32:04', '127.0.0.1'),
(120, 1, '2015-03-18', '13:38:34', '127.0.0.1'),
(121, 1, '2015-03-18', '13:38:36', '127.0.0.1'),
(122, 1, '2015-03-18', '13:40:14', '127.0.0.1'),
(123, 1, '2015-03-18', '13:42:53', '127.0.0.1'),
(124, 1, '2015-03-18', '13:43:32', '127.0.0.1'),
(125, 1, '2015-03-18', '13:49:05', '127.0.0.1'),
(126, 1, '2015-03-18', '13:51:19', '127.0.0.1'),
(127, 1, '2015-03-19', '12:34:07', '127.0.0.1'),
(128, 1, '2015-03-20', '13:08:17', '127.0.0.1'),
(129, 1, '2015-03-20', '16:56:09', '192.168.25.147'),
(130, 1, '2015-03-20', '16:57:17', '127.0.0.1'),
(131, 1, '2015-03-24', '15:55:50', '127.0.0.1'),
(132, 1, '2015-03-24', '19:55:03', '127.0.0.1'),
(133, 1, '2015-03-25', '16:01:04', '127.0.0.1'),
(134, 1, '2015-03-26', '13:42:06', '127.0.0.1'),
(135, 1, '2015-03-27', '12:14:54', '127.0.0.1'),
(136, 1, '2015-03-30', '20:17:56', '127.0.0.1'),
(137, 1, '2015-04-10', '22:00:47', '127.0.0.1'),
(138, 1, '2015-04-14', '16:39:30', '127.0.0.1'),
(139, 1, '2015-04-15', '15:47:37', '127.0.0.1'),
(140, 1, '2015-04-15', '17:09:23', '127.0.0.1'),
(141, 1, '2015-04-16', '13:07:25', '127.0.0.1'),
(142, 1, '2015-04-17', '13:42:07', '127.0.0.1'),
(143, 1, '2015-04-20', '14:55:30', '127.0.0.1'),
(144, 1, '2015-04-22', '17:39:41', '127.0.0.1'),
(145, 1, '2015-04-22', '20:46:22', '192.168.25.147'),
(146, 1, '2015-04-22', '20:48:50', '127.0.0.1'),
(147, 1, '2015-04-23', '13:19:42', '127.0.0.1'),
(148, 1, '2015-04-23', '22:26:28', '192.168.25.147'),
(149, 1, '2015-04-23', '22:30:18', '127.0.0.1'),
(150, 1, '2015-04-24', '13:14:22', '127.0.0.1'),
(151, 1, '2015-04-24', '14:35:53', '192.168.25.147'),
(152, 1, '2015-04-24', '14:46:07', '127.0.0.1'),
(153, 1, '2015-04-24', '22:17:15', '192.168.25.147'),
(154, 1, '2015-04-24', '22:21:32', '127.0.0.1'),
(155, 1, '2015-04-24', '22:45:10', '192.168.25.147'),
(156, 1, '2015-04-24', '22:45:11', '192.168.25.147'),
(157, 1, '2015-04-27', '13:10:11', '127.0.0.1'),
(158, 1, '2015-04-28', '13:11:46', '127.0.0.1'),
(159, 1, '2015-04-29', '13:08:47', '127.0.0.1'),
(160, 1, '2015-04-30', '13:10:20', '127.0.0.1'),
(161, 1, '2015-04-30', '15:47:46', '192.168.25.147'),
(162, 1, '2015-04-30', '15:57:10', '192.168.25.147'),
(163, 1, '2015-04-30', '16:01:22', '127.0.0.1'),
(166, 1, '2015-04-30', '17:38:43', '127.0.0.1'),
(167, 1, '2015-04-30', '18:51:29', '192.168.25.147'),
(168, 1, '2015-04-30', '18:53:35', '192.168.25.147'),
(169, 1, '2015-04-30', '19:42:55', '127.0.0.1'),
(170, 1, '2015-04-30', '20:50:39', '127.0.0.1'),
(171, 1, '2015-04-30', '22:16:41', '127.0.0.1'),
(172, 1, '2015-04-30', '22:20:58', '127.0.0.1'),
(173, 1, '2015-04-30', '22:21:10', '127.0.0.1'),
(174, 1, '2015-04-30', '22:21:12', '127.0.0.1'),
(175, 1, '2015-04-30', '22:22:39', '127.0.0.1'),
(176, 1, '2015-04-30', '22:25:34', '127.0.0.1'),
(177, 1, '2015-04-30', '22:29:36', '127.0.0.1'),
(178, 1, '2015-04-30', '22:30:45', '127.0.0.1'),
(179, 1, '2015-05-04', '13:23:23', '127.0.0.1'),
(180, 5, '2015-05-04', '20:02:06', '127.0.0.1'),
(181, 1, '2015-05-04', '20:03:53', '127.0.0.1'),
(182, 5, '2015-05-04', '20:04:01', '127.0.0.1'),
(183, 5, '2015-05-04', '20:10:33', '127.0.0.1'),
(184, 5, '2015-05-04', '20:10:36', '127.0.0.1'),
(185, 5, '2015-05-04', '20:11:12', '127.0.0.1'),
(186, 5, '2015-05-04', '20:12:03', '127.0.0.1'),
(187, 5, '2015-05-04', '20:13:01', '127.0.0.1'),
(188, 5, '2015-05-04', '20:13:14', '127.0.0.1'),
(189, 5, '2015-05-04', '20:13:44', '127.0.0.1'),
(190, 5, '2015-05-04', '20:14:42', '127.0.0.1'),
(191, 5, '2015-05-04', '20:15:06', '127.0.0.1'),
(192, 5, '2015-05-04', '20:15:18', '127.0.0.1'),
(193, 1, '2015-05-04', '20:36:48', '127.0.0.1'),
(194, 1, '2015-05-04', '20:38:11', '127.0.0.1'),
(195, 6, '2015-05-04', '20:40:02', '127.0.0.1'),
(196, 6, '2015-05-04', '20:40:14', '127.0.0.1'),
(197, 6, '2015-05-04', '20:47:51', '127.0.0.1'),
(198, 1, '2015-05-04', '20:48:37', '127.0.0.1'),
(199, 6, '2015-05-04', '20:49:17', '127.0.0.1'),
(200, 6, '2015-05-04', '20:49:52', '127.0.0.1'),
(201, 1, '2015-05-04', '20:50:05', '127.0.0.1'),
(202, 6, '2015-05-04', '21:38:36', '127.0.0.1'),
(203, 6, '2015-05-04', '21:39:45', '127.0.0.1'),
(204, 6, '2015-05-04', '22:01:43', '127.0.0.1'),
(205, 6, '2015-05-05', '13:19:14', '127.0.0.1'),
(206, 1, '2015-05-05', '15:24:16', '127.0.0.1'),
(207, 6, '2015-05-05', '15:26:02', '127.0.0.1'),
(208, 6, '2015-05-05', '15:30:19', '127.0.0.1'),
(209, 6, '2015-05-05', '15:42:23', '127.0.0.1'),
(210, 6, '2015-05-05', '15:44:51', '127.0.0.1'),
(211, 6, '2015-05-05', '15:45:38', '127.0.0.1'),
(212, 1, '2015-05-05', '16:58:23', '127.0.0.1'),
(213, 6, '2015-05-05', '16:58:46', '127.0.0.1'),
(214, 1, '2015-05-05', '17:05:38', '127.0.0.1'),
(215, 1, '2015-05-05', '17:06:31', '127.0.0.1'),
(216, 5, '2015-05-05', '17:07:09', '127.0.0.1'),
(217, 1, '2015-05-05', '17:07:28', '127.0.0.1'),
(218, 5, '2015-05-05', '17:07:55', '127.0.0.1'),
(219, 5, '2015-05-05', '17:09:52', '127.0.0.1'),
(220, 5, '2015-05-05', '17:10:33', '127.0.0.1'),
(221, 5, '2015-05-05', '17:10:43', '127.0.0.1'),
(222, 5, '2015-05-05', '17:11:09', '127.0.0.1'),
(223, 5, '2015-05-05', '17:12:21', '127.0.0.1'),
(224, 5, '2015-05-05', '17:13:04', '127.0.0.1'),
(225, 1, '2015-05-05', '17:14:11', '127.0.0.1'),
(226, 6, '2015-05-05', '17:21:45', '127.0.0.1'),
(227, 5, '2015-05-05', '17:21:51', '127.0.0.1'),
(228, 5, '2015-05-05', '17:22:17', '127.0.0.1'),
(229, 1, '2015-05-05', '17:22:25', '127.0.0.1'),
(230, 5, '2015-05-05', '17:22:41', '127.0.0.1'),
(231, 1, '2015-05-05', '17:22:51', '127.0.0.1'),
(232, 6, '2015-05-05', '17:24:16', '127.0.0.1'),
(233, 6, '2015-05-05', '17:28:22', '127.0.0.1'),
(234, 5, '2015-05-05', '17:28:32', '127.0.0.1'),
(235, 5, '2015-05-05', '17:30:58', '127.0.0.1'),
(236, 1, '2015-05-05', '17:35:09', '127.0.0.1'),
(237, 1, '2015-05-07', '16:41:42', '127.0.0.1'),
(238, 1, '2015-05-11', '13:07:24', '127.0.0.1'),
(239, 1, '2015-05-12', '13:30:28', '127.0.0.1'),
(240, 1, '2015-05-13', '13:29:45', '127.0.0.1'),
(241, 1, '2015-05-15', '13:26:31', '127.0.0.1'),
(242, 1, '2015-05-18', '13:07:20', '127.0.0.1'),
(243, 1, '2015-05-19', '13:26:46', '127.0.0.1'),
(244, 7, '2015-05-19', '14:01:02', '127.0.0.1'),
(245, 7, '2015-05-19', '14:01:05', '127.0.0.1'),
(246, 7, '2015-05-19', '14:01:46', '127.0.0.1'),
(247, 1, '2015-05-19', '14:03:13', '127.0.0.1'),
(248, 1, '2015-05-19', '15:48:54', '127.0.0.1'),
(249, 7, '2015-05-19', '15:50:25', '192.168.25.147'),
(250, 7, '2015-05-19', '17:17:52', '127.0.0.1'),
(251, 7, '2015-05-19', '17:18:05', '127.0.0.1'),
(252, 7, '2015-05-19', '17:18:51', '127.0.0.1'),
(253, 7, '2015-05-19', '17:19:19', '127.0.0.1'),
(254, 1, '2015-05-19', '18:00:47', '127.0.0.1'),
(255, 7, '2015-05-19', '18:29:32', '192.168.25.147'),
(256, 1, '2015-05-19', '22:24:57', '127.0.0.1'),
(257, 1, '2015-05-20', '13:16:37', '127.0.0.1'),
(258, 1, '2015-05-21', '13:04:00', '127.0.0.1'),
(259, 1, '2015-05-22', '13:19:10', '127.0.0.1'),
(260, 5, '2015-05-22', '16:03:32', '127.0.0.1'),
(261, 5, '2015-05-22', '16:16:15', '192.168.25.26'),
(262, 1, '2015-05-22', '16:16:21', '127.0.0.1'),
(263, 1, '2015-05-22', '19:45:12', '192.168.25.41'),
(264, 1, '2015-05-22', '19:45:19', '192.168.25.50'),
(265, 1, '2015-05-26', '22:04:29', '127.0.0.1'),
(266, 1, '2015-05-27', '13:11:37', '127.0.0.1'),
(267, 1, '2015-05-29', '16:18:00', '127.0.0.1'),
(268, 1, '2015-06-01', '13:21:47', '127.0.0.1'),
(269, 1, '2015-06-02', '13:08:17', '127.0.0.1'),
(270, 1, '2015-06-03', '15:20:55', '127.0.0.1'),
(271, 1, '2015-06-05', '14:10:21', '127.0.0.1'),
(272, 1, '2015-06-08', '14:08:33', '127.0.0.1'),
(273, 1, '2015-06-09', '16:25:46', '192.168.25.41'),
(274, 1, '2015-06-09', '16:44:20', '192.168.25.50'),
(275, 1, '2015-06-11', '17:19:28', '127.0.0.1'),
(276, 1, '2015-06-11', '17:19:28', '127.0.0.1'),
(277, 1, '2015-06-17', '15:29:44', '127.0.0.1'),
(278, 1, '2015-07-01', '13:18:27', '127.0.0.1'),
(279, 1, '2015-07-02', '16:21:36', '127.0.0.1'),
(280, 1, '2015-07-03', '13:07:42', '127.0.0.1'),
(281, 1, '2015-07-03', '17:06:43', '127.0.0.1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_adm_grupo_permissao`
--

CREATE TABLE IF NOT EXISTS `usuario_adm_grupo_permissao` (
  `id_grupo_permissao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_permissao` varchar(255) NOT NULL,
  `permissao` text,
  `data_cadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_grupo_permissao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Extraindo dados da tabela `usuario_adm_grupo_permissao`
--

INSERT INTO `usuario_adm_grupo_permissao` (`id_grupo_permissao`, `nome_permissao`, `permissao`, `data_cadastro`) VALUES
(49, 'Permissão geral', '{"igreja":{"submodulos":{},"paginas":{"home":{"index":"","cadastrar":"","editar":""}}},"rol-de-membros":{"submodulos":{"relatorios":{"relatorio_especifico":{"index":"","cadastrar":"","visualizar":""}}},"paginas":{"home":{"index":"","cadastrar":"","editar":"","genealogia":"","excluir":""}}},"configuracoes":{"submodulos":{"tabelas":{"estado_civil":{"cadastrar":"","editar":"","index":"","excluir":""},"tipo_recebimento":{"index":"","cadastrar":"","editar":"","excluir":""},"home":{},"tipo_membro":{"index":"","cadastrar":"","editar":"","excluir":""},"tipo_telefone":{"index":"","cadastrar":"","editar":"","excluir":""},"tipo_email":{"index":"","editar":"","cadastrar":"","excluir":""},"tipo_oficio_igreja":{"index":"","cadastrar":"","excluir":"","editar":""}},"usuarios":{"cadastrar":{},"grupo_usuarios":{"cadastrar":"","index":"","editar":""},"home":{"index":""},"usuarios":{"index":""}},"modulos":{"home":{"index":""}}},"paginas":{"home":{"index":""}}}}', '2015-05-04 19:49:22'),
(50, 'Altera apenas a igreja', '{"igreja":{"submodulos":{},"paginas":{"home":{"index":"","cadastrar":"","editar":""}}}}', '2015-05-04 19:57:03'),
(51, 'membros', '{"rol-de-membros":{"submodulos":{},"paginas":{"home":{},"undefined":{}}}}', '2015-05-05 17:27:34');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `actions_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `alunos_ebd`
--
ALTER TABLE `alunos_ebd`
  ADD CONSTRAINT `alunos_ebd_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classes_ebd` (`id_classe_ebd`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alunos_ebd_ibfk_1` FOREIGN KEY (`id_membro`) REFERENCES `membros` (`id_membro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `data_aula_ebd`
--
ALTER TABLE `data_aula_ebd`
  ADD CONSTRAINT `data_aula_ebd_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classes_ebd` (`id_classe_ebd`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `emails`
--
ALTER TABLE `emails`
  ADD CONSTRAINT `emails_ibfk_1` FOREIGN KEY (`id_membro`) REFERENCES `membros` (`id_membro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `genealogia`
--
ALTER TABLE `genealogia`
  ADD CONSTRAINT `genealogia_ibfk_1` FOREIGN KEY (`id_membro`) REFERENCES `membros` (`id_membro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `paginas`
--
ALTER TABLE `paginas`
  ADD CONSTRAINT `paginas_ibfk_1` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `redes_sociais`
--
ALTER TABLE `redes_sociais`
  ADD CONSTRAINT `redes_sociais_ibfk_1` FOREIGN KEY (`id_membro`) REFERENCES `membros` (`id_membro`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `status_tipo_oficio_igreja`
--
ALTER TABLE `status_tipo_oficio_igreja`
  ADD CONSTRAINT `status_tipo_oficio_igreja_ibfk_1` FOREIGN KEY (`id_tipo_oficio_igreja`) REFERENCES `tipo_oficio_igreja` (`id_tipo_oficio_igreja`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `telefones`
--
ALTER TABLE `telefones`
  ADD CONSTRAINT `telefones_ibfk_1` FOREIGN KEY (`id_membro`) REFERENCES `membros` (`id_membro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `usuario_adm_acesso`
--
ALTER TABLE `usuario_adm_acesso`
  ADD CONSTRAINT `usuario_adm_acesso_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios_adm` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
