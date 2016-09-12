# Privileges for `funcionarios`@`localhost`

GRANT SELECT, INSERT, UPDATE, DELETE, FILE, EVENT, TRIGGER ON *.* TO 'funcionarios'@'localhost' IDENTIFIED BY PASSWORD '*6965F3E7FBA889647CC91CF74CC2B3B493E5F7B9';

GRANT SELECT, INSERT, UPDATE, DELETE, EVENT, TRIGGER ON `sac`.* TO 'funcionarios'@'localhost';

GRANT SELECT, INSERT, UPDATE, REFERENCES ON `sac`.`fornecedores_agenda` TO 'funcionarios'@'localhost';

GRANT SELECT, INSERT, UPDATE, REFERENCES ON `sac`.`fornecedores` TO 'funcionarios'@'localhost';






# Privileges for `gerencia`@`localhost`

GRANT USAGE ON *.* TO 'gerencia'@'localhost' IDENTIFIED BY PASSWORD '*B2552112BB1980A174B3A6FC5C22280C0126CB0F';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`telefones_fornecedores` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`fornecedores_agenda` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`produtos` TO 'gerencia'@'localhost';

GRANT SELECT ON `sac`.`sys_paginas` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`orcamentos` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`checkout` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`categorias` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`emails` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`requisicao_usuario` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`funcionarios` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`estoque` TO 'gerencia'@'localhost';

GRANT SELECT ON `sac`.`nivel_acesso` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`enderecos` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`fornecedores` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`abertura_caixa` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`telefones_funcionarios` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`orcamento_produto` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`unidade_medida` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`requisicoes` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`cargos` TO 'gerencia'@'localhost';

GRANT SELECT, UPDATE ON `sac`.`sys_usuarios` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`produto_fornecedores` TO 'gerencia'@'localhost';

GRANT SELECT ON `sac`.`sys_actions` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`telefones` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`requisicao_produto` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`emails_fornecedores` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`produto_lote` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`fornecedores_agenda_notificado` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`enderecos_fornecedores` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`enderecos_funcionarios` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`marcas` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`emails_funcionarios` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`vendas` TO 'gerencia'@'localhost';

GRANT SELECT ON `sac`.`sys_modulos` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`unidade_medida_produto` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE ON `sac`.`sys_usuarios_acessos` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`cotacoes` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`produtos_vendidos` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`localizacao_lote` TO 'gerencia'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, INDEX, TRIGGER ON `sac`.`nivel_estoque` TO 'gerencia'@'localhost';



# Privileges for `userlogin`@`localhost`

GRANT SELECT ON *.* TO 'userlogin'@'localhost' IDENTIFIED BY PASSWORD '*B2552112BB1980A174B3A6FC5C22280C0126CB0F';

GRANT SELECT, UPDATE, REFERENCES, TRIGGER ON `sac`.`sys_usuarios` TO 'userlogin'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, TRIGGER ON `sac`.`sys_usuarios_acessos` TO 'userlogin'@'localhost';

GRANT SELECT ON `sac`.`funcionarios` TO 'userlogin'@'localhost';

GRANT SELECT ON `sac`.`nivel_acesso` TO 'userlogin'@'localhost';