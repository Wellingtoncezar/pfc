/*TRIGGER DE BAIXA DE ESTOQUE*/
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



/*EVENTO DE DESCARTE DE LOTE*/
CREATE DEFINER=`root`@`localhost` EVENT `descarteprodutovencido` ON SCHEDULE EVERY 1 MINUTE STARTS '2016-11-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO begin
	DECLARE IDESTOQUE int;
	DECLARE IDNIVELESTOQUE INT;
	DECLARE cursor_ID INT;
  	DECLARE done INT DEFAULT FALSE;
  	DECLARE cursor_i CURSOR FOR 
    	SELECT 
            localizacao_lote.id_localizacao_lote,
            estoque.id_estoque
        FROM 
            localizacao_lote
        INNER JOIN produto_lote ON produto_lote.id_produto_lote = localizacao_lote.id_produto_lote
        INNER JOIN estoque ON estoque.id_estoque = produto_lote.id_estoque
        INNER JOIN produtos ON produtos.id_produto = estoque.id_produto
        WHERE
            produtos.data_validade_controlada = true
            AND produto_lote.data_validade < current_date;
        
  	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  	OPEN cursor_i;
  	read_loop: LOOP
    	FETCH cursor_i INTO cursor_ID, IDESTOQUE;
    	IF done THEN
      		LEAVE read_loop;
    	END IF;
        
        /*VERIFICANDO SE JA EXISTE O NIVEL DE ESTOQUE*/
        SELECT id_nivel_estoque into IDNIVELESTOQUE FROM `nivel_estoque` where id_estoque = IDESTOQUE AND localizacao_estoque = 'DESCARTADOS';
       	/*se não tiver*/
        IF IDNIVELESTOQUE IS NULL THEN
        	INSERT INTO nivel_estoque (id_estoque, localizacao_estoque) VALUES(IDESTOQUE, 'DESCARTADOS');
       	END IF;
       
       	/*ATUALIZAÇÃO DA LOCALIZAçÃO*/
        update 
            localizacao_lote, produto_lote 
        set 
            localizacao_lote.localizacao='DESCARTADOS' 
        WHERE 
            localizacao_lote.id_localizacao_lote = cursor_ID 
            AND localizacao_lote.id_produto_lote = produto_lote.id_produto_lote;
            
       	SET IDNIVELESTOQUE = NULL;
        
        
 	END LOOP;
  	CLOSE cursor_i;

end


/*TRIGGER DE EXCLUSÃO DE USUÁRIOS*/
CREATE TRIGGER `excluiusuario` BEFORE UPDATE ON `funcionarios`
 FOR EACH ROW begin
	if new.status_funcionario = 'EXCLUIDO' then
    	delete from sys_usuarios where id_funcionario = new.id_funcionario;
    end if;
end
