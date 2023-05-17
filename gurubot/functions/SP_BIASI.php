<?php
/*
G U R U B O T
Módulo Leilões SP_BIASI
(c) 2019 06 Marcelon
*/

set_time_limit (600);
$atingiutempolimite=false;
$tempoiniciomg=date("YmdHis");
$r['extra']=organizador_inicia (SITE_SP_BIASI);

$lotescadastrados=0;

$proximo_card=explode('/',$r['extra'].'///');

$conta=0;
$conta_cards=0;
$conta_cards_internos=0;


$texto00= http_get_curl('https://www.biasileiloes.com.br/','ie',false,true);

// mapeia categorias principais
while(  $card=isolar(str_replace('</main>','<div class="col-xs-12 col-sm-6 col-md-3">',$texto00),'<div class="col-xs-12 col-sm-6 col-md-3">','','<div class="col-xs-12 col-sm-6 col-md-3">') ) {
	$texto00=str_replace('<div class="col-xs-12 col-sm-6 col-md-3">'.$card,'', $texto00);

	$ll_agregador_link=trim(isolar($card,'href="','','"'));

	$conta_cards+=1;

	if ($conta_cards>=$proximo_card[0] && $ll_agregador_link!=''){

		$ll_agregador_link='https://www.biasileiloes.com.br'.$ll_agregador_link;
		$numero_leilao=isolar($ll_agregador_link,'/leilao/','','/');



		$listagem_cards_internos= char_convert(http_get_curl('https://www.biasileiloes.com.br/Sale/LotList?id='.$numero_leilao.'&start=0&limit=99999&cat=todas-categorias&term=&vendaDireta=false','ie',false,true));

//echo $listagem_cards_internos; exit;

		while(  $card_interno=isolar($listagem_cards_internos.'<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">','<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">','','<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">') ) {
			$listagem_cards_internos=str_replace('<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">'.$card_interno,'', $listagem_cards_internos);

			$resp0=array();
			$resp0['organizador']=SITE_SP_BIASI;
			$resp0['ll_pais']='BRASIL';
			$resp0['ll_idioma']='pt-BR';
			$resp0['ll_moeda']='BRL';
			$resp0['ll_lote']=trim(limpaespacos(str_replace('LOTE','',strtoupper(isolar_limpo(str_replace('Nº','',str_replace('N°','',$card_interno)),'<div class="header-card">','','</div')))));
			$resp0['ll_descricao']=isolar_limpo($card_interno,'<div class="photo-text">','','</d');
			$localidade=isolar_limpo($card_interno,'<a class="cat-lot"','','</a');
			if (strlen($localidade)>3){
				$resp0['ll_uf']=isolar_limpo($localidade.'§©§','/','','§©§');
				$resp0['ll_cidade']=isolar_limpo('§©§'.$localidade,'§©§','','/');
			}
			$resp['ll_foto_1']=isolar_limpo($card_interno,'src="','','"');

			$ll_link='https://www.biasileiloes.com.br'.trim(isolar($card_interno,'href="','','"'));
			cadastra_SITE_SP_BIASI ($resp0,$ll_agregador_link,$ll_link);

			// ==================================
			$conta+=1;
					//if ($conta>5){exit;}
			// ==================================
			$tempoexecucaomg=diferencasegundos( $tempoiniciomg ,'');

			if ($tempoexecucaomg>30) {
				// atingiu tempo limite.
				$atingiutempolimite=true;
				goto fimdolaco;
			}

		}
	}
}


fimdolaco:


if ($atingiutempolimite==true){
	// não terminou!
    organizador_tempo_limite_atingido (SITE_SP_BIASI,$conta_cards);
echo '***
tempo limite
'; 
} else {
	echo '**** Finalizou tudo';
    organizador_finaliza (SITE_SP_BIASI);
}

