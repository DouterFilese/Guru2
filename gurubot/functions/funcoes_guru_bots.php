<?php
/*
G U R U B O T
Funções comuns de catalogação
(c) 2021 06 Marcelon
*/


function Busca_site_0000_busca_automatizada($idorganizador,$url,$baseurl,$cidade='',$uf='',$leiloeiro='',$cards_por_pagina=30,$teste=false,$texto='',$busca_1='',$busca_2=''){
	global $pdo;
	// 2020 06
	
	if ($baseurl==''){$baseurl=$url;}

//echo '***'; exit;
	$resposta_robo=false;


		$link_original=$url;

		if ($texto==''){
			$texto=http_get_curl($url,'firefox',false,false);
		}


		$texto=str_replace(chr(150),'-',str_replace(chr(156),'',$texto));
		$texto_maiusculas=capitalizacao_str($texto);
		$trata_url=trata_url($url,$texto);


//print_r($trata_url); //exit;
		$url=$trata_url['url'];
		$texto=$trata_url['texto'];
echo '<br><a href='.$url.' style="color: #3283a8;" target="_blank">'.$url.'</a><br>';

		$texto=str_replace(chr(150),'-',str_replace(chr(156),'',$texto));
		

		$texto_maiusculas=str_replace(isolar($texto,'__VIEWSTATE','value=','>'),'',$texto);
		$texto_maiusculas=capitalizacao_str($texto_maiusculas);


echo '<br><small><font color="orange">$url='.$url.' | $uf='.$uf.'  | $cidade='.$cidade.' | $leiloeiro='.$leiloeiro.'</font></small>
<br>';
//if ($teste){exit;}
	//echo '**'.$text;
	//echo '###'; exit;


		if (str_replace('SOLEON','',$texto_maiusculas)!=$texto_maiusculas){
			echo '<br><strong><font color="red">Organizador automático: Soleon</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='Soleon', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='Soleon' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0002_soleon ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina,$teste,$texto) ) {$resposta_robo=true;}
		}

		if (str_replace('PLATAFORMALEILOAR','',$texto_maiusculas)!=$texto_maiusculas || str_replace('PLATAFORMA LEILOAR','',$texto_maiusculas)!=$texto_maiusculas  || str_replace('<div id="c-leiloar','',$texto)!=$texto){
			echo '<br><strong><font color="red">Organizador automático: Leiloar</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='Leiloar', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='Leiloar' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0003_leiloar ($idorganizador,$url,$baseurl,$cidade,$uf,$teste,$texto) ) {$resposta_robo=true;}
		}

		if (str_replace('BOMVALOR','',$texto_maiusculas)!=$texto_maiusculas || str_replace('BOM VALOR','',$texto_maiusculas)!=$texto_maiusculas){
			echo '<br><strong><font color="red">Organizador automático: Bom Valor</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='Bom Valor', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='Bom Valor' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0004_bomvalor ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina,$teste,$texto) ) {$resposta_robo=true;}
		}
		
		if (str_replace('NYX','',$texto_maiusculas)!=$texto_maiusculas || str_replace('NWS','',$texto_maiusculas)!=$texto_maiusculas){
			echo '<br><strong><font color="red">Organizador automático: Nyx</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='Nyx', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='Nyx' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0005_nyx ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,0,$teste,$texto,$busca_1,$busca_2) ) {$resposta_robo=true;}
		}
		
		if (str_replace('DEGRAU','',$texto_maiusculas)!=$texto_maiusculas){
			echo '<br><strong><font color="red">Organizador automático: Degrau</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='Degrau', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='Degrau' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0006_degrau ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,0,$teste,$texto,$busca_1,$busca_2) ) {$resposta_robo=true;}
		}

		if (str_replace('LEILAOPRO','',$texto_maiusculas)!=$texto_maiusculas){
			echo '<br><strong><font color="red">Organizador automático: LeilaoPRO</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='LeilaoPRO', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='LeilaoPRO' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0007_leilaopro ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,0,$teste,$texto,$busca_1,$busca_2) ) {$resposta_robo=true;}
		}

		if (str_replace('LEILOESWEB','',$texto_maiusculas)!=$texto_maiusculas || str_replace('LEILÕES WEB','',$texto_maiusculas)!=$texto_maiusculas){
			echo '<br><strong><font color="red">Organizador automático: LeilõesWeb</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='LeilõesWeb', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='LeilõesWeb' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0008_leiloesweb ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,0,$teste,$texto,$busca_1,$busca_2) ) {$resposta_robo=true;}
		}

		if (str_replace('ASTAVERO','',$texto_maiusculas)!=$texto_maiusculas || str_replace('<body ng-controller="MainCtrl as vm">','',$texto)!=$texto ){
			echo '<br><strong><font color="red">Organizador automático: Astavero</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='Astavero', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='Astavero' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0009_astavero ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,0,$teste,$texto,$busca_1,$busca_2) ) {$resposta_robo=true;}
		}

		if (str_replace('SUPORTELEILOES','',$texto_maiusculas)!=$texto_maiusculas ){
			echo '<br><strong><font color="red">Organizador automático: Suporte Leilões</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='Suporte Leilões', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='Suporte Leilões' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0010_suporteleiloes ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,0,$teste,$texto,$busca_1,$busca_2) ) {$resposta_robo=true;}
		}

		if (str_replace('LEILOESBR','',$texto_maiusculas)!=$texto_maiusculas ){
			echo '<br><strong><font color="red">Organizador automático: LeilõesBR</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='LeilõesBR', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='LeilõesBR' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0011_leiloesbr ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,0,$teste,$texto,$busca_1,$busca_2) ) {$resposta_robo=true;}
		}

		if (str_replace('ROISOFT','',$texto_maiusculas)!=$texto_maiusculas ){
			echo '<br><strong><font color="red">Organizador automático: Roisoft</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='Roisoft', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='Roisoft' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0012_roisoft ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,0,$teste,$texto,$busca_1,$busca_2) ) {$resposta_robo=true;}
		}

		if (str_replace('LEILOVIA','',$texto_maiusculas)!=$texto_maiusculas ){
			echo '<br><strong><font color="red">Organizador automático: Leilovia</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='Leilovia', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='Leilovia' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0014_leilovia ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,0,$teste,$texto,$busca_1,$busca_2) ) {$resposta_robo=true;}
		}

		if (str_replace('SOFTGT','',$texto_maiusculas)!=$texto_maiusculas ){
			echo '<br><strong><font color="red">Organizador automático: Softgt</font></strong><br>';
			if ((int)$r_org['proibe_url_automatica']==0){
				if ($link_original!=$url && str_replace('error.aspx','',$url)==$url){
					$pdo->exec("UPDATE organizadores SET bot_automatico='Softgt', url_automatica='$url' WHERE id='".$r_org['id']."'" );
				} else {
					$pdo->exec("UPDATE organizadores SET bot_automatico='Softgt' WHERE id='".$r_org['id']."'" );
				}
			}
			if ( Busca_site_0015_softgt ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,0,$teste,$texto,$busca_1,$busca_2) ) {$resposta_robo=true;}
		}






		
			
	

	return $resposta_robo;

}

function Busca_site_0001_listagem_geral ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$divisor_cards='<article',$divisor_cards_leilao='<article',$fragmento_link_lote='/lote/',$busca_link_card='href="',$busca_link_lote='href="',
	$busca_agregador_inicio='<p',$busca_agregador_fim='</p',$teste=false,$texto=''){
  // 2021 06
  global $pdo;
  set_time_limit (600);


	$resposta_robo=false;
	$conta=0;
	if ($teste){echo '[teste ligado]';}

	if (substr($url,-1)!='/'){$url.='/';}
	if (substr($baseurl,-1)!='/' && $baseurl!=''){$baseurl.='/';}

	$atingiutempolimite=false;
	$tempoinicial=date("YmdHis");

	$inicializacaocards=max(1,organizador_inicia ($idorganizador));
	$lotescadastrados=0;
	
	$texto_listagem= limpaunicode(http_get_curl($url,'firefox',false,'utf8','','','',true,false));

	$cards_vetor=explode($divisor_cards,$texto_listagem);
	//print_r($cards_vetor); //exit;
	for ($i=$inicializacaocards;$i<sizeof($cards_vetor);$i++){
		$ll_agregador=isolar_limpo($cards_vetor[$i],$busca_agregador_inicio,'',$busca_agregador_fim);


		$url_card=isolar($cards_vetor[$i],$busca_link_card,'','"');
		if ($url_card==''){$url_card=isolar(str_replace('>',' ',$cards_vetor[$i]),'href=','',' ');}
		if (substr($url_card,0,4)!='http'){
			if (substr($url_card,0,1)=='/'){$url_card=substr($url_card,1-strlen($url_card));}
			$url_card=$baseurl.$url_card;
		}

		if (str_replace($fragmento_link_lote,'',$url_card)!=$url_card){
			// é lote único
			$resposta_robo=true;
			$resp=array();
			$resp['organizador']=$idorganizador;
			$resp['ll_pais']='BRASIL';
			$resp['ll_idioma']='pt-BR';
			$resp['ll_moeda']='BRL';
			$resp['ll_link']=$url_card;
			$resp['ll_agregador_link']=$url_card;
			$resp['ll_agregador']=$ll_agregador;
			Busca_site_0001_listagem_geral_processa($resp,$cidade,$uf,$leiloeiro,$baseurl,$teste);
			if (diferencasegundos( $tempoinicial ,'')>CADASTRO_MAX_SEGUNDOS) {$atingiutempolimite=true; goto fimdolaco;	}		
		} else {
			// é leilão
			$ll_agregador_link=$url_card;
			$texto_leilao= limpaunicode(http_get_curl($ll_agregador_link,'firefox',false,'utf8','','','',true,false));

			$cards_leilao_vetor=explode($divisor_cards_leilao,$texto_leilao);
//print_r($cards_leilao_vetor); //exit;
			for ($j=1;$j<sizeof($cards_leilao_vetor);$j++){ // <== ignora o primeiro elemento


				
				$url_card=isolar($cards_leilao_vetor[$j],$busca_link_lote,'','"');
				if ($url_card==''){$url_card=isolar(str_replace('>',' ',$cards_leilao_vetor[$j]),'href=','',' ');}
				if (substr($url_card,0,4)!='http'){
					// 1. reconstroi link do href
					if ($basezinha=isolar($busca_link_lote.'§','href="','','§')){$url_card=$basezinha.$url_card;}
					if (substr($url_card,0,1)=='/'){$url_card=substr($url_card,1-strlen($url_card));}
					$url_card=$baseurl.$url_card;
				}
				if ($url_card!=''){
					$resposta_robo=true;
					$resp=array();
					$resp['organizador']=$idorganizador;
					$resp['ll_pais']='BRASIL';
					$resp['ll_idioma']='pt-BR';
					$resp['ll_moeda']='BRL';
					$resp['ll_link']=$url_card;
					$resp['ll_agregador_link']=$ll_agregador_link;
					$resp['ll_agregador']=$ll_agregador;
					
					$descricao=str_replace('Sem Categoria','',isolar_limpo($cards_leilao_vetor[$j],'<p','','</p'));
					
					$resp['ll_categoria_txt']=$descricao;
					$resp['ll_categoria_rotulo']=$descricao;

						
					Busca_site_0001_listagem_geral_processa($resp,$cidade,$uf,$leiloeiro,$baseurl,$teste);
					if (diferencasegundos( $tempoinicial ,'')>CADASTRO_MAX_SEGUNDOS) {$atingiutempolimite=true; goto fimdolaco;	}
				}
			}
		}
	}
	
	fimdolaco:

	if ($atingiutempolimite){
		// não terminou!
		organizador_tempo_limite_atingido ($idorganizador,$i);
	echo '***
	tempo limite
	'; 
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}

	if ($resposta_robo){echo '<br>___________________________<br>'; }
	return $resposta_robo;
}

function Busca_site_0001_listagem_geral_processa($resp,$cidade,$uf,$leiloeiro,$baseurl,$teste=false){


	if (!VerificaCadastroLeilao($resp)){
		
		$texto_lote= limpaunicode(http_get_curl($resp['ll_link'],'firefox',false,'utf8','','','',true,false));

		$resp['ll_lote']=isolar_limpo($texto_lote,'<h4>LOTE Nº','','</h');
		
		$resp['ll_data_1']=arrumadata_robos(str_replace(' às ','/',isolar_limpo($texto_lote,'<b>1º Leilão</b>','','</p')),6,true);
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=arrumadata_robos(str_replace(' às ','/',isolar_limpo($texto_lote,'<b>Data</b>','','</p')),6,true);}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=arrumadata_robos(str_replace(' às ','/',isolar_limpo($texto_lote,'<b>Leilão</b>','','</p')),6,true);}
		
		$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'mb-0 destaque"><b>1º Leilão:','R$','<')));
		
		if ($resp['ll_lance_min_1']==''){
			$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'mb-0 destaque"><b>Lance','R$','<')));
		}

		$resp['ll_data_2']=arrumadata_robos(str_replace(' às ','/',isolar_limpo($texto_lote,'<b>2º Leilão</b>','','</p')),6,true);
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=arrumadata_robos(str_replace(' às ','/',isolar_limpo($texto_lote,'<b>Data</b>','<b>Data</b>','</p')),6,true);}
		$resp['ll_lance_min_2']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'mb-0 destaque"><b>2º Leilão:','R$','<')));
		if ($resp['ll_data_2']!='' && $resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=$resp['ll_lance_min_1'];}

		$resp['ll_descricao']=isolar_limpo($texto_lote,'<h5 class="mb-4">','','</h');
		if ($resp['ll_descricao']==''){$resp['ll_descricao']=$resp['ll_agregador'];}
					
		$resp['ll_detalhes']=str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
		str_replace(chr(10),' ',isolar_limpo(str_replace('<br>','.~ ',$texto_lote),'h6 class="mb-2"','</h','</span></p>')))))))));
		if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
		str_replace(chr(10),' ',isolar_limpo(str_replace('<br>','.~ ',$texto_lote),'h6 class="mb-2"','</h','</div><div')))))))));}


		$resp['ll_avaliacao']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'<b>AVALIAÇÃO:','R$','</')));

		$resp['ll_capacidade']=isolar_limpo($texto_lote,'Capacidade:','','<');
		$resp['ll_sn']=isolar_limpo($texto_lote,'Número de série:','','<');
		if ($resp['ll_sn']==''){$resp['ll_sn']=isolar_limpo($texto_lote,'Serial Number:','','<');}
		if ($resp['ll_sn']==''){$resp['ll_sn']=isolar_limpo($texto_lote,'Série:','','<');}
		$resp['ll_combustivel']=isolar_limpo($texto_lote,'Combustível:','','<');
		$resp['ll_area_construida']=isolar_limpo($texto_lote,'Área Construída:','','m');
		if ($resp['ll_area_construida']==''){$resp['ll_area_construida']=isolar_limpo($texto_lote,'área construída:','','m');}
		$resp['ll_area_util']=isolar_limpo($texto_lote,'Área útil:','','m');
		$resp['ll_area_terreno']=isolar_limpo($texto_lote,'Área do Terreno:','','m');
		if ($resp['ll_area_terreno']==''){$resp['ll_area_terreno']=isolar_limpo($texto_lote,'Área Terreno:','','m');}
		if ($resp['ll_area_terreno']==''){$resp['ll_area_terreno']=isolar_limpo($texto_lote,'área terreno','','m');}

/*echo $texto_lote.'
';*/

		$pix0=isolar($texto_lote,'<div class="slider">','','</div');		

/*
echo '


====

'.$pix0.'
';		*/
		$contapix=0;
		while(  $pix=isolar($pix0,'/arquivos/','','"') ) {
			$pix0=str_replace('/arquivos/'.$pix,'', $pix0);
			$contapix+=1;
			if ($contapix<=8){
				$resp['ll_foto_'.$contapix]=$baseurl.'arquivos/'.$pix;
			} else {
				$pix0='';
			}
		}

//print_r($resp); exit;

		$local=isolar_limpo($texto_lote,'<b>LOCAL:</b>','','</d');
		$resp['ll_uf']=substr($local,-2);
		$resp['ll_cidade']=substr($local,0,strlen($local)-3);

		$localizacao=str_replace('+',' ',isolar_limpo($texto_lote,'<a href="https://www.google.com/maps/place/','','/'));
		//if ($localizacao==''){$localizacao=str_replace('+',' ',isolar_limpo($texto_lote,'<a href="https://www.google.com/maps/place/','','/'));}
		if ($localizacao==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','/')))));}
		if ($localizacao==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','-')))));}
		if ($localizacao==''){
			$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',strtolower($resp['ll_detalhes']))))),'situado','',$resp['ll_cidade']))))).' '.$resp['ll_cidade'];
			if ($localizacao==''){
				$localizacao0=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))).'§©§','situado','','§©§')))));
				if ($localizacao0!=''){
					$localizacao=isolar('§'.$localizacao,'§','',',').', '.isolar($localizacao,',','',',').', '.isolar($localizacao,',',',',',').'/';

				}
			}
		}

		if ($localizacao!=''){

			
			if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
				echo '<br><font color="green">* Imóvel</font>';
				$geolocalizacao=geolocalizacao($localizacao,'');
			} else {
				$geolocalizacao=geolocalizacao($localizacao,'','','','',false);
			}
			if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
			if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

			if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
			if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
			if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
			$resp['ll_endereco']=$localizacao;
				
		}

		if ($resp['ll_uf']==''){$resp['ll_uf']=$uf;};
		if ($resp['ll_cidade']=='' && $resp['ll_uf']==$uf){$resp['ll_cidade']=$cidade;}
		
		if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) || str_replace('SUCATA','',strtoupper($resp['ll_agregador']))!=strtoupper($resp['ll_agregador'])){
			$resp['ll_categoria_txt'].=','.'SUCATAS';
			$resp['ll_categoria_rotulo']=' SUCATAS';
		}

		if ($teste){
			print_r($resp);echo '<br><br>';
		} else {
			//exit;
			echo NovoLeilao ($resp,array(),0.15,0.15,0,0);
		}
	} else {
		//$texto='';
		echo '/ ';
		
	}
}

function Busca_site_0002_soleon ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina=30,$teste=false,$texto=''){
  // 2021 06
  global $pdo;
  set_time_limit (600);

	if ((int)$cards_por_pagina==0){$cards_por_pagina=30;}

	$resposta_robo=false;
	$conta_subcats=0;
	if ($teste){echo '[teste ligado]';}

	if (substr($url,-1)!='/'){$url.='/';}
	if (substr($baseurl,-1)!='/' && $baseurl!=''){$baseurl.='/';}

$baseurl_=str_replace('www.','',isolar($baseurl.'§','://','','§'));
echo '<br>$baseurl_='.$baseurl_.'<br>';

	$atingiutempolimite=false;
	$tempoinicial=date("YmdHis");

	$inicializacaocards=explode(',',organizador_inicia ($idorganizador).',,,,');

	$inicializacao1_categorias=max(1,$inicializacaocards[0]);
	$inicializacao2_cards=max(1,$inicializacaocards[1]);
	$inicializacao3_cards=max(1,$inicializacaocards[2]);

	$lotescadastrados=0;
	
	echo '<br><strong>Busca clássica (por categorias)</strong>';

	$texto_listagem0=limpacaracteresisolatin1(http_get_curl($url,'firefox',false,'utf8','','','',true,false));
	
//	$texto_listagem= limpacaracteresisolatin1(isolar(limpaunicode($texto_listagem0),'TituloTodasASCategorias','</button','</button'));
	$texto_listagem= isolar($texto_listagem0,'TituloTodasASCategorias','</button','</button');

	
	$texto_listagem0=str_replace($texto_listagem,'',$texto_listagem0);
	$texto_listagem= limpacaracteresisolatin1(limpaunicode($texto_listagem));
//echo $texto_listagem; exit;

//if ($teste){echo $texto_listagem; exit;}	

//echo $texto_listagem; exit;

	$categorias_vetor=explode('<div class="card">',$texto_listagem);


//print_r($categorias_vetor); exit;
	//if (sizeof($categorias_vetor)<=1){

		$texto_listagem2=limpacaracteresfantasma($texto_listagem0);
		while(  $busca_cat=isolar($texto_listagem2,'<a','','</a') ) {
			$texto_listagem2=isolar($texto_listagem2.'§©§§§§','<a'.$busca_cat,'','§©§§§§');

			$ll_categoria=trim(limpahtml($busca_cat));
			$link_cat=isolar_limpo($busca_cat,'href="','','"');
			//if (str_replace('/lotes/','',$link_cat)!=$link_cat && str_replace('/lotes/search','',$link_cat)==$link_cat ){
			if (str_replace('/lotes/','',$link_cat)!=$link_cat && str_replace('/lotes/search','',$link_cat)==$link_cat && str_replace('/lotes/lista_lotes','',$link_cat)==$link_cat){ // 2021 11
				// categoria encontrada
				if (sizeof($categorias_vetor)==0){$categorias_vetor[]='--';}
				
				$incluilink=true;
				for ($i=1;$i<sizeof($categorias_vetor);$i++){
					if (str_replace($link_cat,'',$categorias_vetor[$i])!=$categorias_vetor[$i]){$incluilink=false;}
				}
				if ($incluilink){$categorias_vetor[]='<a href="'.$link_cat.'">'.$ll_categoria.'</a>';}
			}
		}
//print_r($categorias_vetor); exit;		
	//}

		// =====================================================================================================================
		// categorias (rotina original))
		//print_r($cards_vetor); //exit;
		for ($i=1;$i<sizeof($categorias_vetor);$i++){
			$ll_categoria=isolar_limpo($categorias_vetor[$i],'<a','','</a');
			$link_cat=isolar_limpo($categorias_vetor[$i],'href="','','"');
			echo '
	<br><strong><font color="red">Categoria: '.$ll_categoria.'</font></strong>: ';
			
			$subcategorias_vetor=explode('<li',$categorias_vetor[$i].'<li><a href="'.$link_cat.'">'.$ll_categoria.'</a></li>');
			//print_r($cards_vetor); //exit;
			for ($j=1;$j<sizeof($subcategorias_vetor);$j++){
				$ll_sub_categoria=isolar_limpo($subcategorias_vetor[$j],'<a','','</a');
				$conta_subcats+=1;
				echo '
	<br>'.$conta_subcats.' - <strong><font color="blue">Subcategoria: '.$ll_sub_categoria.'</font></strong>: ';

				if ($conta_subcats>=$inicializacao1_categorias){
					if ($conta_subcats>$inicializacao1_categorias){$inicializacao2_cards=0;}
					$link_subcat=isolar_limpo($subcategorias_vetor[$j],'href="','','"');
					$conta_cads_na_categoria=0;
					$pagina=1;

					// página posterior?
					while ($inicializacao2_cards>($conta_cads_na_categoria+$cards_por_pagina)){
						$pagina+=1;
						$conta_cads_na_categoria+=$cards_por_pagina;
					}
					
					while ($pagina>0){
						$link_subcat_pag=$link_subcat.'&page='.$pagina;
						if ($pagina==1){$link_subcat_pag=$link_subcat;}
						echo '
	<br><i>Página '.$pagina.'</i>: '.$link_subcat_pag;
						$texto_cards= limpacaracteresisolatin1(limpaunicode(http_get_curl($link_subcat_pag,'firefox',false,'utf8','','','',true,false)));
						$pagina+=1;
						if (str_replace('page='.$pagina.'"','',$texto_cards)==$texto_cards){$pagina=-1;}


//if ($ll_sub_categoria=='VEÍCULOS'){echo $texto_cards; exit;}

						$cards_vetor=explode('<div class="card-body">',$texto_cards);
						if (sizeof($cards_vetor)<2){$cards_vetor=explode('<div class="lote">',$texto_cards);}
	//if ($ll_sub_categoria=='Veículos'){print_r($cards_vetor); exit;}
						for ($k=1;$k<sizeof($cards_vetor);$k++){
							$conta_cads_na_categoria+=1;
							
							if($conta_cads_na_categoria>=$inicializacao2_cards){

								$url_card=isolar($cards_vetor[$k],'href="','','"');

								if ($url_card==''){$url_card=isolar(str_replace('>',' ',$cards_vetor[$k]),'href=','',' ');}
								if (substr($url_card,0,4)!='http'){
									if (substr($url_card,0,1)=='/'){$url_card=substr($url_card,1-strlen($url_card));}
									$url_card=$baseurl.$url_card;
								}
								if (str_replace('label_lote em_breve','',$cards_vetor[$k])==$cards_vetor[$k]){

									$resposta_robo=true;
									$resp=array();
									$resp['organizador']=$idorganizador;
									$resp['ll_pais']='BRASIL';
									$resp['ll_idioma']='pt-BR';
									$resp['ll_moeda']='BRL';
									$resp['ll_link']=$url_card;
									if ($teste || !VerificaCadastroLeilao($resp)){

										$resp['ll_categoria_txt']=$ll_categoria;
										$resp['ll_categoria_rotulo']=$ll_categoria;

										if ($ll_sub_categoria!='' && $ll_sub_categoria!=$ll_categoria){
											$resp['ll_categoria_txt'].=','.$ll_sub_categoria;
											$resp['ll_categoria_rotulo']=$ll_sub_categoria;
										}

										if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) || str_replace('SUCATA','',strtoupper($resp['ll_agregador']))!=strtoupper($resp['ll_agregador'])){
											$resp['ll_categoria_txt'].=','.'SUCATAS';
											$resp['ll_categoria_rotulo']=' SUCATAS';
										}
	//print_r($resp); //exit;						
echo '<br><i>'.$resp['ll_link'].'</i>';
										if (str_replace($baseurl_,'',$resp['ll_link'])!=$resp['ll_link']){
											Busca_site_0002_soleon_processa($resp,$cidade,$uf,$leiloeiro,$baseurl,$teste);
										} else {
											echo '<font color="red">* não catalogado: URL fora do leiloeiro</font>';
										}
										if (diferencasegundos( $tempoinicial ,'')>CADASTRO_MAX_SEGUNDOS) {$atingiutempolimite=true; goto fimdolaco;	}
									} else {
										//$texto='';
										echo '/ ';

									}
								}
							}
						}
					}
				}
			}
		}
	
		echo '<br><strong>Repescagem...</strong>';
		// =====================================================================================================================
		// 2021 10 não há categorias!
//		echo $texto_listagem0; exit;
		$pagina=1;
		$conta_cards_repescagem=0;

		// página posterior?
		while ($inicializacao3_cards>($conta_cards_repescagem+$cards_por_pagina)){
			$pagina+=1;
			$conta_cards_repescagem+=$cards_por_pagina;
		}


		while ($pagina>0){
			if (substr($url,-1)=='/'){
				$link_subcat_pag=$url.'?page='.$pagina;
			} else {
				$link_subcat_pag=$url.'&page='.$pagina;
			}

echo '
$url='.$url.'
$pagina='.$pagina.'
'.$url.'&page='.$pagina.'
'; //exit;
			
			//if ($pagina==1){$link_subcat_pag=$url;}
			echo '
<br><i>Página '.$pagina.'</i>: '.$link_subcat_pag;
//			if ($texto_cards==1){
//				$texto_cards=$texto_listagem0;
//			} else {
				$texto_cards= limpacaracteresisolatin1(limpaunicode(http_get_curl($link_subcat_pag,'firefox',false,'utf8','','','',true,false)));
//			}
			$pagina+=1;
			if (str_replace('page='.$pagina.'"','',$texto_cards)==$texto_cards){$pagina=-1;}

//echo $texto_cards; exit;

			
			
			$cards_vetor=explode('<div class="card-body">',$texto_cards);
			if (is_array($cards_vetor)){
				if (sizeof($cards_vetor==0)){$cards_vetor=explode('box-leilao',$texto_cards);}
			} else {
				$cards_vetor=explode('box-leilao',$texto_cards);
			}
//if ($ll_sub_categoria=='Veículos'){print_r($cards_vetor); exit;}
			for ($k=1;$k<sizeof($cards_vetor);$k++){
				$conta_cards_repescagem+=1;
				
				if($conta_cards_repescagem>=$inicializacao3_cards){

					$url_card=isolar($cards_vetor[$k],'href="','','"');

					if ($url_card==''){$url_card=isolar(str_replace('>',' ',$cards_vetor[$k]),'href=','',' ');}
					if (substr($url_card,0,4)!='http'){
						if (substr($url_card,0,1)=='/'){$url_card=substr($url_card,1-strlen($url_card));}
						$url_card=$baseurl.$url_card;
					}
					if (str_replace('label_lote em_breve','',$cards_vetor[$k])==$cards_vetor[$k]){

						$resposta_robo=true;
						$resp0=array();
						$resp0['organizador']=$idorganizador;
						$resp0['ll_pais']='BRASIL';
						$resp0['ll_idioma']='pt-BR';
						$resp0['ll_moeda']='BRL';
						$resp0['ll_agregador_link']=$url_card;
						//$resp0['ll_categoria_txt']='';
						//$resp0['ll_categoria_rotulo']='';
						
//print_r($resp0); //exit;
						$texto_listagem= limpacaracteresespeciais(limpaunicode(http_get_curl($resp0['ll_agregador_link'],'firefox',false,'utf8','','','',true,false)));
//echo $texto_listagem; exit;						
						$cards_vetor2=explode('<div class="lote ">',$texto_listagem);

//print_r($cards_vetor2); exit;
						for ($l=1;$l<sizeof($cards_vetor2);$l++){
						
							$url_card=isolar($cards_vetor2[$l],'href="','','"');

							if ($url_card==''){$url_card=isolar(str_replace('>',' ',$cards_vetor2[$l]),'href=','',' ');}
							if (substr($url_card,0,4)!='http'){
								if (substr($url_card,0,1)=='/'){$url_card=substr($url_card,1-strlen($url_card));}
								$url_card=$baseurl.$url_card;
							}
							if (str_replace('label_lote em_breve','',$cards_vetor2[$l])==$cards_vetor2[$l]){
								
								
								$resp=$resp0;
								$resp['ll_link']=$url_card;
echo '<br><i>'.$resp['ll_link'].'</i>';
								if (str_replace($baseurl_,'',$resp['ll_link'])!=$resp['ll_link']){
									if ($teste || !VerificaCadastroLeilao($resp)){
//print_r($resp); exit;
		//print_r($resp); //exit;										

										Busca_site_0002_soleon_processa($resp,$cidade,$uf,$leiloeiro,$baseurl,$teste);
										if (diferencasegundos( $tempoinicial ,'')>CADASTRO_MAX_SEGUNDOS) {$atingiutempolimite=true; goto fimdolaco;	}
									} else {
										//$texto='';
										echo '/ ';

									}
								} else {
									echo '<font color="red">* não catalogado: URL fora do leiloeiro</font>';
								}

							}
						}
					}
				}
			}

			
		}		
		
		
		
		
		
		
		

	fimdolaco:

	if ($atingiutempolimite){
		// não terminou!
		organizador_tempo_limite_atingido ($idorganizador,$conta_subcats.','.$conta_cads_na_categoria.','.$conta_cards_repescagem);
	echo '***
	tempo limite
	'; 
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}

	if ($resposta_robo){echo '<br>___________________________<br>'; }
	return $resposta_robo;

}

