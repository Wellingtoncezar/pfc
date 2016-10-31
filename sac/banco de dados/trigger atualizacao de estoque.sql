

begin
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