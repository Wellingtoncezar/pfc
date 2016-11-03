-- sys_modulos
CREATE TABLE IF NOT EXISTS `sys_modulos` (
  `id_modulo` int(11) NOT NULL,
  `url_modulo` varchar(100) NOT NULL,
  `nome_modulo` varchar(100) DEFAULT NULL,
  `posicao_modulo` int(11) DEFAULT NULL,
  `status_modulo` enum('ATIVO','INATIVO','EXCLUIDO') DEFAULT NULL,
  `status_selecao_modulo` enum('ATIVO','INATIVO','EXCLUIDO') DEFAULT NULL,
  `id_modulo_pai` int(11) DEFAULT NULL,
  `icone_modulo` varchar(255) DEFAULT NULL,
  `data_criacao_modulo` datetime DEFAULT NULL
);
ALTER TABLE `sys_modulos` ADD PRIMARY KEY (`id_modulo`), ADD KEY `id_modulo_pai` (`id_modulo_pai`);
ALTER TABLE `sys_modulos` MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sys_modulos` ADD CONSTRAINT `sys_modulos_ibfk_1` FOREIGN KEY (`id_modulo_pai`) REFERENCES `sys_modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------

--sys_paginas
CREATE TABLE IF NOT EXISTS `sys_paginas` (
  `id_pagina` int(11) NOT NULL,
  `url_pagina` varchar(100) DEFAULT NULL,
  `nome_pagina` varchar(100) DEFAULT NULL,
  `posicao_pagina` int(11) DEFAULT NULL,
  `status_pagina` varchar(100) DEFAULT NULL,
  `status_selecao_pagina` varchar(100) DEFAULT NULL,
  `id_modulo` int(11) DEFAULT NULL,
  `data_criacao_pagina` datetime DEFAULT NULL
);
ALTER TABLE `sys_paginas` ADD PRIMARY KEY (`id_pagina`);
ALTER TABLE `sys_paginas` MODIFY `id_pagina` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sys_paginas` ADD CONSTRAINT `sys_paginas_ibfk_1` FOREIGN KEY (`id_modulo`) REFERENCES `sys_modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------