function Busca_site_0002_soleon_processa($resp,$cidade,$uf,$leiloeiro,$baseurl,$teste=false){


//	if ($teste || !VerificaCadastroLeilao($resp)){
		
		$texto_lote= limpacaracteresisolatin1(limpacaracteresespeciais(limpaunicode(http_get_curl($resp['ll_link'],'firefox',false,'utf8','','','',true,false))));
		$texto_lote_=$texto_lote;
//echo $texto_lote; //exit;
		$resp['ll_lote']=str_replace('LOTE ','',strtoupper(isolar_limpo($texto_lote,'<h4 class="float','','</h')));
		if ($resp['ll_lote']==''){$resp['ll_lote']=str_replace('LOTE ','',strtoupper(isolar_limpo($texto_lote,'<h4','','</h')));}
		$resp['ll_descricao']=isolar_limpo($texto_lote,'<h4 class="float','<h4','</h');
		if ($resp['ll_descricao']==''){$resp['ll_descricao']=isolar_limpo($texto_lote,'<h5>Descrição do Lote','<p','</p');}

		$contapix=0;
		while(  $pix=isolar($texto_lote_,'<div class="carousel-item','','</a') ) {
			$texto_lote_=str_replace('<div class="carousel-item'.$pix,'', $texto_lote_);
			$pix1=isolar($pix,'href="','','"');

			if ($pix1==''){$pix1=isolar(str_replace('>',' ',$pix),'href=','',' ');}
			if (substr($pix1,0,4)!='http'){
				if (substr($pix1,0,1)=='/'){$pix1=substr($pix1,1-strlen($pix1));}
				$pix1=$baseurl.$pix1;
			}

			if ($pix1!=''){
				$contapix+=1;
				if ($contapix<=8){
					$resp['ll_foto_'.$contapix]=$pix1;
				} else {
					$pix0='';
				}
			}
		}

		if ($contapix==0){
			$txt_pix=isolar($texto_lote_,'<div class="galery">','','</ul');
			while(  $pix=isolar($txt_pix,'<li','','</li') ) {
				$txt_pix=str_replace('<li'.$pix,'', $txt_pix);
				$pix1=isolar($pix,'href="','','"');

				if ($pix1==''){$pix1=isolar(str_replace('>',' ',$pix),'href=','',' ');}
				if (substr($pix1,0,4)!='http'){
					if (substr($pix1,0,1)=='/'){$pix1=substr($pix1,1-strlen($pix1));}
					$pix1=$baseurl.$pix1;
				}

				if ($pix1!=''){
					$contapix+=1;
					if ($contapix<=8){
						$resp['ll_foto_'.$contapix]=$pix1;
					} else {
						$pix0='';
					}
				}
			}
		}

		$resp['ll_agregador_link']=isolar($texto_lote,'<div class="my-2','href="','"');
		if ($resp['ll_agregador_link']==''){$resp['ll_agregador_link']=isolar($texto_lote,'<div id="item_lote"','href="','"');}
		$resp['ll_agregador']=isolar_limpo($texto_lote,'<div class="my-2','<div','</d');
		if ($resp['ll_agregador']==''){$resp['ll_agregador']=isolar_limpo($texto_lote,'>Comitente:','','</tr');}
		
		$resp['ll_avaliacao']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'<strong>Valor de Avaliação:','R$','</')));
		
		$datasevalores=isolar($texto_lote,'<h6 class="text-center border-top p-2 m-0">','','</div');
		
		$resp['ll_data_1']=substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',isolar_limpo($datasevalores,'strong>Data','</str','</h'))),6,true),0,12);
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',isolar_limpo($datasevalores,'strong>Encerramento','</str','</h'))),6,true),0,12);}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',isolar_limpo($texto_lote,'<div id="data">',':','</div'))),6,true),0,12);}
		$resp['ll_lance_min_1']=trim(str_replace(',','.',str_replace('.','',isolar_limpo($datasevalores,'<strong>Lance','R$','<'))));
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=trim(str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'Lance Inicial:','R$','<'))));}
		$datasevalores=isolar($datasevalores.'§©§','<strong>Lance','R$','§©§');
		$resp['ll_data_2']=substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',isolar_limpo($datasevalores,'strong>Data','</str','</h'))),6,true),0,12);
		if ($resp['ll_data_2']!=''){$resp['ll_lance_min_2']=trim(str_replace(',','.',str_replace('.','',isolar_limpo($datasevalores,'<strong>Lance','R$','<'))));}
		
		$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
		str_replace(chr(10),' ',isolar_limpo(str_replace('<br>','.~ ',$texto_lote),'<h5>Detalhes','<div class="mb-3','!--DIV DESCRIÇÕES - FIM-->'))))))))));
		if ($resp['ll_detalhes']==''){
			$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
			str_replace(chr(10),' ',isolar_limpo(str_replace('<br>','.~ ',$texto_lote),'<h5>Descrição do Lote</h5>','','<h5>Lances Ofertados</h5>'))))))))));
		}

		$resp['ll_natureza']= '0'; // 0=extra judicial; 1=judicial; 2=público [int]
		$testajudicial=capitalizacao_str(isolar($texto_lote,'<div class="my-2','<h','</h'));
		$cap_ll_detalhes=strtoupper($resp['ll_detalhes']);
		if (str_replace('TRIBUNAL','',$cap_ll_detalhes)!=$cap_ll_detalhes || 
			str_replace('VARA ','',$cap_ll_detalhes)!=$cap_ll_detalhes || 
			str_replace('CIVEL ','',$cap_ll_detalhes)!=$cap_ll_detalhes || 
			str_replace('CÍVEL ','',$cap_ll_detalhes)!=$cap_ll_detalhes || 
			str_replace('FALÊNCIA','',$cap_ll_detalhes)!=$cap_ll_detalhes || 
			str_replace('FALENCIA','',$cap_ll_detalhes)!=$cap_ll_detalhes || 
			str_replace('V.C.','',$cap_ll_detalhes)!=$cap_ll_detalhes || 
			str_replace('V. C.','',$cap_ll_detalhes)!=$cap_ll_detalhes || 
			str_replace('FORO  ','',$cap_ll_detalhes)!=$cap_ll_detalhes || 
			str_replace('TJ','',$cap_ll_detalhes)!=$cap_ll_detalhes || 
			str_replace('TRT','',$cap_ll_detalhes)!=$cap_ll_detalhes || 
			(str_replace('JUDICIAL','',$testajudicial)!=$testajudicial && str_replace('EXTRA','',$testajudicial)==$testajudicial)) {
				$resp['ll_natureza']='1';
		}


		$resp['ll_capacidade']=isolar_limpo($texto_lote,'Capacidade:','','<');
		$resp['ll_sn']=isolar_limpo($texto_lote,'Número de série:','','<');
		if ($resp['ll_sn']==''){$resp['ll_sn']=isolar_limpo($texto_lote,'Serial Number:','','<');}
		if ($resp['ll_sn']==''){$resp['ll_sn']=isolar_limpo($texto_lote,'Série:','','<');}
		$resp['ll_combustivel']=isolar_limpo($texto_lote,'Combustível:','','<');
		$resp['ll_area_construida']=isolar_limpo($texto_lote,'Área Construída:','','m');
		if ($resp['ll_area_construida']==''){$resp['ll_area_construida']=isolar_limpo($texto_lote,'área construída:','','m');}
		$resp['ll_area_util']=isolar_limpo($texto_lote,'Área útil:','','m');
		$resp['ll_area_terreno']=isolar_limpo($texto_lote,'Área do Terreno:','','m');
		if ($resp['ll_area_terreno']==''){$resp['ll_area_terreno']=isolar_limpo($texto_lote,'Área Terreno:','','m');}
		if ($resp['ll_area_terreno']==''){$resp['ll_area_terreno']=isolar_limpo($texto_lote,'área terreno','','m');}

		if ($resp['ll_categoria_txt']=='' || !isset($resp['ll_categoria_txt'])){
			$vetor_categoria=adivinha_categoria($resp['ll_descricao']);

			if (sizeof($vetor_categoria)>0){

				$resp['ll_categoria_txt']=$vetor_categoria[0];
				$resp['ll_categoria_rotulo']=$vetor_categoria[0];

				if (sizeof($vetor_categoria)>1){
					$resp['ll_categoria_txt'].=','.$vetor_categoria[1];
					$resp['ll_categoria_rotulo']=$vetor_categoria[1];
				}
			}
		


			if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) || str_replace('SUCATA','',strtoupper($resp['ll_agregador']))!=strtoupper($resp['ll_agregador'])){
				$resp['ll_categoria_txt'].=','.'SUCATAS';
				$resp['ll_categoria_rotulo']=' SUCATAS';
			}
		}



		$local=isolar_limpo($texto_lote,'<b>Cidade:</b>','','<');
		$resp['ll_uf']=substr($local,-2);
		$resp['ll_cidade']=trim(substr($local,0,strlen($local)-4));
		
		
		
		$localizacao=str_replace('+',' ',isolar_limpo($texto_lote,'<b>Endereço:</b>','','<'));
		//if ($localizacao==''){$localizacao=str_replace('+',' ',isolar_limpo($texto_lote,'<a href="https://www.google.com/maps/place/','','/'));}
		if ($localizacao==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','/')))));}
		if ($localizacao==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','-')))));}
		if ($localizacao==''){
			$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',strtolower($resp['ll_detalhes']))))),'situado','',$resp['ll_cidade']))))).' '.$resp['ll_cidade'];
			if ($localizacao==''){
				$localizacao0=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))).'§©§','situado','','§©§')))));
				if ($localizacao0!=''){
					$localizacao=isolar('§'.$localizacao,'§','',',').', '.isolar($localizacao,',','',',').', '.isolar($localizacao,',',',',',').'/';

				}
			}
		}

		if ($localizacao!=''){
			

			
			if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
				echo '<br><font color="green">* Imóvel</font>';
				$geolocalizacao=geolocalizacao($localizacao,'',$resp['ll_cidade'],$resp['ll_uf']);
			} else {
				$geolocalizacao=geolocalizacao($localizacao,'',$resp['ll_cidade'],$resp['ll_uf'],'',false);
			}

			if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
			if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

			if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
			if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
			if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}

			$resp['ll_endereco']=$localizacao;
				
		}

		if ($resp['ll_uf']==''){$resp['ll_uf']=$uf;};
		if ($resp['ll_cidade']=='' && $resp['ll_uf']==$uf){$resp['ll_cidade']=$cidade;}
		

//print_r($resp);echo '<br><br>'; exit;		
		
		if ($teste){
			print_r($resp);echo '<br><br>'; exit;
		} else {
			//exit;
			echo NovoLeilao ($resp,array(),0.15,0.15,0,0);
			//exit;
		}
/*
	} else {
		//$texto='';
		echo '/ ';
		
	}*/
}

function Busca_site_0003_leiloar ($idorganizador,$url,$baseurl,$cidade='',$uf='',$teste=false,$texto=''){
  // 2021 07
  global $pdo;

	set_time_limit (600);
	$atingiutempolimite=false;
	$tempoinicio__leiloeiro=date("YmdHis");
	
	$baseurl=str_replace('/externo','',$baseurl);
	if ($baseurl==''){$baseurl=isolar('§'.$url,'§','','//').'//'.isolar($url.'/','//','','/');}
	
	if (substr($baseurl,-1)=='/'){$baseurl=substr($baseurl,0,strlen($baseurl)-1);}

	$lotescadastrados=0;

	$proximo_card=explode('/',organizador_inicia ($idorganizador).'///');

	$conta=0;
	$conta_cards=0;
	$conta_cards_internos=0;
	
	$texto000= limpacaracteresutf8_novo(http_get_curl($url,'ie',false,false));
	
	$texto00= isolar($texto000,'<div id="l-leiloes">','','<div id="l-paginas">');
	if ($texto00==''){$texto00= isolar($texto000,'<div id="c-conteudo">','','<div id="c-rodape">');}

/*
echo str_replace('<','
<',$texto00); exit;
*/

	while(  $texto_lote0=isolar($texto00,'<a','','</a') ) {
		$texto00=str_replace('<a'.$texto_lote0,'', $texto00);

		$ll_agregador_link=trim(isolar($texto_lote0,'href="','','"'));
		$status=isolar($texto_lote0,'l-status l-sts-','','"');
		if ($status==''){$status=isolar($texto_lote0,'c-situacao-leilao ','','"');}

		$conta_cards+=1; echo '['.$conta_cards.'] ';

		if ($conta_cards>=$proximo_card[0] && $ll_agregador_link!='' && ($status=='verde' || $status=='azul') && str_replace('SIMULA','',isolar_limpo($texto_lote0,'<spa','','</spa'))==isolar_limpo($texto_lote0,'<spa','','</spa')) {

			$resp0=array();
			$resp0['organizador']=$idorganizador;
			$resp0['ll_pais']='BRASIL';
			$resp0['ll_idioma']='pt-BR';
			$resp0['ll_moeda']='BRL';
			if (substr($ll_agregador_link,0,4)=='http'){
				$resp0['ll_agregador_link']=$ll_agregador_link;
			} else {
				$resp0['ll_agregador_link']=$baseurl.$ll_agregador_link;
			}
			$resp0['ll_agregador']=isolar_limpo($texto_lote0,'<spa','','</spa');
			$resp0['ll_natureza']='1';

//print_r($resp0); //exit;
			// listagem de leilões


			$texto_lote2=limpacaracteresutf8_novo(http_get_curl($resp0['ll_agregador_link'],'ie',false,false));
			$texto_lote2=str_replace('card card-conteudo','<strong class="l-numero-lote"',$texto_lote2);
			$texto_lote2=str_replace('card-footer','l-spn-favorito',$texto_lote2);

			$texto_lote2=str_replace('<div class="c-bem ','<strong class="l-numero-lote"',$texto_lote2);
			$texto_lote2=str_replace('</a','l-spn-favorito</a',$texto_lote2);

//echo $texto_lote2; exit;
/*
print_r($resp0);		

echo '
²$status='.$status.'

'.str_replace('<','
<',$texto_lote2).'
====

';

exit;*/
			while(  $texto_lote=isolar($texto_lote2,'<strong class="l-numero-lote"','','l-spn-favorito') ) {
				$texto_lote2=str_replace('<strong class="l-numero-lote"'.$texto_lote,'', $texto_lote2);


				$ll_link=trim(isolar($texto_lote,'<h4 class="card-title">','href="','"'));
				if ($ll_link==''){$ll_link=trim(isolar($texto_lote,'href="','','"'));}

				$status=trim(isolar($texto_lote0,'l-status l-sts-','','"'));
				if($status==''){$status=trim(isolar($texto_lote,' status-bem-','','"'));}


				if ($ll_link!='' && ($status=='verde' || $status=='azul')){
					$resp=$resp0;
					//$resp['ll_link']=$baseurl.$ll_link;
					if (substr($ll_link,0,4)=='http'){
						$resp['ll_link']=$ll_link;
					} else {
						$resp['ll_link']=$baseurl.$ll_link;
					}

					$resp['ll_lote']=isolar_limpo($texto_lote,'>Lote ','','<');
		
		
		
//print_r($resp);		exit;
					Busca_site_0002_leiloar_processa ($resp,$baseurl,$cidade,$uf,$teste);

					// ==================================
					$conta+=1;
							//if ($conta>5){exit;}
					// ==================================
					$tempoexecucao__leiloeiro=diferencasegundos( $tempoinicio__leiloeiro ,'');

					if ($tempoexecucao__leiloeiro>CADASTRO_MAX_SEGUNDOS) {
						// atingiu tempo limite.
						$atingiutempolimite=true;
						goto fimdolaco;
					}
				}
			}
		}
	}


	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		organizador_tempo_limite_atingido ($idorganizador,$conta_cards."/".$proximo_card[1]);
	echo '***
	tempo limite
	'; 
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}

	$resposta_robo=false;

								$resposta_robo=true;


	if ($resposta_robo){echo '<br>___________________________<br>'; }
	return $resposta_robo;

}

function Busca_site_0002_leiloar_processa($resp,$baseurl,$cidade='',$uf='',$teste=false){

global $pdo;
//print_r($resp); //exit;
	if ($teste || !VerificaCadastroLeilao($resp)){ 


//$local

//		$texto_lote=char_convert(http_get_curl($resp['ll_link'],'ie',false,true));
		$texto_lote=limpacaracteresutf8_novo(http_get_curl($resp['ll_link'],'ie',false,false));
		$texto_lote=str_replace('?º','º',str_replace('&sup2;', '²', str_replace('&rdquo;', '', str_replace('&ldquo;', '', $texto_lote))));

//echo $texto_lote;



		$resp['ll_avaliacao']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'<span>Avaliação:','R$','<')));
		if ($resp['ll_avaliacao']==''){$resp['ll_avaliacao']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'<th>Avaliação','R$','<')));}

		$resp['ll_data_1']=arrumadata_robos(str_replace(' ','/',str_replace('H','',str_replace(' às ','/',str_replace(' de ','/',strtolower(isolar_limpo(
			str_replace('Encerramento 1º Leilão:','ENCERRAMENTO:',str_replace('Encerramento Leilão:','ENCERRAMENTO:',str_replace('PROPOSTAS ATÉ:','ENCERRAMENTO:',str_replace('CICLO:','ENCERRAMENTO:',$texto_lote)))),
			'ENCERRAMENTO:','','<')))))),5,true);
		IF ($resp['ll_data_1']==''){$resp['ll_data_1']=arrumadata_robos(str_replace(' ','/',str_replace('H','',str_replace(' às ','/',str_replace(' de ','/',strtolower(isolar_limpo(str_replace('PROPOSTAS ATÉ:','ENCERRAMENTO:',
			str_replace('CICLO:','ENCERRAMENTO:',$texto_lote)),'ENCERRAMENTO:','','</li')))))),5,true);}
		IF ($resp['ll_data_1']==''){
			$resp['ll_data_1']=arrumadata_robos(str_replace(' ','/',str_replace('H','',str_replace(' às ','/',str_replace(' de ','/',isolar_limpo(isolar(strtolower($texto_lote),'l-cabecalho-datas','<li','</li').'§©§','data:','','§©§'))))),5,true);
		}
		IF ($resp['ll_data_1']==''){
			$resp['ll_data_1']=arrumadata_robos(str_replace(' ','/',str_replace('H','',str_replace(' às ','/',str_replace(' de ','/',isolar_limpo(isolar(strtolower($texto_lote),'l-cabecalho-datas','<li','</li').'§©§','leilão:','','§©§'))))),5,true);
		}



		$resp['ll_data_2']=arrumadata_robos(str_replace(' ','/',str_replace('H','',str_replace(' às ','/',str_replace(' de ','/',strtolower(isolar_limpo(
			str_replace('Encerramento 1º Leilão:','ENCERRAMENTO:',str_replace('Encerramento 2º Leilão:','ENCERRAMENTO:',str_replace('PROPOSTAS ATÉ:','ENCERRAMENTO:',str_replace('CICLO:','ENCERRAMENTO:',$texto_lote)))),
			'ENCERRAMENTO:','ENCERRAMENTO:','<')))))),5,true);
		IF ($resp['ll_data_2']==''){$resp['ll_data_2']=arrumadata_robos(str_replace(' ','/',str_replace('H','',str_replace(' às ','/',str_replace(' de ','/',strtolower(isolar_limpo(str_replace('PROPOSTAS ATÉ:','ENCERRAMENTO:',str_replace('CICLO:','ENCERRAMENTO:',$texto_lote)),'ENCERRAMENTO:','ENCERRAMENTO:','</li')))))),5,true);}

		IF ($resp['ll_data_2']==''){
			$resp['ll_data_2']=arrumadata_robos(str_replace(' ','/',str_replace('H','',str_replace(' às ','/',str_replace(' de ','/',isolar_limpo(isolar(strtolower($texto_lote),'l-cabecalho-datas','</li','</li').'§©§','leilão:','','§©§'))))),5,true);
		}
		
		$resp['ll_lance_min_1']=str_replace('R$','',str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'<span>Lance Minimo:','','</li'))));
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'<span>Lance Minimo:','R$','<')));}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=str_replace('R$','',str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'<th>Lance mínimo','','</tr'))));}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'<th>Lance mínimo','R$','<')));}

		if ($resp['ll_lance_min_1']==''){
			$resp['ll_lance_min_1']=$resp['ll_avaliacao'];
		}
		if ($resp['ll_data_2']!=''){$resp['ll_lance_min_2']=$resp['ll_lance_min_1'];}

//print_r($resp); exit;

		$local=isolar_limpo($texto_lote,'l-cabecalho-infos-local',',','<');
		if ($local==''){$local=isolar_limpo($texto_lote,'c-cabecalho-local',',','<');}

		$resp['ll_descricao']=limpacaracteresfantasma(isolar_limpo($texto_lote,'<div id="l-lote-descricao">','</h2','</p'));
		if ($resp['ll_descricao']==''){$resp['ll_descricao']=limpacaracteresfantasma(isolar_limpo($texto_lote,'<div class="c-detalhes-bem-descricao-lote"> ','</','</p'));}
		if ($resp['ll_descricao']!=''){
			$resp['ll_detalhes']=limpacaracteresfantasma(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('<br>','.~ ',$resp['ll_descricao'])))))))));

			$contapix=0;
			$pix0=isolar($texto_lote,'<div id="l-lote-galeria">','','<span class="l-spn-favorito">');
			if($pix0==''){$pix0=isolar($texto_lote,'<div class="cj-slider','','</div');}
			while(  $pix=isolar($pix0,'href="/externo/bens/../../','','"') ) {
				$pix0=str_replace('href="/externo/bens/../../'.$pix,'', $pix0);

				if (str_replace('img-lote-default.png','',$pix)==$pix){
					$contapix+=1;
					if ($contapix<=8){

	echo '<br>Foto original: '.$pix;
						$resp['ll_foto_'.$contapix]=$baseurl.'/'.$pix;
					} else {
						$pix0='';
					}
				}
			}


			$vetor_categoria=adivinha_categoria($resp['ll_descricao']);

			if (sizeof($vetor_categoria)>0){

				$resp['ll_categoria_txt']=$vetor_categoria[0];
				$resp['ll_categoria_rotulo']=$vetor_categoria[0];

				if (sizeof($vetor_categoria)>1){
					$resp['ll_categoria_txt'].=','.$vetor_categoria[1];
					$resp['ll_categoria_rotulo']=$vetor_categoria[1];
				}
			}
		


			if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) || str_replace('SUCATA','',strtoupper($resp['ll_agregador']))!=strtoupper($resp['ll_agregador'])){
				$resp['ll_categoria_txt'].=','.'SUCATAS';
				$resp['ll_categoria_rotulo']=' SUCATAS';
			}
				
			$resp['ll_cidade']=$cidade;
			$resp['ll_uf']=$uf;
			if ($local!='' ){
				$local=str_replace(' - ','-',$local);
				$resp['ll_uf']=substr($local,-2);
				if (strlen($resp['ll_uf'])==2){				
					$sqlqry="SELECT * FROM uf WHERE uf='".$resp['ll_uf']."' LIMIT 1";
					$statement = $pdo->query($sqlqry);
					if (!$statement->fetch(PDO::FETCH_ASSOC) ){
						$resp['ll_uf']='';
					} else {
						$resp['ll_cidade']=substr($local,0,strlen($local)-3);
					}
				} else {
					//$resp['ll_uf']='';
				}

			}

			
			if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
				echo '<br><font color="green">* Imóvel</font>';
				$geolocalizacao=geolocalizacao('','',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);
			} else {
				$geolocalizacao=geolocalizacao('','',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais'],false);
			}

			if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
			if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

			if ($teste){
				print_r($resp);echo '<br><br>'; 
				

/*
echo str_replace('<','
<',$texto_lote); exit;


				exit;*/
			} else {
				echo NovoLeilao ($resp,array(),0,0,0,0,false);
				//exit;
				// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
			}
		}


	} else {
		//$texto='';
		echo '/ ';
		
	}
}

function Busca_site_0004_bomvalor ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina=30,$teste=false,$texto=''){
  // 2021 07
  global $pdo;
  set_time_limit (600);


	$resposta_robo=false;
	if ($teste){echo '[teste ligado]';}

	if (substr($url,-1)!='/'){$url.='/';}
	if (substr($baseurl,-1)!='/' && $baseurl!=''){$baseurl.='/';}

	$atingiutempolimite=false;
	$tempoinicio_organizador=date("YmdHis");
	$lotescadastrados=0;

	$proxima_categoria=max(1,(int)organizador_inicia ($idorganizador));
	
	$texto= limpacaracteresutf8_novo(http_get_curl($url,'firefox',false,false));
	
	$categorias_vetor=explode('<li class="dropdown',isolar($texto,'<ul class="nav nav-pills"','','</ul'));

//echo '**'; print_r($categorias_vetor);
	for ($i=$proxima_categoria;$i<=sizeof($categorias_vetor);$i++){ // <== ignora o primeiro elemento
		$ll_categoria=strtoupper(isolar_limpo($categorias_vetor[$i],'<a','','<'));
		$lic_natureza='';
		
		if ($ll_categoria=='JUDICIAL' || $ll_categoria=='JUDICIAIS'){$ll_categoria='';$lic_natureza='1';}
		if ($ll_categoria=='EXTRAJUDICIAL' || $ll_categoria=='EXTRAJUDICIAIS' || $ll_categoria=='EXTRA JUDICIAL' || $ll_categoria=='EXTRA JUDICIAIS' || $ll_categoria=='EXTRA-JUDICIAL' || $ll_categoria=='EXTRA-JUDICIAIS'){$ll_categoria='';$lic_natureza='0';}
		
		$link=isolar($categorias_vetor[$i],'href="/','','"');
				
		if ($link!='' && str_replace('/','',$link)==$link && str_replace('maisacessados','',$link)==$link){
			echo '
<br><strong>Categoria '.$ll_categoria.'</strong>: '.$link;

			$texto00= limpacomentarios(limpacaracteresutf8_novo(http_get_curl($url.$link,'firefox',false,false)));
			
			//echo $texto00; exit;	
			$geoloc_bomvalor=explode('{',isolar($texto00,'var locations = [','',']'));	
//			print_r($geoloc_bomvalor);


			
			$cards_vetor=explode('id="card-vitrine"',$texto00);

			for ($j=1;$j<=sizeof($cards_vetor);$j++){
				if (str_replace('Em loteamento','',$cards_vetor[$j])==$cards_vetor[$j]){

					$resp=array();
					$resp['organizador']=$idorganizador;
					$resp['ll_pais']='BRASIL';
					$resp['ll_idioma']='pt-BR';
					$resp['ll_moeda']='BRL';
					$ll_link=isolar_limpo($cards_vetor[$j],'href="','','"');
					$ll_link2=substr($ll_link,1-strlen($ll_link));
					$resp['ll_link']=$url.$ll_link2;
					$resp['ll_numero']=isolar_limpo($cards_vetor[$j],'>ID:','','<');

					
					if (!VerificaCadastroLeilao($resp)){
						
						$id=(int)isolar_reverso($ll_link.'§','-','§');

						$resp['ll_categoria_txt']=str_replace('-',' ',isolar_limpo($ll_link,'/','','/'));
						$resp['ll_categoria_rotulo']=str_replace('-',' ',isolar_limpo($ll_link,'/','/','/'));
						if ($resp['ll_categoria_txt']!=$resp['ll_categoria_rotulo']){$resp['ll_categoria_txt'].=','.$resp['ll_categoria_rotulo'];}

						if ($id>0 && $resp['ll_numero']!='' && $ll_link!='' && $resp['ll_categoria_txt']!='' && $resp['ll_categoria_rotulo']!=''){
							

							$resposta_robo=true;
							$resp['ll_foto_1']=isolar_limpo($cards_vetor[$j],'background-image: url(','',')');
							$resp['ll_descricao']=isolar_limpo($cards_vetor[$j],'<h4','','</h4');
							$resp['ll_detalhes']=$resp['ll_descricao'];
							
							$ll_data_1=isolar_limpo($cards_vetor[$j],'<span id="dt_','','</spa');
							if (substr(' às ','',$ll_data_1)!=$ll_data_1){
								$ll_data_1=str_replace(' ','',str_replace(':','/',str_replace(' às ','/',$ll_data_1)));
							} else {
								$ll_data_1=str_replace(' ','/',str_replace(':','/',$ll_data_1));
							}
							$ll_data_1=substr($ll_data_1,0,10);
							$resp['ll_data_1']=arrumadata_robos($ll_data_1);
							
							$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($cards_vetor[$j],'<label id="vl_','$','</lab')));

							// busca geolocalização
							if (sizeof($geoloc_bomvalor)>0){
								for ($z=0;$z<sizeof($geoloc_bomvalor);$z++){
									if (str_replace($ll_link2,'',$geoloc_bomvalor[$z])!=$geoloc_bomvalor[$z]){
										$resp['ll_latitude']=isolar($geoloc_bomvalor[$z],'lat: ','',',');
										$resp['ll_longitude']=isolar($geoloc_bomvalor[$z],'lng: ','',',');
										$resp['ll_endereco']=isolar_limpo($geoloc_bomvalor[$z],'class="address"','','</');
										$resp['ll_uf']=isolar_reverso($resp['ll_endereco'].'§©§','-','§©§');
										$resp['ll_cidade']=isolar_reverso($resp['ll_endereco'],' - ',' - ');
										
										if (!$teste && ((int)$resp['ll_latitude']==0 || (int)$resp['ll_longitude']==0  )){
											
											if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
												echo '<br><font color="green">* Imóvel</font>';
												$geolocalizacao=geolocalizacao($resp['ll_endereco'],'','','',$resp['ll_pais']);
											} else {
												$geolocalizacao=geolocalizacao($resp['ll_endereco'],'','','',$resp['ll_pais'],false);
											}
											if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
											if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}
											if ($geolocalizacao[2]!='' && $resp['ll_uf']==''){$resp['ll_uf']=$geolocalizacao[2];}
											if ($geolocalizacao[3]!='' && $resp['ll_cidade']==''){$resp['ll_cidade']=$geolocalizacao[3];}		
											if ($geolocalizacao[4]!='' && $resp['ll_bairro']==''){$resp['ll_bairro']=$geolocalizacao[4];}
										}
										break;
									}
								}
							}
							
							if ($resp['ll_cidade']==''){
								$resp['ll_uf']=$uf;
								$resp['ll_cidade']=trim(isolar_reverso($resp['ll_descricao'],',','/'.$resp['ll_uf']));
								if ($resp['ll_cidade']==''){$resp['ll_cidade']=$cidade;}
								
								if (!$teste && ((int)$resp['ll_latitude']==0 || (int)$resp['ll_longitude']==0  )){
									if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
										echo '<br><font color="green">* Imóvel</font>';
										$geolocalizacao=geolocalizacao('','',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);
									} else {
										$geolocalizacao=geolocalizacao('','',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais'],false);
									}
									if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
									if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}
								}
							}
							
							$resp['ll_agregador_link']=$resp['ll_link'];


							if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) || str_replace('SUCATA','',strtoupper($resp['ll_agregador']))!=strtoupper($resp['ll_agregador'])){
								$resp['ll_categoria_txt'].=','.'SUCATAS';
								$resp['ll_categoria_rotulo']=' SUCATAS';
							}
								

							if ($teste){
								print_r($resp);echo '<br><br>'; 
								//exit;
							} else {
								echo NovoLeilao ($resp,array(),0,0,0,0,false);
							}
							//exit;
							// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){


							// ==================================
							$conta+=1;
									//if ($conta>5){exit;}
							// ==================================
							$tempoexecucao_organizador=diferencasegundos( $tempoinicio_organizador ,'');

							if ($tempoexecucao_organizador>CADASTRO_MAX_SEGUNDOS) {
								// atingiu tempo limite.
								$atingiutempolimite=true;
								goto fimdolaco;
							}


							//exit;

					//$tempoexecucao_organizador=99999;
						}



					} else {
						//$texto='';
						echo '/ ';
						
					}
				}
			}
		}
	}

	$proximo_card[2]=0;

	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		organizador_tempo_limite_atingido ($idorganizador,$i);
	echo '***
	tempo limite
	'; 
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}

	if ($resposta_robo){echo '<br>___________________________<br>'; }
	return $resposta_robo;

}

