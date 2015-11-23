CREATE TABLE IF NOT EXISTS `emails` (
`id_email` int(11) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `endereco_email` varchar(255) DEFAULT NULL,
  `tipo_email` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `enderecos` (
`id_endereco` int(11) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
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

CREATE TABLE IF NOT EXISTS `fornecedores_agenda` (
`id_fornecedor_agenda` int(11) NOT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `titulo_agenda` varchar(255) DEFAULT NULL,
  `observacoes_agenda` text,
  `data_agenda` date DEFAULT NULL,
  `data_cadastro_agenda` datetime NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

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
);

CREATE TABLE IF NOT EXISTS `telefones` (
`id_telefone` int(11) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `categoria_telefone` varchar(255) DEFAULT NULL,
  `numero_telefone` varchar(255) DEFAULT NULL,
  `tipo_telefone` varchar(255) DEFAULT NULL,
  `operadora_telefone` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

ALTER TABLE `emails`
 ADD PRIMARY KEY (`id_email`), ADD KEY `id_funcionario` (`id_funcionario`), ADD KEY `id_fornecedor` (`id_fornecedor`);

ALTER TABLE `enderecos`
 ADD PRIMARY KEY (`id_endereco`), ADD KEY `id_funcionario` (`id_funcionario`), ADD KEY `id_fornecedor` (`id_fornecedor`);

ALTER TABLE `fornecedores`
 ADD PRIMARY KEY (`id_fornecedor`);

ALTER TABLE `fornecedores_agenda`
 ADD PRIMARY KEY (`id_fornecedor_agenda`), ADD KEY `id_fornecedor` (`id_fornecedor`);

ALTER TABLE `funcionarios`
 ADD PRIMARY KEY (`id_funcionario`), ADD KEY `id_estado_civil` (`estado_civil_funcionario`), ADD KEY `id_escolaridade` (`escolaridade_funcionario`), ADD KEY `id_cargo` (`cargo_funcionario`);

ALTER TABLE `telefones`
 ADD PRIMARY KEY (`id_telefone`), ADD KEY `id_funcionario` (`id_funcionario`), ADD KEY `id_fornecedor` (`id_fornecedor`);

ALTER TABLE `emails`
MODIFY `id_email` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;

ALTER TABLE `enderecos`
MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;

ALTER TABLE `fornecedores`
MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;

ALTER TABLE `fornecedores_agenda`
MODIFY `id_fornecedor_agenda` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `funcionarios`
MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=53;

ALTER TABLE `telefones`
MODIFY `id_telefone` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;

ALTER TABLE `emails`
ADD CONSTRAINT `emails_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `emails_ibfk_2` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `enderecos`
ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `enderecos_ibfk_2` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `fornecedores_agenda`
ADD CONSTRAINT `fornecedores_agenda_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `telefones`
ADD CONSTRAINT `telefones_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `telefones_ibfk_2` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`) ON DELETE CASCADE ON UPDATE CASCADE;