-- sys_actions
CREATE TABLE IF NOT EXISTS `sys_actions` (
  `id_action` int(11) NOT NULL,
  `url_action` varchar(100) DEFAULT NULL,
  `nome_action` varchar(100) DEFAULT NULL,
  `status_action` varchar(100) DEFAULT NULL,
  `status_selecao_action` varchar(100) DEFAULT NULL,
  `id_pagina` int(11) DEFAULT NULL,
  `posicao_action` int(11) DEFAULT NULL,
  `data_criacao_action` datetime DEFAULT NULL
);
ALTER TABLE `sys_actions` ADD PRIMARY KEY (`id_action`);
ALTER TABLE `sys_actions` MODIFY `id_action` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sys_actions` ADD CONSTRAINT `sys_actions_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `sys_paginas` (`id_pagina`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- cargos
CREATE TABLE IF NOT EXISTS `cargos` (
  `id_cargo` int(11) NOT NULL,
  `nome_cargo` varchar(255) DEFAULT NULL,
  `setor_cargo` varchar(255) DEFAULT NULL
);
ALTER TABLE `cargos` ADD PRIMARY KEY (`id_cargo`);
ALTER TABLE `cargos` MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT;
-- ----------------------------------------------------------

-- funcionarios
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
  `email_funcionario` varchar(255) DEFAULT NULL,  
  `telefone_funcionario` varchar(255) DEFAULT NULL,
  `codigo_funcionario` varchar(255) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `data_admissao_funcionario` date DEFAULT NULL,
  `data_demissao_funcionario` date DEFAULT NULL,
  `status_funcionario` enum('ATIVO','INATIVO','EXCLUIDO') NOT NULL DEFAULT 'ATIVO',
  `data_cadastro_funcionario` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `funcionarios` ADD PRIMARY KEY (`id_funcionario`), ADD UNIQUE KEY `cpf_funcionario` (`cpf_funcionario`), ADD UNIQUE KEY `codigo_funcionario` (`codigo_funcionario`);
ALTER TABLE `funcionarios` MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `funcionarios` ADD CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id_cargo`) ON DELETE SET NULL;
-- ----------------------------------------------------------


-- fornecedores
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
);
ALTER TABLE `fornecedores` ADD PRIMARY KEY (`id_fornecedor`);
ALTER TABLE `fornecedores` MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT;
-- ----------------------------------------------------------


-- fornecedores_agenda
CREATE TABLE IF NOT EXISTS `fornecedores_agenda` (
`id_fornecedor_agenda` int(11) NOT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `titulo_agenda` varchar(255) DEFAULT NULL,
  `observacoes_agenda` text,
  `data_agenda` date DEFAULT NULL,
  `data_cadastro_agenda` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `fornecedores_agenda` ADD PRIMARY KEY (`id_fornecedor_agenda`);
ALTER TABLE `fornecedores_agenda` MODIFY `id_fornecedor_agenda` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `fornecedores_agenda`
ADD CONSTRAINT `fornecedores_agenda_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- fornecedores_agenda_notificado
CREATE TABLE IF NOT EXISTS `fornecedores_agenda_notificado` (
  `id_agenda_notificado` int(11) NOT NULL,
  `id_fornecedor_agenda` int(11) DEFAULT NULL,
  `data_notificacao` date DEFAULT NULL
);
ALTER TABLE `fornecedores_agenda_notificado` ADD PRIMARY KEY (`id_agenda_notificado`);
ALTER TABLE `fornecedores_agenda_notificado` MODIFY `id_agenda_notificado` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `fornecedores_agenda_notificado` ADD CONSTRAINT `fornecedores_agenda_notificado_ibfk_1` FOREIGN KEY (`id_fornecedor_agenda`) REFERENCES `fornecedores_agenda` (`id_fornecedor_agenda`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- telefones
CREATE TABLE IF NOT EXISTS `telefones` (
  `id_telefone` int(11) NOT NULL,
  `categoria_telefone` varchar(255) DEFAULT NULL,
  `numero_telefone` varchar(255) DEFAULT NULL,
  `tipo_telefone` varchar(255) DEFAULT NULL,
  `operadora_telefone` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `telefones` ADD PRIMARY KEY (`id_telefone`);
ALTER TABLE `telefones` MODIFY `id_telefone` int(11) NOT NULL AUTO_INCREMENT;
-- ----------------------------------------------------------


-- telefones_funcionarios
CREATE TABLE IF NOT EXISTS `telefones_funcionarios` (
  `id_funcionario` int(11) DEFAULT NULL,
  `id_telefone` int(11) DEFAULT NULL
);
ALTER TABLE `telefones_funcionarios` ADD KEY `id_telefone` (`id_telefone`);
ALTER TABLE `telefones_funcionarios`
ADD CONSTRAINT `telefones_funcionarios_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `telefones_funcionarios_ibfk_2` FOREIGN KEY (`id_telefone`) REFERENCES `telefones` (`id_telefone`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- telefones_fornecedores
CREATE TABLE IF NOT EXISTS `telefones_fornecedores` (
  `id_fornecedor` int(11) DEFAULT NULL,
  `id_telefone` int(11) DEFAULT NULL
);
ALTER TABLE `telefones_fornecedores`
ADD CONSTRAINT `telefones_fornecedores_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `telefones_fornecedores_ibfk_2` FOREIGN KEY (`id_telefone`) REFERENCES `telefones` (`id_telefone`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- emails
CREATE TABLE IF NOT EXISTS `emails` (
  `id_email` int(11) NOT NULL,
  `endereco_email` varchar(255) DEFAULT NULL,
  `tipo_email` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `emails` ADD PRIMARY KEY (`id_email`);
ALTER TABLE `emails` MODIFY `id_email` int(11) NOT NULL AUTO_INCREMENT;
-- ----------------------------------------------------------


-- emails_fornecedores
CREATE TABLE IF NOT EXISTS `emails_fornecedores` (
  `id_fornecedor` int(11) DEFAULT NULL,
  `id_email` int(11) DEFAULT NULL
);
ALTER TABLE `emails_fornecedores`
ADD CONSTRAINT `emails_fornecedores_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `emails_fornecedores_ibfk_2` FOREIGN KEY (`id_email`) REFERENCES `emails` (`id_email`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- emails_funcionarios
CREATE TABLE IF NOT EXISTS `emails_funcionarios` (
  `id_funcionario` int(11) DEFAULT NULL,
  `id_email` int(11) DEFAULT NULL
);
ALTER TABLE `emails_funcionarios`
ADD CONSTRAINT `emails_funcionarios_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `emails_funcionarios_ibfk_2` FOREIGN KEY (`id_email`) REFERENCES `emails` (`id_email`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- enderecos
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
);
ALTER TABLE `enderecos` ADD PRIMARY KEY (`id_endereco`);
ALTER TABLE `enderecos` MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT;
-- ----------------------------------------------------------


-- enderecos_fornecedores
CREATE TABLE IF NOT EXISTS `enderecos_fornecedores` (
  `id_fornecedor` int(11) DEFAULT NULL,
  `id_endereco` int(11) DEFAULT NULL
);
ALTER TABLE `enderecos_fornecedores`
ADD CONSTRAINT `enderecos_fornecedores_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `enderecos_fornecedores_ibfk_2` FOREIGN KEY (`id_endereco`) REFERENCES `enderecos` (`id_endereco`) ON DELETE CASCADE ON UPDATE CASCADE;

-- -----------------------------------------------------------


-- enderecos_funcionarios`
CREATE TABLE IF NOT EXISTS `enderecos_funcionarios` (
  `id_funcionario` int(11) DEFAULT NULL,
  `id_endereco` int(11) DEFAULT NULL
);
ALTER TABLE `enderecos_funcionarios`
ADD CONSTRAINT `enderecos_funcionarios_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `enderecos_funcionarios_ibfk_2` FOREIGN KEY (`id_endereco`) REFERENCES `enderecos` (`id_endereco`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- nivel_acesso
CREATE TABLE IF NOT EXISTS `nivel_acesso` (
  `id_nivel_acesso` int(11) NOT NULL,
  `nome_nivel_acesso` varchar(100) DEFAULT NULL,
  `tipo_permissao` enum('ADMINISTRADOR','USUARIO') NOT NULL,
  `index_access_db_name` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `nivel_acesso` ADD PRIMARY KEY (`id_nivel_acesso`);
ALTER TABLE `nivel_acesso` MODIFY `id_nivel_acesso` int(11) NOT NULL AUTO_INCREMENT;
-- ----------------------------------------------------------


-- sys_usuarios
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
);
ALTER TABLE `sys_usuarios` ADD PRIMARY KEY (`id_usuario`), ADD UNIQUE KEY `email_usuario` (`email_usuario`), ADD UNIQUE KEY `login_usuario` (`login_usuario`), ADD UNIQUE KEY `id_funcionario_2` (`id_funcionario`);
ALTER TABLE `sys_usuarios` MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sys_usuarios`
ADD CONSTRAINT `sys_usuarios_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE,
ADD CONSTRAINT `sys_usuarios_ibfk_2` FOREIGN KEY (`id_nivel_acesso`) REFERENCES `nivel_acesso` (`id_nivel_acesso`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------

-- excluiusuario -- realiza a exclusão de um usuário em que o funcionário foi excluido
CREATE TRIGGER `excluiusuario` BEFORE UPDATE ON `funcionarios`
 FOR EACH ROW begin
	if new.status_funcionario = 'EXCLUIDO' then
    	delete from sys_usuarios where id_funcionario = new.id_funcionario;
    end if;
end




-- acesso_modulo
CREATE TABLE IF NOT EXISTS `acesso_modulo` (
  `id_acesso_modulo` int(11) NOT NULL,
  `id_nivel_acesso` int(11) DEFAULT NULL,
  `id_modulo` int(11) DEFAULT NULL
);
ALTER TABLE `acesso_modulo` ADD PRIMARY KEY (`id_acesso_modulo`);
ALTER TABLE `acesso_modulo` MODIFY `id_acesso_modulo` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `acesso_modulo`
ADD CONSTRAINT `acesso_modulo_ibfk_1` FOREIGN KEY (`id_nivel_acesso`) REFERENCES `nivel_acesso` (`id_nivel_acesso`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `acesso_modulo_ibfk_2` FOREIGN KEY (`id_modulo`) REFERENCES `sys_modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- acesso_pagina
CREATE TABLE IF NOT EXISTS `acesso_pagina` (
`id_acesso_pagina` int(11) NOT NULL,
  `id_nivel_acesso` int(11) DEFAULT NULL,
  `id_pagina` int(11) DEFAULT NULL
);
ALTER TABLE `acesso_pagina` ADD PRIMARY KEY (`id_acesso_pagina`);
ALTER TABLE `acesso_pagina` MODIFY `id_acesso_pagina` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `acesso_pagina`
ADD CONSTRAINT `acesso_pagina_ibfk_1` FOREIGN KEY (`id_nivel_acesso`) REFERENCES `nivel_acesso` (`id_nivel_acesso`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `acesso_pagina_ibfk_2` FOREIGN KEY (`id_pagina`) REFERENCES `sys_paginas` (`id_pagina`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- acesso_action
CREATE TABLE IF NOT EXISTS `acesso_action` (
  `id_acesso_action` int(11) NOT NULL,
  `id_nivel_acesso` int(11) DEFAULT NULL,
  `id_action` int(11) DEFAULT NULL
);
ALTER TABLE `acesso_action` ADD PRIMARY KEY (`id_acesso_action`);
ALTER TABLE `acesso_action` MODIFY `id_acesso_action` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `acesso_action`
ADD CONSTRAINT `acesso_action_ibfk_1` FOREIGN KEY (`id_nivel_acesso`) REFERENCES `nivel_acesso` (`id_nivel_acesso`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `acesso_action_ibfk_2` FOREIGN KEY (`id_action`) REFERENCES `sys_actions` (`id_action`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------



-- sys_usuarios_acessos
CREATE TABLE IF NOT EXISTS `sys_usuarios_acessos` (
  `id_usuarios_acesso` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `data_acesso` date DEFAULT NULL,
  `hora_acesso` time DEFAULT NULL,
  `ip_acesso` varchar(255) DEFAULT NULL
);
ALTER TABLE `sys_usuarios_acessos` ADD PRIMARY KEY (`id_usuarios_acesso`);
ALTER TABLE `sys_usuarios_acessos` MODIFY `id_usuarios_acesso` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sys_usuarios_acessos` 
ADD CONSTRAINT `sys_usuarios_acessos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `sys_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- marcas
CREATE TABLE IF NOT EXISTS `marcas` (
  `id_marca` int(11) NOT NULL,
  `nome_marca` varchar(255) DEFAULT NULL,
  `status_marca` enum('ATIVO','INATIVO','EXCLUIDO') NOT NULL DEFAULT 'ATIVO',
  `data_cadastro_marca` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `marcas` ADD PRIMARY KEY (`id_marca`);
ALTER TABLE `marcas` MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT;
-- ----------------------------------------------------------


-- categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(255) DEFAULT NULL,
  `status_categoria` enum('ATIVO','INATIVO','EXCLUIDO') DEFAULT NULL,
  `data_cadastro_categoria` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `categorias` ADD PRIMARY KEY (`id_categoria`), ADD UNIQUE KEY `nome_categoria` (`nome_categoria`);
ALTER TABLE `categorias` MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;
-- ----------------------------------------------------------


-- unidade_medida
CREATE TABLE IF NOT EXISTS `unidade_medida` (
  `id_unidade_medida` int(11) NOT NULL,
  `nome_unidade_medida` varchar(255) NOT NULL,
  `abreviacao_unidade_medida` varchar(10) NOT NULL
);
ALTER TABLE `unidade_medida` ADD PRIMARY KEY (`id_unidade_medida`), ADD UNIQUE KEY `abreviacao_unidade_medida` (`abreviacao_unidade_medida`);
ALTER TABLE `unidade_medida` MODIFY `id_unidade_medida` int(11) NOT NULL AUTO_INCREMENT;
-- ----------------------------------------------------------



-- produtos
CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int(11) NOT NULL,
  `foto_produto` varchar(255) DEFAULT NULL,
  `codigo_barra_gti` varchar(20) DEFAULT NULL,
  `nome_produto` varchar(255) DEFAULT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `descricao_produto` text,
  `status_produto` enum('ATIVO','INATIVO','EXCLUIDO') NOT NULL,
  `data_validade_controlada` tinyint(1) NOT NULL DEFAULT '0',
  `data_cadastro_produto` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `produtos` ADD PRIMARY KEY (`id_produto`);
ALTER TABLE `produtos` MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `produtos` 
ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`),
ADD CONSTRAINT `produtos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
ADD CONSTRAINT `produtos_ibfk_3` FOREIGN KEY (`unidade_medida_venda`) REFERENCES `unidade_medida` (`id_unidade_medida`);
-- ----------------------------------------------------------



-- unidade_medida_produto
CREATE TABLE IF NOT EXISTS `unidade_medida_produto` (
  `id_unidade_medida_produto` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_unidade_medida` int(11) NOT NULL,
  `fator_unidade_medida` decimal(10,2) NOT NULL,
  `para_venda` tinyint(1) NOT NULL DEFAULT '0',
  `para_estoque` tinyint(1) NOT NULL DEFAULT '0',
  `ordem` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `unidade_medida_produto` ADD PRIMARY KEY (`id_unidade_medida_produto`);
ALTER TABLE `unidade_medida_produto` MODIFY `id_unidade_medida_produto` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `unidade_medida_produto`
ADD CONSTRAINT `unidade_medida_produto_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `unidade_medida_produto_ibfk_2` FOREIGN KEY (`id_unidade_medida`) REFERENCES `unidade_medida` (`id_unidade_medida`) ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- produto_fornecedores
CREATE TABLE IF NOT EXISTS `produto_fornecedores` (
  `id_produto_fornecedor` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `id_fornecedor` int(11) DEFAULT NULL
);
ALTER TABLE `produto_fornecedores` ADD PRIMARY KEY (`id_produto_fornecedor`);
ALTER TABLE `produto_fornecedores` MODIFY `id_produto_fornecedor` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `produto_fornecedores`
ADD CONSTRAINT `produto_fornecedores_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `produto_fornecedores_ibfk_2` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- Estrutura da tabela `produtos_preco`
CREATE TABLE IF NOT EXISTS `produtos_preco` (
  `id_produto_preco` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `preco_produto` decimal(10,2) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `preco_padrao` tinyint(1) DEFAULT '0',
  `data_cadastro` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `produtos_preco` ADD PRIMARY KEY (`id_produto_preco`);
ALTER TABLE `produtos_preco` MODIFY `id_produto_preco` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `produtos_preco` ADD CONSTRAINT `produtos_preco_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- estoque
CREATE TABLE IF NOT EXISTS `estoque` (
  `id_estoque` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `estoque` ADD PRIMARY KEY (`id_estoque`);
ALTER TABLE `estoque` MODIFY `id_estoque` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `estoque` ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- nivel_estoque
CREATE TABLE IF NOT EXISTS `nivel_estoque` (
  `id_nivel_estoque` int(11) NOT NULL,
  `id_estoque` int(11) DEFAULT NULL,
  `quantidade_minima` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantidade_maxima` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id_unidade_medida_produto` int(11) DEFAULT NULL,
  `localizacao_estoque` enum('ARMAZEM','PRATELEIRA','DESCARTADOS') DEFAULT 'ARMAZEM'
);
ALTER TABLE `nivel_estoque` ADD PRIMARY KEY (`id_nivel_estoque`);
ALTER TABLE `nivel_estoque` MODIFY `id_nivel_estoque` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `nivel_estoque`
ADD CONSTRAINT `nivel_estoque_ibfk_1` FOREIGN KEY (`id_estoque`) REFERENCES `estoque` (`id_estoque`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `nivel_estoque_ibfk_2` FOREIGN KEY (`id_unidade_medida_produto`) REFERENCES `unidade_medida_produto` (`id_unidade_medida_produto`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- produto_lote
CREATE TABLE IF NOT EXISTS `produto_lote` (
  `id_produto_lote` int(11) NOT NULL,
  `id_estoque` int(11) DEFAULT NULL,
  `codigo_lote` varchar(255) DEFAULT NULL,
  `codigo_barras_gti` varchar(15) DEFAULT NULL,
  `codigo_barras_gst` varchar(255) DEFAULT NULL,
  `data_validade` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `produto_lote` ADD PRIMARY KEY (`id_produto_lote`), ADD UNIQUE KEY `codigo_lote` (`codigo_lote`);
ALTER TABLE `produto_lote` MODIFY `id_produto_lote` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `produto_lote` ADD CONSTRAINT `produto_lote_ibfk_1` FOREIGN KEY (`id_estoque`) REFERENCES `estoque` (`id_estoque`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- localizacao_lote
CREATE TABLE IF NOT EXISTS `localizacao_lote` (
  `id_localizacao_lote` int(11) NOT NULL,
  `id_produto_lote` int(11) DEFAULT NULL,
  `id_unidade_medida_produto` int(11) DEFAULT NULL,
  `localizacao` enum('ARMAZEM','PRATELEIRA','DESCARTADOS') NOT NULL DEFAULT 'ARMAZEM',
  `quantidade_localizacao` decimal(10,2) DEFAULT NULL,
  `observacoes_localizacao_lote` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `localizacao_lote` ADD PRIMARY KEY (`id_localizacao_lote`);
ALTER TABLE `localizacao_lote` MODIFY `id_localizacao_lote` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `localizacao_lote`
ADD CONSTRAINT `localizacao_lote_ibfk_1` FOREIGN KEY (`id_produto_lote`) REFERENCES `produto_lote` (`id_produto_lote`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `localizacao_lote_ibfk_2` FOREIGN KEY (`id_unidade_medida_produto`) REFERENCES `unidade_medida_produto` (`id_unidade_medida_produto`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- caixas
CREATE TABLE IF NOT EXISTS `caixas` (
  `id_caixa` int(11) NOT NULL,
  `codigo_caixa` varchar(255) DEFAULT NULL,
  `ip_maquina` varchar(255) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `caixas` ADD PRIMARY KEY (`id_caixa`), ADD UNIQUE KEY `ip_maquina` (`ip_maquina`);
ALTER TABLE `caixas` MODIFY `id_caixa` int(11) NOT NULL AUTO_INCREMENT;
-- ----------------------------------------------------------


-- abertura_caixa
CREATE TABLE IF NOT EXISTS `abertura_caixa` (
  `id_abertura_caixa` int(11) NOT NULL,
  `id_caixa` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `saldo_inicial` decimal(10,2) DEFAULT NULL,
  `saldo_final` decimal(10,2) NOT NULL,
  `data_abertura_caixa` datetime NOT NULL,
  `data_fechamento_caixa` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `abertura_caixa` ADD PRIMARY KEY (`id_abertura_caixa`);
ALTER TABLE `abertura_caixa` MODIFY `id_abertura_caixa` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `abertura_caixa`
ADD CONSTRAINT `abertura_caixa_ibfk_1` FOREIGN KEY (`id_caixa`) REFERENCES `caixas` (`id_caixa`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `abertura_caixa_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `sys_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- vendas
CREATE TABLE IF NOT EXISTS `vendas` (
  `id_venda` int(11) NOT NULL,
  `id_abertura_caixa` int(11) DEFAULT NULL,
  `data_venda` date DEFAULT NULL,
  `hora_venda` time DEFAULT NULL,
  `forma_pagamento` enum('DINHEIRO','CARTAODEBITO','CARTAOCREDITO') NOT NULL,
  `valor_pago` decimal(10,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `vendas` ADD PRIMARY KEY (`id_venda`);
ALTER TABLE `vendas` MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `vendas` ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_abertura_caixa`) REFERENCES `abertura_caixa` (`id_abertura_caixa`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ----------------------------------------------------------


-- produtos_vendidos
CREATE TABLE IF NOT EXISTS `produtos_vendidos` (
  `id_produto_vendido` int(11) NOT NULL,
  `id_venda` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade_produto_vendido` decimal(10,2) DEFAULT NULL,
  `unidade_medida_vendido` varchar(255) DEFAULT NULL,
  `preco_vendido` decimal(10,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE `produtos_vendidos` ADD PRIMARY KEY (`id_produto_vendido`);
ALTER TABLE `produtos_vendidos` MODIFY `id_produto_vendido` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `produtos_vendidos`
ADD CONSTRAINT `produtos_vendidos_ibfk_1` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id_venda`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `produtos_vendidos_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

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

-- ----------------------------------------------------------