function Busca_site_0005_nyx ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina=30,$teste=false,$texto='',$busca_1='',$busca_2=''){
	
	$resposta_robo=false;
	
	if (substr($url,-1)!='/'){$url.='/';}
	$url0=substr($url,0,strlen($url)-1);
	
	set_time_limit (600);
	$atingiutempolimite=false;
	$tempoinicio_nyx=date("YmdHis");

	$r['extra']=organizador_inicia ($idorganizador);
	
	if ($teste){echo '<br>[modo teste]<br>';}

	$lotescadastrados=0;

	$proximo_card=explode('/',$r['extra'].'///');

	$conta=0;
	$conta_cards=0;
	$conta_principais=0;
	$conta_cards_internos=0;
	
	$pagina=1;
	$sufixo_pagina='';
	while ($pagina>0){
		
		echo '

<br><strong>Página '.$pagina.'</strong>: ';

		if ($pagina==1){
			$texto_com_cards0=limpacaracteresutf8_automatico(http_get_curl($url,'ie',true,false));
			$cookie=isolar($texto_com_cards0,'set-cookie: ','',';');
//echo $texto_com_cards0; exit;			
		} else {
			$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:92.0) Gecko/20100101 Firefox/92.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' ".
			"-H 'Connection: keep-alive' -H 'Cookie: $cookie' -H 'Upgrade-Insecure-Requests: 1' -H 'Sec-Fetch-Dest: document' -H 'Sec-Fetch-Mode: navigate' -H 'Sec-Fetch-Site: none' -H 'Sec-Fetch-User: ?1'";
			$resposta=http_post_curl_headers (str_replace($url.'/',$url,$url.$sufixo_pagina), $header, '', $cookie, false, false, false, '', true, 'GET');
					//function http_post_curl_headers ($url, $header, $fields, $cookies='',$limpa=true, $json=false, $xml=false, $json_montado='',$ssl_ignora=false,$request="POST", $gravaarquivo=false,$json2=false, $json_montado2='',$request2="GET", $timeout = 5, $CURLOPT_RETURNTRANSFER=1){
			$texto_com_cards0=limpacaracteresutf8_automatico($resposta['content']);
		}

		if ($busca_1!=''){$texto_com_cards0= str_replace($busca_1,'§=====iniciocard=====§',$texto_com_cards0);}
		if ($busca_2!=''){$texto_com_cards0= str_replace($busca_2,'§=====iniciocard=====§',$texto_com_cards0);}

		if ($busca_1=='' && $busca_2==''){
			$texto_com_cards0= 
				str_replace('col-lg-2','col-lg-X',str_replace('col-lg-3','col-lg-X',str_replace('col-lg-4','col-lg-X',
				str_replace('col-xl-2','col-xl-X',str_replace('col-xl-3','col-xl-X',str_replace('col-xl-4','col-xl-X',
				str_replace('col-mb-2','col-mb-X',str_replace('col-mb-3','col-mb-X',str_replace('col-mb-4','col-mb-X',
				str_replace('col-md-4','col-md-X',str_replace('col-md-5','col-md-X',str_replace('col-md-6','col-md-X',
				str_replace('col-sm-4','col-sm-X',str_replace('col-sm-5','col-sm-X',str_replace('col-sm-6','col-sm-X',
				$texto_com_cards0
				)))))))))))))));

			$texto_com_cards= 
				//str_replace('§=====iniciocard=====§" title=',' title=',
			
				str_replace('<div class="leilao-box','§=====iniciocard=====§',
				str_replace('<div class="d-block shadow">','§=====iniciocard=====§',str_replace('</main','§=====iniciocard=====§',
				str_replace('<section>','§=====iniciocard=====§',str_replace('</section>','§=====iniciocard=====§',str_replace('destaque-leilao','§=====iniciocard=====§',str_replace('leilao-home">','>§=====iniciocard=====§',
				//str_replace('class="d-block p-','§=====iniciocard=====§',str_replace('class="d-block border','§=====iniciocard=====§',str_replace('class="d-block shadow-sm','§=====iniciocard=====§',
				str_replace('fadeInUp','§=====iniciocard=====§',
				str_replace('leilao-hover-trigger','§=====iniciocard=====§',str_replace('<nav','§=====iniciocard=====§<nav',str_replace('<footer','§=====iniciocard=====§<',
				
				str_replace('col-md-X col-xl-X','§=====iniciocard=====§',
				str_replace('col-lg-X col-md-X','§=====iniciocard=====§',
				str_replace('col-sm-X col-md-X','§=====iniciocard=====§',
				str_replace('col-xl-X col-lg-X','§=====iniciocard=====§',str_replace('col-sm-X col-lg-X','§=====iniciocard=====§',str_replace('col-md-X col-lg-X','§=====iniciocard=====§',
				
				$texto_com_cards0
				)))))))))))))))));
			} else {$texto_com_cards=$texto_com_cards0;}


			$texto_com_cards2=isolar($texto_com_cards.'§©§','Abertos para Lances','','§©§');
			if ($texto_com_cards2==''){$texto_com_cards2=isolar($texto_com_cards.'§©§','>próximos leilões','','§©§');}
			if ($texto_com_cards2==''){$texto_com_cards2=isolar($texto_com_cards.'§©§','>em andamento<','','§©§');}
			if ($texto_com_cards2!=''){$texto_com_cards=$texto_com_cards2;}

			
/*
if ($pagina==1){echo $texto_com_cards; }
if ($pagina==2){echo $texto_com_cards; exit;}
*/
//echo $texto_com_cards; exit;

		while(  $texto_card_1=isolar($texto_com_cards,'§=====iniciocard=====§','','§=====iniciocard=====§') ) {
			$texto_com_cards=str_replace('§=====iniciocard=====§'.$texto_card_1,'', $texto_com_cards);

			$ll_link=trim(isolar($texto_card_1,'window.location.href=','','"'));
			if ($ll_link==''){$ll_link=trim(isolar(str_replace(' ','&',str_replace('"','',$texto_card_1)),'offer?url=','','&'));}
			if ($ll_link==''){$ll_link=trim(isolar($texto_card_1,'href="','','"'));}

			if (substr($ll_link,0,10)=='javascript' || substr($ll_link,-4)=='.pdf'){$ll_link=trim(isolar($texto_card_1,'href="leil','','"')); if ($ll_link!=''){
				$ll_link='leil'.$ll_link;
				
				if (substr($ll_link,-4)=='.pdf'){
					$ll_link=trim(isolar($texto_card_1,'href="leil','href="leil','"')); if ($ll_link!=''){$ll_link='leil'.$ll_link;}
				}
			}}

			if ($ll_link==''){$ll_link=trim(isolar(str_replace(' ','>',$texto_card_1),'href=','','>'));}

			if (substr($ll_link,0,10)=='javascript' || substr($ll_link,-4)=='.pdf'){$ll_link=trim(isolar(str_replace(' ','>',$texto_card_1),'href=leil','','>')); if ($ll_link!=''){
				$ll_link='leil'.$ll_link;
				
				if (substr($ll_link,-4)=='.pdf'){
					$ll_link=trim(isolar(str_replace(' ','>',$texto_card_1),'href=leil','href=leil','>')); if ($ll_link!=''){$ll_link='leil'.$ll_link;}
				}
			}}

			$conta_cards+=1;

		
			if ($conta_cards>=$proximo_card[0]){
				
				$texto_card_1_minusculas=capitalizacao_str($texto_card_1,false);

if ($teste){
echo '

---------++++++++++++++++++
Card '.$conta_cards.'
$ll_link='.$ll_link.'

'.$texto_card_1_minusculas;

}


/*
				if ($ll_link!='' && (str_replace('bg-success','',$texto_card_1_minusculas)!=$texto_card_1_minusculas || str_replace('aberto','',$texto_card_1_minusculas)!=$texto_card_1_minusculas || 
				//str_replace('futuro','',$texto_card_1_minusculas)!=$texto_card_1_minusculas || 
				str_replace('aguardando','',$texto_card_1_minusculas)!=$texto_card_1_minusculas  ) && (str_replace('futuro','',$texto_card_1_minusculas)==$texto_card_1_minusculas && str_replace('encerrado','',$texto_card_1_minusculas)==$texto_card_1_minusculas) ){
*/
				if ($ll_link!='' && str_replace('email-protection','',$ll_link)==$ll_link &&
				
				(str_replace('aguardando','',$texto_card_1_minusculas)==$texto_card_1_minusculas || 
						(str_replace('aguardando','',$texto_card_1_minusculas)!=$texto_card_1_minusculas && ( str_replace('r$','',$texto_card_1_minusculas)!=$texto_card_1_minusculas) )
				
				)
				
				&& str_replace('designa','',$texto_card_1_minusculas)==$texto_card_1_minusculas 
					&& (str_replace('encerrado','',$texto_card_1_minusculas)==$texto_card_1_minusculas || 
						(str_replace('encerrado','',$texto_card_1_minusculas)!=$texto_card_1_minusculas && ( str_replace('aberto','',$texto_card_1_minusculas)!=$texto_card_1_minusculas || str_replace('aberto','',$texto_card_1_minusculas)!=$texto_card_1_minusculas ) )
					) 
					&& str_replace('sustad','',$texto_card_1_minusculas)==$texto_card_1_minusculas && str_replace('em breve','',$texto_card_1_minusculas)==$texto_card_1_minusculas ){


				echo '
				
<br><strong>Card '.$conta_cards.'</strong>: ';
/*
echo '
==================================================
'.$texto_card_1.'
=================================================='; //exit;
*/

//echo $texto_card_1; exit;

					if (substr($ll_link,0,4)!='http'){$ll_link=str_replace($url.'/',$url,$url.$ll_link);}
					$resp0=array();
					$resp0['organizador']=$idorganizador;
					$resp0['ll_pais']='BRASIL';
					$resp0['ll_idioma']='pt-BR';
					$resp0['ll_moeda']='BRL';
					$resp0['ll_agregador_link']=$ll_link;

					$resp0['ll_agregador']=isolar_limpo($texto_card_1,'<h1','','</h1');
					if ($resp0['ll_agregador']==''){$resp0['ll_agregador']=isolar_limpo($texto_card_1,'<h2','','</h2');}
					if ($resp0['ll_agregador']==''){$resp0['ll_agregador']=isolar_limpo($texto_card_1,'<p class="mb-','','</p');}
					if ($resp0['ll_agregador']==''){$resp0['ll_agregador']=isolar_limpo($texto_card_1,'content-start','<li','</li');}
					if ($resp0['ll_agregador']==''){$resp0['ll_agregador']=isolar_limpo($texto_card_1,'title="','','"');}
					if ($resp0['ll_agregador']==''){$resp0['ll_agregador']=isolar_limpo($texto_card_1,'<span class="font-weight-bold','','</span');}
					if ($resp0['ll_agregador']==''){$resp0['ll_agregador']=isolar_limpo($texto_card_1,'leilao-subtitulo','','</li');}
					if ($resp0['ll_agregador']==''){$resp0['ll_agregador']=isolar_limpo($texto_card_1,'leilao-home-titulo','','</');}
					$resp0['ll_agregador']=str_replace('?','',$resp0['ll_agregador']);
					
					$resp0['ll_comitente']=isolar_limpo($texto_card_1,'<h3','','</h3');
					if ($resp0['ll_comitente']==''){$resp0['ll_comitente']=isolar_limpo($texto_card_1,'leilao-titulo','','</li');}
					if ($resp0['ll_comitente']==''){$resp0['ll_comitente']=isolar_limpo($texto_card_1,'<h1 itemprop="name">','','</h1');}

					$resp0['ll_link']=$resp0['ll_agregador_link']; // ==> usado só para testes em lotes com link direto
//print_r($resp0); //exit;
					if ($teste || !VerificaCadastroLeilao($resp0)){
					
						
						$resposta000=array();
//						$resposta000 = http_post ($resp0['ll_agregador_link'],'');
						$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:92.0) Gecko/20100101 Firefox/92.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' ".
							"-H 'DNT: 1' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1' -H 'Sec-Fetch-Dest: document' -H 'Sec-Fetch-Mode: navigate' -H 'Sec-Fetch-Site: none' -H 'Sec-Fetch-User: ?1'";
						$resposta000=http_post_curl_headers ($resp0['ll_agregador_link'], $header, '', '', false, false, false, '', true, 'GET');

						
						$texto_interno=limpacaracteresutf8_automatico($resposta000['content']);
						$link_texto_interno='';

						$resposta000['headers']=str_replace('location:','Location:',$resposta000['headers']);
						$link_texto_interno=trim(isolar($resposta000['headers'],'location:','',chr(10)));
						if ($link_texto_interno!=''){
							if (substr($link_texto_interno,0,4)!='http'){$link_texto_interno=str_replace($url.'/',$url,$url.$link_texto_interno);}
							$texto_interno= limpacaracteresutf8_automatico(http_get_curl($link_texto_interno,'ie',false,false));
						}
					
/*
						if (sizeof($resposta000['headers'])>0){
							for ($i=0;$i<sizeof($resposta000['headers']);$i++){

echo '
# '.$resposta000['headers'][$i];
								$resposta000['headers'][$i]=str_replace('location:','Location:',$resposta000['headers'][$i]);
								if (substr($resposta000['headers'][$i],0,9)=='Location:'){	
									$link_texto_interno=$url0.trim(isolar($resposta000['headers'][$i].'§©§','Location:','','§©§'));
									$texto_interno= limpacaracteresutf8_automatico(http_get_curl($link_texto_interno,'ie',false,true));
								}
							}
						}
*/
						if ($link_texto_interno==''){$link_texto_interno=$resp0['ll_link'];}

/*
echo '
$link_texto_interno='.$link_texto_interno.'
';*/
	//print_r($resposta000); exit;
	
/*
echo '

+++++++++++++++++==
'.$texto_interno; //exit;
*/

						// link direto para leilão ou para listagem de lotes?



						$texto_interno=isolar('§'.$texto_interno.'você pode gostar:','§','','você pode gostar:');
						$texto_interno_direto=$texto_interno;


						$texto_interno=str_replace('<div class="d-block p','<div class="leilao-lote',$texto_interno);
						$texto_interno_v2=str_replace('<li class="h1','<div class="leilao-lote',$texto_interno);

//						if (str_replace('<div class="leilao-lote','',$texto_interno_v2)==$texto_interno_v2){
/*
						$verific=isolar($texto_interno.'<div class="leilao-lote','<div class="leilao-lote','','<div class="leilao-lote');
						if (trim(isolar($verific,'href="lotes','','"'))==''){
*/

	//					if (isolar($texto_interno,'<div class="leilao-lote','','</a')==''){
						//if ($link_texto_interno!=''){
							// link direto


//						} else {
							// listagem de lotes
				echo '
=====[listagem de lotes]
';


//echo $texto_interno; exit;

							$resposta_robo0=false;
							$texto_interno=str_replace('<div class="leilao-lotey','<div class="',$texto_interno);
							$texto_interno=str_replace('<div class="col-md-6','<div class="leilao-lote',$texto_interno);
							$texto_interno=str_replace('<div class="d-block bg','<div class="leilao-lote',$texto_interno);
							$texto_interno=str_replace('<div class="py-1 px-2 bg','<div class="leilao-lote',$texto_interno);
							
							$texto_interno_v2=str_replace('<section>','<div class="leilao-lote >',$texto_interno);
							$texto_interno_v2=str_replace('<li class="h1','<div class="leilao-lote',$texto_interno_v2);
							$texto_interno_v2=str_replace('<div class="col-xs-12 leilao-lote"','<div class="leilao-lote',$texto_interno_v2);							
							
							if ($texto_interno_v2!=$texto_interno){$texto_interno=$texto_interno_v2;$tipo2=true; echo '[tipo 2]';}else{$tipo2=false;}

//echo $texto_interno;							

							while(  $texto_card_2=isolar($texto_interno.'<div class="leilao-lote','<div class="leilao-lote','','<div class="leilao-lote') ) {
								$texto_interno=str_replace('<div class="leilao-lote'.$texto_card_2,'', $texto_interno);
/*
			echo '
			------------------=======================
			';//.$texto_card_2; //exit;
*/

								$texto_card_2=str_replace('href="/lotes','href="lotes',$texto_card_2);
								$ll_link2=trim(isolar($texto_card_2,'href="lotes','','"'));
								if ($ll_link2==''){$ll_link2=trim(isolar($texto_card_2,'href="'.$url.'lotes','','"'));}

								if ($ll_link2!=''){

									$resp=$resp0;
									$resp['ll_link']=$url.'lotes'.$ll_link2;
									if (str_replace("'",'',$resp['ll_link'])==$resp['ll_link'] && str_replace('login','',$resp['ll_link'])==$resp['ll_link']  && str_replace('cadastre-se','',$resp['ll_link'])==$resp['ll_link'] && str_replace('.href+','',$resp['ll_link'])==$resp['ll_link']){
//print_r($resp); exit;									
				/*
									$valores=isolar($texto_card_2,'lote-valores','','">Incremento');
									$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($valores,'R$','','</')));
									$resp['ll_lance_min_2']=str_replace(',','.',str_replace('.','',isolar_limpo($valores,'R$','R$','</')));
				*/
										$texto_trabalho= limpacaracteresutf8_automatico(http_get_curl($resp['ll_link'],'ie',false,false));

	//									$texto_trabalho= http_get_curl($resp['ll_link'],'ie',false,true);


										$texto_trabalho=isolar('§'.$texto_trabalho.'você pode gostar:','§','','você pode gostar:');

										if (!$tipo2){
											$resposta_robo0=Busca_site_0005_nyx_processa ($resp,$texto_trabalho,$texto_card_1,$texto_card_2,$idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina,$teste);
										} else {
											$resposta_robo0=Busca_site_0005_nyx_processa ($resp,$texto_trabalho,$texto_card_1,$texto_card_1,$idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina,$teste);
										}
				//						if ($teste){exit;}

										// ==================================
										$conta+=1;
												//if ($conta>5){exit;}
										// ==================================
										$tempoexecucao_nyx=diferencasegundos( $tempoinicio_nyx ,'');

										if ($tempoexecucao_nyx>CADASTRO_MAX_SEGUNDOS) {
											// atingiu tempo limite.
											$atingiutempolimite=true;
											goto fimdolaco;
										}
									}		
								}
							}
//						}
						//if ($teste){exit;}
		//exit;
							if (!$resposta_robo0){

echo '
=====[link direto]
	'; 


								//$texto_interno= http_get_curl($link_texto_interno,'ie',false,true);

								$resp=$resp0;
								$resp['ll_link']=$link_texto_interno;
								if (str_replace("'",'',$resp['ll_link'])==$resp['ll_link'] && str_replace('login','',$resp['ll_link'])==$resp['ll_link']  && str_replace('cadastre-se','',$resp['ll_link'])==$resp['ll_link'] && str_replace('.href+','',$resp['ll_link'])==$resp['ll_link']){

									$resposta_robo0=Busca_site_0005_nyx_processa ($resp,$texto_interno_direto,$texto_card_1,$texto_card_1,$idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina,$teste);
									//if ($teste){exit;}


									// ==================================
									$conta+=1;
											//if ($conta>5){exit;}
									// ==================================
									$tempoexecucao_nyx=diferencasegundos( $tempoinicio_nyx ,'');

									if ($tempoexecucao_nyx>CADASTRO_MAX_SEGUNDOS) {
										// atingiu tempo limite.
										$atingiutempolimite=true;
										goto fimdolaco;
									}
								}
							}

							if ($resposta_robo0){$resposta_robo=true;}
//exit;

					}

				}
//exit;
			}
		}

//exit;
		$texto_com_cards0=capitalizacao_str($texto_com_cards0,false);
		$sufixo_pagina2=isolar(isolar_reverso($texto_com_cards0,'<a','>próxima'),'href="','','"');
		if ($sufixo_pagina2=='' && str_replace('/home/leiloes/'.($pagina+1).'"','',$texto_com_cards0)!=$texto_com_cards0){$sufixo_pagina2='/home/leiloes/'.($pagina+1);}
		if ($sufixo_pagina2=='' && str_replace('/agenda/leiloes/'.($pagina+1).'"','',$texto_com_cards0)!=$texto_com_cards0){$sufixo_pagina2='/agenda/leiloes/'.($pagina+1);}
		if ($sufixo_pagina2=='' && str_replace('pagina-inicial/0/pg/'.($pagina+1).'"','',$texto_com_cards0)!=$texto_com_cards0){$sufixo_pagina2='/pagina-inicial/0/pg/'.($pagina+1);}
		if ($sufixo_pagina2=='' && str_replace('pagina/'.($pagina+1).'"','',$texto_com_cards0)!=$texto_com_cards0){$sufixo_pagina2='/pagina/'.($pagina+1);}
		if ($sufixo_pagina2!=$sufixo_pagina && $sufixo_pagina2!='' && str_replace('gina '.$pagina.' de '.$pagina,'',$texto_com_cards0)==$texto_com_cards0){$pagina+=1;$sufixo_pagina=$sufixo_pagina2;}else {$pagina=0;}
	}
		

	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		if (!$teste){organizador_tempo_limite_atingido ($idorganizador,$conta_cards);}
	echo '***
	tempo limite
	'; 
	} else {
		echo '**** Finalizou tudo';
		if (!$teste){organizador_finaliza ($idorganizador);}
	}
	
	return $resposta_robo;
}

function Busca_site_0005_nyx_processa ($resp,$texto_trabalho,$texto_card_1,$texto_card_2,$idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina,$teste){
    global $pdo;


//print_r($resp); //exit;
	if ($teste || !VerificaCadastroLeilao($resp)){

//if ($resp['ll_link']=='https://www.clebercardosoleiloes.com.br/lotes/401-002-1955-casa-residencial-2-dormitorio-s-1-vaga-s-de-garagem'){$teste=false;}

		$texto_trabalho=str_replace('&sup2;', '²', str_replace('&rdquo;', '', str_replace('&ldquo;', '', $texto_trabalho)));
/*
echo '

&&&&&&&&&&&&&&&&&

'.$texto_trabalho;*/
		$ll_natureza=strtolower(isolar_limpo($texto_trabalho,'<strong>Leilão:</strong>','','</tr').limpahtml($texto_card_1).isolar_limpo($texto_trabalho,'<h2','','<footer'));

		if (str_replace('extra','',$ll_natureza)==$ll_natureza && str_replace('judicial','',$ll_natureza)!=$ll_natureza){$resp['ll_natureza']='1';}

		$texto_trabalho_minusculas=str_replace('&nbsp;','',str_replace('ªª','ª',str_replace('ªpra','ª pra',str_replace('ªº','ª',str_replace('1?','1ª',str_replace('2?','2ª',str_replace(' até ',' à ',str_replace('leilão','praça',str_replace('leilão<','leilão:<',str_replace('único:','praça:',str_replace('única:','praça:',str_replace('praça<','praça:',str_replace('chamada:','praça:',str_replace('º','ª',str_replace('°','ª',str_replace(chr(9),' ',capitalizacao_str($texto_trabalho,false)))))))))))))))));
		$texto_card_2_minusculas=str_replace('&nbsp;','',str_replace('ªª','ª',str_replace('ªpra','ª pra',str_replace('ªº','ª',str_replace('1?','1ª',str_replace('2?','2ª',str_replace(' até ',' à ',str_replace('leilão','praça',str_replace('encerrado','r$',str_replace('vide rel','r$',str_replace('leilão<','leilão:<',str_replace('único:','praça:',str_replace('única:','praça:',str_replace('praça<','praça:<',str_replace('chamada:','praça:',str_replace('º','ª',str_replace('°','ª',str_replace(chr(9),' ',capitalizacao_str($texto_card_2,false)))))))))))))))))));
		$texto_card_1_minusculas=str_replace('&nbsp;','',str_replace('ªª','ª',str_replace('ªpra','ª pra',str_replace('ªº','ª',str_replace('1?','1ª',str_replace('2?','2ª',str_replace(' até ',' à ',str_replace('leilão','praça',str_replace('encerrado','r$',str_replace('vide rel','r$',str_replace('leilão<','leilão:<',str_replace('único:','praça:',str_replace('única:','praça:',str_replace('praça<','praça:<',str_replace('chamada:','praça:',str_replace('º','ª',str_replace('°','ª',str_replace(chr(9),' ',capitalizacao_str($texto_card_1,false)))))))))))))))))));

		$praca1=str_replace(' - ',' às ',isolar($texto_trabalho,'</thead','','</tbody'));
		$praca2=isolar($praca1,'</tr','</th','</tr');
		$praca1=isolar($praca1,'</th','','</tr');

		$resp['ll_data_1']=isolar_limpo($praca1,'</td','','</td'); if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}
		$resp['ll_data_2']=isolar_limpo($praca2,'</td','','</td'); if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}
		$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca1,'R$','','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}
		$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca2,'R$','','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}

/*
echo '

======================
1 - '.$texto_card_1_minusculas.'

';
*/

/*
echo '
### '.str_replace('
</','</',str_replace('<','
<',$texto_trabalho));*/

		
		if ($resp['ll_data_1']==''){
			$praca0=str_replace(' - ',' às ',isolar($texto_card_1_minusculas,'<div class="leilao-pracas','','</a'));
			$praca1=isolar($praca0.'leilao-praca','leilao-praca','','leilao-praca');
			$praca2=isolar($praca0.'§©§','leilao-praca','leilao-praca','§©§');
			
			$resp['ll_data_1']=isolar_limpo($praca1,'</spa','','</spa'); if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}
			if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($praca2,'</spa','','</spa'); if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
			$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca1,'r$','','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}
			$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca2,'r$','','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}
		}

		if ($resp['ll_data_1']=='' || $resp['ll_lance_min_1']==''){
			$praca1=str_replace(' - ',' às ',isolar($texto_trabalho_minusculas,'<tr class="bg-2','','</tbody'));
			$praca2=isolar($praca1,'</tr','','</tr');
			$praca1=isolar($praca1,'>','','</tr');
			
			if (str_replace('1ª praça','',$praca1)==$praca1 && str_replace('2ª praça','',$praca1)!=$praca1){$praca1='';}
			if (str_replace('2ª praça','',$praca2)==$praca2 && str_replace('1ª praça','',$praca2)!=$praca2){$praca2='';}

			if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($praca1,'</td','','</td'); if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
			if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($praca2,'</td','','</td'); if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
			$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca1,'R$','','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}
			$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca2,'R$','','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}
			
			if ($resp['ll_data_1']==''){
				$praca1=isolar($texto_card_1,'<div class="leilao-pracas">','','</a');
				$praca2=isolar($praca1.'§©§','leilao-praca">','leilao-praca">','§©§');
				$praca1=isolar($praca1,'leilao-praca">','','leilao-praca">');
				$resp['ll_data_1']=isolar_limpo($praca1,'</spa','','</spa'); if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}
				if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($praca2,'</spa','','</spa'); if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
				$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca1,'R$','','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}
				$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca2,'R$','','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}
			}
		}

		if ($resp['ll_data_1']=='' || $resp['ll_lance_min_1']==''){
			$praca1=str_replace(' - ',' às ',isolar($texto_trabalho_minusculas,'<tr class="text-secondary','','</tbody'));
			if (str_replace('2ª','',$praca1)!=$praca1&&str_replace('1ª','',$praca1)==$praca1){
				$praca0=isolar_reverso($texto_trabalho_minusculas,'<tbody',$praca1);
				$praca1=$praca0.$praca1;
			}

			$praca2=isolar($praca1,'</tr','','</tr');
			$praca1=isolar($praca1,'>','','</tr');

			if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($praca1,'</td','','</td'); if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
			if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($praca2,'</td','','</td');}
			$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca1,'r$','','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}
			$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca2,'r$','','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}
			
			if ($resp['ll_data_1']==''){
				$praca1=isolar($texto_card_1,'<div class="leilao-pracas">','','</a');
				$praca2=isolar($praca1.'§©§','leilao-praca">','leilao-praca">','§©§');
				$praca1=isolar($praca1,'leilao-praca">','','leilao-praca">');
				$resp['ll_data_1']=isolar_limpo($praca1,'</spa','','</spa'); if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}
				if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($praca2,'</spa','','</spa'); if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
				$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca1,'r$','','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}
				$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca2,'r$','','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}
			}
		}

		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'fa-calendar','</str','</li');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}

		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:',' à ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:','','r$');	if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:',' à ','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:','','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'fechamento','|','</');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'encerra em',':','</li');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}

		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:','encerramento:','</ul');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:',' a ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:',' à ',' às ');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:',' a ',' às ');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo(str_replace('vide ','r$',$texto_card_1_minusculas),'praça -',' a ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}

		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça',' à ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça',' à ','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça','','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'ª praça','</','</');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'>praça','</','</');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça','encerramento:','</ul');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça',' a ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça',' à ',' às ');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça',' a ',' às ');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'encerramento:','</','</');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_reverso($texto_card_1_minusculas,'>','/'.date("Y"));if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}else{$resp['ll_data_1'].='/'.date("Y");}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_reverso($texto_card_1_minusculas,'>','/'.(date("Y")+1));if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}else{$resp['ll_data_1'].='/'.(date("Y")+1);}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:','','</');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}

		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_card_2_minusculas,'praça:','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_2_minusculas,'praça:',' à ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_2_minusculas,'praça:','','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_2_minusculas,'praça:',' à ','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_2_minusculas,'praça:','','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_2_minusculas,'praça:','encerramento:','</ul');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}

		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'praça:','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}

		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_trabalho_minusculas,'praça:',' à ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_trabalho_minusculas,'praça:','','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_trabalho_minusculas,'praça:',' à ','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
		if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_trabalho_minusculas,'praça:','','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}

		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_card_2_minusculas,'lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_card_2_minusculas,'>lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_card_2_minusculas,'>lance inicial','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'>lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'>lance inicial','r$','<'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'> lance inicial','r$','<'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace('r$','',str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'<td itemprop="price">','','</td')))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',str_replace('r$','',isolar_limpo($texto_trabalho_minusculas,'<td>lance mínimo','<td','</td')))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_card_1_minusculas,'>praça','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}

		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas,'fa-calendar','fa-calendar','/li'),'</str','','<');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}

		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','r$','§©§'),'praça:',' à ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','r$','§©§'),'praça:','','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','confira','§©§'),'praça:',' à ','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','confira','§©§'),'praça:','','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','fechamento','','§©§'),'fechamento','|','</');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','encerra em','','§©§'),'encerra em',':','</li');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','','§©§'),'praça:','encerramento:','</ul');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','r$','§©§'),'praça:',' a ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','','§©§'),'praça:',' à ',' às ');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','','§©§'),'praça:',' a ',' às ');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar(str_replace('vide ','r$',$texto_card_1_minusculas).'§©§','praça -','r$','§©§'),'praça -',' a ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar(str_replace('vide ','r$',$texto_card_1_minusculas).'§©§','praça:','r$','§©§'),'praça:',' a ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar(str_replace('vide ','r$',$texto_card_1_minusculas).'§©§','praça:','r$','§©§'),'praça:','','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}

		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','r$','§©§'),'praça',' à ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','r$','§©§'),'praça','','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','confira','§©§'),'praça',' à ','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','confira','§©§'),'praça','','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($texto_card_1_minusculas,'2ª praça','</','</');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($texto_card_1_minusculas,'2ª praça','</','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($texto_card_1_minusculas,'2ª praça','</','>veja ');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','encerramento:','§©§'),'praça','encerramento:','</ul');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','r$','§©§'),'praça',' a ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','','§©§'),'praça',' à ',' às ');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','','§©§'),'praça',' a ',' às ');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','encerramento:','','§©§'),'encerramento:','</','</');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($texto_card_1_minusculas,'2ª praça:','','</');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}

		if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(str_replace(' mínimo','',str_replace('ª ','ª',str_replace('?','ª',str_replace('º','ª',$texto_card_2_minusculas)))),'lance 2ªpraça','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
		if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(str_replace('ª ','ª',str_replace('?','ª',str_replace('º','ª',$texto_card_1_minusculas))),'2ªpraça','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
		if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(str_replace('ª ','ª',str_replace('?','ª',str_replace('º','ª',$texto_card_2_minusculas))),'2ªpraça','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
		if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(str_replace('ª ','ª',str_replace('?','ª',str_replace('º','ª',$texto_card_2_minusculas))),'2ªpraça','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
		if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','r$','§©§'),'praça:','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','r$','§©§'),'praça:',' à ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','r$','§©§'),'praça:','','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','confira','§©§'),'praça:',' à ','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','confira','§©§'),'praça:','','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','','§©§'),'praça:','encerramento:','</ul');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}

		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','praça:','r$','§©§'),'praça:',' à ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','praça:','r$','§©§'),'praça:','','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','praça:','confira','§©§'),'praça:',' à ','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
		if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','praça:','confira','§©§'),'praça:','','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}

		if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','>lance mínimo','r$','§©§'),'>lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
		if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','>lance inicial','r$','§©§'),'>lance inicial','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
		if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_card_2_minusculas.'§©§','>lance mínimo','r$','§©§'),'>lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
		if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_card_2_minusculas.'§©§','>lance inicial','r$','§©§'),'>lance inicial','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
		if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','praça:','r$','§©§'),'praça:','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}

		if ($resp['ll_data_2']!='' && $resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=$resp['ll_lance_min_1'];}
		if ($resp['ll_data_2']!='' && $resp['ll_lance_min_2']!='' && $resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=$resp['ll_lance_min_2'];}
		if ($resp['ll_data_2']=='' && $resp['ll_lance_min_2']!=''){$resp['ll_lance_min_2']='';}

		if (str_replace(' à ','',$resp['ll_data_1'])!=$resp['ll_data_1']){$resp['ll_data_1']=isolar($resp['ll_data_1'].'§©§',' à ','','§©§');}
		if (str_replace(' à ','',$resp['ll_data_2'])!=$resp['ll_data_2']){$resp['ll_data_2']=isolar($resp['ll_data_2'].'§©§',' à ','','§©§');}

//		$data_temp=isolar('§'.$resp['ll_data_1'],'§','',chr(10)); if (strlen($data_temp)>6){$resp['ll_data_1']=$data_temp;}
//		$data_temp=isolar('§'.$resp['ll_data_2'],'§','',chr(10)); if (strlen($data_temp)>6){$resp['ll_data_2']=$data_temp;}
		$data_temp=explode(chr(10),$resp['ll_data_1']);
		for ($ii=0;$ii<sizeof($data_temp);$ii++){
			$data_temp[$ii]=str_replace('-','/',$data_temp[$ii]);
			if(str_replace('/','',$data_temp[$ii])!=$data_temp[$ii]){$resp['ll_data_1']=$data_temp[$ii];break;}	
		}
		$data_temp=explode(chr(10),$resp['ll_data_2']);
		for ($ii=0;$ii<sizeof($data_temp);$ii++){
			$data_temp[$ii]=str_replace('-','/',$data_temp[$ii]);
			if(str_replace('/','',$data_temp[$ii])!=$data_temp[$ii]){$resp['ll_data_2']=$data_temp[$ii];break;}	
		}

echo '

v1='.$resp['ll_lance_min_1'].'
v2='.$resp['ll_lance_min_2'].'

d1='.$resp['ll_data_1'].'
d2='.$resp['ll_data_2'].'
';

		$resp['ll_data_1']=arrumadata_robos(str_replace('-','/',str_replace(' ','/',str_replace('H','',str_replace(' às ','/',$resp['ll_data_1'])))),6,true);
		$resp['ll_data_2']=arrumadata_robos(str_replace('-','/',str_replace(' ','/',str_replace('H','',str_replace(' às ','/',$resp['ll_data_2'])))),6,true);

		if ($resp['ll_data_1']==$resp['ll_data_2']){$resp['ll_data_2']='';$resp['ll_lance_min_2']='';}
		
		$resp['ll_avaliacao']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho,'>Avaliação:','R$','</')));

		$resp['ll_descricao']=isolar_limpo($texto_trabalho,'"og:title"','content="','"');
		if ($resp['ll_descricao']==''){$resp['ll_descricao']=trim(isolar_limpo($texto_trabalho,'<h1','','</h1').' '.isolar_limpo($texto_trabalho,'<h2','','</h2'));}
		$resp['ll_descricao']=str_replace('?','',$resp['ll_descricao']);
		if($resp['ll_descricao']=='Próximos Leilões'){$resp['ll_descricao']='';}
		
		if ($teste || ($resp['ll_descricao']!='' && $resp['ll_descricao']!='Acesso de usurios' && $resp['ll_descricao']!='Acesso de usuários')){
			if($resp['ll_descricao']!=''){$resposta_robo=true;}

			$lotes=isolar($texto_trabalho,'<select name="lote','','</select');
			$resp['ll_lote']=trim(limpaespacos(str_replace('VER ','',str_replace('LOTE','',strtoupper(isolar_limpo(str_replace('Nº','',str_replace('N°','',$lotes)),'selected>','','</option'))))));
			if ($resp['ll_lote']==''){$resp['ll_lote']=trim(limpaespacos(str_replace('VER ','',str_replace('LOTE','',strtoupper(isolar_limpo(str_replace('Nº','',str_replace('N°','',$texto_trabalho)),'dropdown-item active','','</a'))))));}
			if ($resp['ll_lote']==''){$resp['ll_lote']=trim(limpaespacos(str_replace('VER ','',str_replace('LOTE','',strtoupper(isolar_limpo(str_replace('Nº','',str_replace('N°','',$texto_trabalho)),'>Número do lote:','','</'))))));}		
			if ($resp['ll_lote']==''){$resp['ll_lote']=trim(limpaespacos(str_replace('VER ','',str_replace('LOTE','',strtoupper(isolar_limpo(str_replace('Nº','',str_replace('N°','',$texto_trabalho)),'id="dropdownLotes"','','</'))))));}		
			if ($resp['ll_lote']==''){$resp['ll_lote']=trim(limpaespacos(str_replace('VER ','',strtoupper(isolar_limpo(str_replace('Nº','',str_replace('N°','',$texto_trabalho)),'o do lote" data-toggle="tab">Lote','','</')))));}		
			if ($resp['ll_lote']==''){$resp['ll_lote']=trim(limpaespacos(str_replace('VER ','',strtoupper(isolar_limpo(str_replace('Nº','',str_replace('N°','',$texto_card_2_minusculas)),'>lote ','','</')))));}		

			
			
			if ($resp['ll_lote']==''){
				$resp['ll_lote']=trim(limpaespacos(str_replace('ver ','',isolar_limpo(str_replace('Nº','',str_replace('n°','',$texto_card_1_minusculas)),'lote ','','</')))); 
				if (strlen($resp['ll_lote'])>6){$resp['ll_lote']='';}
			}
			
			$resp['ll_processo']=trim(isolar_limpo($texto_trabalho,'>Processo:','','</li'));
			if ($resp['ll_processo']==''){$resp['ll_processo']=trim(isolar_limpo($texto_trabalho,'>Processo',':','</'));}


//if ($resp['ll_descricao'] == 'Apartamento Jatiuca'){echo $texto_trabalho; exit;}

//echo $texto_trabalho;			
			
			$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('Descrição completa do lote:','',$texto_trabalho))),'id="sobre-lote"','','</p');if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'<article','','</article');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'<div id="lote_descricao"','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'itemprop="description">','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'<div id="lote_descricao"','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'>DESCRIÇÃO','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',$texto_trabalho))),'Descrição completa do lote:','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'>Descrição','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'>descrição','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'<div class="tab-content ','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'lote-descricao','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'descricao-lote','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'<p align="justify">','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'>Mais informações','','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}
			if ($resp['ll_detalhes']==''){$resp['ll_detalhes']=isolar_limpo(str_replace('</p','.~ <',str_replace('<br>','.~ ',str_replace('<li','.~ <li',str_replace('Descrição completa do lote:','',$texto_trabalho)))),'>Mais informações','<div','</div');}if ($resp['ll_detalhes']=='.~'){$resp['ll_detalhes']='';}


			$resp['ll_detalhes']=limpaespacos(limpacaracteresfantasma(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
			$resp['ll_detalhes'])))))))));


			$contapix=0;
			$pix0=str_replace('</li','</div',str_replace('class="galeria"','><div class="carousel-item',str_replace('<div class="carousel-slide','<div class="carousel-item',$texto_trabalho)));

