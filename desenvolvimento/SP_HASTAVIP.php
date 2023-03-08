<?php

$inicializacaocards=(int)organizador_inicia (SITE_SP_HASTAVIP);

$site = 'https://www.hastavip.com.br';

//$paginacao = '1';
//Cada página contém 20 cards
$paginacao=(int)($inicializacaocards/20)+1;


// controle de tempo de execução
$tempolimite = 30;
$tempoinicio=strtotime(date("Y-m-d H:i:s"));

while ($paginacao>0){
	
	$contador_de_cards=20*($paginacao-1);
	
	$pagina = $site.'/Default.aspx?Pag='.$paginacao;
	if ($paginacao=='1'){$pagina = $site;}

	echo '

<br><strong>Página '.$paginacao.'</strong>: '.$pagina;

	$html = mb_convert_encoding(file_get_contents($pagina),'CP1252','UTF-8');
		
	// extrai o filé da página 1
	if ($paginacao==1){$html=isolar($html,'<h1>Leilões','','<h1>Leilões');}

	//navegando em cada card de cada página
	while($cards_isolados=isolar($html,'<div Class="padding-null auction-card col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">','','</a>')){
		$html = str_replace('<div Class="padding-null auction-card col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">'.$cards_isolados,'',$html);
		//até aqui ok

		$contador_de_cards+=1;

//if (contador_de_cards==2){echo '************';exit;}
		
		echo '['.$contador_de_cards.']';
		
		if ($contador_de_cards>=$inicializacaocards){

			$ll_agregador=isolar_limpo($cards_isolados,'<div Class="address">','','</p');
			$url_card=isolar($cards_isolados,'href="','','"');
			$ll_link = $url_card;
			$url_completo = $site.$url_card;

			if (str_replace('/lote/','',$url_completo)!=$url_completo){
				// direcionamento direto para o lote
				// ou seja: só há um lote único
				//fazer a captura aqui
				//echo "link de lote ".$url_completo."<br>";//teste para verificar se o link esta correto
				
				/* Tentativa de fazer a captura das informações*/
				
				 
				 
				$url_card_pesquisados = mb_convert_encoding(file_get_contents($url_completo),'CP1252','UTF-8');
				 
				$url_pesquisar_card= isolar($url_card_pesquisados,'class="btn-group">','','<Button');
				$url_card_pesquisados = str_replace('class="btn-group">',$url_pesquisar_card,'',$url_card_pesquisados);
				$ll_agregador=isolar_limpo($cards_isolados,'<div Class="address">','','</p');
				$link_grid = isolar($url_pesquisar_card,'<a href="/leilao','','"');

				$url_card = $site.$url_card;
				$ll_link = $url_card;						 
				$resp = array();		
				
				$resp['organizador']=SITE_SP_HASTAVIP; // nome do script [int]
				$resp['ll_pais']='BRASIL'; // País [varchar 64]
				$resp['ll_idioma']='pt-BR'; // Idioma do texto [varchar 8]
				$resp['ll_moeda']='BRL'; // Moeda (BRL= Real Brasileiro) [varchar 4]
				$resp['ll_link'] = $ll_link; // link específico deste lote [varchar 512]
				$resp['ll_agregador'] = $ll_agregador; // nome do leilão que inclui os lotes [varchar 128]
													
				if (!VerificaCadastroLeilao($resp)){
					cadastraSP_HASTAVIP($resp);//chamando a função

					//controle de tempo
					$tempoexecucao=strtotime(date("Y-m-d H:i:s"))-$tempoinicio;

					if ($tempoexecucao>=$tempolimite){goto fim_antecipado;}
				}
					
			} else {
				// direcionamento para a página do leilão
				// há vários lotes
				//filtrar o link dos lotes
				
				//echo "link de leilão ".$url_completo."<br>";
				/*Tentativa de fazer a captura do link de cada card */
				
				
				$url_card_pesquisados = mb_convert_encoding(file_get_contents($url_completo),'CP1252','UTF-8');
				$ll_natureza = strtoupper(isolar($url_card_pesquisados,'<span id="Holder_lblCategoria" class="text-capitalize">','','</span>'));
				
				$inicio_isolar = '<div class="col-xs-12 col-sm-6 col-md-3 padding-null lot-card pb-3">';
				$final1_isolar = '';
				$final2_isolar = '"</a>';
				
				
				while($url_pesquisar_card= isolar($url_card_pesquisados,'<div class="col-xs-12 col-sm-6 col-md-3 padding-null lot-card pb-3">','','</a>')){
					$url_card_pesquisados= str_replace('<div class="col-xs-12 col-sm-6 col-md-3 padding-null lot-card pb-3">'.$url_pesquisar_card,'',$url_card_pesquisados);

					$ll_cetegoria_rotulo = isolar($url_pesquisar_card,'<p class="ng-binding">','','</p>	');
						
					$link_card = isolar($url_pesquisar_card,'<a href="','','"');
					$link_leilao_card = 'https://www.hastavip.com.br'.$link_card;
					
					$url_pesquisar_card= isolar($url_card_pesquisados,'class="btn-group">','','<Button');
					//$url_card_pesquisados = str_replace('class="btn-group">',$url_pesquisar_card,'',$url_card_pesquisados);
					$ll_agregador=isolar_limpo($cards_isolados,'<div Class="address">','','</p');
					$link_grid = isolar($url_pesquisar_card,'<a href="/leilao','','"');
				
					$ll_link = $link_leilao_card;						 
					
					$resp = array();
					
					$resp['organizador']=SITE_SP_HASTAVIP; // nome do script [int]
					$resp['ll_pais']='BRASIL'; // País [varchar 64]
					$resp['ll_idioma']='pt-BR'; // Idioma do texto [varchar 8]
					$resp['ll_moeda']='BRL'; // Moeda (BRL= Real Brasileiro) [varchar 4]
					$resp['ll_link'] = $ll_link; // link específico deste lote [varchar 512]
					$resp['ll_agregador'] = $ll_agregador; // nome do leilão que inclui os lotes [varchar 128]
					$resp['ll_agregador_link'] = $url_completo; // link para ver todos os lotes (leilão que inclui os lotes) [varchar 512]
					
					$resp['ll_natureza']=0;
					if(str_replace('JUDICIAL','',$ll_natureza)!=$ll_natureza && str_replace('EXTRA','',$ll_natureza)==$ll_natureza){$resp['ll_natureza']=1;}
					
					$ll_categoria = $ll_cetegoria_rotulo;// texto da última categoria ao qual o lote de enquadra. Exemplo: "UTILITÁRIOS" ,"TRATOR", "TERRENO", "APARTAMENTO", "CASA" ** SEMPRE QUE SE TRATAR DE SUCATA, CADASTRAR COM O TERMO "SUCATA" [varchar 64]


					if (!VerificaCadastroLeilao($resp)){
						cadastraSP_HASTAVIP($resp,$ll_categoria);//chamando a função

						//controle de tempo
						$tempoexecucao=strtotime(date("Y-m-d H:i:s"))-$tempoinicio;
						if ($tempoexecucao>=$tempolimite){goto fim_antecipado;}
					}
				
				}

	//exit;
			}
		}
	}

	$paginacao_anterior=$paginacao;
	$paginacao=0; 
	
	if (str_replace('Pag='.($paginacao_anterior+1).'"','',$html)!=$html){
		$paginacao=$paginacao_anterior+1;
	}


}
goto fim;
fim_antecipado:
echo '<br>Terminou antes do previsto. Tempo de execução: '.$tempoexecucao.'s
$contador_de_cards='.$contador_de_cards;
organizador_tempo_limite_atingido (SITE_SP_HASTAVIP,$contador_de_cards);
goto fim2;

