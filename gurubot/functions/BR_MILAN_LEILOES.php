<?php
/*
G U R U B O T
MÛdulo Leilıes BR_MILAN_LEILOES
(c) 2017 10 Marcelon
*/

set_time_limit (600);
$atingiutempolimite=false;
$tempoiniciomg=date("YmdHis");
$r['extra']=organizador_inicia (SITE_BR_MILAN_LEILOES);

$lotescadastrados=0;

$proxima_categoria=explode('/',$r['extra'].'/////');

$conta=0;
$contacategorias=0;

$texto000= http_get_curl('https://www.milanleiloes.com.br/Leiloes/Agenda.asp','ie',true,false);
$texto00=isolar(str_replace('∞','∫',limpacaracteresisolatin1($texto000)),'TODOS</a>','','</ul');

// mapeia categorias principais
while(  $categoria0=isolar($texto00,'<a','','</a') ) {
	$texto00=str_replace('<a'.$categoria0,'', $texto00);

	$ll_categoria=trim(limpahtml($categoria0));
	if ($ll_categoria=='MATERIAIS/SUCATAS'){$ll_categoria='MATERIAIS';}
	$link=isolar($categoria0,'href="','','"');

	$contacategorias+=1;
	if ($link!='' && $contacategorias>=$proxima_categoria[0]){
		echo '
<br><strong>Categoria: <font color="red">'.$ll_categoria.'</font></strong>: ';
		
		$txtcat=limpacaracteresisolatin1(http_get_curl('https://www.milanleiloes.com.br'.$link,'ie',false,false,'','','',true,false));
		//function http_get_curl($url,$agente='',$obtemcookies=false,$limpa=true,$cookie='',$porta='',$versaossl='',$ssl_ignora=true,$tiraaspas=true,$header000='',$timeout = 5, $zipado=false) {

//echo $txtcat; exit;		
//		$texto=str_replace('<div id="footer-container"','<div class="caixa-1de4 ',str_replace('<div class="caixa-1de4">','',str_replace('∞','∫',$txtcat)));
		$texto=str_replace('footer-container','><div class="caixa-1de4 ',str_replace('<div class="caixa-1de4">','',str_replace('∞','∫',$txtcat)));

//echo '===='.$texto; exit;				
		while(  $lote=isolar($texto,'<div class="caixa-1de4','','<div class="caixa-1de4') ) {
			$texto=str_replace('<div class="caixa-1de4'.$lote,'', $texto);

			$resp0=array();
			$resp0['organizador']=SITE_BR_MILAN_LEILOES;
			$resp0['ll_pais']='BRASIL';
			$resp0['ll_idioma']='pt-BR';
			$resp0['ll_moeda']='BRL';
			$resp0['ll_bairro']='';
			$numero_leilao=isolar($lote,'"AbrirPagLeilao(','',',');

			$tipo_pagina=isolar($lote,'"AbrirPagLeilao(',", '","'");
			$catalogoaut='';
			if ($tipo_pagina=='catalogo'){
				$resp0['ll_link']='https://www.milanleiloes.com.br/Leiloes/Catalogo.asp?IdLeilao='.$numero_leilao;
			} else {
				if ($tipo_pagina=='catalogo-aut'){
					$resp0['ll_link']='https://www.milanleiloes.com.br/Leiloes/CatalogoAut.asp?IdLeilao='.$numero_leilao;
					$catalogoaut='Aut';
				} else {
					if ($tipo_pagina=='agenda'){
						$resp0['ll_link']='https://www.milanleiloes.com.br/Leiloes/CatalogoAut.asp?IdLeilao='.$numero_leilao;
					} else {
						$resp0['ll_link']='https://www.milanleiloes.com.br/Editais/'.isolar($lote,'"AbrirPagLeilao(',"', '","[").$numero_leilao;
					}
				}
			}
			$comitente=strtoupper(trim(str_replace('logo','',isolar($lote,'images/logosLeilao/','','.'))));
			$agregador=isolar_limpo(str_replace('/','',$lote),'class="descricaoLeilao"','','<div');

			if (str_replace('LEILAO JUDICIAL','',strtoupper(strtr($agregador, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC")))!=strtoupper(strtr($agregador, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"))){
				$resp0['ll_natureza']='1';
			}

/*print_r($resp0);*/
echo '====
$tipo_pagina='.$tipo_pagina.'
';//.$lote; //exit;	*/			
			
			// verifica se È listagem ou lote ˙nico
			if ($tipo_pagina=='catalogo' || $tipo_pagina=='catalogo-aut'){
				// listagem de lotes
				$resp0['ll_agregador_link']=$resp0['ll_link'];
				$resp0['ll_comitente']=$comitente;
				if ($resp0['ll_comitente']==''){$resp0['ll_comitente']=isolar_limpo($lote,'<div class="descricaoLeilao">','','</div');}
				$resp0['ll_data_1']=arrumadata_robos(str_replace(' - ','/',str_replace('h','/',isolar_limpo($lote,'<div class="dataLeilao">','','</span').'/'.isolar_limpo($lote,'<div class="dataLeilao">',', ','</'))));
	
				$texto_leilao_00=str_replace('∞','∫',limpacaracteresisolatin1(http_get_curl('https://www.milanleiloes.com.br/Leiloes/Catalogo'.$catalogoaut.'.asp?IdLeilao='.$numero_leilao,'ie',false,false,'','','',true,false)));
				$local_00=str_replace('Leil„o On-line','',isolar_limpo($texto_leilao_00,'>Local',':','</p'));

				$texto_leilao=str_replace('∞','∫',limpacaracteresisolatin1(http_get_curl('https://www.milanleiloes.com.br/Leiloes/Ajax/CatalogoLotes.asp?IdLeilao='.$numero_leilao.'&PagAtual=1&LoteFrom=000&LoteTo=999','ie',false,false,'','','',true,false)));
/*
echo '
--
'.'https://www.milanleiloes.com.br/Leiloes/Ajax/CatalogoLotes.asp?IdLeilao='.$numero_leilao.'&PagAtual=1&LoteFrom=000&LoteTo=999
'.$texto_leilao;
*/
				$texto_lotes=str_replace('∞','∫',limpacaracteresutf8_novo(limpacaracteresisolatin1(limpaunicode(http_get_curl('https://www.milanleiloes.com.br/Leiloes/Ajax/loadLotes.asp?idLeilao='.$numero_leilao,'ie',false,false,'','','',true,false)))));
/*echo '




xxxxxxxxxxxxxxxxxx


--
'.'https://www.milanleiloes.com.br/Leiloes/Ajax/loadLotes.asp?idLeilao='.$numero_leilao.'
'.$texto_lotes; exit;
*/


				while(  $lote=isolar($texto_leilao,'<li class="catalogo-listagem-item"','','</li') ) {
					$texto_leilao=isolar($texto_leilao.'ß©ßßßß','<li class="catalogo-listagem-item"'.$lote,'','ß©ßßßß'); 


					$resp=$resp0;
					$resp['ll_lote']=isolar($lote,'href="javascript:Abrir',", '","'");
					if (!VerificaCadastroLeilao($resp)){ 
						$lotescadastrados+=1;

						$resp['ll_agregador']=$agregador;//isolar_limpo($lote,'<div class="descricaoLeilao">','','</div');//$resp['ll_comitente'];

						$lance_aproximado=false;
						$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($lote,'LANCE INICIAL: <span>','R$','</')));
						if ($resp['ll_lance_min_1']==''){$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($lote,'class="loteMinimo">','R$','</')));}
						if ($resp['ll_lance_min_1']==''){
							$lance_aproximado=true;
							$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($lote,'loteLances-valor','R$','</div')));
						}
						if ($resp['ll_lance_min_1']==''){
							$lance_aproximado=true;
							$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($lote,'R$','','</div')));
						}
						$resp['ll_lance_min_1']=trim(str_replace('-','',$resp['ll_lance_min_1']));
						$texto_lote=str_replace(chr(150),'-',str_replace('\\','',char_convert(str_replace('∞','∫',limpacaracteresisolatin1(http_get_curl('https://www.milanleiloes.com.br/Leiloes/Lances/ajax/dadosLote.asp?CL='.$numero_leilao.'&Lote='.$resp['ll_lote'],'ie',false,false,'','','',true,false))))));

						$resp['ll_descricao']=espacapontuacao(isolar_limpo($texto_lote,'"titulo":"','','"'));

						$resp['ll_detalhes']=str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('Veja aqui a matricula','',str_replace('Veja a matricula','',isolar_limpo(str_replace('<br>','.~ ',str_replace('<br >','.~ ',str_replace('<br />','.~ ',str_replace('->','',$texto_lote)))),'"descricao":"','','","'))))))))));
						if ($lance_aproximado==true){$resp['ll_detalhes'].='~OBS: Valores de praÁa aproximados.';}
						
						if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao'])){
							$resp['ll_categoria_rotulo']='SUCATA';
							$resp['ll_categoria_txt']='SUCATA';
							$resp['ll_categoria_principal']=='3';
						} else {
							if ($ll_categoria!='VEÕCULOS E MOTOS'){
								$resp['ll_categoria_rotulo']=$ll_categoria;
								$resp['ll_categoria_txt']=$ll_categoria;//.','.isolar_limpo($lote,'</div','','</div');;
							} else {
								$categorizacao_automatica=categorizacao_automatica($resp['ll_descricao']);
								$resp['ll_categoria_rotulo']=$categorizacao_automatica['ll_categoria_txt'];
								$resp['ll_categoria_txt']=$categorizacao_automatica['ll_categoria_txt'];
								$resp['ll_categoria_principal']=$categorizacao_automatica['categoria_principal'];
								if ($resp['ll_categoria_principal']=='0'){
									if (str_replace('IPVA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes'])){$resp['ll_categoria_principal']='2';}

								}
							}
						}



						$local=isolar_limpo(str_replace('VIST. E RET.','',$texto_lote),'LOCAL:','','<br');
						if ($local==''){$local=isolar_limpo($texto_lote,'VIST. E RET. EM','','-');}
						if ($local==''){$local=isolar_limpo($texto_lote,'VIST. E RET. ','','-');}
						if ($local==''){$local=isolar_limpo($texto_lote,'VIST.E RET. EM','','-');}
						if ($local==''){$local=isolar_limpo($texto_lote,'VIST.E RET.','','-');}
						if ($local==''){$local=isolar_limpo($texto_lote,'VIST. RET.','','-');}
						if ($local==''){$local=isolar_limpo($texto_lote,'(VIS.RET.','',')');}
						if ($local==''){$local=isolar_limpo($texto_lote,'VIS.RET.','','-');}
						if ($local==''){$local=isolar_limpo($texto_lote,'RET.','','-');}
						if ($local==''){$local=$local_00;echo '<br>Usando $local_00='.$local_00;}
						if ($local!=''){
							$local=isolar('ß'.$local.'c/Sr','ß','','c/Sr');
							$local=isolar('ß'.$local.'C/Sr','ß','','C/Sr');
							$local=isolar('ß'.$local.'C/SR','ß','','C/SR');
							$local=isolar('ß'.$local.'c/ Sr','ß','','c/ Sr');
							$local=isolar('ß'.$local.'C/ Sr','ß','','C/ Sr');
							$local=isolar('ß'.$local.'C/ SR','ß','','C/ SR');
							$local=str_replace('Visit. e Ret.', '', $local);
							$local=str_replace('VIST. E RET. EM', '', $local);
							$local=str_replace('VIST. E RET.', '', $local);
							$local=str_replace('VIST.E RET. EM', '', $local);
							$local=str_replace('VIST.E RET. ', '', $local);
							$local=str_replace('VIST.E RET.', '', $local);
							$local=str_replace('VIST.E RET.', '', $local);
							$local=str_replace('VISIT. E RET. EM', '', $local);
							$local=str_replace('VISIT. E RET.', '', $local);
							$local=str_replace('LOCAL VISITA E RETIRADA:', '', $local);
							$local=str_replace('VIS.RET.', '', $local);
							$local=str_replace('RET.', '', $local);
							$local=str_replace('(', '', $local);
							$local=str_replace(')', '', $local);
							$local=str_replace('Centro ', 'Centro - ', $local);
							$local=trim($local);
							if (!preg_match('/^[a-zA-Z0-9¿-ˇ ]+$/', substr($local,-1))){$local=trim(substr($local,0,strlen($local)-1));}
							if (!preg_match('/^[a-zA-Z0-9¿-ˇ ]+$/', substr($local,-1))){$local=trim(substr($local,0,strlen($local)-1));}
						}

						if (trim($resp['ll_cidade'])==''){$resp['ll_cidade']=trim(isolar_reverso($local,' - ','/'));}
						if (trim($resp['ll_cidade'])==''){$resp['ll_cidade']=trim(isolar_reverso(','.$local,',','/'));}

						if (trim($resp['ll_cidade'])=='' && str_replace('PREFEITURA DE ','',strtoupper($resp['ll_comitente']))!=strtoupper($resp['ll_comitente'])) {$resp['ll_cidade']=isolar_limpo(strtoupper($resp['ll_comitente']),'PREFEITURA DE ','','/');$resp['ll_uf']=isolar_limpo(strtoupper($resp['ll_comitente']).'ß©ß','PREFEITURA DE ','/','ß©ß');}
						if (trim($resp['ll_cidade'])=='' && str_replace('PREFEITURA MUNICIPAL DE ','',strtoupper($resp['ll_comitente']))!=strtoupper($resp['ll_comitente'])) {$resp['ll_cidade']=isolar_limpo(strtoupper($resp['ll_comitente']),'PREFEITURA MUNICIPAL DE ','','/');$resp['ll_uf']=isolar_limpo(strtoupper($resp['ll_comitente']).'ß©ß','PREFEITURA MUNICIPAL DE ','/','ß©ß');}
						if (trim($resp['ll_cidade'])=='' && str_replace('MUNICÕPIO ','',strtoupper($resp['ll_comitente']))!=strtoupper($resp['ll_comitente'])) {$resp['ll_cidade']=isolar_limpo(strtoupper($resp['ll_comitente']),'MUNICÕPIO ','','/');$resp['ll_uf']=isolar_limpo(strtoupper($resp['ll_comitente']).'ß©ß','MUNICÕPIO ','/','ß©ß');}


						//if ($resp['ll_uf']==''){$resp['ll_uf']=trim(str_replace('.','',str_replace(' ','',isolar_reverso($local.'<','/','<'))));}
						if ($resp['ll_uf']==''){$resp['ll_uf']=substr(trim(str_replace('.','',str_replace(' ','',isolar_reverso($local.'<','/','<')))),0,2);}

						if (trim($resp['ll_cidade'])==''){$resp['ll_cidade']=trim(isolar_reverso($local,' - ',' - '));}
						if ($resp['ll_uf']==''){$resp['ll_uf']=substr(trim(str_replace('.','',str_replace(' ','',isolar_reverso($local.'<','-','<')))),0,2);}

						$resp['ll_endereco']='';

						if (trim($resp['ll_endereco'])==''){$resp['ll_endereco']=trim(isolar_reverso('ß'.$local,'ß',' - '));}
						if (trim($resp['ll_endereco'])==''){$resp['ll_endereco']=trim(isolar_reverso('ß'.$local,'ß',','));}
						if (trim($resp['ll_endereco'])==''){$resp['ll_endereco']=$local;}

						if (strlen(trim($resp['ll_cidade']))<3){$resp['ll_cidade']='';}
						if ($resp['ll_uf']!=''){
                            // $statement = $pdo->query("SELECT * FROM geolocalizacao WHERE geo_uf='".$resp['ll_uf']."' AND cod_IBGE>0 LIMIT 1");
                            // if (!$statement->fetch(PDO::FETCH_ASSOC) ) {$resp['ll_uf']='';$resp['ll_cidade']='';}
						}

						if ($resp['ll_uf']==''){$resp['ll_cidade']='';}
						if ($resp['ll_cidade']==''){$resp['ll_uf']='';}

						$basefotos='https:'.isolar($lote,'<img src="','','"');
						if ($basefotos!='https:'){
							$basefotos=str_replace(isolar_reverso($basefotos.'ß©ß','/','ß©ß'),'',$basefotos).'/';

							$pix0=','.isolar($texto_lote,',"fotos":[','',']');
							$contapix=0;
							while(  $pix=isolar($pix0,',"','','"') ) {
								$pix0=str_replace(',"'.$pix,'', $pix0);
								$contapix+=1;
								if ($contapix<=8){
									$resp['ll_foto_'.$contapix]=$basefotos.$pix;
								} else {
									$pix0='';
								}
							}
						}

						$resp['ll_marca']=isolar_limpo($texto_lote,'FABRICANTE:','','<');
						if ($resp['ll_marca']==''){$resp['ll_marca']=isolar_limpo($texto_lote,'MARCA:','','<');}
						$resp['ll_modelo']=isolar_limpo($texto_lote,'MODELO:','','<');
						if ($resp['ll_modelo']==''){$resp['ll_modelo']=isolar_limpo($texto_lote,'TIPO:','','<');}
						$resp['ll_ano_modelo']=isolar_limpo($texto_lote,'ANO:','','<');
						$resp['ll_ocupacao']=isolar_limpo($texto_lote,'OCUPA«√O:','','<');
						$resp['ll_placa']=isolar_limpo($texto_lote,'PLACA:','','<');
						$resp['ll_quilometragem']=isolar_limpo($texto_lote,'KM:','','<');
						$resp['ll_cor']=isolar_limpo($texto_lote,'COR:','','<');
						$resp['ll_combustivel']=isolar_limpo($texto_lote,'COMBUSTÕVEL:','','<');
						$resp['ll_capacidade']=isolar_limpo($texto_lote,'CAPACIDADE:','','<');
						$resp['ll_sn']=isolar_limpo($texto_lote,'S…RIE:','','<');


						$descricao=strtoupper(strtr($resp['ll_descricao'], "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"));
						if ( (str_replace('APTO','',$descricao)!=$descricao || str_replace('APARTAMENTO','',$descricao)!=$descricao) && str_replace('CASA','',$descricao)==$descricao && str_replace('TERRENO','',$descricao)==$descricao && str_replace('COMERCIAL','',$descricao)==$descricao ){$resp['ll_categoria_rotulo']='APARTAMENTO';}
						if (str_replace('APTO','',$descricao)==$descricao && str_replace('APARTAMENTO','',$descricao)==$descricao && str_replace('CASA','',$descricao)!=$descricao && str_replace('TERRENO','',$descricao)==$descricao && str_replace('COMERCIAL','',$descricao)==$descricao ){$resp['ll_categoria_rotulo']='CASA';}
						if (str_replace('APTO','',$descricao)==$descricao && str_replace('APARTAMENTO','',$descricao)==$descricao && str_replace('CASA','',$descricao)==$descricao && str_replace('TERRENO','',$descricao)!=$descricao && str_replace('COMERCIAL','',$descricao)==$descricao ){$resp['ll_categoria_rotulo']='TERRENO';}
						if (str_replace('APTO','',$descricao)==$descricao && str_replace('APARTAMENTO','',$descricao)==$descricao && str_replace('CASA','',$descricao)==$descricao && str_replace('TERRENO','',$descricao)==$descricao && str_replace('COMERCIAL','',$descricao)!=$descricao ){$resp['ll_categoria_rotulo']='COMERCIAL';}
						if (str_replace('APTO','',$descricao)==$descricao && str_replace('APARTAMENTO','',$descricao)==$descricao && str_replace('CASA','',$descricao)==$descricao && str_replace('TERRENO','',$descricao)==$descricao && str_replace('SALA COMERCIAL','',$descricao)!=$descricao ){$resp['ll_categoria_rotulo']='SALA COMERCIAL';}


						$detalhes=strtoupper(strtr($resp['ll_detalhes'], "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"));
						if ($resp['ll_bairro']!='' && $detalhes!='' && $resp['ll_endereco']==''){
							$resp['ll_endereco']=descobre_endereco(' SITO A '.isolar($detalhes.'ß©ß',strtoupper(strtr($resp['ll_bairro'], "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC")),'','ß©ß'));
						}
						if (!$resp['ll_endereco'] || $resp['ll_endereco']==''){
							$resp['ll_endereco']=descobre_endereco($detalhes);
						}


						if ($resp['ll_cidade']=='' && $resp['ll_uf']=='' && $resp['ll_endereco']!=''){
							$sqlqry="SELECT * FROM db_leilao WHERE ll_endereco='".$resp['ll_endereco']."' AND ll_latitude!='' AND ll_longitude!='' ORDER BY ll_cidade DESC LIMIT 1";
                            $statement = $pdo->query($sqlqry);
							if ($r = $statement->fetch(PDO::FETCH_ASSOC)){
								$resp['ll_latitude']= trim($r['ll_latitude']);
								$resp['ll_longitude']= trim($r['ll_longitude']);
								$resp['ll_cidade']=$r['ll_cidade'];
								$resp['ll_uf']=$r['ll_uf'];
							}
						} 


						if ($ll_categoria=='IM”VEIS' && $resp['ll_cidade']=='' && $resp['ll_uf']=='' ){
							$resp['ll_cidade']=trim(isolar('ß'.$resp['ll_descricao'],'ß','','-'));
							$resp['ll_uf']=substr(trim(isolar($resp['ll_descricao'].'-',$resp['ll_cidade'],'-','-')),0,2);

                            $statement = $pdo->query("SELECT * FROM geolocalizacao WHERE geo_uf='".$resp['ll_uf']."' AND cod_IBGE>0 LIMIT 1");
                            if (!$statement->fetch(PDO::FETCH_ASSOC) ) {
								$resp['ll_uf']='';$resp['ll_cidade']='';
							}

						}


						if (str_replace('Rod. Raposo Tavares, KM 20','',$resp['ll_endereco'])!=$resp['ll_endereco']){
							$resp['ll_latitude']= '-23.5919807';
							$resp['ll_longitude']= '-46.8040883';
							$resp['ll_cidade']='S„o Paulo';
							$resp['ll_uf']='SP';
							$resp['ll_bairro']='Jardim Boa Vista';
						} else {
							if (str_replace('733','',$resp['ll_endereco'])!=$resp['ll_endereco'] || str_replace('Quat·','',$resp['ll_endereco'])!=$resp['ll_endereco']){
								$resp['ll_latitude']= '-23.5329';
								$resp['ll_longitude']= '-46.6395';
								$resp['ll_cidade']='S„o Paulo';
								$resp['ll_uf']='SP';
								$resp['ll_bairro']='Vila OlÌmpia';
							} else {
								if (str_replace('707','',$resp['ll_endereco'])!=$resp['ll_endereco'] || str_replace('Emb˙','',$resp['ll_endereco'])!=$resp['ll_endereco']){
									$resp['ll_latitude']= '-23.6030756';
									$resp['ll_longitude']= '-46.8553674';
									$resp['ll_cidade']='Cotia';
									$resp['ll_uf']='SP';
									$resp['ll_bairro']='Jardim Torino';
								} else {
									if ($resp['ll_cidade']=='' && $resp['ll_uf']=='' && $resp['ll_endereco']!=''){
										$sqlqry="SELECT * FROM db_leilao WHERE ll_endereco='".$resp['ll_endereco']."' AND ll_latitude!='' AND ll_longitude!='' ORDER BY ll_cidade DESC LIMIT 1";
                                        $statement = $pdo->query($sqlqry);
										if ($r = $statement->fetch(PDO::FETCH_ASSOC) ){
											$resp['ll_latitude']= trim($r['ll_latitude']);
											$resp['ll_longitude']= trim($r['ll_longitude']);
											$resp['ll_cidade']=$r['ll_cidade'];
											$resp['ll_uf']=$r['ll_uf'];
										} else {
											if ($ll_categoria=='IM”VEIS'){
												$geolocalizacao=geolocalizacao_google($resp['ll_endereco']);
												$resp['ll_latitude']=$geolocalizacao[0];
												$resp['ll_longitude']=$geolocalizacao[1];
											}
										}
									} else {
										
										if (str_replace('IM”VE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
											echo '<br><font color="green">* ImÛvel</font>';
											$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);
										} else {
											$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais'],false);
										}
										$resp['ll_latitude']=$geolocalizacao[0];
										$resp['ll_longitude']=$geolocalizacao[1];
									}
								}
							}
						}

							
						//print_r($resp);echo '<br><br>';
						//exit;
						echo NovoLeilao ($resp,array(),0,0,0,0);
						//exit;
						// ==================================
						$conta+=1;
						//if ($conta>5){echo '**'.$conta;exit;}
						// ==================================
						$tempoexecucaomg=diferencasegundos( $tempoiniciomg ,'');
						if ($tempoexecucaomg>30) {
							// atingiu tempo limite.
							$atingiutempolimite=true;
							goto fimdolaco;
						}
					} else {
						echo '/ ';
						
					}
				}
			
			} 

			if ($tipo_pagina=='especifica'){

				// lote ˙nico
				$resp=$resp0;
				
				if (!VerificaCadastroLeilao($resp)){ 
					
					$lote=str_replace(chr(150),'-', $lote);

					$resp['ll_data_1']=arrumadata_robos(str_replace(' ','/',str_replace('h','/',isolar_limpo($lote,'1™ PRA«A:','','<br'))));
					$resp['ll_lance_min_1']=str_replace(',','.',str_replace('.','',isolar_limpo($lote,'1™ PRA«A:','R$','</')));

					$resp['ll_data_2']=arrumadata_robos(str_replace(' ','/',str_replace('h','/',isolar_limpo($lote,'2™ PRA«A:','','<br'))));
					$resp['ll_lance_min_2']=str_replace(',','.',str_replace('.','',isolar_limpo($lote,'2™ PRA«A:','R$','</')));

					if ($resp['ll_data_1']==''){$resp['ll_data_1']=arrumadata_robos(str_replace(' - ','/',str_replace('h','/',isolar_limpo($lote,'<div class="dataLeilao">','','</span').'/'.isolar_limpo($lote,'<div class="dataLeilao">',', ','</'))));}

					$resp['ll_categoria_rotulo']=$ll_categoria;
					if ($ll_categoria=='IM”VEIS'){$resp['ll_categoria_rotulo']='IM”VEL';}
					$resp['ll_categoria_txt']=$ll_categoria;


					$resp['ll_comitente']=$comitente;
					$resp['ll_agregador']=$agregador;//$resp['ll_comitente'];

					$resp['ll_descricao']=espacapontuacao(isolar_limpo($lote,'"descricaoLeilao"','','<div'));

					$resp['ll_cidade']=trim(isolar('ß'.$resp['ll_descricao'],'ß','','-'));
					$resp['ll_uf']=trim(isolar($resp['ll_descricao'],'-','','-'));
					$resp['ll_bairro']=trim(isolar($resp['ll_descricao'],'-','-','-'));
					if ($resp['ll_bairro']!=''){$resp['ll_descricao']=trim(isolar($resp['ll_descricao'].'ß©ß',$resp['ll_bairro'],'-','ß©ß'));}

					if ($resp['ll_cidade']=='' || $resp['ll_uf']==''){
						$resp['ll_cidade']='';$resp['ll_uf']='';
						$resp['ll_uf']=trim(strtoupper(isolar_reverso($resp['ll_descricao'].'ß©ß','/','ß©ß')));
                        $statement = $pdo->query("SELECT * FROM geolocalizacao WHERE geo_uf='".$resp['ll_uf']."' AND cod_IBGE>0 LIMIT 1");
                        if (!$statement->fetch(PDO::FETCH_ASSOC) ) {
							$resp['ll_uf']='';$resp['ll_cidade']='';
						} else {
							$resp['ll_cidade']=trim(strtoupper(isolar_reverso(str_replace(' EM ','-',str_replace(' DE ','-',$resp['ll_descricao'])),'-','/')));
						}

					}
					
					$descricao=strtoupper(strtr($resp['ll_descricao'], "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"));
					if ( (str_replace('APTO','',$descricao)!=$descricao || str_replace('APARTAMENTO','',$descricao)!=$descricao) && str_replace('CASA','',$descricao)==$descricao && str_replace('TERRENO','',$descricao)==$descricao && str_replace('COMERCIAL','',$descricao)==$descricao ){$resp['ll_categoria_rotulo']='APARTAMENTO';}
					if (str_replace('APTO','',$descricao)==$descricao && str_replace('APARTAMENTO','',$descricao)==$descricao && str_replace('CASA','',$descricao)!=$descricao && str_replace('TERRENO','',$descricao)==$descricao && str_replace('COMERCIAL','',$descricao)==$descricao ){$resp['ll_categoria_rotulo']='CASA';}
					if (str_replace('APTO','',$descricao)==$descricao && str_replace('APARTAMENTO','',$descricao)==$descricao && str_replace('CASA','',$descricao)==$descricao && str_replace('TERRENO','',$descricao)!=$descricao && str_replace('COMERCIAL','',$descricao)==$descricao ){$resp['ll_categoria_rotulo']='TERRENO';}
					if (str_replace('APTO','',$descricao)==$descricao && str_replace('APARTAMENTO','',$descricao)==$descricao && str_replace('CASA','',$descricao)==$descricao && str_replace('TERRENO','',$descricao)==$descricao && str_replace('COMERCIAL','',$descricao)!=$descricao ){$resp['ll_categoria_rotulo']='COMERCIAL';}
					if (str_replace('APTO','',$descricao)==$descricao && str_replace('APARTAMENTO','',$descricao)==$descricao && str_replace('CASA','',$descricao)==$descricao && str_replace('TERRENO','',$descricao)==$descricao && str_replace('SALA COMERCIAL','',$descricao)!=$descricao ){$resp['ll_categoria_rotulo']='SALA COMERCIAL';}

					$texto_leilao=str_replace('Veja aqui a copia da matrÌcula','',str_replace('∞','∫',limpacaracteresisolatin1(http_get_curl($resp['ll_link'],'ie',false,false))));

					//$ll_agregador_link=trim(isolar(str_replace("&", '"', $texto_leilao),'?Idleilao=','','"'));
					//if ($ll_agregador_link!=''){
					//	$resp['ll_agregador_link']='https://www.milanleiloes.com.br/Leiloes/CatalogoImoveis.asp?IdLeilao='.$ll_agregador_link;
					//} else {
						$resp['ll_agregador_link']=$resp['ll_link'];
					//}
					$resp['ll_lote']=trim(isolar($texto_leilao,'javascript:AbrirDetalhes(',"'","'"));
					if ($resp['ll_lote']==''){$resp['ll_lote']='⁄nico';}

					$detalhes=espacapontuacao(isolar_limpo(str_replace('<br>','.~ ',str_replace('<br >','.~ ',str_replace('<br />','.~ ',str_replace('->','',$texto_leilao)))),'"og:description"','="','"'));
					$resp['ll_detalhes']=str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',$detalhes)))))));
					$detalhes=strtoupper(strtr($detalhes, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"));

					if ($resp['ll_bairro']!='' && $detalhes!='' && $resp['ll_endereco']==''){
						$resp['ll_endereco']=descobre_endereco(' SITO A '.isolar($detalhes.'ß©ß',strtoupper(strtr($resp['ll_bairro'], "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC")),'','ß©ß'));
					}
					if (!$resp['ll_endereco'] || $resp['ll_endereco']==''){
						$resp['ll_endereco']=descobre_endereco($detalhes);
					}

/*					$numeroend='';
					if ($resp['ll_bairro']!='' && $detalhes!=''){
						$endereco=isolar($detalhes.'ß©ß',strtoupper(strtr($resp['ll_bairro'], "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC")),'','ß©ß');
					}
					if ($endereco==''){$endereco=isolar($detalhes.'ß©ß','SITO A ','','ß©ß');}
						if ($endereco==''){$endereco=isolar($detalhes.'ß©ß','RUA  ','','ß©ß');} if ($endereco!=''){$endereco='RUA '.$endereco;}
						if ($endereco==''){$endereco=isolar($detalhes.'ß©ß','AVENIDA  ','','ß©ß');} if ($endereco!=''){$endereco='AVENIDA '.$endereco;}
						if ($endereco==''){$endereco=isolar($detalhes.'ß©ß',' R.','','ß©ß');} if ($endereco!=''){$endereco='RUA '.$endereco;}
						if ($endereco==''){$endereco=isolar($detalhes.'ß©ß','AV.','','ß©ß');} if ($endereco!=''){$endereco='AVENIDA  '.$endereco;}
					if ($endereco!=''){
						$endereco_ex=explode(' ',$endereco);
						
						for ($i=2;$i<sizeof($endereco_ex);$i++){
							$so_letras_numeros_espacos=trim(so_letras_numeros_espacos($endereco_ex[$i]));
							if ($so_letras_numeros_espacos==''.(int)$so_letras_numeros_espacos && $so_letras_numeros_espacos!=''){$numeroend=$endereco_ex[$i];break;}
						}
							if ($numeroend!=''){$resp['ll_endereco']=limpaespacos(trim(str_replace('.','',str_replace('-',' ',isolar('ß'.$endereco,'ß','',$numeroend).' '.$numeroend))));}
					}
*/
					$basefotos=trim(isolar($texto_leilao,'"og:image"','="','"'));
					if (strlen($basefotos)>10){
						if (substr($basefotos,0,2)=='//'){$basefotos='https:'.$basefotos;}
						$resp['ll_foto_1']=$basefotos;
					}


					if ($resp['ll_cidade']=='' && $resp['ll_uf']=='' && $resp['ll_endereco']!=''){
						$sqlqry="SELECT * FROM db_leilao WHERE ll_endereco='".$resp['ll_endereco']."' AND ll_latitude!='' AND ll_longitude!='' ORDER BY ll_cidade DESC LIMIT 1";
                        $statement = $pdo->query($sqlqry);
						if ($r = $statement->fetch(PDO::FETCH_ASSOC)){
							$resp['ll_latitude']= trim($r['ll_latitude']);
							$resp['ll_longitude']= trim($r['ll_longitude']);
							$resp['ll_cidade']=$r['ll_cidade'];
							$resp['ll_uf']=$r['ll_uf'];
						} else {
							if ($ll_categoria=='IM”VEIS'){
								$geolocalizacao=geolocalizacao_google($resp['ll_endereco']);
								$resp['ll_latitude']=$geolocalizacao[0];
								$resp['ll_longitude']=$geolocalizacao[1];
							}
						}
					} else {
		
						if (str_replace('IM”VE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
							echo '<br><font color="green">* ImÛvel</font>';
							$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);
						} else {
							$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais'],false);
						}
						$resp['ll_latitude']=$geolocalizacao[0];
						$resp['ll_longitude']=$geolocalizacao[1];
					}

						
					//print_r($resp);echo '<br><br>';
					//exit;
					echo NovoLeilao ($resp,array(),0,0,0,0);
					//exit;
					// ==================================
					$conta+=1;
					//if ($conta>5){echo '**'.$conta;exit;}
					// ==================================
					$tempoexecucaomg=diferencasegundos( $tempoiniciomg ,'');
					if ($tempoexecucaomg>30) {
						// atingiu tempo limite.
						$atingiutempolimite=true;
						goto fimdolaco;
					}
				} else {
					echo '/ ';
					
				}

			}
		}


		$contasubcategoria1=0;
	}
}

fimdolaco:

	
if ($atingiutempolimite==true){
	// n„o terminou!
    organizador_tempo_limite_atingido (SITE_BR_MILAN_LEILOES,$contacategorias.'/'.$contasubcategoria1);
echo '***
tempo limite
'; 
} else {
    echo '**** Finalizou tudo';
    organizador_finaliza(SITE_BR_MILAN_LEILOES);
}

?>