//echo $pix0;
			
			while(  $pix=isolar($pix0,'<div class="carousel-item','','</div') ) {
				$pix0=str_replace('<div class="carousel-item'.$pix,'', $pix0);


				$pix2=isolar($pix,'src="','','"');
				if (substr($pix2,0,10)=='data:image'){$pix2='';}
				if ($pix2==''){$pix2=isolar($pix,'background-image','url(',')');}
				if (substr($pix2,0,10)=='data:image'){$pix2='';}
				if ($pix2==''){$pix2=isolar($pix,'data-src="','','"');}
				if (substr($pix2,0,10)=='data:image'){$pix2='';}
				
				$pix=$pix2;

				if (str_replace('img-lote-default.png','',$pix)==$pix && str_replace('/600x400.gif','',$pix)==$pix){
					$contapix+=1;
					if ($contapix<=8){

	echo '<br>Foto original: '.$pix;
						if (substr($pix,0,4)!='http'){$pix=str_replace($url.'/',$url,$url.$pix);}
						$resp['ll_foto_'.$contapix]=$pix;
					} else {
						$pix0='';
					}
				}
			}

//echo $texto_trabalho;
			
			$resp['ll_uf']=substr($resp['ll_descricao'],-2);
			$resp['ll_cidade']='';
			if (strlen($resp['ll_uf'])==2){				
				$sqlqry="SELECT * FROM uf WHERE uf='".$resp['ll_uf']."' LIMIT 1";
				$statement = $pdo->query($sqlqry);
				if (!$statement->fetch(PDO::FETCH_ASSOC) ){	$resp['ll_uf']='';}
			} else {$resp['ll_uf']='';}

			if ($resp['ll_uf']==''){
				$resp['ll_cidade']=trim(isolar_reverso(str_replace('-',',',$resp['ll_descricao']),',','/'.$resp['ll_uf']));
				if ($resp['ll_cidade']!=''){$resp['ll_uf']=$uf;}
			}
		

			if ($resp['ll_cidade']==''){
				$resp['ll_cidade']=trim(str_replace('-Data:-','',isolar_reverso($resp['ll_descricao'],',','/'.$resp['ll_uf'])));
	//echo '<br><font color="blue">'.$resp['ll_descricao'].'<br>¹'.$resp['ll_cidade'].'</font> ';			
			}
			if ($resp['ll_cidade']==''){
				$resp['ll_cidade']=str_replace('-Data:-','',isolar_limpo($texto_trabalho,'>Cidade:','','</div'));
	//echo '<br><font color="blue">'.$resp['ll_descricao'].'<br>¹'.$resp['ll_cidade'].'</font> ';			
			}

			if ($resp['ll_uf']==''){
				$possivel_cidade=str_replace('-Data:-','',trim(isolar_reverso($resp['ll_descricao'].'§',',','§')));
				$sqlqry="SELECT * FROM geolocalizacao WHERE geo_cidade!='' AND geo_cidade='".$possivel_cidade."' AND cod_IBGE>0 LIMIT 1";
				$statement = $pdo->query($sqlqry);
				if ($r = $statement->fetch(PDO::FETCH_ASSOC) ){
						$resp['ll_uf']=$r['geo_uf'];
						$resp['ll_cidade']=$possivel_cidade;
	echo '<br>Cidade deduzida: '.$possivel_cidade.'<br>';
				}
			}

			
			if ($resp['ll_cidade']==''){$resp['ll_cidade']=trim(str_replace('-Data:-','',isolar_reverso(str_replace('-',',',$resp['ll_descricao']),',','/'.$resp['ll_uf'])));}
			if ($resp['ll_cidade']==''){$resp['ll_cidade']=trim(str_replace('-Data:-','',isolar_reverso(str_replace('-',',',$resp['ll_descricao']),',','/ '.$resp['ll_uf'])));}
			if ($resp['ll_cidade']==''){$resp['ll_cidade']=trim(str_replace('-Data:-','',isolar_reverso(str_replace('-',',',$resp['ll_descricao']),',','-'.$resp['ll_uf'])));}
			if ($resp['ll_cidade']==''){$resp['ll_cidade']=trim(str_replace('-Data:-','',isolar_reverso(str_replace('-',',',$resp['ll_descricao']),',','- '.$resp['ll_uf'])));}
			
			
	//echo '<br><font color="blue">²'.$resp['ll_cidade'].'</font> '; exit;			

			$ll_categoria_txt0=isolar($texto_trabalho,'name="categoria"','','</select');
			$resp['ll_categoria_txt']='';
			
			if (str_replace('<select','',$ll_categoria_txt0)==$ll_categoria_txt0){$resp['ll_categoria_txt']=isolar_limpo($ll_categoria_txt0,'</option','','</option');}

			if ($resp['ll_categoria_txt']==''){$resp['ll_categoria_txt']=isolar_limpo(str_replace('Categorias','',$texto_trabalho),'id="filtros_leilao"','id="categorias"','</a');}

			$resp['ll_categoria_rotulo']=isolar_limpo(isolar($texto_trabalho,'name="subcategoria"','','</select'),'</option','','</option');
			if ($resp['ll_categoria_rotulo']==''){$resp['ll_categoria_rotulo']=isolar_limpo(str_replace('Subcategorias','',$texto_trabalho),'id="filtros_leilao"','id="subcategorias"','</a');}

			if ($resp['ll_categoria_rotulo']!=''){
				if ($resp['ll_categoria_txt']!=''){$resp['ll_categoria_txt'].=',';}
				$resp['ll_categoria_txt'].=$resp['ll_categoria_rotulo'];
			} else {
				$resp['ll_categoria_rotulo']=$resp['ll_categoria_txt'];
			}

			if ($resp['ll_categoria_txt']==''){

				$vetor_categoria=adivinha_categoria($resp['ll_descricao'].' '.$resp['ll_detalhes']);
				if (sizeof($vetor_categoria)>0){

					$resp['ll_categoria_txt']=$vetor_categoria[0];
					$resp['ll_categoria_rotulo']=$vetor_categoria[0];

					if (sizeof($vetor_categoria)>1){
						$resp['ll_categoria_txt'].=','.$vetor_categoria[1];
						$resp['ll_categoria_rotulo']=$vetor_categoria[1];
					}
				}
			}


			if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) || str_replace('SUCATA','',strtoupper($resp['ll_agregador']))!=strtoupper($resp['ll_agregador'])){
				$resp['ll_categoria_txt'].=','.'SUCATAS';
				$resp['ll_categoria_rotulo']=' SUCATAS';
			}
			
			if ($resp['ll_uf']==''){$resp['ll_uf']=$uf;};
			if ($resp['ll_cidade']=='' && $resp['ll_uf']==$uf){$resp['ll_cidade']=$cidade;}								

			$endereco=str_replace('Â°','',limpaespacos(str_replace(',',', ',limpacaracteresutf8_automatico(urldecode(trim(isolar(str_replace('"','&',$texto_trabalho),'google.com/maps/embed/','&q=','&')))))));
			if (str_replace('visita','',$endereco)!=$endereco || str_replace('contato','',$endereco)!=$endereco){$endereco='';}
			if ($endereco==''){$endereco=isolar_limpo($texto_trabalho,'<abbr title="Endereço"','</abb','</p');}
			if (str_replace('visita','',$endereco)!=$endereco || str_replace('contato','',$endereco)!=$endereco){$endereco='';}

			if ($endereco==''){$endereco=adivinha_endereco($resp['ll_detalhes'],$resp['ll_cidade']);}

			$endereco=limpacaracteresutf8_automatico(str_replace('+',' ',mb_convert_encoding($endereco,'CP1252','UTF-8')));

			$resp['ll_endereco']=$endereco;


			if (!$teste){
				// às vezes, o endereço é em outra cidade. assim, se aqui tiver o cep, desconsidera cidade encontrada anteriormente
				$re = '/[0-9]{5}-[0-9]{3}/';
				if (preg_match_all($re, $endereco, $matches, PREG_SET_ORDER, 0)){
					
					if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
						echo '<br><font color="green">* Imóvel</font>';
						$geolocalizacao=geolocalizacao($resp['ll_endereco'],'','','',$resp['ll_pais']);
					} else {
						$geolocalizacao=geolocalizacao($resp['ll_endereco'],'','','',$resp['ll_pais'],false);
					}

				} else {

					if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
						echo '<br><font color="green">* Imóvel</font>';
						$geolocalizacao=geolocalizacao($resp['ll_endereco'],'',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);
					} else {
						$geolocalizacao=geolocalizacao($resp['ll_endereco'],'',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais'],false);
					}
				}
		
				//$geolocalizacao=geolocalizacao($resp['ll_endereco'],'',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);

				if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
				if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}
		//		if ($geolocalizacao[4]!='' && $resp['ll_bairro']==''){$resp['ll_bairro']=$geolocalizacao[4];}

				if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
				//if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}

				if ($geolocalizacao[3]!=''){$resp['ll_cidade']=$geolocalizacao[3];}		
				//if ($geolocalizacao[3]!=''){$resp['ll_cidade']=$geolocalizacao[3];}
				if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
			}

			if ($teste){
				print_r($resp);echo '<br><br>'; 
				//exit;
				return $resposta_robo;

	//if ($resp['ll_link']=='https://www.gustavoreisleiloes.com.br/lotes/454-1-'){exit;}

			} else {
				echo NovoLeilao ($resp,array(),0,0,0,0,false);
				//exit;
				// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
				return $resposta_robo;
			}
		}


		//exit;

//$tempoexecucao_nyx=99999;



	} else {
		//$texto='';
		echo '/ '; return false;
		
	}
	// ==================================
//										$texto='';
	// ==================================
	//exit;	
}

function Busca_site_0006_degrau ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$nada,$teste=false,$texto='',$busca_1='',$busca_2=''){

	set_time_limit (600);
	$atingiutempolimite=false;
	$tempoiniciodegrau=date("YmdHis");
	
	if (substr($url,-1)!='/'){$url.='/';}

	$r['extra']=organizador_inicia ($idorganizador);

	$lotescadastrados=0;
	$resposta_robo=false;

	$proximo_card=(int)$r['extra'];
	// $proximo_card => página;

	$conta=0;
	$conta_cards=0;
	$conta_principais=0;
	$conta_cards_internos=0;

	// 1. obtém cookie

	$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:88.0) Gecko/20100101 Firefox/88.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' ".
	"-H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' --compressed -H 'DNT: 1' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1'";
	$resposta=http_post_curl_headers ($url, $header, '', $cookie, 'charconvert+utf8', false, false, '', true, 'GET');
			//function http_post_curl_headers ($url, $header, $fields, $cookies='',$limpa=true, $json=false, $xml=false, $json_montado='',$ssl_ignora=false,$request="POST", $gravaarquivo=false,$json2=false, $json_montado2='',$request2="GET", $timeout = 5, $CURLOPT_RETURNTRANSFER=1){

	$texto=$resposta['content'];
	$cookie=str_replace('; ;',';',str_replace(';;',';',limpacaracteresfantasma(isolar(str_replace(' path=/','',str_replace(' httponly;','',str_replace(' secure;','',str_replace('set-cookie: ','Set-Cookie: ',$texto)))),'Set-Cookie: ','',chr(10)).'; CookiesChaveCliente=')));

	$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:93.0) Gecko/20100101 Firefox/93.0' -H 'Accept: application/json, text/javascript, */*; q=0.01' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' ".
	"-H 'Referer: $url' -H 'Content-Type: application/json; charset=utf-8' -H 'X-Requested-With: XMLHttpRequest' -H 'Origin: $url' -H 'DNT: 1' -H 'Connection: keep-alive' ".
	"-H 'Cookie: $cookie' -H 'Sec-Fetch-Dest: empty' -H 'Sec-Fetch-Mode: cors' -H 'Sec-Fetch-Site: same-origin' -H 'TE: trailers'";

	//$parametros='{"ID_Leiloes_Status":[],"Personalizado":0}';
	$parametros='{"ID_Leiloes_Status":[1,3],"Personalizado":0}';

	//2. varre paginação json
	$pagina=1;
	$pageindex=1;

	$contapaginacao=0;

	while ($pagina>0){
		$contapaginacao+=1;

		echo '<br><strong>Página '.$pagina.'/ '.$pageindex.'</strong>: ';

		if ($contapaginacao>=$proximo_card){
			$proximo_card=$contapaginacao;

			$resposta=http_post_curl_headers ($url.'ApiEngine/GetLeiloesDestaqueV2/'.$pagina.'/'.$pageindex.'/'.($pageindex-1)*8, $header, '', $cookie, 'charconvert+utf8', true, false, $parametros,true);

			echo '
'.$url.'ApiEngine/GetLeiloesDestaqueV2/'.$pagina.'/'.$pageindex.'/'.(($pageindex-1)*8).'
	';
			$texto_card_principal=$resposta['content'];


//echo $texto_card_principal; exit;

			if (str_replace('"Leiloes":[]','',$texto_card_principal)!=$texto_card_principal){
				// acabou a LISTAGEM
				$pagina=-1;
				$pageindex=-1;
			} else {
				// varre leilões
				$conta_cards+=1;
				$existem_cards=false;
	//if ($conta_cards>2){exit;}
				while(  $texto_este_card=isolar($texto_card_principal,'{"QualPraca":','','}}') ) {
					$texto_card_principal=isolar($texto_card_principal.'§©§§§§','{"QualPraca":'.$texto_este_card,'','§©§§§§');
					
					$existem_cards=true;

					//echo '<br><strong>Card '.$conta_cards.'</strong>: ';

					$resp=array();
					$resp['organizador']=$idorganizador;
					$resp['ll_pais']='BRASIL';
					$resp['ll_idioma']='pt-BR';
					$resp['ll_moeda']='BRL';

					$resp['ll_numero']=isolar_limpo($texto_este_card,'"ID_Leilao":','',',');//.'/ '.isolar_limpo($texto_este_card,'"CodLeilao":"','','",');
					$resp['ll_agregador']=isolar_limpo($texto_este_card,'"Leilao":"','','",');

					$resp['ll_agregador_link']=$url.isolar_limpo($texto_este_card,'"URLLeilao":"','','",');

					$pag_leilao=1;
					$pag_index_leilao=1;
					while ($pag_leilao>0){

						$resposta=http_post_curl_headers ($url.'ApiEngine/GetLotesLeilao/'.$resp['ll_numero'].'/'.$pag_leilao.'/'.$pag_index_leilao.'/'.($pag_index_leilao-1)*8, $header, '', $cookie, 'charconvert+utf8', true, false, $parametros,true);
						$texto_card_leilao=$resposta['content'];

//echo $texto_card_leilao; exit;

	//if ($pag_index_leilao==2){echo $texto_card_leilao; exit;}
						if (str_replace('"Lotes":[]','',$texto_card_leilao)!=$texto_card_leilao){
							// acabou a LISTAGEM
							$pag_leilao=-1;
							$pag_index_leilao=-1;
						}

		//echo $texto_card_leilao;

						while(  $texto_card_analisado=isolar($texto_card_leilao,'"ID_LeilaoMascara":','',']}') ) {
							$texto_card_leilao=isolar($texto_card_leilao.'§©§§§§','"ID_LeilaoMascara":'.$texto_card_analisado,'','§©§§§§');

							$ll_natureza=strtolower(isolar_limpo($texto_card_analisado,'"LabelModalidade":"','','"'));
							if (str_replace('extra','',$ll_natureza)==$ll_natureza && str_replace('judicial','',$ll_natureza)!=$ll_natureza){$resp['ll_natureza']='1';}
							$resp['ll_link']=$url.isolar_limpo($texto_card_analisado,'"URLlote":"','','"');
							$resp['ll_descricao']=isolar_limpo($texto_card_analisado,'"Lote":"','','",');
							$resp['ll_lote']=isolar_limpo($texto_card_analisado,'"LoteNumero":"','','",');


							$ll_categoria_txt=isolar_limpo($texto_card_analisado,'"Categoria":"','','"');
							$ll_sub_categoria=isolar_limpo($texto_card_analisado,'"IconeCategoria":"','','"');
							if ($ll_categoria=='residencial' || $ll_categoria=='comercial' || $ll_categoria=='rural' || $ll_categoria=='residencial'){$ll_sub_categoria=$ll_categoria;$ll_categoria='Imóveis';}

//echo $texto_card_analisado;

							$resp['ll_data_1']=substr(str_replace(' ','',str_replace('-','',str_replace('T','',str_replace(':','',isolar_limpo($texto_card_analisado,'DataHoraEncerramentoPrimeiraPraca":"','','"'))))),0,12);
							$resp['ll_data_2']=substr(str_replace(' ','',str_replace('-','',str_replace('T','',str_replace(':','',isolar_limpo($texto_card_analisado,'DataHoraEncerramentoSegundaPraca":"','','"'))))),0,12);
							
							if ((int)$resp['ll_data_2']<(int)$resp['ll_data_1']){$resp['ll_data_2']='';}


							if ($resp['ll_data_1']>date("YmdHi") || $resp['ll_data_2']>date("YmdHi")) {
								if (!VerificaCadastroLeilao($resp)){

									$resp['ll_avaliacao']=round(isolar_limpo($texto_card_analisado,'"ValorAvaliacao":','',','),2);
									$resp['ll_lance_min_1']=round(isolar_limpo($texto_card_analisado,'"ValorMinimoLancePrimeiraPraca":','',','),2);
									if ((int)$resp['ll_data_2']>0){$resp['ll_lance_min_2']=round(isolar_limpo($texto_card_analisado,'"ValorMinimoLanceSegundaPraca":','',','),2);}

									$texto_lote=limpacaracteresisolatin1(limpacaracteresutf8_novo(http_get_curl($resp['ll_link'],'ie',false,false)));
									$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
										str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('<br>','.~ ',$ll_detalhes0.isolar($texto_lote,'dg-lote-descricao-txt','','</div')))))))))))));

//echo $texto_lote;

									$pix0=isolar($texto_lote,'dg-lote-img','','"dg-lote-label">');

									$contapix=0;
									while(  $pix=isolar($pix0,'<img src="','','"') ) {
										$pix0=str_replace('<img src="'.$pix,'', $pix0);
										if ($pix!='' && (str_replace('jpg','',strtolower($pix))!=strtolower($pix) || str_replace('jpeg','',strtolower($pix))!=strtolower($pix) || str_replace('png','',strtolower($pix))!=strtolower($pix) || str_replace('gif','',strtolower($pix))!=strtolower($pix)) ) {
											$contapix+=1;
											if ($contapix<=8){
												$resp['ll_foto_'.$contapix]=$pix;
												echo '
					foto: '.$resp['ll_foto_'.$contapix];
											} else {
												$pix0='';
											}
										}
									}

									$texto_lote_detalhada=limpacaracteresisolatin1(isolar_limpo($texto_lote,'dg-desc-text','','class="col'));


									$resp['ll_comitente']=isolar_limpo($texto_card_analisado,'"Comitente":"','','"');

									$cep=isolar_limpo($texto_card_analisado,'"Lote_CEP":"','','"');
									$resp['ll_cidade']=isolar_limpo($texto_card_analisado,'"Cidade":"','','"');
									$resp['ll_uf']=isolar_limpo($texto_card_analisado,'"UF":"','','"');
									$resp['ll_endereco']=trim(isolar_limpo($texto_card_analisado,'"Lote_Endereco":"','','"').' '.isolar_limpo($texto_card_analisado,'"Lote_Numero":"','','"').' '.isolar_limpo($texto_card_analisado,'"Lote_Complemento":"','','"'));
									$resp['ll_bairro']=isolar_limpo($texto_card_analisado,'"Lote_Bairro":"','','"');

									$resp['ll_categoria_txt']=$ll_categoria;
									$resp['ll_categoria_rotulo']=$ll_categoria;

									if (strtoupper($ll_categoria)=='DIVERSOS'){

										$categorizacao_automatica=categorizacao_automatica($resp['ll_descricao']);
										$resp['ll_categoria_rotulo']=$categorizacao_automatica['ll_categoria_txt'];
										$resp['ll_categoria_txt']=$categorizacao_automatica['ll_categoria_txt'];
										$resp['ll_categoria_principal']=$categorizacao_automatica['categoria_principal'];
									} else {


										if ($ll_sub_categoria!=''){
											$resp['ll_categoria_txt'].=','.$ll_sub_categoria;
											$resp['ll_categoria_rotulo']=$ll_sub_categoria;
										}


										if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) || str_replace('SUCATA','',strtoupper($resp['ll_agregador']))!=strtoupper($resp['ll_agregador'])){
											$resp['ll_categoria_txt'].=','.'SUCATAS';
											$resp['ll_categoria_rotulo']=' SUCATAS';
										}
									}
									
									$coords=isolar_limpo($texto_card_analisado,'"Coordenadas":"','','"');

									$resp['ll_latitude']=isolar_limpo('§'.$coords,'§','',',');
									$resp['ll_longitude']=isolar_limpo($coords.'§',',','','§');
									if ($resp['ll_latitude']=='' || $resp['ll_longitude']==''){


										
										if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
											echo '<br><font color="green">* Imóvel</font>';
											$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);
										} else {
											$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais'],false);
										}

										if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
										if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}
									}
									if ($resp['ll_uf']==''){$resp['ll_uf']=$uf;}

									if($resp['ll_descricao']!=''){$resposta_robo=true;}


									if ($teste){
										print_r($resp);echo '<br><br>'; if($resposta_robo){return $resposta_robo;}
										//exit;
									} else {
										echo NovoLeilao ($resp,array(),0,0,0,0,false);
										//exit;
										// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
									}


									//exit;
									// ==================================
									$conta+=1;
									if ($conta==1){$tempoiniciodegrau=date("YmdHis");}
									// ==================================
									$tempoexecucaomg=diferencasegundos( $tempoiniciodegrau ,'');

									//$tempoexecucaomg=99999;



									if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
										// atingiu tempo limite.
										$atingiutempolimite=true;
										goto fimdolaco;
									}

								} else {
								//$texto='';
								echo '/ ';

								}
							}

							$pag_index_leilao+=1;
							if ($pag_index_leilao>3){
								$pag_index_leilao=1;
								$pag_leilao+=1;
							}
						}
					}
				}
			}
			
			if (!$existem_cards){
				$pagina=-1;
				$pageindex=-1;
			} 
			
		}

		$pageindex+=1;
		if ($pageindex>3){
			$pageindex=1;
			$pagina+=1;
		}

	}

	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		organizador_tempo_limite_atingido ($idorganizador,$proximo_card);
	echo '***
	tempo limite
	';
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}
	
	return $resposta_robo;
}

function Busca_site_0007_leilaopro ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$nada,$teste=false,$texto='',$busca_1='',$busca_2=''){
	global $pdo;

	set_time_limit (600);
	$atingiutempolimite=false;
	$tempoiniciodegrau=date("YmdHis");
	
	if (substr($url,-1)!='/'){$url.='/';}

	$r['extra']=organizador_inicia ($idorganizador);

	$lotescadastrados=0;
	$resposta_robo=false;

	$proximo_card=explode(',',$r['extra'].',');
	// $proximo_card => página;

	$conta=0;
	$conta_cards=0;
	$conta_principais=0;
	$conta_cards_internos=0;

	// 1. obtém cookie

	$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:88.0) Gecko/20100101 Firefox/88.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' ".
	"-H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' --compressed -H 'DNT: 1' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1'";
	$resposta=http_post_curl_headers ($url.'leilao/proximos', $header, '', $cookie, 'charconvert+utf8', false, false, '', true, 'GET');
			//function http_post_curl_headers ($url, $header, $fields, $cookies='',$limpa=true, $json=false, $xml=false, $json_montado='',$ssl_ignora=false,$request="POST", $gravaarquivo=false,$json2=false, $json_montado2='',$request2="GET", $timeout = 5, $CURLOPT_RETURNTRANSFER=1){

	$texto=$resposta['content'];
	$cookie=str_replace('; ;',';',str_replace(';;',';',limpacaracteresfantasma(isolar(str_replace(' path=/','',str_replace(' httponly;','',str_replace(' secure;','',str_replace('set-cookie: ','Set-Cookie: ',$texto)))),'Set-Cookie: ','',chr(10)).'; CookiesChaveCliente=')));

/*
echo '
$cookie='.$cookie.'
$texto='.$texto.'
'; exit;
*/
/*
echo '
=====
'.$texto.'
=====
';*/
	
	$categoria_vetor=explode('<li',isolar($texto,'menu-categorias','<ul','</ul'));
	$categoria_vetor[0]='';
	//print_r($categoria_vetor); exit;
	for ($categoria_em_analise=max(1,(int)$proximo_card[0]);$categoria_em_analise<sizeof($categoria_vetor);$categoria_em_analise++){
		
		$proximo_card[0]=$categoria_em_analise;

		$ll_categoria_txt=isolar_limpo($categoria_vetor[$categoria_em_analise],'</i','','(');
		$ll_categoria_qt=(int)isolar_limpo($categoria_vetor[$categoria_em_analise],'<spa','','</spa');
		$ll_categoria_link=isolar($categoria_vetor[$categoria_em_analise],'href="','','"');
		if ($ll_categoria_link!=''){
			if (strlen($ll_categoria_link)>0 && substr($ll_categoria_link,0,4)!='http'){
				if(substr($ll_categoria_link,0,1)=='/'){
				$ll_categoria_link=substr($ll_categoria_link,1-strlen($ll_categoria_link));
				} 
				$ll_categoria_link=$url.$ll_categoria_link;
			}
		}

		echo '<br><strong>
Categoria '.$categoria_em_analise.': '.$ll_categoria_txt.' ('.$ll_categoria_qt.')</strong> '.$ll_categoria_link;

		if ($ll_categoria_qt>0){
			$resposta=http_post_curl_headers ($ll_categoria_link, $header, '', $cookie, 'charconvert+utf8', false, false, '', true, 'GET');
			$texto=$resposta['content'];

//echo $texto; exit;

			$leilao_vetor=explode('rotating-card-container',$texto);
			if (sizeof($leilao_vetor)<2){$leilao_vetor=explode('"card-header',$texto);}
			
			$leilao_vetor[0]='';
			//print_r($leilao_vetor); exit;
			for ($card_em_analise=max(1,(int)$proximo_card[1]);$card_em_analise<sizeof($leilao_vetor);$card_em_analise++){

				echo '<strong>
['.$card_em_analise.']</strong>';
				$proximo_card[1]=$card_em_analise;
				$texto_este_card=$leilao_vetor[$card_em_analise];

				$resp=array();
				$resp['organizador']=$idorganizador;
				$resp['ll_pais']='BRASIL';
				$resp['ll_idioma']='pt-BR';
				$resp['ll_moeda']='BRL';
				$resp['ll_link']=isolar(isolar($texto_este_card,'card-footer','card-footer','</a'),'href="','','"');
				if ($resp['ll_link']==''){$resp['ll_link']=isolar($texto_este_card,'href="','','"');}
				
				if ($resp['ll_link']!=''){
					if (strlen($resp['ll_link'])>0 && substr($resp['ll_link'],0,4)!='http'){
						if(substr($resp['ll_link'],0,1)=='/'){
						$resp['ll_link']=substr($resp['ll_link'],1-strlen($resp['ll_link']));
						} 
						$resp['ll_link']=$url.$resp['ll_link'];
					}
				}

				if (!VerificaCadastroLeilao($resp)){
					
					$resposta=http_post_curl_headers ($resp['ll_link'], $header, '', $cookie, false, false, false, '', true, 'GET');
					//$texto_este_lote=str_replace('&quot;','',$resposta['content']);
					$texto_este_lote=str_replace('&quot;','',limpacaracteresutf8_novo($resposta['content'],2));

//ECHO $texto_este_lote;
					
					$resp['ll_lote']=trim(str_replace('LOTE','',str_replace('-','',isolar_limpo(isolar($texto_este_lote,'card-title','','<div'),'<b','','</b'))));
					$resp['ll_descricao']=isolar_limpo(str_replace('?','',isolar($texto_este_lote,'card-title','','<div')),'</b','','</h');
					if ($resp['ll_descricao']==''){$resp['ll_descricao']=isolar_limpo(str_replace('?','',$texto_este_lote),'card-title','','<div');}

					$resp['ll_lance_min_1']=round(sonumeros(str_replace(',','.',str_replace('.','',isolar_limpo($texto_este_lote,'"lance-inicial-valor','R$','</p')))),2);
					$resp['ll_avaliacao']=round(sonumeros(str_replace(',','.',str_replace('.','',isolar_limpo($texto_este_lote,'AVALIAÇÃO</h5>','R$','</h')))),2);
					$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
						str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('<br>','.~ ',isolar(str_replace('?','',$texto_este_lote),'descricao">','','</div')))))))))))));

//print_r($resp); exit;

					$pix0=isolar($texto_este_lote,'<div class="owl-carousel">','','</div');
					$contapix=0;
					while(  $pix=isolar($pix0,'data-big-img="','','"') ) {
						$pix0=str_replace('data-big-img="'.$pix,'', $pix0);
						if ($pix!='' && (str_replace('jpg','',strtolower($pix))!=strtolower($pix) || str_replace('jpeg','',strtolower($pix))!=strtolower($pix) || str_replace('png','',strtolower($pix))!=strtolower($pix) || 
							str_replace('gif','',strtolower($pix))!=strtolower($pix)) ) {
							$contapix+=1;
							if ($pix!=str_replace('resolve/','',$pix)){$pix=str_replace('resolve/','',$pix).'.webp';}
							if ($contapix<=8){
								$resp['ll_foto_'.$contapix]=$pix;
								echo '
foto: '.$resp['ll_foto_'.$contapix];
							} else {
								$pix0='';
							}
						}
					}

					$resp['ll_agregador_link']=isolar($texto_este_lote,'"Ver Todos Lotes"','href="','"');
					
					if ($resp['ll_agregador_link']!=''){
						if (strlen($resp['ll_agregador_link'])>0 && substr($resp['ll_agregador_link'],0,4)!='http'){
							if(substr($resp['ll_agregador_link'],0,1)=='/'){
							$resp['ll_agregador_link']=substr($resp['ll_agregador_link'],1-strlen($resp['ll_agregador_link']));
							} 
							$resp['ll_agregador_link']=$url.$resp['ll_agregador_link'];
						}
					}
					
					// já está cadastrado?
					$sqlqry="SELECT * FROM db_leilao WHERE ll_agregador_link='".$resp['ll_agregador_link']."' LIMIT 1";
					$statement = $pdo->query($sqlqry);
					if ($agregadordb = $statement->fetch(PDO::FETCH_ASSOC)){
						$resp['ll_data_1']=$agregadordb['ll_data_1'];
						$resp['ll_data_2']=$agregadordb['ll_data_2'];
						$resp['ll_agregador']=$agregadordb['ll_agregador'];
echo '<br><font color="blue">
Dados de agregador aproveitados de lote já cadastrado!</font>';
					} else {
						$resposta=http_post_curl_headers ($resp['ll_agregador_link'], $header, '', $cookie, 'charconvert+utf8', false, false, '', true, 'GET');
						$listagem_lotes=$resposta['content'];
						$resp['ll_agregador']=isolar_limpo($listagem_lotes,'<h2 class="card-title','','</h');
						$resp['ll_data_1']=arrumadata_robos(limpahtml(str_replace(' ','',str_replace('fa-clock','>/<',isolar($listagem_lotes,'fa-calendar','','</li')))),6,true);
						$resp['ll_data_2']=arrumadata_robos(limpahtml(str_replace(' ','',str_replace('fa-clock','>/<',isolar($listagem_lotes,'fa-calendar','fa-calendar','</li')))),6,true);
						
echo '<br><font color="pink">
Dados de agregador novos</font>';
					}
					if ((int)$resp['ll_data_2']>0){$resp['ll_lance_min_2']=$resp['ll_lance_min_1'];}

					$resp['ll_categoria_txt']=$ll_categoria_txt;
					$resp['ll_categoria_rotulo']=$ll_categoria_txt;

					if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) ){
						$resp['ll_categoria_txt'].=','.'SUCATAS';
						$resp['ll_categoria_rotulo']=' SUCATAS';
					}
					

					$resp['ll_cidade']=$cidade;
					$resp['ll_uf']=$uf;
					
					$endereco=isolar($texto_este_lote,"var address","'","'");
					$endereco_adivinhado=false;
					if ($endereco==''){
						$endereco_adivinhado=false;
						
						$endereco=isolar($texto_este_lote,'<b>LOGRADOURO:</b>','','</p');
						$cidadeuf=isolar($texto_este_lote,'<b>CIDADE:</b>','','</p');
						$bairro=isolar($texto_este_lote,'<b>CIDADE:</b>','','</p');
						
						$cidadeuf_vetor=explode('/',$cidadeuf);
						if (sizeof($cidadeuf_vetor)==2){
							$resp['ll_cidade']=$cidadeuf_vetor[0];
							$resp['ll_uf']=$cidadeuf_vetor[1];
						}
						if ($bairro!=''){$resp['ll_bairro']=$bairro;}
						
					
						if ($endereco==''){ $endereco=adivinha_endereco($resp['ll_detalhes'],$resp['ll_cidade']);}
					}

					$resp['ll_endereco']=$endereco;


					if (!$teste){
						// às vezes, o endereço é em outra cidade. assim, se aqui tiver o cep, desconsidera cidade encontrada anteriormente
						$re = '/[0-9]{5}-[0-9]{3}/';
						if (!$endereco_adivinhado || preg_match_all($re, $endereco, $matches, PREG_SET_ORDER, 0)){
							
							if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
								echo '<br><font color="green">* Imóvel</font>';
								$geolocalizacao=geolocalizacao($resp['ll_endereco'],'','','',$resp['ll_pais']);
							} else {
								$geolocalizacao=geolocalizacao($resp['ll_endereco'],'','','',$resp['ll_pais'],false);
							}
						} else {
										
							if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
								echo '<br><font color="green">* Imóvel</font>';
								$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);
							} else {
								$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais'],false);
							}
						}
				
						//$geolocalizacao=geolocalizacao($resp['ll_endereco'],'',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);

						if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
						if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}
				//		if ($geolocalizacao[4]!='' && $resp['ll_bairro']==''){$resp['ll_bairro']=$geolocalizacao[4];}

						if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
						//if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}

						if ($geolocalizacao[3]!=''){$resp['ll_cidade']=$geolocalizacao[3];}		
						//if ($geolocalizacao[3]!=''){$resp['ll_cidade']=$geolocalizacao[3];}
						if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
					}

					if($resp['ll_descricao']!=''){$resposta_robo=true;}


					if ($teste){
						print_r($resp);echo '<br><br>'; if($resposta_robo){return $resposta_robo;}
						//exit;
					} else {
						echo NovoLeilao ($resp,array(),0,0,0,0,false);
						//exit;
						// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
					}


					//exit;
					// ==================================
					$conta+=1;
					if ($conta==1){$tempoiniciodegrau=date("YmdHis");}
					// ==================================
					$tempoexecucaomg=diferencasegundos( $tempoiniciodegrau ,'');

					//$tempoexecucaomg=99999;



					if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
						// atingiu tempo limite.
						$atingiutempolimite=true;
						goto fimdolaco;
					}

				} else {
				//$texto='';
				echo '/ ';

				}
			}
			$proximo_card[1]=0;
		}
	}

	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		if (!$teste){organizador_tempo_limite_atingido ($idorganizador,$proximo_card[0].','.$proximo_card[1]);}
	echo '***
	tempo limite
	';
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}
	
	return $resposta_robo;
}