fim:
organizador_finaliza (SITE_SP_HASTAVIP);
echo '<br>Terminei tudo. Tempo de execução: '.$tempoexecucao.'s';

fim2:


function cadastraSP_HASTAVIP($resp,$ll_categoria=''){


	$texto_extraido = mb_convert_encoding(file_get_contents($resp['ll_link']),'CP1252','UTF-8');		
	
//echo $texto_extraido;						
	$agregador = isolar($texto_extraido,'<span id="Holder_lblTitulo1">','','</span>');
	$lanceatual= isolar($texto_extraido,'<span id="Holder_lblIncremento">','','</span>'); 
	
	// páginas de lotes que não passaram pela página do leilão...
	if (!isset($resp['ll_agregador_link'])){
		$ll_agregador_link = 'https://www.hastavip.com.br/leilao/'.isolar($texto_extraido,' <a href="/leilao/','','"');
		$html_link_conteudo_extra = mb_convert_encoding(file_get_contents($ll_agregador_link),'CP1252','UTF-8');	

		$ll_natureza = strtoupper(isolar($html_link_conteudo_extra,'<span id="Holder_lblCategoria" class="text-capitalize">','','</span>'));
		$resp['ll_natureza']=0;
		if(str_replace('JUDICIAL','',$ll_natureza)!=$ll_natureza && str_replace('EXTRA','',$ll_natureza)==$ll_natureza){$resp['ll_natureza']=1;}
		$resp['ll_agregador_link'] = $ll_agregador_link; // link para ver todos os lotes (leilão que inclui os lotes) [varchar 512]
		$ll_categoria = isolar($html_link_conteudo_extra,'<p class="ng-binding">','','</p>	');
	}


	//$ll_comitente = isolar($html_link_conteudo_extra,'<span id="Holder_lblLeiloeiro" class="text-capitalize">','','</span>');//******verificar se esta correto */	
	$ll_data_1 = sonumeros(isolar($texto_extraido,'<span id="Holder_lblPrimeiroLeilao">','','<br>'));//verificar caracter especial
	$ll_data_2 = sonumeros(isolar($texto_extraido,'<span id="Holder_lblSegundoLeilao">','','<br>'));//verificar caracter especial
	$ll_processo = isolar($texto_extraido,'<em class="fa fas fa-paperclip"></em> <u>','','</u>');//verificar caracter especial
	$ll_endereco = isolar($texto_extraido,'<span id="Holder_lblEndereco">','','Bairro:');
	$ll_bairro = isolar($texto_extraido,'Bairro:','','</span>');
	$ll_cidade = isolar($texto_extraido,'<span id="Holder_lblCidade">','','</span>');
	$ll_uf = isolar($texto_extraido,'<span id="Holder_lblUF">','','</span>');
	$ll_detalhes = isolar($texto_extraido,'<span id="Holder_lblDescricao">','','</span>');
	$ll_avaliacao = str_replace('R$','',str_replace(',','.',str_replace('.','',isolar($texto_extraido,'<span id="Holder_lblAvaliacao">','','</span>'))));//verificar caracter especial
	$ll_categoria_txt = isolar($texto_extraido,'<span id="Holder_lblSubClasse">','','</span>');
	$ll_numero = isolar($texto_extraido,'<em class="far fa-check-square mr-2"></em> Cod:','','</span>');//não funcionou
	$ll_descricao = isolar($texto_extraido,'<h1><span id="Holder_lblTitulo1">','','</span>');
	$ll_lote = isolar($texto_extraido,'<span id="Holder_lblLoteNumero">','','</span>');
	$ll_lance_min_1 = trim(str_replace('R$','',str_replace(',','.',str_replace('.','',str_replace('</strike>','',isolar($texto_extraido,'<span id="Holder_lblPrimeiroLeilao">','<br>','</span>'))))));
	$ll_lance_min_2 = trim(str_replace('R$','',str_replace(',','.',str_replace('.','',isolar($texto_extraido,'<span id="Holder_lblSegundoLeilao">','<br>','</span>')))));//verificar caracter especial
	

	//Captura das fotos
	$contapix=0;
	$pix0=$texto_extraido;
	while(  $pix=isolar($pix0,'<img data-u="image" src="','','"') ) {
		$pix0=str_replace('<img data-u="image" src="'.$pix,'', $pix0);

		if($pix != "/siteCSS/hastavip/lote-diversos.jpg" && $pix != "/siteCSS/hastavip/lote-maquina.jpg" && $pix != "/siteCSS/hastavip/lote-carro.jpg" && $pix != "/siteCSS/hastavip/lote-imovel.jpg"){
			$contapix+=1;
			if ($contapix<=8){
				$resp['ll_foto_'.$contapix]=$pix;
			} else {
				$pix0='';
			}
		}
	}


	$mapa = isolar($texto_extraido,'<div class="tab-pane active" id="home" role="tabpanel">','<iframe src="','"');
	$html_link_conteudo_extra = mb_convert_encoding(file_get_contents($mapa),'CP1252','UTF-8');
	$ll_latitude = isolar($html_link_conteudo_extra,'<input id="coordslat" type="hidden" value="','','">');
	$ll_longitude = isolar($html_link_conteudo_extra,'<input id="coordslng" type="hidden" value="','',',');

	
	//$resp['ll_venda_direta'] = $ll_venda_direta; // 0=não; 1=sim [int]
	
	//$resp['ll_comitente']= $ll_comitente;//***sem nome // nome do comitente do lote [varchar 256]
	$resp['ll_lote']= $ll_lote; // número do lote [varchar 8]
	$resp['ll_obs'] = $ll_obs; // observações relevantes, quando disponíveis [varchar 256]
	$resp['ll_avaliacao'] = $ll_avaliacao; // valor de avaliação, quando disponível [varchar 32]
	
	$resp['ll_descricao'] = $ll_descricao;// descrição sintética do lote (título) [varchar 256]
	$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
		str_replace(chr(10),' ',str_replace('<br>','.~ ',$ll_detalhes))))))))));
	
	// tratamento do endereço
	if ($ll_endereco==''){$ll_endereco=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','/')))));}
	if ($ll_endereco==''){$ll_endereco=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','-')))));}
	if ($ll_endereco==''){
		$ll_endereco=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',strtolower($resp['ll_detalhes']))))),'situado','',$resp['ll_cidade']))))).' '.$resp['ll_cidade'];
		if ($ll_endereco==''){
			$ll_endereco0=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))).'§©§','situado','','§©§')))));
			if ($ll_endereco0!=''){
				$ll_endereco=isolar('§'.$ll_endereco,'§','',',').', '.isolar($ll_endereco,',','',',').', '.isolar($ll_endereco,',',',',',').'/';

			}
		}
	}

	$resp['ll_latitude'] = $ll_latitude; // latitude. Quando for imóvel, coordenada exata da localização. Quando outra categoria sem esta informação, incluir coordenada do pátio do leiloeiro [varchar 32]
	$resp['ll_longitude'] = $ll_longitude;// longitude. Quando for imóvel, coordenada exata da localização. Quando outra categoria sem esta informação, incluir coordenada do pátio do leiloeiro [varchar 32] 
	$resp['ll_endereco'] = $ll_endereco;// Endereço. Quando for imóvel, usar sua localização. Quando outra categoria sem esta informação, incluir localização do pátio do leiloeiro [varchar 256]
	$resp['ll_bairro'] = $ll_bairro;// bairro. Quando for imóvel, usar sua localização. Quando outra categoria sem esta informação, incluir localização do pátio do leiloeiro [varchar 128]
	$resp['ll_cidade'] = $ll_cidade;// cidade [varchar 128]
	$resp['ll_uf'] = $ll_uf;// UF/ sigla do estado [varchar 2]

	if ($ll_endereco!='' && ($resp['ll_latitude']=='' || $resp['ll_longitude']=='')){

		$geolocalizacao=geolocalizacao($ll_endereco,$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf']);

		if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
		if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

		if ($geolocalizacao[2]!='' && $resp['ll_uf']==''){$resp['ll_uf']=$geolocalizacao[2];}
		if ($geolocalizacao[3]!='' && $resp['ll_cidade']==''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
		if ($geolocalizacao[4]!='' && $resp['ll_bairro']==''){$resp['ll_bairro']=$geolocalizacao[4];}

	}
	
	$resp['ll_data_1'] = substr($ll_data_1,4,4).substr($ll_data_1,2,2).substr($ll_data_1,0,2).substr($ll_data_1,8,4);// data da primeira praça [YYYYmmddHHii]
	$resp['ll_lance_min_1'] = $ll_lance_min_1; // lance mínimo da primeira praça [varchar 32]
	$resp['ll_data_2'] = substr($ll_data_2,4,4).substr($ll_data_2,2,2).substr($ll_data_2,0,2).substr($ll_data_2,8,4);;// data da segunda praça, quando houver [YYYYmmddHHii]						 
	$resp['ll_lance_min_2'] = $ll_lance_min_2; // lance mínimo da segunda praça [varchar 32]
	$resp['ll_processo'] = $ll_processo;// número do processo, quando disponível [varchar 64]
	$resp["ll_avaliacao"] = $ll_avaliacao;
	$resp["ll_numero"] = $ll_numero;
	$resp['ll_descricao'] = $ll_descricao;// descrição sintética do lote (título) [varchar 256]
	$resp['ll_marca'] = $ll_marca; //'TOYOTA' //  [varchar 64]
	$resp['ll_modelo'] = $ll_modelo;// 'YARIS' //  [varchar 64]
	$resp['ll_capacidade'] = $ll_capacidade; //  [varchar 32]
	$resp['ll_ano_modelo'] = $ll_ano_modelo;// '2007' //  [varchar 16]
	$resp['ll_placa'] = $ll_placa;// 'ABC-1234' //  [varchar 16]
	$resp['ll_setor'] = $ll_setor; //  [varchar 64]
	$resp['ll_quilometragem'] = $ll_quilometragem;// '150000' //  [varchar 16]
	$resp['ll_cor'] = $ll_cor;// 'CINZA' // [varchar 16]
	$resp['ll_combustivel'] = $ll_combustivel;// 'GASOLINA' //  [varchar 16]
	$resp['ll_area_terreno'] = $ll_area_terreno; // '250' //  [varchar 32]
	$resp['ll_area_construida'] = $ll_area_construida;// '150'; //   [varchar 32]
	$resp['ll_area_util'] = $ll_area_util;// '100'; //   [varchar 32]
	$resp['ll_area_total'] = $ll_area_total;// '980'; //   [varchar 32]
	$resp['ll_dormitorios'] = $ll_dormitorios; //'2'; //   [varchar 32]

	$resp['ll_categoria_txt']=$ll_categoria;
	$resp['ll_categoria_rotulo']=$ll_categoria;

	if ($ll_categoria_txt!='' && $ll_categoria_txt!=$ll_categoria){
		$resp['ll_categoria_txt'].=','.$ll_categoria_txt;
		$resp['ll_categoria_rotulo']=$ll_categoria_txt;
	}

	if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) || str_replace('SUCATA','',strtoupper($resp['ll_agregador']))!=strtoupper($resp['ll_agregador'])){
		$resp['ll_categoria_txt'].=','.'SUCATAS';
		$resp['ll_categoria_rotulo']=' SUCATAS';
	}
		

	//print_r($resp); //exit;
	echo NovoLeilao ($resp,array(),0.15,0.15,0,0);
	
}

?>

