<?php
/*
G U R U B O T
Módulo Leilões SP_HASTA_PUBLICA
(c) 2019 10 Marcelon
v2 2019 12
*/


set_time_limit (600);
$atingiutempolimite=false;
$tempoinicio_SP_HASTA_PUBLICA=date("YmdHis");
$r['extra']=organizador_inicia (SITE_SP_HASTA_PUBLICA);

$lotescadastrados=0;

$proximo_card=explode('/',$r['extra'].'///');

$conta=0;
$conta_cards=0;
$conta_principais=0;
$conta_cards_internos=0;


$proximo_card[1]=max((int)$proximo_card[1],1); // página
$proximo_card[2]=max((int)$proximo_card[2],1); // principal

$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:70.0) Gecko/20100101 Firefox/70.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' --compressed -H 'DNT: 1' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1'";
$resposta=http_post_curl_headers ('https://www.hastapublica.com.br/', $header, '', '', true, false, false, '', true, 'GET');
        //http_post_curl_headers ($url, $header, $fields, $cookies='',$limpa=true, $json=false, $xml=false, $json_montado='',$ssl_ignora=false,$request="POST", $gravaarquivo=false){
$texto_original=isolar($resposta['content'],'<ul class="showCategoria"','','</ul');
//echo '***'.$texto_original; exit;

while(  $texto_busca=isolar($texto_original,'<li','','</li') ) { // modalidade (?) ============
	$texto_original=str_replace('<li'.$texto_busca,'', $texto_original);

	$principal_link=trim(isolar($texto_busca,'idx="','','"'));
	$ll_categoria_txt=trim(limpahtml($texto_busca));

	$conta_principais+=1;

	if ($conta_principais>=$proximo_card[2] && $principal_link!=''){
		echo '<br><strong>'.$ll_categoria_txt.'</strong>: '; 

//exit;		

		while ($proximo_card[1]>0){ // paginação =====================

			echo '<br><i>Página '.$proximo_card[1].'</i>: ';
//exit;
			$linkpagina='';
			if ((int)$proximo_card[1]>1){$linkpagina=9*($proximo_card[1]-1);}

			$resposta=http_post_curl_headers ('https://www.hastapublica.com.br/busca/'.$linkpagina.'?id_categoria='.$principal_link.'&id_sub_categoria=&localidade=&data=&id_leilao=&palavra=', $header, '', '', true, false, false, '', true, 'GET');
			        //http_post_curl_headers ($url, $header, $fields, $cookies='',$limpa=true, $json=false, $xml=false, $json_montado='',$ssl_ignora=false,$request="POST", $gravaarquivo=false){
			$texto_com_cards=$resposta['content'];

//echo $texto_com_cards; exit;
			while(  $texto_lote=isolar($texto_com_cards,'<li class="card card-leilao">','','</li') ) {
				$texto_com_cards=str_replace('<li class="card card-leilao">'.$texto_lote,'', $texto_com_cards);

//echo $texto_lote; //exit;

				$ll_link=trim(isolar($texto_lote,'href="','','"'));

				$conta_cards+=1;

				if ($ll_link!=''){
//				if ($conta_cards>=$proximo_card[0] && $ll_link!=''){

//echo $texto_lote;

					$resp=array();
					$resp['organizador']=SITE_SP_HASTA_PUBLICA;
					$resp['ll_pais']='BRASIL';
					$resp['ll_idioma']='pt-BR';
					$resp['ll_moeda']='BRL';
					$resp['ll_link']=$ll_link;
					$resp['ll_lote']=isolar_limpo(str_replace('Nº','',str_replace('N°','',$texto_lote)),'<dd>','','</');
					$resp['ll_comitente']=trim(isolar_limpo($texto_lote,'</dl','</dl','</dl'));
					$endereco=isolar_limpo($texto_lote,'descricao col-12">','','</dt');
					$resp['ll_uf']=substr($endereco,-2);
					$resp['ll_cidade']=isolar_reverso('§©§'.$endereco,'§©§','/');
					$resp['ll_descricao']=isolar_limpo($texto_lote,'titleInsideLote','','</dd');

					$pracas=isolar($texto_lote,'<dt>Incremento</dt>','</div','<div class="card-footer">');
					$praca2=isolar($pracas.'§©§','</div','</div','§©§');
					$resp['ll_data_1']=arrumadata_robos(str_replace(' ','/',str_replace('H','',str_replace(' às ','/',isolar_limpo($pracas,'<dd','','</dd')))),6,true);
					$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo(str_replace('R$','',$pracas),'</dd','<dd','</dd')));
					$resp['ll_data_2']=arrumadata_robos(str_replace(' ','/',str_replace('H','',str_replace(' às ','/',isolar_limpo($praca2,'<dd','','</dd')))),6,true);
					$resp['ll_lance_min_2']=str_replace(',','.',str_replace('.','',isolar_limpo(str_replace('R$','',$praca2),'</dd','<dd','</dd')));

//print_r($resp); exit;

					cadastra_SITE_SP_HASTA_PUBLICA ($resp,$ll_categoria_txt);

					// ==================================
					$conta+=1;
							//if ($conta>5){exit;}
					// ==================================
					$tempoexecucao_SP_HASTA_PUBLICA=diferencasegundos( $tempoinicio_SP_HASTA_PUBLICA ,'');

					if ($tempoexecucao_SP_HASTA_PUBLICA>30) {
						// atingiu tempo limite.
						$atingiutempolimite=true;
						goto fimdolaco;
					}
				}
			}
	
			$conta_cards=0;

			if (str_replace('https://www.hastapublica.com.br/busca/'.(9*$proximo_card[1]).'?','',$texto_com_cards)!=$texto_com_cards){
				$proximo_card[1]+=1;
			} else {
				$proximo_card[1]=0;$proximo_card[2]+=1;
			}


		}
		$proximo_card[1]=1;
	}
}