function Busca_site_0008_leiloesweb ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina=30,$teste=false,$texto='',$busca_1='',$busca_2=''){
	
	$resposta_robo=false;
	
	if (substr($url,-1)!='/'){$url.='/';}
	$url0=substr($url,0,strlen($url)-1);
	
	set_time_limit (600);
	$atingiutempolimite=false;
	$tempoinicio_lw=date("YmdHis");

	$r['extra']=organizador_inicia ($idorganizador);

	if ($teste){echo '<br>[modo teste]<br>';}

	$lotescadastrados=0;

	$proximo_card=explode('/',$r['extra'].'///');

	$conta=0;
	$conta_cards=0;
	$conta_principais=0;
	$conta_cards_internos=0;

/*
echo '
$url='.$url.'
'.http_get_curl($url,'ie',true,false); exit;			
*/
	$texto_com_cards=limpacaracteresutf8_automatico(http_get_curl($url,'ie',true,false));
	$cookie=isolar($texto_com_cards,'set-cookie: ','',';');

	$texto_com_cards_encerrados=isolar($texto_com_cards,'<div class="lista_leiloes" id="encerrados"','','<div class="lista_leiloes" id="');
	//$texto_com_cards=isolar($texto_com_cards,'<div class="lista_leiloes" id="proximos','','<div class="lista_leiloes" id="');
	$texto_com_cards=str_replace($texto_com_cards_encerrados,'',$texto_com_cards);
	$texto_com_cards=str_replace('tempo_regressivoHome','></article',str_replace('<p class="cod"','<article',$texto_com_cards));

/*
echo '
$cookie='.$cookie.'
****'.$texto_com_cards; exit;			
*/

	while(  $texto_card_1=isolar($texto_com_cards,'<article','','</article') ) {
		$texto_com_cards=str_replace('<article'.$texto_card_1,'', $texto_com_cards);

		$conta_cards+=1;

		if ($conta_cards>=(int)$proximo_card[0]){
			echo '['.$conta_cards.'] ';

			$resp0=array();
			$resp0['organizador']=$idorganizador;
			$resp0['ll_pais']='BRASIL';
			$resp0['ll_idioma']='pt-BR';
			$resp0['ll_moeda']='BRL';
			$resp0['ll_agregador_link']=trim(isolar($texto_card_1,'<div class="bid-link">','href="','"'));
			if ($resp0['ll_agregador_link']==''){$resp0['ll_agregador_link']=trim(isolar($texto_card_1,'<div class="bid-details">','href="','"'));}
/*
echo '
--
'.$texto_card_1.'
';print_r($resp0); exit;*/

			if ($resp0['ll_agregador_link']!=''){
				if (strlen($resp0['ll_agregador_link'])>0 && substr($resp0['ll_agregador_link'],0,4)!='http'){
					if(substr($resp0['ll_agregador_link'],0,1)=='/'){
					$resp0['ll_agregador_link']=substr($resp0['ll_agregador_link'],1-strlen($resp0['ll_agregador_link']));
					} 
					$resp0['ll_agregador_link']=$url.$resp0['ll_agregador_link'];
				}

				$resp0['ll_agregador']=isolar_limpo($texto_card_1,'"bid-title"','','</h');
				if ($resp0['ll_agregador']==''){$resp0['ll_agregador']=isolar_limpo($texto_card_1,'"bid-details"','','</div');}
				
				$ll_natureza=isolar_limpo($texto_card_1,'"bid-type"','','</p');
				if (str_replace('extra','',$ll_natureza)==$ll_natureza && str_replace('judicial','',$ll_natureza)!=$ll_natureza){$resp['ll_natureza']='1';}
				
				$texto_card_1_minusculas=capitalizacao_str($texto_card_1,false);
/*
if ($teste){
echo '

---------++++++++++++++++++
Card '.$conta_cards.'
$texto_card_1='.$texto_card_1.'

'; print_r($resp0); exit;

}*/

				// varre lotes
				$texto_lotes=limpacaracteresutf8_automatico(http_get_curl($resp0['ll_agregador_link'],'ie',true,false));
				
				// é lote único?
				$location=trim(isolar($texto_lotes,'ocation:','',chr(13)));

				if (str_replace('HTTP/1.1 200 OK','',$texto_lotes)==$texto_lotes && $location!=''){
					echo '[lote isolado]';
					$resp=$resp0;
					$resp['ll_link']=$location;
					Busca_site_0008_leiloesweb_processa ($resp,$texto_card_1_minusculas,$idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina,$teste);

					if (diferencasegundos( $tempoinicio_lw ,'')>CADASTRO_MAX_SEGUNDOS) {$atingiutempolimite=true;goto fimdolaco;}
					
				} else {
					echo '[listagem de lotes]';
//echo $texto_lotes;
					$lotes_vetor=explode('"img-lote"',$texto_lotes);
					if (sizeof($lotes_vetor)==1){$lotes_vetor=explode('"num_lote"',$texto_lotes);}
					for ($i=1;$i<sizeof($lotes_vetor);$i++){

						$resp=$resp0;
						$resp['ll_link']=isolar($lotes_vetor[$i],'href="','','"');

						if ($resp['ll_link']!=''){
							if (strlen($resp['ll_link'])>0 && substr($resp['ll_link'],0,4)!='http'){
								if(substr($resp['ll_link'],0,1)=='/'){
								$resp['ll_link']=substr($resp['ll_link'],1-strlen($resp['ll_link']));
								} 
								$resp['ll_link']=$url.$resp['ll_link'];
							}
							Busca_site_0008_leiloesweb_processa ($resp,$texto_card_1_minusculas,$idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina,$teste);
							if (diferencasegundos( $tempoinicio_lw ,'')>CADASTRO_MAX_SEGUNDOS) {$atingiutempolimite=true;goto fimdolaco;}
						}
					}
				}
//exit;				
			}
		}

	}
		

	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		if (!$teste){organizador_tempo_limite_atingido ($idorganizador,$conta_cards);}
	echo '***
	tempo limite
	'; 
	} else {
		echo '**** Finalizou tudo';
		if (!$teste){organizador_finaliza ($idorganizador);}
	}
	
	return $resposta_robo;
}

function Busca_site_0008_leiloesweb_processa ($resp,$texto_card_1_minusculas,$idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$cards_por_pagina,$teste){
    global $pdo;

//print_r($resp); //exit;
	if ($teste || !VerificaCadastroLeilao($resp)){

		$texto_card_1_minusculas=str_replace('°','º',$texto_card_1_minusculas);
		$texto_card_1_minusculas=str_replace('ª leilão','º leilão',$texto_card_1_minusculas);
		
		$texto_trabalho=limpacaracteresutf8_automatico(http_get_curl($resp['ll_link'],'ie',true,false));
		$texto_trabalho=str_replace('&sup2;', '²', str_replace('&rdquo;', '', str_replace('&ldquo;', '', $texto_trabalho)));

		$resp['ll_lote']=isolar_limpo($texto_trabalho,'<div class="title-lote">','','</');
		if ($resp['ll_lote']==''){$resp['ll_lote']=isolar_limpo($texto_trabalho,'<div class="box-lotes">','','</');}
		$resp['ll_lote']=trim(str_replace(':','',str_replace('LOTE','',capitalizacao_str($resp['ll_lote']))));

		$resp['ll_descricao']=isolar_limpo($texto_trabalho,'<h2>Descrição detalhada do Lote</h2>','','</p');
		if ($resp['ll_descricao']==''){$resp['ll_descricao']=isolar_limpo($texto_trabalho,'<h2>Descrição detalhada</h2>','','</p');}
		if ($resp['ll_descricao']==''){$resp['ll_descricao']=$resp['ll_agregador'];}
		$resp['ll_descricao']=str_replace('?','',$resp['ll_descricao']);

		$resp['ll_detalhes']=limpaespacos(limpacaracteresfantasma(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
			$resp['ll_descricao'])))))))));

		
		$resp['ll_data_1']='';
		$resp['ll_data_2']='';
		$resp['ll_lance_min_1']='';
		$resp['ll_lance_min_2']='';
		
		
//echo $texto_trabalho;
		
		if (str_replace('{m:ano','',$texto_card_1_minusculas)==$texto_card_1_minusculas){
			$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'<b>data:','</p','</p');
			if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'1º leilão:','</p','</p');}
			$resp['ll_data_1']=arrumadata_robos(str_replace('-','/',str_replace(' ','',str_replace('h','',str_replace(' às ','/',$resp['ll_data_1'])))),6,true);

			$resp['ll_data_2']=isolar_limpo($texto_card_1_minusculas,'2º leilão:','</p','</p');
			$resp['ll_data_2']=arrumadata_robos(str_replace('-','/',str_replace(' ','',str_replace('h','',str_replace(' às ','/',$resp['ll_data_2'])))),6,true);
		}

		if ($resp['ll_data_1']==''){
			$resp['ll_data_1']=isolar_limpo($texto_trabalho,'<!-- INICIO: BLOCO_1_PRACA_LOTE -->',':</b></p>','</p');
			$resp['ll_data_1']=adivinha_data('ABERTURA: '.$resp['ll_data_1']);

			$resp['ll_data_2']=isolar_limpo(isolar(str_replace('BLOCO_2_PRACA_LOTE','BLOCO_1_PRACA_LOTE',$texto_trabalho).'§©§','BLOCO_1_PRACA_LOTE','','§©§'),'<!-- INICIO: BLOCO_1_PRACA_LOTE -->',':</b></p>','</p');
			$resp['ll_data_2']=adivinha_data('ABERTURA: '.$resp['ll_data_2']);
		}

		if ($resp['ll_data_1']==''){
			// tipo 2
			$resp['ll_data_1']=isolar_limpo($texto_trabalho,'>1º Leilão:','','</d');
			if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_trabalho,'ª Tentativa:','','</d');}
			if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_trabalho,'>Data:','','</d');}
			$resp['ll_data_1']=adivinha_data('ABERTURA: '.$resp['ll_data_1']);

			$resp['ll_data_2']=isolar_limpo($texto_trabalho,'>2º Leilão:','','</d');
			if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_trabalho.'§©§','ª Tentativa:','R$','§©§'),'ª Tentativa:','','</d');}
			$resp['ll_data_2']=adivinha_data('ABERTURA: '.$resp['ll_data_2']);
			
			if ($resp['ll_data_1']!=''){
				$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho,'Lance inicial em 1º Leilão:','R$','</'))));
				if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho,'ª Tentativa:','R$','</'))));}
				if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho,'Lance inicial:','R$','</'))));}

				$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho,'Lance inicial em 2º Leilão:','R$','</'))));
				if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_trabalho.'§©§','ª Tentativa:','R$','§©§'),'ª Tentativa:','R$','</'))));}
			}
		}


		if ($resp['ll_lance_min_1']=='' && str_replace('{m:lance_i','',$texto_card_1_minusculas)==$texto_card_1_minusculas){
			$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_card_1_minusculas,'lance inicial:','r$','</'))));
			$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_card_1_minusculas.'§©§','lance inicial:','','§©§'),'lance inicial:','r$','</'))));
		}
		
		
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho,'Lance inicial em 1º Leilão:','R$','</'))));}
		if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho,'BLOCO_1_PRACA_LOTE','R$','</'))));}
		if ($resp['ll_lance_min_2']=='' && $resp['ll_data_2']!=''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho,'Lance inicial em 2º Leilão:','R$','</'))));}
		if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar(str_replace('BLOCO_2_PRACA_LOTE','BLOCO_1_PRACA_LOTE',$texto_trabalho).'§©§','BLOCO_1_PRACA_LOTE','','§©§'),'BLOCO_1_PRACA_LOTE','R$','</'))));}
		if ($resp['ll_lance_min_2']=='' && $resp['ll_data_2']!=''){$resp['ll_lance_min_2']=$resp['ll_lance_min_1'];}
		
		
		$resp['ll_avaliacao']=str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_trabalho,'<!-- INICIO: VAL_AVALIACAO -->','','<!-- FIM: VAL_AVALIACAO -->'),'R$','','<')));
		$resp['ll_comitente']=isolar_limpo($texto_trabalho,'<div class="subtitle">','','</d');


		$contapix=0;
		$pix0=isolar($texto_trabalho,'<div class="col-imagens-lote">','','<!-- FIM: LISTA_IMAGENS -->');
		if ($pix0==''){$pix0=isolar($texto_trabalho,'<div class="col-imagens-lote">','','</ul');}

		while(  $pix=isolar($pix0,'<img src="','','"') ) {
			$pix0=str_replace('<img src="'.$pix,'', $pix0);


			if (str_replace('ico_sem_img','',$pix)==$pix && str_replace('/600x400.gif','',$pix)==$pix){
				$contapix+=1;
				if ($contapix<=8){

echo '<br>Foto original: '.$pix;
					if (substr($pix,0,4)!='http'){$pix=str_replace($url.'/',$url,$url.$pix);}
					$resp['ll_foto_'.$contapix]=$pix;
				} else {
					$pix0='';
				}
			}
		}

		$vetor_categoria=adivinha_categoria($resp['ll_descricao'].' '.$resp['ll_detalhes']);
		if (sizeof($vetor_categoria)>0){

			$resp['ll_categoria_txt']=$vetor_categoria[0];
			$resp['ll_categoria_rotulo']=$vetor_categoria[0];

			if (sizeof($vetor_categoria)>1){
				$resp['ll_categoria_txt'].=','.$vetor_categoria[1];
				$resp['ll_categoria_rotulo']=$vetor_categoria[1];
			}
		}


		if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) || str_replace('SUCATA','',strtoupper($resp['ll_agregador']))!=strtoupper($resp['ll_agregador'])){
			$resp['ll_categoria_txt'].=','.'SUCATAS';
			$resp['ll_categoria_rotulo']=' SUCATAS';
		}		
		
		$resp['ll_uf']='';
		$resp['ll_cidade']='';

		$endereco0=str_replace('Â°','',limpaespacos(str_replace(',',', ',limpacaracteresutf8_novo(urldecode(trim(isolar($texto_trabalho,'google.com/maps/embed','!2s','!')))))));
		$endereco_vetor=explode(',',str_replace(' - ',',',$endereco0));
		$indice_uf=0;

		if (strlen($endereco_vetor[sizeof($endereco_vetor)])==2){
			$indice_uf=sizeof($endereco_vetor);
		} else {
			if (strlen($endereco_vetor[sizeof($endereco_vetor)-1])==2){
				$indice_uf=sizeof($endereco_vetor)-1;
			} else {
				if (strlen($endereco_vetor[sizeof($endereco_vetor)-2])==2){
					$indice_uf=sizeof($endereco_vetor)-2;
				}

			}
		}
		if ($indice_uf>0){
			$resp['ll_uf']=$endereco_vetor[$indice_uf];
			$resp['ll_cidade']=$endereco_vetor[$indice_uf-1];
			$resp['ll_endereco']='';
			for ($i=0;$i<$indice_uf-1;$i++){
				if ($resp['ll_endereco']!=''){$resp['ll_endereco'].=', ';}
				$resp['ll_endereco'].=$endereco_vetor[$i];
			}
			
		} else {

			$localizacao=str_replace('+',' ',isolar_limpo($texto_trabalho,'<a href="https://www.google.com/maps/place/','','/'));
			//if ($localizacao==''){$localizacao=str_replace('+',' ',isolar_limpo($texto_lote,'<a href="https://www.google.com/maps/place/','','/'));}
			if (trim($localizacao)==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','/')))));}
			if (trim($localizacao)==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','-')))));}
			if (trim($localizacao)==''){
				$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',strtolower($resp['ll_detalhes']))))),'situado','',$resp['ll_cidade']))))).' '.$resp['ll_cidade'];
				if (trim($localizacao)==''){
					$localizacao0=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))).'§©§','situado','','§©§')))));
					if (trim($localizacao)!=''){
						$localizacao=isolar('§'.$localizacao,'§','',',').', '.isolar($localizacao,',','',',').', '.isolar($localizacao,',',',',',').'/';

					}
				}
			}

			if (trim($localizacao)==''){$localizacao=isolar_limpo($texto_trabalho,'<b>Local do pregão:<','','</');}

			if (trim($localizacao)!=''){

				
				if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
					echo '<br><font color="green">* Imóvel</font>';
					$geolocalizacao=geolocalizacao($localizacao,'');
				} else {
					$geolocalizacao=geolocalizacao($localizacao,'','','','',false);
				}
				
				if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
				if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

				if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
				if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
				if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
				$resp['ll_endereco']=$localizacao;
					
			}
		}

		if ($resp['ll_uf']==''){$resp['ll_uf']=$uf;};
		if ($resp['ll_cidade']=='' && $resp['ll_uf']==$uf){$resp['ll_cidade']=$cidade;}
		
		
		if ($resp['ll_latitude']=='' || !isset($resp['ll_latitude']) || (int)$resp['ll_latitude']==0){
			

			if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
				echo '<br><font color="green">* Imóvel</font>';
				$geolocalizacao=geolocalizacao($resp['ll_endereco'],'',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);
			} else {
				$geolocalizacao=geolocalizacao($resp['ll_endereco'],'',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais'],false);
			}


			if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
			if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}
			if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
		}



/*
print_r($resp); //return;
exit;

echo '

&&&&&&&&&&&&&&&&&

'.$texto_trabalho;exit;


*/
		if ($teste){
			print_r($resp);echo '<br><br>'; 
			//exit;
			return $resposta_robo;

//if ($resp['ll_link']=='https://www.gustavoreisleiloes.com.br/lotes/454-1-'){exit;}

		} else {
			echo NovoLeilao ($resp,array(),0,0,0,0,false);
			//exit;
			// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
			return $resposta_robo;
		}

		//exit;

//$tempoexecucao_nyx=99999;



	} else {
		//$texto='';
		echo '/ '; return false;
		
	}
	// ==================================
//										$texto='';
	// ==================================
	//exit;	
}

