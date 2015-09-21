-- Módulos do sistema
create table sys_modulos(
	id_modulo int auto_increment primary key,
	slug_modulo varchar(255) not null,
	nome_modulo varchar(255),
	posicao_modulo varchar(255),
	status_modulo varchar(255), /*status de visualização*/
	status_selecao_modulo varchar(255), /*status para seleção no grupo de usuários*/
	id_modulo_pai int references sys_modulos(id_modulo) on delete cascade on update cascade,
	icone_modulo varchar(255),
	data_criacao_modulo datetime
);
-- Páginas relacionadas aos módulos
create table sys_paginas(
	id_pagina int auto_increment primary key,
	slug_pagina varchar(255),
	nome_pagina varchar(255),
	posicao_pagina int,
	status_pagina varchar(255), /*status de visualização*/
	status_selecao_pagina varchar(255), /*status para seleção no grupo de usuários*/
	id_modulo int references sys_modulos(id_modulo) on delete cascade on update cascade,
	data_criacao_pagina datetime
);
-- Ações relacionadas as páginas
create table sys_actions(
	id_action int auto_increment primary key,
	slug_action varchar(255),	
	nome_action varchar(255),
	status_action varchar(255), /*status de visualização*/
	status_selecao_action varchar(255), /*status para seleção no grupo de usuários*/
	id_pagina int references sys_paginas(id_pagina) on delete cascade on update cascade,
	posicao_action int,
	data_criacao_pagina datetime
);

-- Grupo de usuários - acesso ao sistema
create table sys_usuarios_grupo(
	id_usuarios_grupo int auto_increment primary key,
	nome_usuarios_grupo varchar(255),
	data_criacao_grupo datetime,
	data_atualizacao_grupo datetime
);

-- Módulo de acesso ao sistema, por grupo de usuários
create table sys_acesso_modulo(
	id_acesso_modulo int auto_increment primary key,
	id_usuarios_grupo int references sys_usuarios_grupo(id_usuarios_grupo) on delete cascade on update cascade,
	id_modulo int references sys_modulos(id_modulo) on delete cascade on update cascade,
	timestamp_acesso_modulo timestamp
);

-- Páginas de acesso ao sistema, por grupo de usuários
create table sys_acesso_pagina(
	id_acesso_pagina int auto_increment primary key,
	id_usuarios_grupo int references sys_usuarios_grupo(id_usuarios_grupo) on delete cascade on update cascade,
	id_pagina int references sys_paginas(id_pagina) on delete cascade on update cascade,
	id_acesso_modulo int references sys_acesso_modulo(id_acesso_modulo),
	timestamp_acesso_modulo timestamp
);

-- Ações de acesso ao sistema, por grupo de usuários
create table sys_acesso_action(
	id_acesso_action int auto_increment primary key,
	id_usuarios_grupo int references sys_usuarios_grupo(id_usuarios_grupo) on delete cascade on update cascade,
	id_action int references sys_actions(id_action) on delete cascade on update cascade,
	id_acesso_pagina int references sys_acesso_pagina(id_acesso_pagina),
	timestamp_acesso_modulo timestamp
);

create table estado_civil(
	id_estado_civil int auto_increment primary key,
	nome_estado_civil varchar(255),
	status_estado_civil varchar(255),
	data_criacao_estado_civil datetime,
	data_atualizacao_estado_civil datetime
);


create table cargos(
	id_cargo int auto_increment primary key,
	nome_cargo varchar(255),
	status_cargo varchar(255),
	data_criacao_cargo datetime,
	data_atualizacao_cargo datetime
);

create table escolaridade(
	id_escolaridade int auto_increment primary key,
	nome_escolaridade varchar(255),
	status_escolaridade varchar(255),
	data_criacao_escolaridade datetime,
	data_atualizacao_escolaridade datetime
);




-- funcionarios
create table funcionarios(
	id_funcionario int primary key auto_increment,
	foto_funcionario varchar(255),
	nome_funcionario varchar(255) not null,
	sobrenome_funcionario varchar(255) not null,
	data_nascimento_funcionario date not null,
	sexo_funcionario char(1) not null,
	naturalidade_funcionario varchar(255),
	nacionalidade_funcionario varchar(255),
	rg_funcionario varchar(255),
	cpf_funcionario varchar(255) not null,
	id_estado_civil int,
	id_escolaridade int references escolaridade(id_escolaridade) on update cascade,
	codigo_inscricao varchar(255),
	id_cargo int references cargos(id_cargo) on update cascade,
	data_admissao date,
	salario numeric(10,2),
	data_criacao_funcionario datetime
);

create table enderecos(
	id_endereco int auto_increment primary key,
	id_funcionario int references funcionarios(id_funcionario) on delete cascade on update cascade,
	cep_endereco varchar(255),
	rua_endereco varchar(255),
	numero_endereco int,
	complemento_endereco varchar(255),
	bairro_endereco varchar(255),
	cidade_endereco varchar(255),
	estado_endereco varchar(255),
	pais_endereco varchar(255),
	data_cadastro_endereco datetime,
	data_atualizacao_endereco datetime
);	 

create table tipo_telefone(
	id_tipo_telefone int auto_increment primary key,
	nome_tipo_telefone varchar(255),
	status_tipo_telefone varchar(255),/*Ativo, Inativo ou excluído*/
	data_cadastro datetime
);

create table telefones(
	id_telefone int auto_increment primary key,
	id_funcionario int references funcionarios(id_funcionario) on delete cascade on update cascade,
	numero_telefone varchar(255),
	categoria_telefone varchar(255),/*refere-se à telefone ou celular, conforme o tipo selecionado*/
	operadora_telefone varchar(255),
	tipo_telefone int,/* referencia para os tipos de telefone*/
	data_cadastro_telefone datetime,
	FOREIGN key (tipo_telefone) references tipo_telefone(id_tipo_telefone) on update cascade,
	FOREIGN key (id_funcionario) references funcionarios (id_funcionario) on delete cascade
);

create table tipo_email(
	id_tipo_email int auto_increment primary key,
	nome_tipo_email varchar(255),
	status_tipo_email varchar(255),/*Ativo, Inativo ou Excluído*/
	data_cadastro datetime
);

create table emails(
	id_email int auto_increment primary key,
	id_funcionario int references funcionarios(id_funcionario) on delete cascade on update cascade,
	id_tipo_email int references tipo_email(id_tipo_email) on update cascade,
	email varchar(255),
	data_cadastro_email datetime,
	FOREIGN key (id_tipo_email) references tipo_email(id_tipo_email),
	FOREIGN key (id_funcionario) references funcionarios (id_funcionario) on delete cascade
);






-- Usuários do sistema
create table sys_usuarios(
	id_usuario int auto_increment primary key,
	id_funcionario int references funcionarios(id_funcionario) on delete cascade on update cascade,
	id_usuarios_grupo int references sys_usuarios_grupo(id_usuarios_grupo) on update cascade,
	email_usuario varchar(255) not null unique,
	login_usuario varchar(255) not null unique,
	senha_usuario varchar(255) not null,
	hash_acesso text,
	status_usuario varchar(255),
	data_criacao_usuario datetime,
	data_atualizacao_usuario datetime
);