$proximo_card[2]=0;

fimdolaco:


if ($atingiutempolimite==true){
	// não terminou!
    organizador_tempo_limite_atingido (SITE_SP_HASTA_PUBLICA,$conta_cards."/".$proximo_card[1]."/".$proximo_card[2]);
echo '***
tempo limite
'; 
} else {
	echo '**** Finalizou tudo';
    organizador_finaliza (SITE_SP_HASTA_PUBLICA);
}

function cadastra_SITE_SP_HASTA_PUBLICA ($resp,$ll_categoria_txt){
//print_r($resp); //exit;
	if (!VerificaCadastroLeilao($resp)){ 

		$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:70.0) Gecko/20100101 Firefox/70.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' --compressed -H 'DNT: 1' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1'";
		$resposta=http_post_curl_headers ($resp['ll_link'], $header, '', '', true, false, false, '', true, 'GET');
		        //http_post_curl_headers ($url, $header, $fields, $cookies='',$limpa=true, $json=false, $xml=false, $json_montado='',$ssl_ignora=false,$request="POST", $gravaarquivo=false){
		$texto_lote=$resposta['content'];

		$ll_sub_categoria=isolar_limpo($texto_lote,'<article','</li','</li');
		$resp['ll_agregador']=isolar_limpo($texto_lote,'<div class="numeroLeilao','','</span');
		$resp['ll_agregador_link']=isolar_limpo($texto_lote,'fas fa-arrow-circle-left','href="','"');
		if ($resp['ll_agregador_link']==''){$resp['ll_agregador_link']=isolar_limpo($texto_lote,'<div class="paginationLote">','href="','"');}
		$resp['ll_processo']=isolar_limpo($texto_lote,'<dt>Número do Processo','','</dd');


		$contapix=0;
		$pix0=isolar($texto_lote,'<ul class="loop owl-carousel">','','</ul');
		while(  $pix=isolar($pix0,'src="','','"') ) {
			$pix0=str_replace('src="'.$pix,'', $pix0);

			if (str_replace('nopicfull.png','',$pix)==$pix){
				$contapix+=1;
				if ($contapix<=8){

 '<br>Foto original: '.$pix;
					$resp['ll_foto_'.$contapix]=$pix;
				} else {
					$pix0='';
				}
			}
		}

		// acessa página do leilão para verificar natureza
		$resposta=http_post_curl_headers ($resp['ll_agregador_link'], $header, '', '', true, false, false, '', true, 'GET');
		$texto_natureza=$resposta['content'];
		$ll_natureza=strtolower(isolar_limpo($texto_natureza,'<ul class="cardDescricaoLeilao">','|','</div'));
		if (str_replace('extra','',$ll_natureza)==$ll_natureza && str_replace('judicial','',$ll_natureza)!=$ll_natureza){$resp['ll_natureza']='1';}

		$resp['ll_detalhes']=limpacaracteresfantasma(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',isolar_limpo(str_replace('<br>','.~ ',$texto_lote),'<small>Descrição do lote:','','<h6')))))))));

		$resp['ll_avaliacao']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'<dt>Avaliação','R$','</dd')));

		$resp['ll_endereco']=isolar($texto_lote,'endereco=new Array("','','"');

			
		if (str_replace('IMÓVE','',capitalizacao_str($ll_categoria_txt))!=capitalizacao_str($ll_categoria_txt) || str_replace('IMOVE','',capitalizacao_str($ll_categoria_txt))!=capitalizacao_str($ll_categoria_txt) ){
			echo '<br><font color="green">* Imóvel</font>';
			$geolocalizacao=geolocalizacao($resp['ll_endereco'],'',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);
		} else {
			$geolocalizacao=geolocalizacao($resp['ll_endereco'],'',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais'],false);
		}

		if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
		if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}
//		if ($geolocalizacao[4]!='' && $resp['ll_bairro']==''){$resp['ll_bairro']=$geolocalizacao[4];}

		if ($geolocalizacao[2]!='' && $resp['ll_uf']==''){$resp['ll_uf']=$geolocalizacao[2];}
		//if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}

		if ($geolocalizacao[3]!='' && $resp['ll_cidade']==''){$resp['ll_cidade']=$geolocalizacao[3];}		
		//if ($geolocalizacao[3]!=''){$resp['ll_cidade']=$geolocalizacao[3];}
		if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}

	
		$resp['ll_categoria_txt']=$ll_categoria_txt;
		$resp['ll_categoria_rotulo']=$ll_categoria_txt;


		if ($ll_sub_categoria!=''){
			$resp['ll_categoria_txt'].=','.$ll_sub_categoria;
			$resp['ll_categoria_rotulo']=$ll_sub_categoria;
		}

		if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_obs']))!=strtoupper($resp['ll_obs'])) {
			$resp['ll_categoria_txt'].=','.'SUCATAS';
			$resp['ll_categoria_rotulo']=' SUCATAS';
		}


		//print_r($resp);echo '<br><br>'; exit;
		echo NovoLeilao ($resp,array(),0,0,0,0,false);
		//exit;
		// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){


		//exit;

//$tempoexecucao_SP_HASTA_PUBLICA=99999;



	} else {
		//$texto='';
		echo '/ ';
		
	}
	// ==================================
//										$texto='';
	// ==================================
	//exit;	
}
?>