function Busca_site_0009_astavero ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$nada,$teste=false,$texto='',$busca_1='',$busca_2=''){
	global $pdo;

	set_time_limit (600);
	$atingiutempolimite=false;
	$tempoinicioastavero=date("YmdHis");
	
	if (substr($url,-1)!='/'){$url.='/';}

	$r['extra']=organizador_inicia ($idorganizador);

	$lotescadastrados=0;
	$resposta_robo=false;

	$proximo_card=explode(',',$r['extra'].',');
	// $proximo_card => página;

	$conta=0;
	$conta_cards=0;
	$conta_principais=0;
	$conta_cards_internos=0;


	// 1. acha domínio
	$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:93.0) Gecko/20100101 Firefox/93.0' -H 'Accept: application/json, text/plain, */*' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' ".
	"-H 'auth: Baerer' -H 'Connection: keep-alive' -H 'Referer: $url' -H 'Sec-Fetch-Dest: empty' -H 'Sec-Fetch-Mode: cors' -H 'Sec-Fetch-Site: same-origin' -H 'TE: trailers'";
	$resposta=http_post_curl_headers ($url.'domain', $header, '', $cookie, 'utf8', false, false, '', true, 'GET');
	$dominio=trim(isolar($resposta['content'],'"dominio":"','','"'));

	// 2. obtém categorias
	$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:93.0) Gecko/20100101 Firefox/93.0' -H 'Accept: application/json, text/plain, */*' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' ".
	"-H 'Content-Type: application/json;charset=utf-8' -H 'auth: Baerer' -H 'Origin: $url' -H 'Connection: keep-alive' -H 'Referer: $url' -H 'Sec-Fetch-Dest: empty' ".
	"-H 'Sec-Fetch-Mode: cors' -H 'Sec-Fetch-Site: same-origin' -H 'TE: trailers' ";
	$parametros='{"page":1,"pages":1,"limit":"20","limite":20,"count":0,"skip":0,"tab":1,"hoje":"","vara":"","busca":"","categoria":"","sub":"","cidade":"","origem":"tudo","dominio":"'.$dominio.'"}';
	$resposta=http_post_curl_headers ($url.'categorias', $header, '', $cookie, 'utf8', true, false, $parametros,true);
	$json_cat=trim(isolar($resposta['content'].'§©§','{','{','§©§'));
	$json_cat='{'.substr($json_cat,0,strlen($json_cat)-1);

	$categoria_vetor=explode(']}',$json_cat);
	for ($categoria_em_analise=max(0,(int)$proximo_card[0]);$categoria_em_analise<sizeof($categoria_vetor);$categoria_em_analise++){
		
		$proximo_card[0]=$categoria_em_analise;
		
		$categoria=isolar_limpo($categoria_vetor[$categoria_em_analise],'"','','"');
		echo '<br><strong>
Categoria: '.$categoria.'</strong>: ';
		$subcategorias_vetor=explode('{',isolar_limpo($categoria_vetor[$categoria_em_analise].']','[','',']'));
		
//print_r($subcategorias_vetor); exit;
		for ($subcategoria_em_analise=max(0,(int)$proximo_card[1]);$subcategoria_em_analise<sizeof($subcategorias_vetor);$subcategoria_em_analise++){
			
			$proximo_card[1]=$subcategoria_em_analise;
			$subcategoria=isolar_limpo($subcategorias_vetor[$subcategoria_em_analise],':"','','"');
			$qtsubcategoria=(int)isolar_limpo($subcategorias_vetor[$subcategoria_em_analise].'}','"q":','','}');
			echo '<br><i>
SubCategoria: '.$subcategoria.'</i> ('.$qtsubcategoria.'): ';

			if ($qtsubcategoria>0){
				$pagina=max(1,(int)$proximo_card[2]);
				$paginas_total=((int)($qtsubcategoria/50))+1;
				
				while ($pagina<=$paginas_total){
					echo '<u>
Página '.$pagina.'</u>: ';

					$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:93.0) Gecko/20100101 Firefox/93.0' -H 'Accept: application/json, text/plain, */*' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' ".
					"-H 'Content-Type: application/json;charset=utf-8' -H 'auth: Baerer' -H 'Origin: ".substr($url,0,strlen($url)-1)."' -H 'DNT: 1' -H 'Connection: keep-alive' -H 'Referer: ".$url."' -H 'Sec-Fetch-Dest: empty' -H 'Sec-Fetch-Mode: cors' ".
					"-H 'Sec-Fetch-Site: same-origin' -H 'TE: trailers' ";

					$parametros='{"page":'.$pagina.',"pages":'.$pagina.',"limit":"50","limite":50,"count":'.$qtsubcategoria.',"skip":0,"tab":1,"hoje":"","vara":"","busca":"","categoria":"'.
					utf8_encode($categoria).'","sub":"'.utf8_encode($subcategoria).
					'","cidade":"","origem":"tudo","dominio":"'.$dominio.'"}';

					$resposta=http_post_curl_headers ($url.'lotes', $header, '', $cookie, 'utf8', true, false, $parametros,true);

					$txt_paginacao=$resposta['content'];
					
					$lotes_vetor=explode('{"valor"',$txt_paginacao);
					for ($i=1;$i<sizeof($lotes_vetor);$i++){
						$lote_info=$lotes_vetor[$i];
						
						$ll_numero=isolar($lote_info,'id":"','','"');
						$leilao=isolar($lote_info,'"leilao":"','','"');
						if ($ll_numero!='' && $leilao!=''){
							$resp=array();
							$resp['organizador']=$idorganizador;
							$resp['ll_pais']='BRASIL';
							$resp['ll_idioma']='pt-BR';
							$resp['ll_moeda']='BRL';
							$resp['ll_numero']=$ll_numero;
							$resp['ll_agregador_link']=$url.'leilao/'.$leilao;

							if (!VerificaCadastroLeilao($resp)){
								$resposta=http_post_curl_headers ($url.'pregao/lote/'.$resp['ll_numero'], $header, '', $cookie, 'utf8', false, false, '', true, 'GET');
								$txt_lote=$resposta['content'];
								
								$resposta=http_post_curl_headers ($url.'pregao/leilao/'.$leilao, $header, '', $cookie, 'utf8', false, false, '', true, 'GET');
								$txt_leilao=$resposta['content'];
								
								$resp['ll_link']=$resp['ll_agregador_link'];

								// **===============
								$valores=isolar($txt_lote,'"v":{"','','},');
								$resp['ll_lance_min_1']=round(sonumeros(str_replace(',','.',str_replace('.','',str_replace('"','',isolar_limpo($valores,'"primeira":','',','))))),2);
								$resp['ll_lance_min_2']=round(sonumeros(str_replace(',','.',str_replace('.','',str_replace('"','',isolar_limpo($valores,'"segunda":','',','))))),2);
								$resp['ll_avaliacao']=round(sonumeros(str_replace(',','.',str_replace('.','',str_replace('"','',isolar_limpo($valores,'"avaliacao":','',','))))),2);

								// **===============
								$resp['ll_data_1']=substr((int)sonumeros(str_replace('-','',str_replace(':','',isolar($txt_leilao,'"d1":"','','"')))),0,12);
								$resp['ll_data_2']=substr((int)sonumeros(str_replace('-','',str_replace(':','',isolar($txt_leilao,'"d2":"','','"')))),0,12);

								// **===============
								$anexos=isolar($txt_lote,'"anexos":[','','],');

								$contapix=0;

								$pix=isolar($txt_lote,'"image":"','','",');
								if ($pix!=''){
									$pix='https://asta.nyc3.cdn.digitaloceanspaces.com/'.$pix;

									$contapix+=1;
									$resp['ll_foto_'.$contapix]=$pix;
									echo '
foto: '.$resp['ll_foto_'.$contapix];
								}

								while(  $pix0=isolar($anexos,'"type":"image','','}') ) {
									$anexos=str_replace('"type":"image'.$pix0,'', $anexos);
									
									$pix=isolar($pix0,'"path":"','','",').isolar($pix0,'"arquivo":"','','"');
									if ($pix!=''){
										$pix='https://asta.nyc3.cdn.digitaloceanspaces.com/'.$pix;

										$contapix+=1;
										if ($contapix<=8){
											$resp['ll_foto_'.$contapix]=$pix;
											echo '
foto: '.$resp['ll_foto_'.$contapix];
										} else {
											$anexos='';
										}
									}
								}
								
								$resp['ll_lote']=isolar_limpo($txt_lote,'"lote":"','','",');

								$resp['ll_descricao']=isolar_limpo($txt_lote,'"detalhada":"','"nome":"','",');

								$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
									str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('<br>','.~ ',isolar($txt_lote,'"detalhada":"','','",')))))))))))));

								$resp['ll_obs']=isolar_limpo($txt_lote,'"anotacoes":"','','",');

								if (str_replace('EXTRAJUDICIA','',$txt_lote)!=$txt_lote || str_replace('EXTRA JUDICIA','',$txt_lote)!=$txt_lote || str_replace('EXTRA-JUDICIA','',$txt_lote)!=$txt_lote ){
									$resp['ll_natureza']='0';
								} else {
									if (str_replace('JUDICIA','',$txt_lote)!=$txt_lote ){
										$resp['ll_natureza']='1';
									}
								}

								$resp['ll_categoria_txt']=$categoria.','.$subcategoria;
								$resp['ll_categoria_rotulo']=$subcategoria;

								if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) ){
									$resp['ll_categoria_txt'].=',SUCATAS';
									$resp['ll_categoria_rotulo']='SUCATAS';
								}

								// **===============
								$visitacao=str_replace('?','',isolar($txt_lote,'"d":{"','','},'));
								$resp['ll_endereco']=isolar($visitacao,'"endereco":"','','",');
								$resp['ll_bairro']=isolar($visitacao,'"bairro":"','','",');
								$resp['ll_cidade']=isolar($visitacao,'"cidade":"','','",');
								$resp['ll_uf']=isolar($visitacao,'"uf":"','','",');


								if ($resp['ll_endereco']==''){ $resp['ll_endereco']=adivinha_endereco($resp['ll_detalhes'],$cidade);}
								if ($resp['ll_uf']==''){ 
									$resp['ll_uf']=$uf;
									if ($resp['ll_cidade']==''){ 
										$resp['ll_cidade']=$cidade;
									}
								}
								
								if (!$teste){
									if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
										echo '<br><font color="green">* Imóvel</font>';
										$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);
									} else {
										$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais'],false);
									}
									
							
									//$geolocalizacao=geolocalizacao($resp['ll_endereco'],'',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);

									if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
									if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}
							//		if ($geolocalizacao[4]!='' && $resp['ll_bairro']==''){$resp['ll_bairro']=$geolocalizacao[4];}

									if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
									//if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}

									if ($geolocalizacao[3]!=''){$resp['ll_cidade']=$geolocalizacao[3];}		
									//if ($geolocalizacao[3]!=''){$resp['ll_cidade']=$geolocalizacao[3];}
									if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
								}

								if($resp['ll_descricao']!=''){$resposta_robo=true;}


								if ($teste){
									print_r($resp);echo '<br><br>'; if($resposta_robo){return $resposta_robo;}
									//exit;
								} else {
									echo NovoLeilao ($resp,array(),0,0,0,0,false);
									//exit;
									// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
								}


								//exit;
								// ==================================
								$conta+=1;
								if ($conta==1){$tempoinicioastavero=date("YmdHis");}
								// ==================================
								$tempoexecucaomg=diferencasegundos( $tempoinicioastavero ,'');

								//$tempoexecucaomg=99999;



								if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
									// atingiu tempo limite.
									$atingiutempolimite=true;
									goto fimdolaco;
								}

							} else {
							//$texto='';
							echo '/ ';

							}
								
						}
					}
					
					$pagina+=1;
					
				}
				$proximo_card[2]=1;

			}
		}
		$proximo_card[1]=0;
	}


	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		if (!$teste){organizador_tempo_limite_atingido ($idorganizador,$proximo_card[0].','.$proximo_card[1].','.$proximo_card[2]);}
	echo '***
	tempo limite
	';
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}
	
	return $resposta_robo;
}

function Busca_site_0010_suporteleiloes ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$nada,$teste=false,$texto='',$busca_1='',$busca_2=''){
	global $pdo;

	set_time_limit (600);
	$atingiutempolimite=false;
	$tempoinicioastavero=date("YmdHis");
	
	if (substr($url,-1)!='/'){$url.='/';}

	$r['extra']=organizador_inicia ($idorganizador);

	$lotescadastrados=0;
	$resposta_robo=false;

	$proximo_card=explode(',',$r['extra'].',');
	// $proximo_card => página;

	$conta=0;
	$conta_cards=0;
	$conta_principais=0;
	$conta_cards_internos=0;

	$texto_categorias=isolar(http_get_curl($url.'busca-tipo/1','firefox',false,'utf8'),'<div class="lotes-tipo">','<ul','</ul');
//echo $texto_categorias; exit;

	$categoria_vetor=explode('<li',$texto_categorias);
	for ($categoria_em_analise=max(0,(int)$proximo_card[0]);$categoria_em_analise<sizeof($categoria_vetor);$categoria_em_analise++){
		
		$proximo_card[0]=$categoria_em_analise;
		
		$categoria=isolar_limpo($categoria_vetor[$categoria_em_analise],'<div class="content">','','</div');
		$categoria_link=isolar_limpo($categoria_vetor[$categoria_em_analise],'href="/','','"');
		
		if ($categoria!='' && $categoria_link!=''){
		echo '<br><strong>
Categoria: '.$categoria.'</strong>: '.$categoria_link;

			$pagina=max(1,(int)$proximo_card[1]);
			$continua_paginando=true;
			
			while ($continua_paginando){
				echo '<u>
Página '.$pagina.'</u>: ';

				$txt_paginacao=http_get_curl($url.$categoria_link.'?page='.$pagina,'firefox',false,'utf8');
//echo $txt_paginacao; exit;

			
				$lotes_vetor=explode('class="lote">',$txt_paginacao);
				$lotes_vetor[0]='';
				if (sizeof($lotes_vetor)>1){
//print_r($lotes_vetor); exit;				
					for ($i=1;$i<sizeof($lotes_vetor);$i++){
						$ll_link=isolar($lotes_vetor[$i],'href="/','','"');
						if ($ll_link!=''){
							$resp=array();
							$resp['organizador']=$idorganizador;
							$resp['ll_pais']='BRASIL';
							$resp['ll_idioma']='pt-BR';
							$resp['ll_moeda']='BRL';
							$resp['ll_link']=$url.$ll_link;

							if (!VerificaCadastroLeilao($resp)){
								$txt_lote=http_get_curl($resp['ll_link'],'firefox',false,'utf8');
								$txt_lote_minusculas=capitalizacao_str($txt_lote,false);

								$resp['ll_agregador_link']=isolar($txt_lote,'<div class="leilao-info">','href="/','"'); if ($resp['ll_agregador_link']!=''){$resp['ll_agregador_link']=$url.$resp['ll_agregador_link'];}
								$resp['ll_agregador']=isolar_limpo($txt_lote,'<div class="leilao-info">','<a','</a');
								
								$datas=isolar($txt_lote_minusculas,'<div class="leilao-info">','','<div class="btns">');
								$resp['ll_data_1']=substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',isolar_limpo($datas,'abertura:','','</div'))),6,true),0,12);
								if ($resp['ll_data_1']==''){$resp['ll_data_1']=substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',isolar_limpo($datas,'praça:','','</div'))),6,true),0,12);}
								$resp['ll_data_2']=substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',isolar_limpo($datas,'praça:','praça:','</div'))),6,true),0,12);

								$anexos=isolar($txt_lote,'<ul class="lote-thumbs">','','</ul');
								$contapix=0;
								while(  $pix0=isolar($anexos,'src="','','"') ) {
									$anexos=str_replace('src="'.$pix0,'', $anexos);
									
									if ($pix0!=''){
										$contapix+=1;
										if ($contapix<=8){
											$resp['ll_foto_'.$contapix]=$pix0;
											echo '
foto: '.$resp['ll_foto_'.$contapix];
										} else {
											$anexos='';
										}
									}
								}

								$resp['ll_lote']=isolar_limpo($txt_lote,'<div class="numero-lote','<str','</str');
								$resp['ll_descricao']=isolar_limpo($txt_lote,'class="item-title"','','</');
								$resp['ll_processo']=isolar_limpo($txt_lote,'>Processo<','','<');
								$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
									str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('<br>','.~ ',isolar($txt_lote,'>Descrição<','','</div')))))))))))));

								$resp['ll_lance_min_1']=round(sonumeros(isolar($txt_lote,'"valorInicial":"','','"')),2);
								$resp['ll_lance_min_2']=round(sonumeros(isolar($txt_lote,'"valorInicial2":"','','"')),2);
								
								if ($resp['ll_lance_min_2']>0 && $resp['ll_data_2']==''){$resp['ll_data_2']=$resp['ll_data_1'];}

								$resp['ll_categoria_txt']=$categoria;
								$resp['ll_categoria_rotulo']=$categoria;

								if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) ){
									$resp['ll_categoria_txt'].=',SUCATAS';
									$resp['ll_categoria_rotulo']='SUCATAS';
								}

								$resp['ll_uf']='';
								$resp['ll_cidade']='';

								$endereco0=str_replace('Â°','',limpaespacos(str_replace(',',', ',limpacaracteresutf8_novo(urldecode(trim(isolar($txt_lote,'google.com/maps/embed','!2s','!')))))));
								$endereco_vetor=explode(',',str_replace(' - ',',',$endereco0));
								$indice_uf=0;

								if (strlen($endereco_vetor[sizeof($endereco_vetor)])==2){
									$indice_uf=sizeof($endereco_vetor);
								} else {
									if (strlen($endereco_vetor[sizeof($endereco_vetor)-1])==2){
										$indice_uf=sizeof($endereco_vetor)-1;
									} else {
										if (strlen($endereco_vetor[sizeof($endereco_vetor)-2])==2){
											$indice_uf=sizeof($endereco_vetor)-2;
										}

									}
								}
								if ($indice_uf>0){
									$resp['ll_uf']=$endereco_vetor[$indice_uf];
									$resp['ll_cidade']=$endereco_vetor[$indice_uf-1];
									$resp['ll_endereco']='';
									for ($i=0;$i<$indice_uf-1;$i++){
										if ($resp['ll_endereco']!=''){$resp['ll_endereco'].=', ';}
										$resp['ll_endereco'].=$endereco_vetor[$i];
									}
									
								} else {

									$localizacao=str_replace('+',' ',isolar_limpo($txt_lote,'<a href="https://www.google.com/maps/place/','','/'));
									//if ($localizacao==''){$localizacao=str_replace('+',' ',isolar_limpo($texto_lote,'<a href="https://www.google.com/maps/place/','','/'));}
									if (trim($localizacao)==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','/')))));}
									if (trim($localizacao)==''){$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))),'situado','','-')))));}
									if (trim($localizacao)==''){
										$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',strtolower($resp['ll_detalhes']))))),'situado','',$resp['ll_cidade']))))).' '.$resp['ll_cidade'];
										if (trim($localizacao)==''){
											$localizacao0=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$resp['ll_detalhes'])))).'§©§','situado','','§©§')))));
											if (trim($localizacao)!=''){
												$localizacao=isolar('§'.$localizacao,'§','',',').', '.isolar($localizacao,',','',',').', '.isolar($localizacao,',',',',',').'/';

											}
										}
									}

									if (trim($localizacao)==''){ $localizacao=adivinha_endereco($resp['ll_detalhes'],$cidade);}
									if ($resp['ll_uf']==''){ 
										$resp['ll_uf']=$uf;
										if ($resp['ll_cidade']==''){ 
											$resp['ll_cidade']=$cidade;
										}
									}

									if ((!$teste && trim($localizacao)!='')){

										if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
											echo '<br><font color="green">* Imóvel</font>';
											$geolocalizacao=geolocalizacao($localizacao,'');
										} else {
											$geolocalizacao=geolocalizacao($localizacao,'','','','',false);
										}
										if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
										if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

										if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
										if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
										if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
										$resp['ll_endereco']=$localizacao;
											
									}
								}


								if($resp['ll_descricao']!=''){$resposta_robo=true;}

								if ($teste){
									print_r($resp);echo '<br><br>'; //if($resposta_robo){return $resposta_robo;}
									//exit;
								} else {
									echo NovoLeilao ($resp,array(),0,0,0,0,false);
									//exit;
									// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
								}

								//exit;
								// ==================================
								$conta+=1;
								if ($conta==1){$tempoinicioastavero=date("YmdHis");}
								// ==================================
								$tempoexecucaomg=diferencasegundos( $tempoinicioastavero ,'');

								//$tempoexecucaomg=99999;



								if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
									// atingiu tempo limite.
									$atingiutempolimite=true;
									goto fimdolaco;
								}

							} else {
							//$texto='';
							echo '/ ';

							}
								
						}
					}
					$pagina+=1;
				} else {
					$continua_paginando=false;
					
				}
			}
			$proximo_card[1]=1;
		}
	}


	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		if (!$teste){organizador_tempo_limite_atingido ($idorganizador,$proximo_card[0].','.$proximo_card[1]);}
	echo '***
	tempo limite
	';
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}
	
	return $resposta_robo;
}

function Busca_site_0011_leiloesbr ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$nada,$teste=false,$texto='',$busca_1='',$busca_2=''){
	global $pdo;

	set_time_limit (600);
	$atingiutempolimite=false;
	$tempoinicioastavero=date("YmdHis");
	
	if (substr($url,-1)!='/'){$url.='/';}

	$r['extra']=organizador_inicia ($idorganizador);

	$lotescadastrados=0;
	$resposta_robo=false;

	$proximo_card=explode(',',$r['extra'].',');
	// $proximo_card => página;

	$conta=0;
	$conta_cards=0;
	$conta_principais=0;
	$conta_cards_internos=0;

	$texto_cards=http_get_curl($url.'listacatalogo.asp','firefox',false,'utf8');
//echo $texto_cards; exit; // ************ separar por "ANDAMENTO":true,"IDLEILAO":"

	$cards_vetor=explode('leilao-box-wrap"',$texto_cards);
	$tipo_lbr=1;
	if (sizeof($cards_vetor)<=1){
		$tipo_lbr=2;
		$cards_vetor=explode('"ANDAMENTO":true,"IDLEILAO":',$texto_cards);
	}
	for ($card_em_analise=max(1,(int)$proximo_card[0]);$card_em_analise<sizeof($cards_vetor);$card_em_analise++){
		
		$proximo_card[0]=$card_em_analise;
		
		if ($tipo_lbr==1){
			$ll_numero=isolar_limpo($cards_vetor[$card_em_analise],'catalogo.asp?Num=','','"');
			$link_catalogo=isolar($cards_vetor[$card_em_analise],'"leilao-nav','href="','"');
			if (substr($link_catalogo,0,4)=='http' && str_replace($url,'',$link_catalogo)==$link_catalogo){$ll_numero='';}

			echo '['.$card_em_analise.'] ';
			
			if ($ll_numero!='' ){

				$pagina=max(1,(int)$proximo_card[1]);
				$continua_paginando=true;
				
				while ($continua_paginando){
					echo '<u>
Página '.$pagina.'</u>: '.$url.'catalogo.asp?Num='.$ll_numero.'&pag='.$pagina;
	//exit;
					$proximo_card[1]=$pagina;

					$txt_paginacao=http_get_curl($url.'catalogo.asp?Num='.$ll_numero.'&pag='.$pagina,'firefox',false,'utf8');
//echo $txt_paginacao; exit;

				
					$lotes_vetor=explode('loteestatus',$txt_paginacao);
					$lotes_vetor[0]='';
					if (sizeof($lotes_vetor)>1){
	//print_r($lotes_vetor); exit;				
						for ($i=1;$i<sizeof($lotes_vetor);$i++){
							$ll_link=isolar($lotes_vetor[$i],'href="','','"');
							if ($ll_link!='' && str_replace('R$','',strtoupper($lotes_vetor[$i]))!=strtoupper($lotes_vetor[$i]) && str_replace('LOTE VENDIDO','',strtoupper($lotes_vetor[$i]))==strtoupper($lotes_vetor[$i])  ){
								$resp=array();
								$resp['organizador']=$idorganizador;
								$resp['ll_pais']='BRASIL';
								$resp['ll_idioma']='pt-BR';
								$resp['ll_moeda']='BRL';
								$resp['ll_link']=$url.$ll_link;
								$resp['ll_agregador_link']=$url.'catalogo.asp?Num='.$ll_numero;

								if (!VerificaCadastroLeilao($resp)){
									$txt_lote=http_get_curl($resp['ll_link'],'firefox',false,'utf8');
									$txt_lote_minusculas=capitalizacao_str($txt_lote,false);
									
									$resp['ll_agregador']=isolar_limpo($txt_lote,'>Lista de Catálogos', '<li','</li');

									$resp['ll_lote']=trim(str_replace('lote','',isolar_limpo($txt_lote_minusculas,'class="pickLote"','','<')));
									//$resp['ll_agregador']=isolar_limpo($txt_lote,'og:description"', 'content="','"');
									$resp['ll_descricao']=isolar_limpo($txt_lote,'og:description"', 'content="','"');
									$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
										str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('<br>','.~ ',isolar($txt_lote,'og:description"', 'content="','"')))))))))))));


									$resp['ll_categoria_txt']=isolar_limpo($txt_lote_minusculas,'<p><b>Tipo:','','</p');
									$resp['ll_categoria_rotulo']=$resp['ll_categoria_txt'];

									if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) ){
										$resp['ll_categoria_txt'].=',SUCATAS';
										$resp['ll_categoria_rotulo']='SUCATAS';
									}

									$localizacao=isolar_limpo($txt_lote,'Local:', '</label','</p');

									if ((!$teste && trim($localizacao)!='')){

										if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
											echo '<br><font color="green">* Imóvel</font>';
											$geolocalizacao=geolocalizacao($localizacao,'');
										} else {
											$geolocalizacao=geolocalizacao($localizacao,'','','','',false);
										}
										
										if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
										if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

										if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
										if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
										if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
										$resp['ll_endereco']=$localizacao;
											
									}
									
									$resp['ll_data_1']=substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',isolar_limpo($txt_lote,'id="lei-modal"','','</'))),6,true),0,12);
									$resp['ll_lance_min_1']=round(sonumeros(isolar(isolar($txt_lote,'<li class="valor','','</li'),'R$','','</p')),2);
									
									$pix0=isolar(isolar($txt_lote,'<div class="img-wrap">','','</div'),'src="','','"');
									if ($pix0!=''){
										$resp['ll_foto_1']=$pix0;
										echo '
foto: '.$resp['ll_foto_'.$contapix];
									}

									if($resp['ll_descricao']!=''){$resposta_robo=true;}

	//print_r($resp); echo $txt_lote; exit;				

									if ($teste){
										print_r($resp);echo '<br><br>'; //if($resposta_robo){return $resposta_robo;}
										//exit;
									} else {
										echo NovoLeilao ($resp,array(),0,0,0,0,false);
										//exit;
										// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
									}

									//exit;
									// ==================================
									$conta+=1;
									if ($conta==1){$tempoinicioastavero=date("YmdHis");}
									// ==================================
									$tempoexecucaomg=diferencasegundos( $tempoinicioastavero ,'');

									//$tempoexecucaomg=99999;



									if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
										// atingiu tempo limite.
										$atingiutempolimite=true;
										goto fimdolaco;
									}

								} else {
								//$texto='';
								echo '/ ';

								}
									
							}
						}
					}
					$pagina+=1;
					if (str_replace('&pag='.$pagina.'"','',$txt_paginacao)==$txt_paginacao){$continua_paginando=false;}
				}
				$proximo_card[1]=1;
			}
		}
		
		
		if ($tipo_lbr==2){
			$ll_numero=isolar_limpo($cards_vetor[$card_em_analise],'"','','"');


			echo '['.$card_em_analise.'] ';
			
			if ($ll_numero!='' ){

				$pagina=max(1,(int)$proximo_card[1]);
				$continua_paginando=true;
				
				while ($continua_paginando){

					echo '<u>
	Página '.$pagina.' (tipo 2)</u>: ';
	//exit;
					$proximo_card[1]=$pagina;

//https://www.brasiliafilatelia.com.br/templates/catalogo/asp/catalogocontentload.asp?leilao=23397&pesquisa=&irpara=&Dia=&Tipo=&artista=&Srt=0&Temtotal=859&pag=1&status=2&remote=1&limit=30&_=1635430891360

					$txt_paginacao=http_get_curl($url.'templates/catalogo/asp/catalogocontentload.asp?leilao='.$ll_numero.'&pesquisa=&irpara=&Dia=&Tipo=&artista=&Srt=0&Temtotal=859&pag='.$pagina.'&status=2&remote=1&limit=30&_='.time().'000','firefox',false,'utf8');
//echo $txt_paginacao; exit;
  
					$lotes_vetor=explode('{"VALOR_VENDA"',$txt_paginacao);
					$lotes_vetor[0]='';
					if (sizeof($lotes_vetor)>1){
	//print_r($lotes_vetor); exit;				
						for ($i=1;$i<sizeof($lotes_vetor);$i++){
							if (str_replace('LOTE VENDIDO','',strtoupper($lotes_vetor[$i]))==strtoupper($lotes_vetor[$i])  ){
								$resp=array();
								$resp['organizador']=$idorganizador;
								$resp['ll_pais']='BRASIL';
								$resp['ll_idioma']='pt-BR';
								$resp['ll_moeda']='BRL';
								$resp['ll_link']=$url.'peca.asp?id='.isolar($lotes_vetor[$i],'"ID":"','','"');
								$resp['ll_agregador_link']=$url.'catalogo.asp?Num='.isolar($lotes_vetor[$i],'"ID_LEILAO":"','','"');
								if (!VerificaCadastroLeilao($resp)){
									$txt_lote=http_get_curl($resp['ll_link'],'firefox',false,'utf8');
									$txt_lote_minusculas=capitalizacao_str($txt_lote,false);
									$resp['ll_agregador']='Catálogo '.isolar($lotes_vetor[$i],'"ID_LEILAO":"','','"');

									$resp['ll_lote']=isolar($lotes_vetor[$i],'"LOTE":"','','"');
									//$resp['ll_descricao']=isolar($lotes_vetor[$i],'"MINI_DESCRICAO":"','','"');
									//if ($resp['ll_descricao']==''){$resp['ll_descricao']=isolar($lotes_vetor[$i],'"DESCRICAO":"','','"');}
									$resp['ll_descricao']=isolar($lotes_vetor[$i],'"DESCRICAO":"','','"');
									$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
										str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('<br>','.~ ',isolar($lotes_vetor[$i],'"DESCRICAO":"','','"')))))))))))));

									$resp['ll_categoria_txt']=isolar($txt_lote_minusculas,'"TIPO":"','','"');
									$resp['ll_categoria_rotulo']=$resp['ll_categoria_txt'];

									if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) ){
										$resp['ll_categoria_txt'].=',SUCATAS';
										$resp['ll_categoria_rotulo']='SUCATAS';
									}
									$localizacao=isolar_limpo($txt_lote,'"LOCALTXT":"', '','"');

									if ((!$teste && trim($localizacao)!='')){

										if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
											echo '<br><font color="green">* Imóvel</font>';
											$geolocalizacao=geolocalizacao($localizacao,'');
										} else {
											$geolocalizacao=geolocalizacao($localizacao,'','','','',false);
										}
										
										if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
										if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

										if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
										if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
										if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
										$resp['ll_endereco']=$localizacao;
											
									}

									$resp['ll_data_1']=substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',isolar($txt_lote,'"DATADIA":"','','"'))),6,true),0,12);
									$resp['ll_lance_min_1']=round(sonumeros(isolar($lotes_vetor[$i],'"VALOR_VALUE":"','','"')),2);
									
									$pix0=isolar($txt_lote,'"VPASTA":"','','"');
									if ($pix0!=''){
										$resp['ll_foto_1']=$pix0;
										echo '
foto: '.$resp['ll_foto_'.$contapix];
									}



									if($resp['ll_descricao']!=''){$resposta_robo=true;}

	//print_r($resp); echo $txt_lote; exit;				

									if ($teste){
										print_r($resp);echo '<br><br>'; //if($resposta_robo){return $resposta_robo;}
										//exit;
									} else {
										echo NovoLeilao ($resp,array(),0,0,0,0,false);
										//exit;
										// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
									}

									//exit;
									// ==================================
									$conta+=1;
									if ($conta==1){$tempoinicioastavero=date("YmdHis");}
									// ==================================
									$tempoexecucaomg=diferencasegundos( $tempoinicioastavero ,'');

									//$tempoexecucaomg=99999;



									if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
										// atingiu tempo limite.
										$atingiutempolimite=true;
										goto fimdolaco;
									}

								} else {
								//$texto='';
								echo '/ ';

								}
									
							}
						}
					}
					$pagina+=1;
					if (str_replace('&pag='.$pagina.'"','',$txt_paginacao)==$txt_paginacao){$continua_paginando=false;}
				}
				$proximo_card[1]=1;
			}
		}
		
	}


	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		if (!$teste){organizador_tempo_limite_atingido ($idorganizador,$proximo_card[0].','.$proximo_card[1]);}
	echo '***
	tempo limite
	';
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}
	
	return $resposta_robo;
}

function Busca_site_0012_roisoft ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$nada,$teste=false,$texto='',$busca_1='',$busca_2=''){
	global $pdo;

	set_time_limit (600);
	$atingiutempolimite=false;
	$tempoinicioastavero=date("YmdHis");
	
	if (substr($url,-1)!='/'){$url.='/';}

	$r['extra']=organizador_inicia ($idorganizador);

	$lotescadastrados=0;
	$resposta_robo=false;

	$proximo_card=explode(',',$r['extra'].',,,');
	// $proximo_card => página;

	$conta=0;
	$conta_cards=0;
	$conta_principais=0;
	$conta_cards_internos=0;

	$texto_cats=http_get_curl($url.'listacatalogo.asp','firefox',false,'utf8');
	
	if (str_replace('<li class="nav-item">','',$texto_cats)==$texto_cats){
		$texto_cats='<inicio>
            <li class="nav-item"><a href="/veiculos">VEÍCULOS</a>
            <li class="nav-item"><a href="/materiais">MATERIAIS</a>
            <li class="nav-item"><a href="/imoveis">IMÓVEIS</a>
            <li class="nav-item"><a href="/judiciais">JUDICIAIS</a>
            <li class="nav-item"><a href="/diversos">DIVERSOS</a>';
        echo '* Usando links genéricos. ';
	}

//echo $texto_cats; exit;
//$proximo_card[0]=2;

	$cats_vetor=explode('<li class="nav-item">',$texto_cats);
	for ($categ_em_analise=max(1,(int)$proximo_card[0]);$categ_em_analise<sizeof($cats_vetor);$categ_em_analise++){
		
		$proximo_card[0]=$categ_em_analise;

		$link_cat=isolar($cats_vetor[$categ_em_analise],'href="','','"');
		if (substr($link_cat,0,1)=='/'){$link_cat=substr($link_cat,1-strlen($link_cat));}
		if (substr($link_cat,-1)!='/'){$link_cat.='/';}
		$categoria=isolar_limpo($cats_vetor[$categ_em_analise],'<a','','</a');
		if ($link_cat!=''){
			if (substr($link_cat,0,4)!='http'){$link_cat=$url.$link_cat;}
			echo '<br><strong>
Categoria '.$categoria.'</strong>: '.$link_cat;
			$texto_categ=http_get_curl($link_cat,'firefox',false,'utf8');
			$formulario=isolar($texto_categ,'<form id="formulario"','','</form');
			$urlformulario=isolar($formulario,'action="','','"');
			if (substr($urlformulario,0,4)!='http'){$urlformulario=$url.$urlformulario;}
			
			$campos_form=array();
			$campos_form_nomes=array();
			$campos_form0=explode('name=',$formulario);
			for ($campo_em_analise=1;$campo_em_analise<sizeof($campos_form0);$campo_em_analise++){
				$campo_nome=isolar($campos_form0[$campo_em_analise],'"','','"');
				$campo_valor=isolar($campos_form0[$campo_em_analise],'value','"','"');
				if (str_replace('[','',$campo_nome)==$campo_nome && str_replace('LEI_SITE_TRANSMISSAO_AO_VIVO','',$campo_nome)==$campo_nome && str_replace('LEL_ARREMATE_ANTECIPADO','',$campo_nome)==$campo_nome && str_replace('LET_ID_JUDICIAL','',$campo_nome)==$campo_nome){
					$campos_form[]=array($campo_nome,$campo_valor);
					$campos_form_nomes[]=$campo_nome;
				}
			}

			if (sizeof($campos_form)>0 && $urlformulario!=''){
				
				$header= "-X POST -H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:93.0) Gecko/20100101 Firefox/93.0' -H 'Accept: application/json, text/javascript, */*; q=0.01' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' ".
				"-H 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' -H 'X-Requested-With: XMLHttpRequest' -H 'Origin: ".substr($url,0,strlen($url)-1)."' -H 'Connection: keep-alive' -H 'Referer: $link_cat' ".
				//"-H 'Cookie: _ga=GA1.3.537660247.1633704118; __gads=ID=592b7c7b7b2b68e7-22a50cd6297b001c:T=1633704119:RT=1633704119:S=ALNI_MYb70H110z3tvFrr8ScXQNpxfinLg; acceptCookies=true; PHPSESSID=brr2h1id2ssncs0nuuje3r6kv1' ".
				"-H 'Sec-Fetch-Dest: empty' -H 'Sec-Fetch-Mode: cors' -H 'Sec-Fetch-Site: same-origin' -H 'TE: trailers' ";
				$parametros='';
				for ($i=0;$i<sizeof($campos_form);$i++){
					if ($parametros!=''){$parametros.='&';}
					$parametros.=$campos_form[$i][0].'='.$campos_form[$i][1];
				}

				$resposta=http_post_curl_headers ($urlformulario, $header, '', $cookie, false, true, false, $parametros,true);
				$texto_listagem_pagina=$resposta['content'];
				// destrincha categorias...
				
				if (in_array('VTS_ID',$campos_form_nomes)){
					$tipo_subcat='1'; // veículos
					$subcat_ops=limpacaracteresutf8_novo(limpaunicode_v2(isolar($texto_listagem_pagina,'"tipos":{"options":','','}')),2);
					$parametro_subcat='VTS_ID';
				} else {
					if (in_array('LLCA_ID',$campos_form_nomes)){
						$tipo_subcat='2'; // materiais e imóveis
						$subcat_ops=limpacaracteresutf8_novo(limpaunicode_v2(isolar($texto_listagem_pagina,'"categorias":{"options":','','}')),2);
						$parametro_subcat='LLCA_ID';
					} else {
						$tipo_subcat='3'; // judiciais e diversos
						$subcat_ops=limpacaracteresutf8_novo(limpaunicode_v2(isolar($texto_listagem_pagina,'"tiposbem":{"options":','','}')),2);
						$parametro_subcat='LEL_TIPO';
					}
				}


				$subcat_vetor=explode('<option',$subcat_ops);

				for ($subcat_em_analise=max(0,(int)$proximo_card[1]);$subcat_em_analise<sizeof($subcat_vetor);$subcat_em_analise++){
					
					$proximo_card[1]=$subcat_em_analise;

					$valor_subcat=trim(str_replace("'",'',str_replace('"','',isolar($subcat_vetor[$subcat_em_analise],'value=','','>'))));
					$subcategoria=isolar_limpo(str_replace('-','',$subcat_vetor[$subcat_em_analise]),'>','','(');
					$qtsubcategoria=(int)isolar_limpo($subcat_vetor[$subcat_em_analise],'>','(',')');


					if ($qtsubcategoria>0 && $valor_subcat!=''){
						echo '<br><strong>
Subcategoria '.$subcategoria.' ('.$qtsubcategoria.')</strong>: '.$valor_subcat;
						// usa valor da categoria

						$pagina=max(1,(int)$proximo_card[2]);
						$continua_paginando=true;
						while ($continua_paginando){


							echo '<i>
Página '.$pagina.'</i>: ';


							$parametros='';
							for ($i=0;$i<sizeof($campos_form);$i++){
								if ($parametros!=''){$parametros.='&';}

								if ($campos_form[$i][0]==$parametro_subcat){$campos_form[$i][1]=$valor_subcat;}
								if ($campos_form[$i][0]=='pagina'){$campos_form[$i][1]=$pagina;}
								$parametros.=$campos_form[$i][0].'='.$campos_form[$i][1];
							}

							$resposta=http_post_curl_headers ($urlformulario, $header, '', $cookie, false, true, false, $parametros,true);
							
							$texto_listagem_pagina=str_replace('\\','',str_replace('\r','',str_replace('\n',chr(13),$resposta['content'])));

							$pagina+=1;
							if (str_replace('js_paginacao" rel="'.$pagina.'"','',$texto_listagem_pagina)==$texto_listagem_pagina){$continua_paginando=false;}
							
							// varre cards
							$cards_vetor=explode('js_leiloes-col',$texto_listagem_pagina);
							if (sizeof($cards_vetor)<=1){$cards_vetor=explode('colGroupLot',$texto_listagem_pagina);}
							
							if (sizeof($cards_vetor)>1){
								for ($card_em_analise=1;$card_em_analise<sizeof($cards_vetor);$card_em_analise++){
									

									$ll_link=isolar($cards_vetor[$card_em_analise],'href="','','"');
									if (strlen($ll_link)<10){
										$ll_link=isolar($cards_vetor[$card_em_analise],'"veja-mais"','data-rowid="','"');
										if ($ll_link!=''){$ll_link=$link_cat.'lote/'.$ll_link;}
									}

									if ($ll_link!='' ){
										$resp=array();
										$resp['organizador']=$idorganizador;
										$resp['ll_pais']='BRASIL';
										$resp['ll_idioma']='pt-BR';
										$resp['ll_moeda']='BRL';
										$resp['ll_link']=$ll_link;

										$resp['ll_categoria_txt']=$categoria;
										$subcategoria_maiu=capitalizacao_str($subcategoria);
										if (str_replace('NÃO ','',$subcategoria_maiu)!=$subcategoria_maiu){$subcategoria=$categoria;}
										if ($categoria!=$subcategoria){$resp['ll_categoria_txt'].=','.$subcategoria;}
										$resp['ll_categoria_rotulo']=$subcategoria;

										if (str_replace('SUCATA','',strtoupper($cards_vetor[$card_em_analise]))!=strtoupper($cards_vetor[$card_em_analise]) ){
											$resp['ll_categoria_txt'].=',SUCATAS';
											$resp['ll_categoria_rotulo']='SUCATAS';
										}

//print_r($resp); exit;
										if (!VerificaCadastroLeilao($resp)){
											$txt_lote=char_convert(http_get_curl($resp['ll_link'],'firefox',false,'utf8'));
											$txt_lote_minusculas=capitalizacao_str($txt_lote,false);

											$card_min=capitalizacao_str($cards_vetor[$card_em_analise],false);
											if (str_replace('extrajudicia','',$card_min)!=$card_min || str_replace('extra judicia','',$card_min)!=$card_min || str_replace('extra-judicia','',$card_min)!=$card_min ){
												$resp['ll_natureza']='0';
											} else {
												if (str_replace('judicia','',$card_min)!=$card_min ){
													$resp['ll_natureza']='1';
												}
											}

											
											$lote=str_replace(chr(13),'',isolar($txt_lote_minusculas,'>lote<','','</div'));
											if ($lote==''){$lote=str_replace(chr(13),'',isolar($txt_lote_minusculas,'id="lot-title"','','</spa'));}
											$id=isolar_limpo($lote,'id ','','-');
											$resp['ll_lote']=isolar_limpo($lote,':','','-');
											if ($id!=''){$resp['ll_lote'].=' - ID '.$id;}
											$resp['ll_descricao']=capitalizacao_str(isolar(limpahtml($lote).'§©§',' - ', ' - ','§©§')); 
											if ($resp['ll_descricao']==''){$resp['ll_descricao']=capitalizacao_str(limpahtml($lote)); }

											$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
												str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('</tr','.~ <',str_replace('<br>','.~ ',isolar($txt_lote,'>Descrição do Lote', '','</tbody'))))))))))))));

											$resp['ll_agregador']=isolar_limpo($txt_lote,'<div id="lot-info-auction">', '<span class="h','</div');
											$resp['ll_agregador_link']=isolar_limpo($txt_lote,'<div id="lot-info-auction">', 'theme-bg" href="','"');
											if ($resp['ll_agregador_link']==''){$resp['ll_agregador_link']=isolar_limpo($txt_lote,'<div id="lot-info-auction">', 'href="','"');}
											
											$resp['ll_data_1']=trim(substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',str_replace(' - ','/',isolar_limpo($txt_lote_minusculas,'1º leilão','','<')))),6,true),0,12));
											if ($resp['ll_data_1']==''){$resp['ll_data_1']=trim(substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',str_replace(' - ','/',isolar_limpo($txt_lote_minusculas,'id="lot-info-auction-info"','','<')))),6,true),0,12));}
											if ($resp['ll_data_1']==''){$resp['ll_data_1']=trim(substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',str_replace(' - ','/',isolar_limpo($txt_lote_minusculas,'>data',':','<')))),6,true),0,12));}
											if ($resp['ll_data_1']==''){$resp['ll_data_1']=trim(substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',str_replace(' - ','/',isolar_limpo($txt_lote_minusculas,'>data',':','</div')))),6,true),0,12));}
											$resp['ll_lance_min_1']=round(sonumeros(str_replace(',','.',str_replace('.','',isolar_limpo($txt_lote,'class="lance-minimo"','','</')))),2);

											$anexos=isolar($txt_lote,'<div id="lot-pics"','<ul','</ul');
											$contapix=0;
											while(  $pix0=isolar($anexos,'src="','','"') ) {
												$anexos=str_replace('src="'.$pix0,'', $anexos);
												
												if ($pix0!=''){
													$contapix+=1;
													if ($contapix<=8){
														$resp['ll_foto_'.$contapix]=$pix0;
														echo '
foto: '.$resp['ll_foto_'.$contapix];
													} else {
														$anexos='';
													}
												}
											}

											$localizacao=isolar_limpo($txt_lote_minusculas,'endereço:','','<');
											if ($localizacao==''){
												$localizacao=adivinha_endereco(str_replace('.~','',$resp['ll_detalhes']),$cidade);
											}

											if ((!$teste && trim($localizacao)!='')){

												if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
													echo '<br><font color="green">* Imóvel</font>';
													$geolocalizacao=geolocalizacao($localizacao,'');
												} else {
													$geolocalizacao=geolocalizacao($localizacao,'','','','',false);
												}
												
												if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
												if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

												if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
												if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
												if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
												$resp['ll_endereco']=$localizacao;
													
											}
											if ($resp['ll_uf']==''){ 
												$resp['ll_uf']=$uf;
												if ($resp['ll_cidade']==''){ 
													$resp['ll_cidade']=$cidade;
												}

												if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
													echo '<br><font color="green">* Imóvel</font>';
													$geolocalizacao=geolocalizacao($localizacao,'',$resp['ll_cidade'],$resp['ll_uf']);
												} else {
													$geolocalizacao=geolocalizacao($localizacao,'',$resp['ll_cidade'],$resp['ll_uf'],'',false);
												}

												if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
												if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

												if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
												if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
												if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}

												$resp['ll_endereco']=$localizacao;
													
											
											}
										
											if($resp['ll_descricao']!=''){$resposta_robo=true;}

											if ($teste){
												print_r($resp);echo '<br><br>'; //if($resposta_robo){return $resposta_robo;}
												//exit;
											} else {
												echo NovoLeilao ($resp,array(),0,0,0,0,false);
												//exit;
												// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
											}

											//exit;
											// ==================================
//											$conta+=1;
//											if ($conta==1){$tempoinicioastavero=date("YmdHis");}
											// ==================================
											$tempoexecucaomg=diferencasegundos( $tempoinicioastavero ,'');
											if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
												// atingiu tempo limite.
												$atingiutempolimite=true;
												goto fimdolaco;
											}

										} else {
										//$texto='';
										echo '/ ';

										}
									}
									
								}			
							}else{$continua_paginando=false;}
									$tempoexecucaomg=diferencasegundos( $tempoinicioastavero ,'');
									if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
										// atingiu tempo limite.
										$atingiutempolimite=true;
										goto fimdolaco;
									}									

						}
						$proximo_card[2]=1;
					}
				}
				$proximo_card[1]=0;
			}
		}
	}
				

	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		if (!$teste){organizador_tempo_limite_atingido ($idorganizador,$proximo_card[0].','.$proximo_card[1].','.$proximo_card[2]);}
	echo '***
	tempo limite
	';
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}
	
	return $resposta_robo;
}