function cadastra_SITE_SP_BIASI ($resp,$ll_agregador_link,$ll_link){

//print_r($resp); //exit;
	if ($ll_agregador_link!='' && $ll_link!=''){

		if (!VerificaCadastroLeilao($resp)){ 

			$resp['ll_agregador_link']=$ll_agregador_link;
			$resp['ll_link']=$ll_link;

			$texto_lote=char_convert(http_get_curl($resp['ll_link'],'ie',false,true));


	//echo $texto_lote; //exit;

			$resp['ll_agregador']=isolar_limpo($texto_lote,'<li><a href="/">Ínicio</a></li>','','</li');
			$resp['ll_data_1']=arrumadata_robos(str_replace(' ','/',str_replace('h','/',str_replace('.','/',isolar_limpo($texto_lote,'Data do Leilão:','','<').'/'.isolar_limpo($texto_lote,'Data do Leilão:',' das ','<')))),6,true);
			$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'1º leilão: R$','','</')));
			if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'Lance Inicial: <strong>R$','','</')));}

			
			$resp['ll_lance_min_2']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'2º leilão:','R$','</')));
			if ($resp['ll_lance_min_2']!=''){$resp['ll_data_2']=$resp['ll_data_1'];}

			$resp['ll_comitente']=trim(isolar_limpo($texto_lote,'<div class="panel-body ','<h','</h'));

			$resp['ll_detalhes']=limpacaracteresfantasma(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('<br>','.~ ',isolar_limpo($texto_lote,'Informações sobre o Lote','</b','</div'))))))))));

			$localizacao=trim(isolar_limpo($texto_lote,'fa fa-map-marker','','</i> Fotos'));
			if ($localizacao!=''){
				$resp['ll_endereco']=isolar('§'.$localizacao,'§','',$resp['ll_cidade']);
				if ($resp['ll_endereco']==''){$resp['ll_endereco']=$localizacao;}
			}
			$resp['ll_latitude']=trim(isolar_limpo($texto_lote,'id="lat" value="','','"')); if (round($resp['ll_latitude'])==0){$resp['ll_latitude']='';}
			$resp['ll_longitude']=trim(isolar_limpo($texto_lote,'id="long" value="','','"')); if (round($resp['ll_longitude'])==0){$resp['ll_longitude']='';}

			if ($localizacao==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','/'.$resp['ll_uf'])))));}
			if ($localizacao==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','/ '.$resp['ll_uf'])))));}
			if ($localizacao==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','-'.$resp['ll_uf'])))));}
			if ($localizacao==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','- '.$resp['ll_uf'])))));}
			if ($localizacao==''){
				$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',strtolower($resp['ll_detalhes']))))),'situado','','salvador'))))).$resp['ll_cidade'];
				if ($localizacao==''){
					$localizacao0=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))).'§©§','situado','','§©§')))));
					if ($localizacao0!=''){
						$localizacao=isolar('§'.$localizacao,'§','',',').', '.isolar($localizacao,',','',',').', '.isolar($localizacao,',',',',',').'/';
					}
				}
			}
	echo '
	$localizacao='.$localizacao; //exit;
			if ($localizacao!='' && $resp['ll_latitude']=='' && $resp['ll_longitude']==''){
				if (strtolower(substr($localizacao,-2))!=strtolower($resp['ll_uf'])){$localizacao.=' '.$resp['ll_uf'];}

	//				$extraido_uf=substr($localizacao,-2);
					$extraido_endereco=isolar('§'.$localizacao,'§','',',');
					$extraido_endereco_numero=isolar($localizacao,',','',',');
					$extraido_endereco_bairro=isolar($extraido_endereco_numero.'§','-','','§');
					if ($extraido_endereco_bairro!=''){$extraido_endereco_numero=isolar($localizacao,',','','-');}
	//				$extraido_endereco_cidade=isolar_reverso(str_replace('-',',',str_replace('/',',',$localizacao)),',',',');

				if ($extraido_endereco!='' && $extraido_endereco_numero!='' ) { //&& $extraido_endereco_cidade!='' && $extraido_uf!='' ) {
					$resp['ll_endereco']=$extraido_endereco.' '.$extraido_endereco_numero;
					$resp['ll_bairro']=$extraido_endereco_bairro;
					$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);

					if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
					if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}
						if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}


				} else {


						$geolocalizacao=geolocalizacao($localizacao,'');
						if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
						if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

	//					if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
	//					if ($geolocalizacao[3]!=''){$resp['ll_cidade']=$geolocalizacao[3];}
						if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
						$resp['ll_endereco']=$localizacao;
					
				}
			}
			if ($resp['ll_uf']==''){$resp['ll_uf']='SP';};
			if ($resp['ll_cidade']=='' && $resp['ll_uf']=='SP'){$resp['ll_cidade']='SÃO PAULO';}


			$pix0=isolar($texto_lote,'<div class="owl-carousel','','</div');

			$contapix=1; if ($resp['ll_foto_1']==''){$contapix=0;}
			while(  $pix=isolar($pix0,'src="','','"') ) {
				$pix0=str_replace('src="'.$pix,'', $pix0);

				if (str_replace('img-lote-default.png','',$pix)==$pix){
					$contapix+=1;
					if ($contapix<=8){

	echo '<br>Foto original: '.$pix;
						$resp['ll_foto_'.$contapix]=$pix;
					} else {
						$pix0='';
					}
				}
			}
			
			if (strtolower(str_replace('judicial','',$resp['ll_detalhes']))!=strtolower($resp['ll_detalhes']) && strtolower(str_replace('extra','',$resp['ll_detalhes']))==strtolower($resp['ll_detalhes'])){$resp['ll_natureza']='1';}

			$resp['ll_categoria_txt']='IMÓVEL';
			$resp['ll_categoria_rotulo']='IMÓVEL';

			if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) || str_replace('SUCATA','',strtoupper($resp['ll_agregador']))!=strtoupper($resp['ll_agregador'])){
				$resp['ll_categoria_txt'].=','.'SUCATAS';
				$resp['ll_categoria_rotulo']=' SUCATAS';
			}
				
			//print_r($resp);echo '<br><br>'; exit;
			echo NovoLeilao ($resp,array(),0,0,0,0,false);
			//exit;
			// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){


			//exit;

	//$tempoexecucaomg=99999;



		} else {
			//$texto='';
			echo '/ ';
			
		}
		// ==================================
	//										$texto='';
		// ==================================
		//exit;	
	}
}
?>