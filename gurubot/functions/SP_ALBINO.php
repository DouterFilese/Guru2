<?php
/*
G U R U B O T
Módulo Leilões SP_ALBINO
(c) 2019 10 Marcelon
*/


set_time_limit (600);
$atingiutempolimite=false;
$tempoinicio_SP_ALBINO=date("YmdHis");
$r['extra']=organizador_inicia (SITE_SP_ALBINO);
$lotescadastrados=0;

$proximo_card=explode('/',$r['extra'].'///');

$conta=0;
$conta_cards=0;
$conta_listagens=0;
$conta_cards_internos=0;


$proximo_card[1]=max((int)$proximo_card[1],1); // página
$proximo_card[2]=max((int)$proximo_card[2],1); // listagem

$texto_original= isolar(http_get_curl('https://www.leiloesalbino.com.br/Leiloes/Agenda','ie',false,true),'</tr','','</table');

//echo '***'.$texto_original; exit;

while(  $texto_busca=isolar($texto_original,'<tr','','</tr') ) { // listagem (?) ============
	$texto_original=str_replace('<tr'.$texto_busca,'', $texto_original);

	$listagem_link=trim(isolar($texto_busca,'href="','','"'));
	$ll_agregador=isolar($texto_busca,'</td','</td','<a');
	$ll_agregador=isolar_limpo($ll_agregador,'</td','','</td');

	if (arrumadata_robos(str_replace(' ','/',str_replace('H','',str_replace(' às ','/',isolar_limpo($texto_busca,'<td','','</td')))))>date("YmdHi")){

		echo '<br><strong>Página '.$ll_agregador.'</strong>: ';

		$conta_listagens+=1;

		if ($conta_listagens>=$proximo_card[2] && $listagem_link!=''){


			while ($proximo_card[1]>0){ // paginação =====================

				echo '<br><i>Página '.$proximo_card[1].'</i>: ';

				$texto_com_cards= http_get_curl('https://www.leiloesalbino.com.br'.$listagem_link.'&pg='.$proximo_card[1],'ie',false,true);
				$ll_data_1=arrumadata_robos(str_replace(' ','/',str_replace('H','',str_replace(' às ','/',isolar_limpo(str_replace('(','</td>',$texto_com_cards),'<th>Data:</th>','','</td')))),6,true); 

//echo $texto_com_cards; exit;
				while(  $texto_lote=isolar($texto_com_cards,'<h4>','','<hr') ) {
					$texto_com_cards=str_replace('<h4>'.$texto_lote,'', $texto_com_cards);

					$ll_link=trim(isolar($texto_lote,'href="','','"'));

					$conta_cards+=1;

					if ($ll_link!=''){

						$resp=array();
						$resp['organizador']=SITE_SP_ALBINO;
						$resp['ll_pais']='BRASIL';
						$resp['ll_idioma']='pt-BR';
						$resp['ll_moeda']='BRL';
						$resp['ll_link']='https://www.leiloesalbino.com.br'.$ll_link;
						$resp['ll_agregador']=$ll_agregador;
						$resp['ll_agregador_link']='https://www.leiloesalbino.com.br'.$listagem_link;
						$resp['ll_lote']=trim(limpaespacos(str_replace('LOTE','',strtoupper(isolar_limpo('§'.str_replace('Nº','',str_replace('N°','',$texto_lote)),'§','','<')))));
						$resp['ll_descricao']=isolar_limpo($texto_lote,'<h5','','</h');
						$resp['ll_detalhes']=limpacaracteresfantasma(str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',isolar_limpo(str_replace('<br>','.~ ',$texto_lote),'</h5','','</div')))))))));
						$resp['ll_data_1']=$ll_data_1;
						$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($texto_lote,'Lance inicial:','R$','</')));

						cadastra_SITE_SP_ALBINO ($resp);

						// ==================================
						$conta+=1;
								//if ($conta>5){exit;}
						// ==================================
						$tempoexecucao_SP_ALBINO=diferencasegundos( $tempoinicio_SP_ALBINO ,'');

						if ($tempoexecucao_SP_ALBINO>10) {
							// atingiu tempo limite.
							$atingiutempolimite=true;
							goto fimdolaco;
						}		
					}
				}
		
				$conta_cards=0;
				if (str_replace('&pg='.($proximo_card[1]+1).'"','',$texto_com_cards)!=$texto_com_cards){
					$proximo_card[1]+=1;
				} else {
					$proximo_card[1]=0;$proximo_card[2]+=1;
				}
			
			}
			$proximo_card[1]=1;
		}
	}
}

$proximo_card[2]=0;

fimdolaco:


 if ($atingiutempolimite==true){
	 não terminou!
    organizador_tempo_limite_atingido (SITE_SP_ALBINO,$conta_cards."/".$proximo_card[1]."/".$proximo_card[2]);
echo '***
tempo limite
'; 
} else {
	echo '**** Finalizou tudo';
    organizador_finaliza (SITE_SP_ALBINO);
}

function cadastra_SITE_SP_ALBINO ($resp){
//print_r($resp); //exit;
	if (!VerificaCadastroLeilao($resp)){ 

		$texto_lote=http_get_curl($resp['ll_link'],'ie');
		$texto_lote=char_convert(str_replace('&sup2;', '²', str_replace('&rdquo;', '', str_replace('&ldquo;', '', $texto_lote))));

		$vetor_categoria=adivinha_categoria($resp['ll_agregador'].' '.$resp['ll_descricao'].' '.$resp['ll_detalhes']);

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


		$resp['ll_endereco']=isolar_limpo($texto_lote,'<th>Local:</th>','','</tr');

	
		if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
			echo '<br><font color="green">* Imóvel</font>';
			$geolocalizacao=geolocalizacao($resp['ll_endereco']);
		} else {
			$geolocalizacao=geolocalizacao($resp['ll_endereco'],'',$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais'],false);
		}

		if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
		if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}
		if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
		if ($geolocalizacao[3]!=''){$resp['ll_cidade']=$geolocalizacao[3];}
		if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}


		$contapix=0;
		$pix0=$texto_lote;
		while(  $pix=isolar($pix0,'<img class="card img-fluid"','','</div') ) {
			$pix0=str_replace('<img class="card img-fluid"'.$pix,'', $pix0);

			$pix=isolar($pix,'src="','','"');

			if (str_replace('img-lote-default.png','',$pix)==$pix){
				$contapix+=1;
				if ($contapix<=8){

echo '<br>Foto original: '.$pix;
					$resp['ll_foto_'.$contapix]='https://www.leiloesalbino.com.br'.$pix;
				} else {
					$pix0='';
				}
			}
		}


		//print_r($resp);echo '<br><br>'; exit;
		echo NovoLeilao ($resp,array(),0,0,0,0,false);
		//exit;
		// NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){


		//exit;

//$tempoexecucao_SP_ALBINO=99999;



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