function Busca_site_0014_leilovia ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$nada,$teste=false,$texto='',$busca_1='',$busca_2=''){
	global $pdo;

	set_time_limit (600);
	$atingiutempolimite=false;
	$tempoinicioastavero=date("YmdHis");
	
	if (substr($url,-1)!='/'){$url.='/';}

	$r['extra']=organizador_inicia ($idorganizador);

	$lotescadastrados=0;
	$resposta_robo=false;

	$proximo_card=explode(',',$r['extra'].',,,');
	// $proximo_card => página;

	$conta=0;
	$conta_cards=0;
	$conta_principais=0;
	$conta_cards_internos=0;

	$textocards=limpacaracteresisolatin1(isolar(http_get_curl($url,'firefox',false,'utf8','','','',true,false),'id="titulo-proximos','','<h2'));
	
//echo $textocards; exit;
//$proximo_card[0]=3;

	$vetorcards=explode('<a',$textocards);
	for ($cardemanalise=max(1,(int)$proximo_card[0]);$cardemanalise<sizeof($vetorcards);$cardemanalise++){
		
		$proximo_card[0]=$cardemanalise;
		echo '['.$cardemanalise.']';

//echo $vetorcards[$cardemanalise]; //exit;			


		$ll_agregador_link=isolar($vetorcards[$cardemanalise],"href='",'',"'");
		if (substr($ll_agregador_link,0,1)=='/'){$ll_agregador_link=substr($ll_agregador_link,1-strlen($ll_agregador_link));}
		//if (substr($ll_agregador_link,-1)!='/'){$ll_agregador_link.='/';}
		if ($ll_agregador_link!='' && str_replace('fa fa-lock','',$vetorcards[$cardemanalise])==$vetorcards[$cardemanalise]){
			if (substr($ll_agregador_link,0,4)!='http'){$ll_agregador_link=$url.$ll_agregador_link;}
			$textoagregador=limpacaracteresisolatin1(isolar(http_get_curl($ll_agregador_link,'firefox',false,'utf8','','','',true,false),'<h2>Lotes','','modalAvaliar'));
/*
echo '

***'.$textoagregador;exit;			
*/
			// varre cards
			$lotesvetor=explode('<a',$textoagregador);
		
			if (sizeof($lotesvetor)>1){
				for ($loteemanalise=1;$loteemanalise<sizeof($lotesvetor);$loteemanalise++){
					

					$ll_link=isolar($lotesvetor[$loteemanalise],"href='",'',"'");

					if ($ll_link!='' ){
						if (substr($ll_link,0,1)=='/'){$ll_link=substr($ll_link,1-strlen($ll_link));}
						if (substr($ll_link,0,4)!='http'){$ll_link=$url.$ll_link;}

						$resp=array();
						$resp['organizador']=$idorganizador;
						$resp['ll_pais']='BRASIL';
						$resp['ll_idioma']='pt-BR';
						$resp['ll_moeda']='BRL';
						$resp['ll_link']=$ll_link;
						$resp['ll_agregador_link']=$ll_agregador_link;

						if (!VerificaCadastroLeilao($resp)){
							$txt_lote=limpacaracteresisolatin1(char_convert(http_get_curl($resp['ll_link'],'firefox',false,'utf8','','','',true,false)));
							$txt_lote_minusculas=capitalizacao_str($txt_lote,false);
							
							$resp['ll_agregador']=isolar_limpo($txt_lote,'<h2>Próximos Leilões</h2>', '<strong','</strong');
							$resp['ll_lote']=isolar_limpo($txt_lote,'<h2>Próximos Leilões</h2>','Lote:','<');

							$categoriaesub=explode('»',isolar_limpo(isolar($txt_lote,'<h2>Próximos Leilões</h2>','Lote:','</p'),'</str','','<'));
							$resp['ll_categoria_txt']='';
							for ($j=0;$j<sizeof($categoriaesub);$j++){
								if ($resp['ll_categoria_txt']!=''){$resp['ll_categoria_txt'].=',';}
								$resp['ll_categoria_txt'].=trim(str_replace('- ','',$categoriaesub[$j]));
							}
							$resp['ll_categoria_rotulo']=trim(str_replace('- ','',$categoriaesub[sizeof($categoriaesub)-1]));

							if (str_replace('SUCATA','',strtoupper($lotesvetor[$loteemanalise]))!=strtoupper($lotesvetor[$loteemanalise]) ){
								$resp['ll_categoria_txt'].=',SUCATAS';
								$resp['ll_categoria_rotulo']='SUCATAS';
							}

							$resp['ll_lance_min_1']=round(sonumeros(str_replace(',','.',str_replace('.','',isolar_limpo($txt_lote,'>Lance inicial:','R$','<')))),2);
							$resp['ll_data_1']=trim(substr(arrumadata_robos(str_replace(' ','/',str_replace(' às ','/',str_replace(' - ','/',isolar_limpo(str_replace('(','<',$txt_lote_minusculas),'>Encerramento:<','','<')))),6,true),0,12));

							$descricao=str_replace('Ver local','',isolar($txt_lote,'<h4>Descrição:</h4>', '','<h3>Dados do leilão'));
							$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
								str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('</tr','.~ <',str_replace('<br>','.~ ',$descricao)))))))))))));

							$resp['ll_descricao']=isolar_limpo($lotesvetor[$loteemanalise],'<blockquote>', '','</b'); 
							if ($resp['ll_descricao']==''){$resp['ll_descricao']=isolar_limpo($descricao,'<h', '','</h');}
							if ($resp['ll_descricao']==''){$resp['ll_descricao']=limpahtml($descricao);}
							
							$resp['ll_comitente']=isolar_limpo($txt_lote,'<h3>Dados do leilão</h3>', '','</h');

							$localizacao=adivinha_endereco(str_replace('.~','',$resp['ll_detalhes']),$cidade);

							if ($localizacao==''){$localizacao=isolar_limpo($lotesvetor[$loteemanalise],'na cidade de','<','<');}
							if ($localizacao==''){$localizacao=isolar_limpo($txt_lote_minusculas,'>Local:<','','<');}

							if ((!$teste && trim($localizacao)!='')){

								if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
									echo '<br><font color="green">* Imóvel</font>';
									$geolocalizacao=geolocalizacao($localizacao,'');
								} else {
									$geolocalizacao=geolocalizacao($localizacao,'','','','',false);
								}

								if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
								if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

								if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
								if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
								if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
								$resp['ll_endereco']=$localizacao;
									
							}
							if ($resp['ll_uf']==''){ 
								$resp['ll_uf']=$uf;
								if ($resp['ll_cidade']==''){ 
									$resp['ll_cidade']=$cidade;
								}
								if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
									echo '<br><font color="green">* Imóvel</font>';
									$geolocalizacao=geolocalizacao($localizacao,'',$resp['ll_cidade'],$resp['ll_uf']);
								} else {
									$geolocalizacao=geolocalizacao($localizacao,'',$resp['ll_cidade'],$resp['ll_uf'],'',false);
								}

								if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
								if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

								if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
								if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
								if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}

								$resp['ll_endereco']=$localizacao;
									
							
							}

							if (str_replace('extrajudicia','',$resp['ll_detalhes'])!=$resp['ll_detalhes'] || str_replace('extra judicia','',$resp['ll_detalhes'])!=$resp['ll_detalhes'] || str_replace('extra-judicia','',$resp['ll_detalhes'])!=$resp['ll_detalhes'] ){
								$resp['ll_natureza']='0';
							} else {
								if (str_replace('judicia','',$resp['ll_detalhes'])!=$resp['ll_detalhes'] ){
									$resp['ll_natureza']='1';
								}
							}

							$anexos=isolar($txt_lote,'<div class="carousel-inner"','','carousel-control');

							$contapix=0;
							while(  $pix0=isolar($anexos."<div class='item","<div class='item",'',"<div class='item") ) {
								$anexos=str_replace("<div class='item".$pix0,'', $anexos);
								
								$pix=isolar($pix0,"src='",'',"'") ;
								
								if ($pix!=''){
									if (substr($pix,0,4)!='http'){$pix=$url.$pix;}
									$contapix+=1;
									if ($contapix<=8){
										$resp['ll_foto_'.$contapix]=$pix;
										echo '
foto: '.$resp['ll_foto_'.$contapix];
									} else {
										$anexos='';
									}
								}
							}
							
							if($resp['ll_descricao']!=''){$resposta_robo=true;}

							if ($teste){
								print_r($resp);echo '<br><br>'; //if($resposta_robo){return $resposta_robo;}
								//exit;
							} else {
								echo NovoLeilao ($resp,array(),0,0,0,0,false);
								//exit;
								// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
							}

							//exit;
							// ==================================
//											$conta+=1;
//											if ($conta==1){$tempoinicioastavero=date("YmdHis");}
							// ==================================
							$tempoexecucaomg=diferencasegundos( $tempoinicioastavero ,'');
							if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
								// atingiu tempo limite.
								$atingiutempolimite=true;
								goto fimdolaco;
							}

						} else {
						//$texto='';
						echo '/ ';

						}
					}
					
				}			
			}else{$continua_paginando=false;}
			
			$tempoexecucaomg=diferencasegundos( $tempoinicioastavero ,'');
			if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
				// atingiu tempo limite.
				$atingiutempolimite=true;
				goto fimdolaco;
			}									
	
		}
	}
				

	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		if (!$teste){organizador_tempo_limite_atingido ($idorganizador,$proximo_card[0]);}
	echo '***
	tempo limite
	';
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}
	
	return $resposta_robo;
}

function Busca_site_0015_softgt ($idorganizador,$url,$baseurl,$cidade,$uf,$leiloeiro,$nada,$teste=false,$texto='',$busca_1='',$busca_2=''){
	global $pdo;

	set_time_limit (600);
	$atingiutempolimite=false;
	$tempoinicioastavero=date("YmdHis");
	
	if (substr($url,-1)!='/'){$url.='/';}

	$r['extra']=organizador_inicia ($idorganizador);

	$lotescadastrados=0;
	$resposta_robo=false;

	$proximo_card=explode(',',$r['extra'].',,,');
	// $proximo_card => página;

	$conta=0;
	$conta_cards=0;
	$conta_principais=0;
	$conta_cards_internos=0;

	$textocards0=limpacaracteresisolatin1(http_get_curl($url,'firefox',true,'utf8','','','',true,false));
	$cookie=isolar($textocards0,'set-cookie: ','',';');

	$textocards=isolar($textocards0,'>Próximos Leilões','','<footer'); if ($textocards!=''){$tipo=1;}
	if ($textocards==''){$textocards=isolar($textocards0,'<section class="bloco-cinza">','','<footer'); if ($textocards!=''){$tipo=2;}}
	if ($textocards==''){$textocards=isolar($textocards0,'<section class="corpo">','','<footer'); if ($textocards!=''){$tipo=3;}}
/*	
echo '
tipo '.$tipo.'
'.$textocards; exit;*/
//$proximo_card[0]=3;

	$vetorcards=explode('<li',$textocards);
	if (sizeof($vetorcards)<2){$vetorcards=explode('>Ver Lote</a>',str_replace('<div class="row">','>Ver Lote</a>',$textocards));}
//print_r($vetorcards); exit;
	for ($cardemanalise=max(1,(int)$proximo_card[0]);$cardemanalise<sizeof($vetorcards);$cardemanalise++){
		
		$proximo_card[0]=$cardemanalise;
		echo '['.$cardemanalise.']';

//echo $vetorcards[$cardemanalise]; //exit;			

		$ll_agregador_link=isolar(str_replace('"','',str_replace("'",'',str_replace(' ','>',$vetorcards[$cardemanalise]))),"href=",'',">");
		if ($ll_agregador_link=='#'){$ll_agregador_link=isolar(str_replace('"','',str_replace("'",'',str_replace(' ','>',$vetorcards[$cardemanalise]))),"href=",'href=',">");}
		if (substr($ll_agregador_link,0,1)=='/'){$ll_agregador_link=substr($ll_agregador_link,1-strlen($ll_agregador_link));}

		if ($ll_agregador_link!=''){
			if (substr($ll_agregador_link,0,4)!='http'){$ll_agregador_link=$url.$ll_agregador_link;}
			
			if(str_replace('/detalhe-lote/','',$ll_agregador_link)!=$ll_agregador_link){
				$ll_agregador_link=isolar('§'.$ll_agregador_link,'§','','/detalhe-lote/').'/leiloes/'.isolar($ll_agregador_link,'/detalhe-lote/','','/').'/';
			}
			
			if (substr($ll_agregador_link,-1)!='/'){$ll_agregador_link.='/';}

echo '
$ll_agregador_link='.$ll_agregador_link.'
';
//exit;
			$textoagregador=limpacaracteresisolatin1(http_get_curl($ll_agregador_link,'firefox',true,'utf8',$cookie,'','',true,false));
			$cookie=isolar($textoagregador,'set-cookie: ','',';');
/*
echo '

***'.$textoagregador;exit;	
*/
			// varre cards
			$lotesvetor=explode('<h3 class="titulo-lote"',$textoagregador);
			if (sizeof($lotesvetor)<2){$lotesvetor=explode('<tr',isolar($textoagregador,'<tbody','','</tbody'));}

//print_r($lotesvetor); exit;		
			if (sizeof($lotesvetor)>1){
				for ($loteemanalise=1;$loteemanalise<sizeof($lotesvetor);$loteemanalise++){

					$txt_listagem_leilao=isolar($lotesvetor[$loteemanalise],'>','','</li');
					if ($txt_listagem_leilao==''){$txt_listagem_leilao=isolar($lotesvetor[$loteemanalise],'>','','</tr');}
					$txt_listagem_leilao=str_replace("href='#'",'',$txt_listagem_leilao);

					$ll_link=isolar(str_replace('"','',str_replace("'",'',str_replace(' ','>',$txt_listagem_leilao))),"href=",'href=',">");
					if ($ll_link==''){$ll_link=isolar(str_replace('"','',str_replace("'",'',str_replace(' ','>',$txt_listagem_leilao))),"href=",'',">");}

					if ($ll_link!='' ){
						if (substr($ll_link,0,1)=='/'){$ll_link=substr($ll_link,1-strlen($ll_link));}
						if (substr($ll_link,0,4)!='http'){$ll_link=$url.$ll_link;}
						if (substr($ll_link,-1)!='/'){$ll_link.='/';}
						
						$resp=array();
						$resp['organizador']=$idorganizador;
						$resp['ll_pais']='BRASIL';
						$resp['ll_idioma']='pt-BR';
						$resp['ll_moeda']='BRL';
						$resp['ll_link']=$ll_link;
						$resp['ll_agregador_link']=$ll_agregador_link;

						$resp['ll_agregador']=isolar_limpo($vetorcards[$cardemanalise],'titulo-leilao', '','<');
//print_r($resp); exit;	
						if (!VerificaCadastroLeilao($resp)){

							$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:94.0) Gecko/20100101 Firefox/94.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' ".
							"-H 'DNT: 1' -H 'Upgrade-Insecure-Requests: 1' -H 'Connection: keep-alive' -H 'Cookie: $cookie' -H 'Sec-Fetch-Dest: document' -H 'Sec-Fetch-Mode: navigate' -H 'Sec-Fetch-Site: same-origin' -H 'Sec-Fetch-User: ?1' -H 'TE: trailers'";
							$resposta1=http_post_curl_headers ($ll_link, $header, '', $cookie, 'utf8', false, false, '', true, 'GET');


							$header= "-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:94.0) Gecko/20100101 Firefox/94.0' -H 'Accept: application/json, text/javascript, */*; q=0.01' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' ".
							"-H 'X-Requested-With: XMLHttpRequest' -H 'Origin: ".substr($url,0,strlen($url)-1)."' -H 'DNT: 1' -H 'Connection: keep-alive' -H 'Referer: $ll_link' -H 'Cookie: $cookie' -H 'Sec-Fetch-Dest: empty' -H 'Sec-Fetch-Mode: cors' ".
							"-H 'Sec-Fetch-Site: same-origin' -H 'Content-Length: 0' -H 'TE: trailers'";

							$resposta=http_post_curl_headers ($url.'proximo_lote.php', $header, '', $cookie, false, false, false, '', true, 'POST');


							$txt_lote=str_replace('?','',limpacaracteresutf8_novo(limpaunicode_v2($resposta['content']),2));
							
							if (str_replace('document has moved','',$txt_lote)!=$txt_lote){$txt_lote=limpacaracteresisolatin1($resposta1['content'],2);}
/*
echo '
* $txt_lote='.$txt_lote.'
';*/
/*
**'.$vetorcards[$cardemanalise].'

';*/
							$resp['ll_lote']=isolar($txt_lote,'"lote":"','','"');
							if ($resp['ll_lote']==''){$resp['ll_lote']=trim(limpaespacos(str_replace('-','',str_replace('LOTE','',capitalizacao_str(isolar_limpo($txt_lote,'<h2 class="titulo"','','</h'))))));}
							if ($resp['ll_lote']==''){$resp['ll_lote']=trim(limpaespacos(str_replace('-','',str_replace('LOTE','',capitalizacao_str(isolar_limpo($txt_lote,'<section class="corpo">','','</h'))))));}
							if ($resp['ll_lote']==''){$resp['ll_lote']=trim(limpaespacos(str_replace('-','',str_replace('LOTE','',capitalizacao_str(isolar_limpo($txt_lote,'<h3>','','</h'))))));}

							$resp['ll_descricao']=isolar($txt_lote,'"descricao":"','','"');
							if ($resp['ll_descricao']==''){$resp['ll_descricao']=isolar_limpo($txt_lote,'<h2 class="titulo" ','</h','</h');}
							if ($resp['ll_descricao']==''){$resp['ll_descricao']=isolar_limpo($txt_lote,'<section class="corpo">','</h','</h');}
							if (str_replace('Lote Anterior','',$resp['ll_descricao'])!=$resp['ll_descricao']){$resp['ll_descricao']=isolar_limpo($vetorcards[$cardemanalise],'<div class="card-body h-50">','','</d');}
							if ($resp['ll_descricao']==''){$resp['ll_descricao']=isolar_limpo($txt_lote,'<h2 class="texto-titulo','','</h');}

							$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
								str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('</tr','.~ <',str_replace('<br>','.~ ',
								str_replace('"','',str_replace('[','',str_replace(']','',
								isolar($txt_lote,'"obs":','',',"')))))))))))))))));
							if ($resp['ll_detalhes']==''){
								$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
								str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('</tr','.~ <',str_replace('<br>','.~ ',
								str_replace('"','',str_replace('[','',str_replace(']','',
								isolar($txt_lote,'<section class="texto-detalhe">','</','</section')))))))))))))))));
							}

							if ($resp['ll_detalhes']==''){
								$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
								str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('</tr','.~ <',str_replace('<br>','.~ ',
								str_replace('"','',str_replace('[','',str_replace(']','',
								'<'.isolar($txt_lote,'>DETALHE','</','</section').' <'.isolar($txt_lote,'>CARACTERÍSTICAS','</','</section')))))))))))))))));
							}

							if ($resp['ll_detalhes']==''){
								$resp['ll_detalhes']=limpaespacos(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
								str_replace(chr(10),' ',limpahtml(str_replace('</p','.~ <',str_replace('</tr','.~ <',str_replace('<br>','.~ ',
								str_replace('"','',str_replace('[','',str_replace(']','',
								'<'.isolar($txt_lote,'<span class="descricao">','','</div')))))))))))))))));
							}


							$resp['ll_processo']=isolar($txt_lote,'"autos":"','','"');
							$resp['ll_avaliacao']=round(str_replace(',','.',str_replace('.','',isolar_limpo($txt_lote,'"avaliacao":"','','"'))),2);
							if ($resp['ll_avaliacao']==0){$resp['ll_avaliacao']=round(str_replace(',','.',str_replace('.','',isolar_limpo(isolar($txt_lote,'class="valor-avaliado"','','</section>').'§','R$','','§'))),2);}
							if ($resp['ll_avaliacao']==0){$resp['ll_avaliacao']=round(str_replace(',','.',str_replace('.','',isolar_limpo(isolar(str_replace('-','',$txt_lote),'Valor Avaliação:','','</small').'§','R$','','§'))),2);}

							$resp['ll_lance_min_1']=round(str_replace('R$','',str_replace(',','.',str_replace('.','',isolar_limpo($txt_lote,'"bem_lance_inicial":"','','"')))),2);
							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=round(str_replace(',','.',str_replace('.','',isolar_limpo(isolar($txt_lote,'class="valor-inicial"','','</section>').'§','R$','','§'))),2);}
							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=round(str_replace(',','.',str_replace('.','',isolar_limpo(isolar(str_replace('-','',$txt_lote),'Lance Inicial: ','','</small').'§','R$','','§'))),2);}



							$texto_trabalho_minusculas=capitalizacao_str($txt_lote,false);

							$texto_card_1_minusculas=capitalizacao_str($vetorcards[$cardemanalise],false);
							$texto_card_1_minusculas=str_replace('&nbsp;','',str_replace('ªª','ª',str_replace('ªpra','ª pra',str_replace('ªº','ª',str_replace('1?','1ª',str_replace('2?','2ª',str_replace(' até ',' à ',str_replace('leilão','praça',
								str_replace('encerrado','r$',str_replace('vide rel','r$',str_replace('leilão<','leilão:<',str_replace('único:','praça:',str_replace('única:','praça:',str_replace('praça<','praça:<',str_replace('chamada:','praça:',
								str_replace('hasta','praça',str_replace('º','ª',str_replace('°','ª',str_replace(chr(9),' ',$texto_card_1_minusculas)))))))))))))))))));

							$praca0=str_replace(' - ',' às ',isolar($texto_card_1_minusculas,'<div class="leilao-pracas','','</a'));
							$praca1=isolar($praca0.'leilao-praca','leilao-praca','','leilao-praca');
							$praca2=isolar($praca0.'§©§','leilao-praca','leilao-praca','§©§');

//echo $texto_card_1_minusculas;
							
							$resp['ll_data_1']=isolar_limpo($praca1,'</spa','','</spa'); if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($praca2,'</spa','','</spa'); if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca1,'r$','','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
							$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($praca2,'r$','','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}

							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'fa-calendar','</str','</li');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:',' à ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:','','r$');	if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:',' à ','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:','','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'fechamento','|','</');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'encerra em',':','</li');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:','encerramento:','</ul');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:',' a ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:',' à ',' às ');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:',' a ',' às ');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo(str_replace('vide ','r$',$texto_card_1_minusculas),'praça -',' a ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça',' à ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça',' à ','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça','','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'ª praça','</','</');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'>praça','</','</');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça','encerramento:','</ul');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça',' a ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça',' à ',' às ');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça',' a ',' às ');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça','','-');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'encerramento:','</','</');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_reverso($texto_card_1_minusculas,'>','/'.date("Y"));if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}else{$resp['ll_data_1'].='/'.date("Y");}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_reverso($texto_card_1_minusculas,'>','/'.(date("Y")+1));if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}else{$resp['ll_data_1'].='/'.(date("Y")+1);}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_1_minusculas,'praça:','','</');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_card_2_minusculas,'praça:','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_2_minusculas,'praça:',' à ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_2_minusculas,'praça:','','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_2_minusculas,'praça:',' à ','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_2_minusculas,'praça:','','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_card_2_minusculas,'praça:','encerramento:','</ul');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}

							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'praça:','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}

							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_trabalho_minusculas,'praça:',' à ','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_trabalho_minusculas,'praça:','','r$');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_trabalho_minusculas,'praça:',' à ','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}
							if ($resp['ll_data_1']==''){$resp['ll_data_1']=isolar_limpo($texto_trabalho_minusculas,'praça:','','confira');if (strlen($resp['ll_data_1'])>75 || str_replace('/','',$resp['ll_data_1'])==$resp['ll_data_1']){$resp['ll_data_1']='';}}

							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_card_2_minusculas,'lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_card_2_minusculas,'>lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_card_2_minusculas,'>lance inicial','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}

							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'>lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'>lance inicial','r$','<'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'> lance inicial','r$','<'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace('r$','',str_replace(',','.',str_replace('.','',isolar_limpo($texto_trabalho_minusculas,'<td itemprop="price">','','</td')))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}
							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',str_replace('r$','',isolar_limpo($texto_trabalho_minusculas,'<td>lance mínimo','<td','</td')))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}

							if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo($texto_card_1_minusculas,'>praça','r$','</'))));if (strlen($resp['ll_lance_min_1'])>15 || round($resp['ll_lance_min_1'],2)==0 ){$resp['ll_lance_min_1']='';}}

							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas,'fa-calendar','fa-calendar','/li'),'</str','','<');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}

							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','r$','§©§'),'praça:',' à ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','r$','§©§'),'praça:','','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','confira','§©§'),'praça:',' à ','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','confira','§©§'),'praça:','','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','fechamento','','§©§'),'fechamento','|','</');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','encerra em','','§©§'),'encerra em',':','</li');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','','§©§'),'praça:','encerramento:','</ul');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','r$','§©§'),'praça:',' a ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','','§©§'),'praça:',' à ',' às ');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça:','','§©§'),'praça:',' a ',' às ');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($texto_card_1_minusculas.'§©§','praça','praça','-');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar(str_replace('vide ','r$',$texto_card_1_minusculas).'§©§','praça -','r$','§©§'),'praça -',' a ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar(str_replace('vide ','r$',$texto_card_1_minusculas).'§©§','praça:','r$','§©§'),'praça:',' a ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar(str_replace('vide ','r$',$texto_card_1_minusculas).'§©§','praça:','r$','§©§'),'praça:','','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}

							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','r$','§©§'),'praça',' à ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','r$','§©§'),'praça','','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','confira','§©§'),'praça',' à ','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','confira','§©§'),'praça','','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($texto_card_1_minusculas,'2ª praça','</','</');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($texto_card_1_minusculas,'2ª praça','</','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($texto_card_1_minusculas,'2ª praça','</','>veja ');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','encerramento:','§©§'),'praça','encerramento:','</ul');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','r$','§©§'),'praça',' a ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','','§©§'),'praça',' à ',' às ');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','praça','','§©§'),'praça',' a ',' às ');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_1_minusculas.'§©§','encerramento:','','§©§'),'encerramento:','</','</');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo($texto_card_1_minusculas,'2ª praça:','','</');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}

							if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(str_replace(' mínimo','',str_replace('ª ','ª',str_replace('?','ª',str_replace('º','ª',$texto_card_2_minusculas)))),'lance 2ªpraça','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
							if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(str_replace('ª ','ª',str_replace('?','ª',str_replace('º','ª',$texto_card_1_minusculas))),'2ªpraça','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
							if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(str_replace('ª ','ª',str_replace('?','ª',str_replace('º','ª',$texto_card_2_minusculas))),'2ªpraça','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
							if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(str_replace('ª ','ª',str_replace('?','ª',str_replace('º','ª',$texto_card_2_minusculas))),'2ªpraça','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
							if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','r$','§©§'),'praça:','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','r$','§©§'),'praça:',' à ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','r$','§©§'),'praça:','','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','confira','§©§'),'praça:',' à ','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','confira','§©§'),'praça:','','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_card_2_minusculas.'§©§','praça:','','§©§'),'praça:','encerramento:','</ul');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}

							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','praça:','r$','§©§'),'praça:',' à ','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','praça:','r$','§©§'),'praça:','','r$');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','praça:','confira','§©§'),'praça:',' à ','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}
							if ($resp['ll_data_2']==''){$resp['ll_data_2']=isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','praça:','confira','§©§'),'praça:','','confira');if (strlen($resp['ll_data_2'])>75 || str_replace('/','',$resp['ll_data_2'])==$resp['ll_data_2']){$resp['ll_data_2']='';}}

							if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','>lance mínimo','r$','§©§'),'>lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
							if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','>lance inicial','r$','§©§'),'>lance inicial','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
							if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_card_2_minusculas.'§©§','>lance mínimo','r$','§©§'),'>lance mínimo','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
							if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_card_2_minusculas.'§©§','>lance inicial','r$','§©§'),'>lance inicial','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}
							if ($resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=sonumeros (str_replace(',','.',str_replace('.','',isolar_limpo(isolar($texto_trabalho_minusculas.'§©§','praça:','r$','§©§'),'praça:','r$','</'))));if (strlen($resp['ll_lance_min_2'])>15 || round($resp['ll_lance_min_2'],2)==0 ){$resp['ll_lance_min_2']='';}}

							if ($resp['ll_data_2']!='' && $resp['ll_lance_min_2']==''){$resp['ll_lance_min_2']=$resp['ll_lance_min_1'];}
							if ($resp['ll_data_2']!='' && $resp['ll_lance_min_2']!='' && $resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=$resp['ll_lance_min_2'];}
							if ($resp['ll_data_2']=='' && $resp['ll_lance_min_2']!=''){$resp['ll_lance_min_2']='';}

							if (str_replace(' à ','',$resp['ll_data_1'])!=$resp['ll_data_1']){$resp['ll_data_1']=isolar($resp['ll_data_1'].'§©§',' à ','','§©§');}
							if (str_replace(' à ','',$resp['ll_data_2'])!=$resp['ll_data_2']){$resp['ll_data_2']=isolar($resp['ll_data_2'].'§©§',' à ','','§©§');}

					//		$data_temp=isolar('§'.$resp['ll_data_1'],'§','',chr(10)); if (strlen($data_temp)>6){$resp['ll_data_1']=$data_temp;}
					//		$data_temp=isolar('§'.$resp['ll_data_2'],'§','',chr(10)); if (strlen($data_temp)>6){$resp['ll_data_2']=$data_temp;}
							$data_temp=explode(chr(10),$resp['ll_data_1']);
							for ($ii=0;$ii<sizeof($data_temp);$ii++){
								$data_temp[$ii]=str_replace('-','/',$data_temp[$ii]);
								if(str_replace('/','',$data_temp[$ii])!=$data_temp[$ii]){$resp['ll_data_1']=$data_temp[$ii];break;}	
							}
							$data_temp=explode(chr(10),$resp['ll_data_2']);
							for ($ii=0;$ii<sizeof($data_temp);$ii++){
								$data_temp[$ii]=str_replace('-','/',$data_temp[$ii]);
								if(str_replace('/','',$data_temp[$ii])!=$data_temp[$ii]){$resp['ll_data_2']=$data_temp[$ii];break;}	
							}

							$resp['ll_data_1']=arrumadata_robos(str_replace('-','/',str_replace(' ','/',str_replace('H','',str_replace(' às ','/',$resp['ll_data_1'])))),6,true);
							$resp['ll_data_2']=arrumadata_robos(str_replace('-','/',str_replace(' ','/',str_replace('H','',str_replace(' às ','/',$resp['ll_data_2'])))),6,true);
							
							if ($resp['ll_data_1']==$resp['ll_data_2']){$resp['ll_lance_min_2']='';$resp['ll_data_2']='';}



							$anexos=isolar($txt_lote,'"imagem":','','"obs"');

							$contapix=0;
							while(  $pix=isolar($anexos,"src='",'',"'") ) {
								$anexos=str_replace("src='".$pix,'', $anexos);
																
								if ($pix!='' && str_replace('sem-foto','',$pix)==$pix && str_replace('logo.','',$pix)==$pix){
									if (substr($pix,0,4)!='http'){$pix=$url.$pix;}
									$contapix+=1;
									if ($contapix<=8){
										$resp['ll_foto_'.$contapix]=$pix;
										echo '
foto: '.$resp['ll_foto_'.$contapix];
									} else {
										$anexos='';
									}
								}
							}
							
							if ($contapix==0){
								$anexos=isolar($txt_lote,'class="fotorama-wrap"','','</div');

								while(  $pix=isolar($anexos,'src="','','"') ) {
									$anexos=str_replace('src="'.$pix,'', $anexos);
																	
									if ($pix!='' && str_replace('sem-foto','',$pix)==$pix && str_replace('logo.','',$pix)==$pix){
										if (substr($pix,0,4)!='http'){$pix=$url.$pix;}
										$contapix+=1;
										if ($contapix<=8){
											$resp['ll_foto_'.$contapix]=$pix;
											echo '
foto: '.$resp['ll_foto_'.$contapix];
										} else {
											$anexos='';
										}
									}
								}
							}
							

 
							$resp['ll_categoria_txt']=isolar_limpo($txt_listagem_leilao,'>Categoria:<','','</sp');
							$resp['ll_categoria_rotulo']=$resp['ll_categoria_txt'];

							if ($resp['ll_categoria_txt']=='' || !isset($resp['ll_categoria_txt'])){
								$vetor_categoria=adivinha_categoria($resp['ll_descricao'].' '.$resp['ll_detalhes']);

								if (sizeof($vetor_categoria)>0){

									$resp['ll_categoria_txt']=$vetor_categoria[0];
									$resp['ll_categoria_rotulo']=$vetor_categoria[0];

									if (sizeof($vetor_categoria)>1){
										$resp['ll_categoria_txt'].=','.$vetor_categoria[1];
										$resp['ll_categoria_rotulo']=$vetor_categoria[1];
									}
								}
							}
		
							if (str_replace('SUCATA','',strtoupper($resp['ll_descricao'].$resp['ll_detalhes']))!=strtoupper($resp['ll_descricao'].$resp['ll_detalhes']) ){
								$resp['ll_categoria_txt'].=',SUCATAS';
								$resp['ll_categoria_rotulo']='SUCATAS';
							}
					
							$localizacao=adivinha_endereco(str_replace('.~','',$resp['ll_detalhes']),$cidade);
							if ($localizacao==''){$localizacao=isolar($resp['ll_detalhes'],'Município:','','/');if ($localizacao!=''){$cidade=$localizacao;}}
