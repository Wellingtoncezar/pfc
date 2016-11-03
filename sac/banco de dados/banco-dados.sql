-- sys_modulos
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (0, '', 'ROOT', 0, 'ATIVO', 'INATIVO', NULL, NULL, '2016-01-20 00:00:00');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (5, 'funcionarios', 'Funcion&aacute;rios', 0, 'ATIVO', 'ATIVO', 0, 'glyphicons glyphicons-group', '2016-01-20 15:15:22');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (6, 'configuracoes', 'Configura&ccedil;&otilde;es', 8, 'ATIVO', 'ATIVO', 0, 'glyphicons glyphicons-cogwheels', '2016-01-20 15:24:33');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (7, 'modulos', 'M&oacute;dulos', 0, 'ATIVO', 'INATIVO', 6, NULL, '2016-01-20 15:24:40');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (8, 'fornecedores', 'Fornecedores', 1, 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-handshake', '2016-01-20 20:55:14');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (9, 'produtos', 'Produtos', 2, 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-package', '2016-01-23 16:19:53');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (10, 'estoque', 'Estoque', 3, 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-cargo', '2016-01-23 16:20:46');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (11, 'caixa', 'Caixa', 4, 'ATIVO', 'ATIVO', 0, 'glyphicons glyphicons-calculator', '2016-01-23 16:21:21');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (14, 'relatorios', 'Relat&oacute;rios', 6, 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-stats', '2016-01-23 16:23:17');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (15, 'niveis_acesso', 'N&iacute;veis de acesso', NULL, 'ATIVO', 'INATIVO', 6, NULL, '2016-01-30 15:00:29');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (17, 'usuarios', 'Usu&aacute;rios', NULL, 'ATIVO', 'INATIVO', 5, NULL, '2016-03-03 23:16:41');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (18, 'cargos', 'Cargos', NULL, 'ATIVO', 'INATIVO', 5, NULL, '2016-03-13 03:31:55');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (19, 'categorias', 'Categorias', NULL, 'INATIVO', 'INATIVO', 9, NULL, '2016-03-22 00:01:40');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (20, 'marcas', 'Marcas', NULL, 'INATIVO', 'INATIVO', 9, NULL, '2016-03-22 00:01:50');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (21, 'suprimentos', 'Suprimentos', 5, 'ATIVO', 'ATIVO', 0, 'glyphicons glyphicons-transfer', '2016-04-26 01:13:32');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (22, 'requisicoes', 'Requisi&ccedil;&otilde;es', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-04-26 01:17:25');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (23, 'cotacoes', 'Cota&ccedil;&otilde;es', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-04-26 01:17:40');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (24, 'pedidos', 'Pedidos', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-04-26 01:17:52');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (25, 'prateleira', 'Prateleira', NULL, 'ATIVO', 'INATIVO', 10, NULL, '2016-07-20 14:34:06');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (26, 'armazem', 'Armaz&eacute;m', NULL, 'ATIVO', 'INATIVO', 10, NULL, '2016-07-20 14:35:33');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (27, 'descartados', 'Descartados', NULL, 'ATIVO', 'INATIVO', 10, NULL, '2016-07-20 14:35:41');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (28, 'checkout', 'Checkout', NULL, 'ATIVO', 'INATIVO', 11, NULL, '2016-07-22 16:33:39');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (29, 'orcamentos', 'Or&ccedil;amentos', NULL, 'ATIVO', 'INATIVO', 21, NULL, '2016-08-20 18:17:49');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (30, 'agenda', 'Agenda', 7, 'ATIVO', 'INATIVO', 0, 'glyphicons glyphicons-calendar', '2016-09-12 00:05:32');
INSERT INTO `sys_modulos` (`id_modulo`, `url_modulo`, `nome_modulo`, `posicao_modulo`, `status_modulo`, `status_selecao_modulo`, `id_modulo_pai`, `icone_modulo`, `data_criacao_modulo`) VALUES (31, 'empresa', NULL, NULL, 'INATIVO', 'INATIVO', 6, NULL, '2016-09-12 00:20:59');
-- ----------------------------------------------------------

-- sys_paginas
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


-- sys_actions
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

-- nivel_acesso
INSERT INTO `nivel_acesso` (`id_nivel_acesso`, `nome_nivel_acesso`, `tipo_permissao`, `index_access_db_name`, `timestamp`) VALUES
(1, 'Administrativo', 'ADMINISTRADOR', 'default', '2016-10-14 00:49:01'),
(2, 'Gerência', 'USUARIO', 'gerencia', '2016-10-14 00:49:06'),
(4, 'Caixa', 'USUARIO', 'caixa', '2016-10-14 00:49:12'),
(5, 'Suprimentos', 'USUARIO', 'suprimentos', '2016-10-14 00:49:16'),
(6, 'Estoquista', 'USUARIO', 'estoquista', '2016-10-14 00:49:23');



-- cargos
INSERT INTO `cargos` (`id_cargo`, `nome_cargo`, `setor_cargo`) VALUES
(2, 'estoquista', 'suprimentos'),
(3, 'Gerente', 'TI');


-- funcionarios
INSERT INTO `funcionarios` (`id_funcionario`, `foto_funcionario`, `nome_funcionario`, `sobrenome_funcionario`, `data_nascimento_funcionario`, `sexo_funcionario`, `rg_funcionario`, `cpf_funcionario`, `estado_civil_funcionario`, `escolaridade_funcionario`, `codigo_funcionario`, `id_cargo`, `data_admissao_funcionario`, `data_demissao_funcionario`, `status_funcionario`, `data_cadastro_funcionario`, `timestamp`) VALUES
(59, 'c1d693986ded7c8d7aa41e6939ae036e.png', 'Usu&aacute;rio', 'Administrador', '2001-03-13', 'M', '21.331.313-2', '151.847.942-12', 'Solteiro', 'Ensino Superior Completo', '', 3, '2016-03-13', '0000-00-00', 'ATIVO', '2016-03-13 04:49:17', '2016-09-24 21:42:51');

-- sys_usuarios
INSERT INTO `sys_usuarios` (`id_usuario`, `id_funcionario`, `id_nivel_acesso`, `email_usuario`, `login_usuario`, `senha_usuario`, `hash_acesso`, `status_usuario`, `data_criacao_usuario`, `timestamp`) VALUES
(1, 59, 1, 'admin@prysmarket.com.br', 'admin', '$2a$08$MTY2MjMyMDcyMTU3MmJjNe4RI1/LIguX39aJwjjJ374Tx2TdxfSXe', '$2a$08$NTI2NDYzMDY2NTgxNWViN.Qlonhz2W3NenSyrIhSJvqeMVn4oPXKm', 'ATIVO', NULL, '2016-05-05 22:17:49')