echo '
* $localizacao='.$localizacao;
							if ((!$teste && trim($localizacao)!='')){

								if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
									echo '<br><font color="green">* Imóvel</font>';
									$geolocalizacao=geolocalizacao($localizacao,'');
								} else {
									$geolocalizacao=geolocalizacao($localizacao,'','','','',false);
								}
								if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
								if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

								if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
								if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
								if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
								$resp['ll_endereco']=$localizacao;
									
							}
							if ($resp['ll_uf']==''){ 
								$resp['ll_uf']=$uf;
								if ($resp['ll_cidade']==''){ 
									$resp['ll_cidade']=$cidade;
								}
								if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
									echo '<br><font color="green">* Imóvel</font>';
									$geolocalizacao=geolocalizacao($localizacao,'',$resp['ll_cidade'],$resp['ll_uf']);
								} else {
									$geolocalizacao=geolocalizacao($localizacao,'',$resp['ll_cidade'],$resp['ll_uf'],'',false);
								}
								

								if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
								if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

								if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
								if ($geolocalizacao[3]!=''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
								if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}

								$resp['ll_endereco']=$localizacao;
									
							
							}

							if (str_replace('extrajudicia','',$resp['ll_detalhes'])!=$resp['ll_detalhes'] || str_replace('extra judicia','',$resp['ll_detalhes'])!=$resp['ll_detalhes'] || str_replace('extra-judicia','',$resp['ll_detalhes'])!=$resp['ll_detalhes'] ){
								$resp['ll_natureza']='0';
							} else {
								if (str_replace('judicia','',$resp['ll_detalhes'])!=$resp['ll_detalhes'] ){
									$resp['ll_natureza']='1';
								}
							}

							
							if($resp['ll_descricao']!=''){$resposta_robo=true;}

							if ($teste){
								print_r($resp);echo '<br><br>'; if($resposta_robo){return $resposta_robo;}
								//exit;
							} else {
								echo NovoLeilao ($resp,array(),0,0,0,0,false);
								//exit;
								// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){
							}

							//exit;
							// ==================================
//											$conta+=1;
//											if ($conta==1){$tempoinicioastavero=date("YmdHis");}
							// ==================================
							$tempoexecucaomg=diferencasegundos( $tempoinicioastavero ,'');
							if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
								// atingiu tempo limite.
								$atingiutempolimite=true;
								goto fimdolaco;
							}

						} else {
						//$texto='';
						echo '/ ';

						}
					}
					
				}			
			}else{$continua_paginando=false;}
			
			$tempoexecucaomg=diferencasegundos( $tempoinicioastavero ,'');
			if ($tempoexecucaomg>CADASTRO_MAX_SEGUNDOS) {
				// atingiu tempo limite.
				$atingiutempolimite=true;
				goto fimdolaco;
			}									
	
		}
	}
				

	fimdolaco:


	if ($atingiutempolimite==true){
		// não terminou!
		if (!$teste){organizador_tempo_limite_atingido ($idorganizador,$proximo_card[0]);}
	echo '***
	tempo limite
	';
	} else {
		echo '**** Finalizou tudo';
		organizador_finaliza ($idorganizador);
	}
	
	return $resposta_robo;
}






















function trata_url($url,$texto=''){
	global $pdo;

	$queimou_segunda_chance=0;
	reinicia_trata_url:

//echo '[Q'.$queimou_segunda_chance.']';

	$url_original=$url;


	$header="-H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36' ".
		"-H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9' -H 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7,es;q=0.6'";

	// 2020 03
	$header="-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:86.0) Gecko/20100101 Firefox/86.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3' ".//--compressed
	"-H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1'";


	// retorna vetor com url certa e texto
	if ($texto==''){$texto=http_get_curl($url,'firefox',false,false);}

//echo $texto; exit;

	if ($texto==''){
		$resposta=http_post_curl_headers ($url, $header, '', '', true, false, false, '', true, 'GET');
		$url2=isolar_limpo($resposta['headers'],'Location:','',chr(10));
		if(substr($url2,0,4)!='http'){
			if (substr($url,-1)!='/'){$url.='/';}
			$url2=$url.$url2;
		}
		$url=$url2;

		if ($url!=''){
			$texto=http_get_curl($url,'firefox',false,false);

			$texto_maiusculas=capitalizacao_str($texto);
			if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
		}
	}


	if (str_replace('https:','',$url)!=$url && str_replace('<title>Apache HTTP Server Test Page','',$texto)!=$texto) {
		$url=str_replace('https:','http:',$url);
		$texto=http_get_curl($url,'firefox',false,false);
	}
	$texto=str_replace('http-equiv','',$texto);

	// 2021 03 Moved Permanently
	// testa http://www.link
	//		 https://www.link
	//		 http://link
	//		 https://link

	$titulo=capitalizacao_str(isolar($texto,'<title>','','</title>'));
	$url00=$url;
//echo '['.$url.']';
	//if (strlen($texto)<1000 && (str_replace('MOVED PERMANENTLY','',strtoupper($texto))!=strtoupper($texto) || str_replace('CURL ERROR','',strtoupper($texto))!=strtoupper($texto)  || str_replace('SERVER ERROR','',strtoupper($texto))!=strtoupper($texto) || str_replace('UNREACHABLE','',strtoupper($texto))!=strtoupper($texto)  || str_replace('CONNECTION REFUSED','',strtoupper($texto))!=strtoupper($texto)  )  && str_replace('http','',$texto)==$texto) {
	if ( (strlen($texto)<5000 || str_replace('MOVED PERMANENTLY','',$titulo)!=$titulo) && str_replace('http','',$texto)==$texto) {

		// 1.http://www.link
		$url_teste=str_replace('https://','http://',str_replace('://','://www.',str_replace('://www.','://',$url)));
		if ($url!=$url_teste && substr($url_teste,-4)!='.css' && substr($url_teste,-3)!='.js' && substr($url_teste,-4)!='/base' && substr($url_teste,-4)!='.dtd' && str_replace('gmpg.org','',$url_teste)==$url_teste && str_replace('ogp.me','',$url_teste)==$url_teste && str_replace('wordpress.org/extend/plugins/','',$url_teste)==$url_teste 
			&& str_replace('w3.org','',$url_teste)==$url_teste && strlen($url_teste)>10 ){
			$texto=http_get_curl($url_teste,'firefox',false,'utf8');$texto=str_replace('http-equiv','',$texto);
		}
		$titulo=capitalizacao_str(isolar($texto,'<title>','','</title>'));
		//echo '[1'.$titulo.']'.$url_teste.'*';
		//if (strlen($texto)<1000 && (str_replace('MOVED PERMANENTLY','',strtoupper($texto))!=strtoupper($texto) || str_replace('CURL ERROR','',strtoupper($texto))!=strtoupper($texto)  || str_replace('SERVER ERROR','',strtoupper($texto))!=strtoupper($texto) || str_replace('UNREACHABLE','',strtoupper($texto))!=strtoupper($texto)  || str_replace('CONNECTION REFUSED','',strtoupper($texto))!=strtoupper($texto)  ) && str_replace('http','',$texto)==$texto) {
		if ((strlen($texto)<5000 || str_replace('MOVED PERMANENTLY','',$titulo)!=$titulo) && str_replace('http','',$texto)==$texto) {
			// 2.https://www.link
			$url_teste=str_replace('http://','https://',str_replace('://','://www.',str_replace('://www.','://',$url)));
			if ($url!=$url_teste && substr($url_teste,-4)!='.css' && substr($url_teste,-3)!='.js' && substr($url_teste,-4)!='/base' && substr($url_teste,-4)!='.dtd' && str_replace('gmpg.org','',$url_teste)==$url_teste && str_replace('ogp.me','',$url_teste)==$url_teste && str_replace('wordpress.org/extend/plugins/','',$url_teste)==$url_teste 
				&& str_replace('w3.org','',$url_teste)==$url_teste && strlen($url_teste)>10 ){
				$texto=http_get_curl($url_teste,'firefox',false,'utf8');$texto=str_replace('http-equiv','',$texto);
			}
			$titulo=capitalizacao_str(isolar($texto,'<title>','','</title>'));
			//echo '[2'.$titulo.']';
			//if (strlen($texto)<1000 && (str_replace('MOVED PERMANENTLY','',strtoupper($texto))!=strtoupper($texto) || str_replace('CURL ERROR','',strtoupper($texto))!=strtoupper($texto)  || str_replace('SERVER ERROR','',strtoupper($texto))!=strtoupper($texto) || str_replace('UNREACHABLE','',strtoupper($texto))!=strtoupper($texto)  || str_replace('CONNECTION REFUSED','',strtoupper($texto))!=strtoupper($texto)  ) && str_replace('http','',$texto)==$texto) {
			if ((strlen($texto)<5000 || str_replace('MOVED PERMANENTLY','',$titulo)!=$titulo) && str_replace('http','',$texto)==$texto) {
				// 3.http://link
				$url_teste=str_replace('https://','http://',str_replace('://www.','://',$url));
				if ($url!=$url_teste && substr($url_teste,-4)!='.css' && substr($url_teste,-3)!='.js' && substr($url_teste,-4)!='/base' && substr($url_teste,-4)!='.dtd' && str_replace('gmpg.org','',$url_teste)==$url_teste && str_replace('ogp.me','',$url_teste)==$url_teste && str_replace('wordpress.org/extend/plugins/','',$url_teste)==$url_teste 
					&& str_replace('w3.org','',$url_teste)==$url_teste  && strlen($url_teste)>10){
					$texto=http_get_curl($url_teste,'firefox',false,'utf8');$texto=str_replace('http-equiv','',$texto);
				}
				$titulo=capitalizacao_str(isolar($texto,'<title>','','</title>'));
				//echo '['.$titulo.']';
				//if (strlen($texto)<1000 && (str_replace('MOVED PERMANENTLY','',strtoupper($texto))!=strtoupper($texto) || str_replace('CURL ERROR','',strtoupper($texto))!=strtoupper($texto)  || str_replace('SERVER ERROR','',strtoupper($texto))!=strtoupper($texto) || str_replace('UNREACHABLE','',strtoupper($texto))!=strtoupper($texto)  || str_replace('CONNECTION REFUSED','',strtoupper($texto))!=strtoupper($texto)  ) && str_replace('http','',$texto)==$texto) {
				if ((strlen($texto)<5000 || str_replace('MOVED PERMANENTLY','',$titulo)!=$titulo) && str_replace('http','',$texto)==$texto) {
					// 4.https://link
					$url_teste=str_replace('http://','https://',str_replace('://www.','://',$url));
					if ($url!=$url_teste && substr($url_teste,-4)!='.css' && substr($url_teste,-3)!='.js' && substr($url_teste,-4)!='/base' && substr($url_teste,-4)!='.dtd' && str_replace('gmpg.org','',$url_teste)==$url_teste && str_replace('ogp.me','',$url_teste)==$url_teste && str_replace('wordpress.org/extend/plugins/','',$url_teste)==$url_teste  
						&& str_replace('w3.org','',$url_teste)==$url_teste&& strlen($url_teste)>10 ){
						$texto=http_get_curl($url_teste,'firefox',false,'utf8');$texto=str_replace('http-equiv','',$texto);
					}
					//if (strlen($texto)>1000 || !(str_replace('MOVED PERMANENTLY','',strtoupper($texto))!=strtoupper($texto) || str_replace('CURL ERROR','',strtoupper($texto))!=strtoupper($texto)  || str_replace('SERVER ERROR','',strtoupper($texto))!=strtoupper($texto) || str_replace('UNREACHABLE','',strtoupper($texto))!=strtoupper($texto)  || str_replace('CONNECTION REFUSED','',strtoupper($texto))!=strtoupper($texto)  ) || str_replace('http','',$texto)!=$texto) {
					if ((strlen($texto)<5000 || str_replace('MOVED PERMANENTLY','',$titulo)!=$titulo) && str_replace('http','',$texto)!=$texto) {
						$url_teste=isolar(str_replace(';','"',str_replace(' ','"',str_replace('>','"',str_replace("'",'"',$texto)))),'http','','"');
						if ($url!=$url_teste && substr($url_teste,-4)!='.css' && substr($url_teste,-3)!='.js' && substr($url_teste,-4)!='/base' && substr($url_teste,-4)!='.dtd' && str_replace('gmpg.org','',$url_teste)==$url_teste && str_replace('ogp.me','',$url_teste)==$url_teste && str_replace('wordpress.org/extend/plugins/','',$url_teste)==$url_teste   
							&& str_replace('w3.org','',$url_teste)==$url_teste&& strlen($url_teste)>10){
							$url='http'.$url_teste; $texto=http_get_curl($url,'firefox',false,'utf8');$texto=str_replace('http-equiv','',$texto);
						}
					} else {
						$url=$url00;
					}
				} else {
					if ((strlen($texto)<5000 || str_replace('MOVED PERMANENTLY','',$titulo)!=$titulo) && str_replace('http','',$texto)!=$texto) {
						$url_teste=isolar(str_replace(';','"',str_replace(' ','"',str_replace('>','"',str_replace("'",'"',$texto)))),'http','','"');
						if ($url!=$url_teste && substr($url_teste,-4)!='.css' && substr($url_teste,-3)!='.js' && substr($url_teste,-4)!='/base' && substr($url_teste,-4)!='.dtd' && str_replace('gmpg.org','',$url_teste)==$url_teste && str_replace('ogp.me','',$url_teste)==$url_teste && str_replace('wordpress.org/extend/plugins/','',$url_teste)==$url_teste  
							&& str_replace('w3.org','',$url_teste)==$url_teste&& strlen($url_teste)>10 ){
							$url='http'.$url_teste; $texto=http_get_curl($url,'firefox',false,false);$texto=str_replace('http-equiv','',$texto);
						}
					} else {
						$url=$url_teste;
					}
				}
			} else {
				if ((strlen($texto)<5000 || str_replace('MOVED PERMANENTLY','',$titulo)!=$titulo) && str_replace('http','',$texto)!=$texto) {
					$url_teste=isolar(str_replace(';','"',str_replace(' ','"',str_replace('>','"',str_replace("'",'"',$texto)))),'http','','"');
					if ($url!=$url_teste && substr($url_teste,-4)!='.css' && substr($url_teste,-3)!='.js' && substr($url_teste,-4)!='/base' && substr($url_teste,-4)!='.dtd' && str_replace('gmpg.org','',$url_teste)==$url_teste && str_replace('ogp.me','',$url_teste)==$url_teste && str_replace('wordpress.org/extend/plugins/','',$url_teste)==$url_teste   
						&& str_replace('w3.org','',$url_teste)==$url_teste&& strlen($url_teste)>10){$url='http'.$url_teste; $texto=http_get_curl($url,'firefox',false,false);$texto=str_replace('http-equiv','',$texto);}
				} else {
					$url=$url_teste;
				}
			}
		} else {
			if ((strlen($texto)<5000 || str_replace('MOVED PERMANENTLY','',$titulo)!=$titulo) && str_replace('http','',$texto)!=$texto) {
				$url_teste=isolar(str_replace(';','"',str_replace(' ','"',str_replace('>','"',str_replace("'",'"',$texto)))),'http','','"');
				if ($url!=$url_teste && substr($url_teste,-4)!='.css' && substr($url_teste,-3)!='.js' && substr($url_teste,-4)!='/base' && substr($url_teste,-4)!='.dtd' && str_replace('gmpg.org','',$url_teste)==$url_teste && str_replace('ogp.me','',$url_teste)==$url_teste && str_replace('wordpress.org/extend/plugins/','',$url_teste)==$url_teste  
					&& str_replace('w3.org','',$url_teste)==$url_teste&& strlen($url_teste)>10 ){$url='http'.$url_teste; $texto=http_get_curl($url,'firefox',false,false);$texto=str_replace('http-equiv','',$texto);}
			} else {
				$url=$url_teste;
			}
		}
	} else {
		if ((strlen($texto)<5000 || str_replace('MOVED PERMANENTLY','',$titulo)!=$titulo) && str_replace('http','',$texto)!=$texto) {
			$url_teste=isolar(str_replace(';','"',str_replace(' ','"',str_replace('>','"',str_replace("'",'"',$texto)))),'http','','"');
			if ($url!=$url_teste && substr($url_teste,-4)!='.css' && substr($url_teste,-3)!='.js' && substr($url_teste,-4)!='/base' && substr($url_teste,-4)!='.dtd' && str_replace('gmpg.org','',$url_teste)==$url_teste && str_replace('ogp.me','',$url_teste)==$url_teste && str_replace('wordpress.org/extend/plugins/','',$url_teste)==$url_teste   
				&& str_replace('w3.org','',$url_teste)==$url_teste&& strlen($url_teste)>10){$url='http'.$url_teste; $texto=http_get_curl($url,'firefox',false,false);$texto=str_replace('http-equiv','',$texto);}
		}
	}

//echo '[²'.$url.']'; exit;

	if (str_replace('https:','',$url)!=$url && ($texto=='' || str_replace('CURL ERROR','',strtoupper($texto))!=strtoupper($texto)  || str_replace('SERVER ERROR','',strtoupper($texto))!=strtoupper($texto) || str_replace('UNREACHABLE','',strtoupper($texto))!=strtoupper($texto)  ||
		str_replace('CONNECTION REFUSED','',strtoupper($texto))!=strtoupper($texto) || str_replace('<TITLE>NOT FOUND</TITLE>','',strtoupper($texto))!=strtoupper($texto)  ) ) {

		$texto2= http_get_curl(str_replace('https:','http:',$url),'ie',true,false);
		$url2=isolar_limpo($texto2,'Location:','',chr(10));

		if ($url2!=''){
			if(substr($url2,0,4)!='http'){
				if (substr($url,-1)!='/'){$url.='/';}
				$url2=$url.$url2;
			}
			$texto=http_get_curl($url2,'ie',false,false);
			$texto_maiusculas=capitalizacao_str($texto);
			if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';} else {$url=$url2;}
		} else {
			if ($texto2!=''){
				$texto=$texto2;
				$texto_maiusculas=capitalizacao_str($texto);
				if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';} else {$url=str_replace('https:','http:',$url);}
			}
		}
	}

	if (strlen($texto)<100 && str_replace('Redirecting to http','',$texto)!=$texto  ) {

		$url2=trim(isolar(str_replace('"','',$texto).' ','Redirecting to ','',' '));
		if ($url2!=''){
			if(substr($url2,0,4)!='http'){
				if (substr($url,-1)!='/'){$url.='/';}
				$url2=$url.$url2;
			}
			$texto=http_get_curl($url2,'ie',false,false);
			$texto_maiusculas=capitalizacao_str($texto);
			if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';} else {$url=$url2;}
		}
	}

	if (strlen($texto)<5000 && (str_replace('document.location=','',$texto)!=$texto || str_replace('window.location.href','',$texto)!=$texto) ) {

		$url2=trim(isolar($texto.';','document.location=','',';'));
		if ($url2==''){$url2=trim(isolar(str_replace('"','',str_replace(' ','',$texto)).';','window.location.href=','',';'));}

		if ($url2!=''){
			if(substr($url2,0,4)!='http'){
				if (substr($url,-1)!='/'){$url.='/';}
				$url2=$url.$url2;
			}
			$texto=http_get_curl($url2,'ie',false,false);
			$texto_maiusculas=capitalizacao_str($texto);
			if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';} else {$url=$url2;}
		} else {
			if ($texto2!=''){
				$texto=$texto2;
				$texto_maiusculas=capitalizacao_str($texto);
				if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';} else {$url=str_replace('https:','http:',$url);}
			}
		}
	}
	
	$texto_maiusculas=capitalizacao_str($texto);
	if (strlen($texto)<5000 && str_replace('REFRESH','',$texto_maiusculas)!=$texto_maiusculas && str_replace('URL=','',$texto_maiusculas)!=$texto_maiusculas ) {

		$url2=trim(isolar(str_replace('url=','URL=',str_replace('"',';',$texto)).';','URL=','',';'));

		if ($url2!=''){
			if(substr($url2,0,4)!='http'){
				if (substr($url,-1)!='/'){$url.='/';}
				$url2=$url.$url2;
			}
			$texto=http_get_curl($url2,'ie',false,false);
			$texto_maiusculas=capitalizacao_str($texto);
			if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';} else {$url=$url2;}
		} else {
			if ($texto2!=''){
				$texto=$texto2;
				$texto_maiusculas=capitalizacao_str($texto);
				if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';} else {$url=str_replace('https:','http:',$url);}
			}
		}
	}

	$texto_maiusculas=capitalizacao_str($texto);
	if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){
		$texto_maiusculas='';
		$texto='';

		$resposta=http_post_curl_headers ($url, $header, '', '', false, false, false, '', true, 'GET');

		$url2=isolar_limpo($resposta['headers'].chr(10),'Location:','',chr(10));
		if(substr($url2,0,4)!='http'){
			if (substr($url,-1)!='/'){$url.='/';}
			$url2=$url.$url2;
		}
		$url=$url2;

		if ($url!=''){
			$texto=http_get_curl($url,'ie',false,false);

			//2020 03 mudou de novo?
			if ($texto==''){
				$resposta=http_post_curl_headers ($url, $header, '', '', false, false, false, '', true, 'GET');

				$url2=isolar_limpo($resposta['headers'].chr(10),'Location:','',chr(10));
				if(substr($url2,0,4)!='http'){
					if (substr($url,-1)!='/'){$url.='/';}
					$url2=$url.$url2;
				}

				if ($url2!=''){
					$url=$url2;
					$texto=http_get_curl($url,'ie',false,false);
				}
			}
			$texto_maiusculas=capitalizacao_str($texto);

			if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
		}
	}


	// sem www
	if (str_replace('www.','',$url)!=$url && trim($texto_maiusculas)==''){
		$url=str_replace('//www.','//',$url);
		$texto=http_get_curl($url,'firefox',false,false);
		$texto_maiusculas=capitalizacao_str($texto);
		if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){
			$texto_maiusculas='';
			$texto='';

			$resposta=http_post_curl_headers ($url, $header, '', '', true, false, false, '', true, 'GET');
			$url2=isolar_limpo($resposta['headers'],'Location:','',chr(10));
			if(substr($url2,0,4)!='http'){
				if (substr($url,-1)!='/'){$url.='/';}
				$url2=$url.$url2;
			}
			$url=$url2;

			if ($url!=''){
				$texto=http_get_curl($url,'firefox',false,false);

				$texto_maiusculas=capitalizacao_str($texto);
				if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
			}
		}
	}

	// objeto movido?
	$url00=$url;
	for ($i=1;$i<=3;$i++){
		if (str_replace('OBJECT MOVED','',$texto_maiusculas)!=$texto_maiusculas || str_replace('DOCUMENT MOVED','',$texto_maiusculas)!=$texto_maiusculas  ||
			str_replace('MOVED PERMANENTLY','',$texto_maiusculas)!=$texto_maiusculas || str_replace('DOCUMENT HAS MOVED','',$texto_maiusculas)!=$texto_maiusculas ||
			str_replace('OBJETO MOVIDO','',$texto_maiusculas)!=$texto_maiusculas || str_replace('DOCUMENTO MOVIDO','',$texto_maiusculas)!=$texto_maiusculas  ||
			str_replace('DOMAIN NOT FOUND','',$texto_maiusculas)!=$texto_maiusculas || str_replace('DOMÍNIO NÃO ENCONTRADO','',$texto_maiusculas)!=$texto_maiusculas  ||
			str_replace('MOVIDO PERMANENTEMENTE','',$texto_maiusculas)!=$texto_maiusculas || str_replace('DOCUMENTO FOI MOVIDO','',$texto_maiusculas)!=$texto_maiusculas
			){

			$url2=isolar_limpo($texto,'HREF=','"','"');
			if ($url2==''){$url2=isolar_limpo($texto,'href=','"','"');}
			if (substr($url2,0,4)!='http'){
				if (substr($url2,0,1)=='/'){$url2=substr($url2,1-strlen($url2));}
				if (substr($url00,-1)=='/'){
					$url2=$url00.$url2;
				} else {
					$url2=$url00.'/'.$url2;
				}
			}
			if ($url2==''){
				$url2=isolar_limpo(http_get_curl($url,'ie',true,false),'Location:','',chr(10));
				if(substr($url2,0,4)!='http'){
					if (substr($url,-1)!='/'){$url.='/';}
					$url2=$url.$url2;
				}
				$url=$url2;
			} else {
				if(substr($url2,0,4)!='http'){$url.=$url2;}else{$url=$url2;}
				$url=str_replace('http:/','http://',str_replace('https:/','https://',str_replace('//','/',$url)));
			}
			$texto=http_get_curl($url,'firefox',false,false);
			$texto_maiusculas=capitalizacao_str($texto);


			// 2021 03 informação de objeto movido http mas na real é https
			if ($texto==''){
				if(substr($url,0,5)=='https' && substr($url_original,0,5)=='https'){
					$url_teste=str_replace('https://','http://',$url);
				} else {
					$url_teste=str_replace('http://','https://',$url);
				}
				$texto=http_get_curl($url_teste,'ie',false,false);
				if ($texto!=''){$url=$url_teste;}
				$texto_maiusculas=capitalizacao_str($texto);
			}

			if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}

		}
	}

	if (str_replace('<meta http-equiv="refresh"','',$texto)!=$texto){
		$url2=strtolower(isolar_limpo($texto_maiusculas,'URL=','','"'));

		if ($url2==''){
			$url2=isolar_limpo(http_get_curl($url,'ie',true,false),'Location:','',chr(10));
			if(substr($url2,0,4)!='http'){
				if (substr($url,-1)!='/'){$url.='/';}
				$url2=$url.$url2;
			}
			$url=$url2;
		} else {
			if (substr($url,-1)!='/'){$url.='/';}
			if(substr($url2,0,3)=='../'){
				$dir_voltar=isolar_reverso($url,'/','/');
				$url=substr($url,0,-strlen($dir_voltar)-1);
				$url2=substr($url2,3-strlen($url2));
			}

			if(substr($url2,0,4)!='http'){$url.=$url2;}else{$url=$url2;}
			$url=str_replace('http:/','http://',str_replace('https:/','https://',str_replace('//','/',$url)));
		}
		if (substr($url,-1)!='/' && strlen($url)>0){ $url.='/';}
		$texto=http_get_curl($url,'ie',false,false);

		$texto_maiusculas=capitalizacao_str($texto);
		if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
	}

	if (str_replace('<frame name="main" src="principal.asp">','',$texto)!=$texto){
		$url.='/principal.asp';
		$texto=http_get_curl($url,'ie',false,false);
		$texto_maiusculas=capitalizacao_str($texto);
		if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
	} else {
		if (str_replace('<frame name="main" src="','',$texto)!=$texto){
			$url2=isolar_limpo($texto,'<frame name="main" src="','','"');
			if(substr($url2,0,4)!='http'){$url.='/'.$url2;}else{$url=$url2;}
			$url=str_replace('http:/','http://',str_replace('https:/','https://',str_replace('//','/',$url)));
			$texto=http_get_curl($url,'ie',false,false);
			$texto_maiusculas=capitalizacao_str($texto);
			if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
		} else {
			if (str_replace('<frame src="','',$texto)!=$texto){
				$url2=isolar_limpo($texto,'<frame src="','','"');
				if(substr($url2,0,4)!='http'){$url.='/'.$url2;}else{$url=$url2;}
				$url=str_replace('http:/','http://',str_replace('https:/','https://',str_replace('//','/',$url)));
				$texto=http_get_curl($url,'ie',false,false);
				$texto_maiusculas=capitalizacao_str($texto);
				if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
			/*} else {

				if (str_replace('frame src="','',$texto)!=$texto){
					$url2=isolar_reverso($texto,'frame src="','"');
					if (str_replace('facebook','',$url2)==$url2 && str_replace('instagram','',$url2)==$url2 && str_replace('whatsapp','',$url2)==$url2 && str_replace('twitter','',$url2)==$url2 && str_replace('youtube','',$url2)==$url2 && str_replace('radiosnaweb','',$url2)==$url2){
						if(substr($url2,0,4)!='http'){$url.='/'.$url2;}else{$url=$url2;}
						$url=str_replace('http:/','http://',str_replace('https:/','https://',str_replace('//','/',$url)));
						$texto=http_get_curl($url,'ie',false,false);
						$texto_maiusculas=capitalizacao_str($texto);
						if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
					}
				} */
			}
		}
	}


	// contém link do transparênciamg?
	if (str_replace('.asp?pag=70"','',$texto)!=$texto && str_replace('_ano'.date("Y"),'',$url)==$url){
		$url2=isolar_reverso($texto,'"','.asp?pag=70"');
		if (substr($url2,0,4)=='http'){$url=$url2;}else{$url=isolar('§'.$url,'§','','cont_pag').$url2;}
		if ($url!=''){
			if (str_replace('_ano'.date("Y"),'',$url)==$url){$url.='_ano'.date("Y").'.asp?pag=70';}else{$url.='.asp?pag=70';}
			$texto=http_get_curl($url,'ie',false,false);
			$texto_maiusculas=capitalizacao_str($texto);
			if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
		}
	}
	
	if (strlen($texto)<5000 && str_replace('location.href=','',$texto)!=$texto ) {

		$url2=trim(isolar($texto.';','location.href=','',';'));
		if ($url2!=''){
			if(substr($url2,0,4)!='http'){
				if (substr($url,-1)!='/'){$url.='/';}
				$url2=$url.$url2;
			}
			$texto=http_get_curl($url2,'ie',false,false);
			$texto_maiusculas=capitalizacao_str($texto);
			if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';} else {$url=$url2;}
		} 
	}

	$texto=trim(str_replace(chr(150),'-',str_replace(chr(156),'',$texto)));

	// 2020 03
	if ($texto=='' && $queimou_segunda_chance<3){$queimou_segunda_chance+=1; goto reinicia_trata_url;}


	$resposta=array();
	$resposta['url']=$url;
	$resposta['texto']=$texto;
	return $resposta;


}



function adivinha_endereco($texto,$cidade){
	
	$texto=capitalizacao_str($texto,false);
	$cidade=trim(capitalizacao_str($cidade,false));
	
	$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',
	str_replace(' r. ',' rua ',str_replace(' avenida ',' rua ',str_replace(' av. ',' rua ',strtolower($texto)))))))),'situado',' rua ','capital')))));
	if ($localizacao!=''){$localizacao.=' capital';}
	if (trim($localizacao)==''){

		$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',
		str_replace(' r. ',' rua ',str_replace(' avenida ',' rua ',str_replace(' av. ',' rua ',strtolower($texto)))))))),'situado',' rua ',$cidade)))));
		if ($localizacao!=''){$localizacao.=' '.$cidade;}
		if (trim($localizacao)==''){
			$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',str_replace(',','/',str_replace('-','/',str_replace('.','/',
			str_replace(' r. ',' rua ',str_replace(' avenida ',' rua ',str_replace(' av. ',' rua ',strtolower($texto))))))))))),'situado',' rua ','/')))));
			if (trim($localizacao)==''){
				$localizacao0=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',
				str_replace(' r. ',' rua ',str_replace(' avenida ',' rua ',str_replace(' av. ',' rua ',strtolower($texto)))))))).'§©§','situado',' rua ','§©§')))));
			}
		}
	}
	
	$localizacao=trim($localizacao);
	
	if ($localizacao==''){
		$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',strtolower($texto))))),'situado','','capital')))));
		if ($localizacao!=''){$localizacao.=' capital';}
		if (trim($localizacao)==''){

			$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',strtolower($texto))))),'situado','',$cidade)))));
			if ($localizacao!=''){$localizacao.=' '.$cidade;}
			if (trim($localizacao)==''){
				$localizacao=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',str_replace(',','/',str_replace('-','/',str_replace('.','/',$texto))))))),'situado','','/')))));
				if (trim($localizacao)==''){
					$localizacao0=trim(str_replace(' à ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$texto)))).'§©§','situado','','§©§')))));
					if (trim($localizacao0)==''){
						$localizacao=isolar('§'.$localizacao,'§','',',').', '.isolar($localizacao,',','',',').', '.isolar($localizacao,',',',',',').'/';
					}
				}
			}
		}
		
		$localizacao=trim($localizacao);
	}


	
	
	if ($localizacao==$cidade || $localizacao=='capital'){return false;}
	
	return trim(str_replace(', , /','',$localizacao));

}


?>
