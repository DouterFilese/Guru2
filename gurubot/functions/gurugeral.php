<?php

// G U R U B O T
// MÛdulo Leilıes BB
// (c) 2010 05 Marcelon

// Padr„o de data: YYYYMMDDHHii
date_default_timezone_set('America/Sao_Paulo');

function VerificaCadastroLeilao($resp,$ignora_db_secundario=false,$idminimo=0,$excluidos=array()){
	$porcentagem_sem_cadastro=40; // preencher de 0 a 100
	if (rand(1,100)<=$porcentagem_sem_cadastro){
		echo '<br><small><i>
* Considerada <b>n„o cadastrada</b> (configurado '.$porcentagem_sem_cadastro.'% dos leilıes n„o cadastrados). Para mudar, altere $porcentagem_sem_cadastro na rotina VerificaCadastroLicitacao, em gurubot/functions/gurugeral.php
</i></small><br>';
		return false;
	}else {
		echo '<br><small><i>
* Considerada <b>cadastrada</b> (configurado '.$porcentagem_sem_cadastro.'% dos leilıes n„o cadastrados). Para mudar, altere $porcentagem_sem_cadastro na rotina VerificaCadastroLicitacao, em gurubot/functions/gurugeral.php
</i></small><br>';
		return true;
	}
}

function NovoLeilao ($resp,$lote=array(),$margem_v_icone=0.1,$margem_h_icone=0.1,$margem_v=0,$margem_h=0,$verificamd5=true,$precadastro=false){

	// verifica se est· tudo ok... 2023 01
	$advertencia='';
	if (!isset($resp['ll_pais']) || $resp['ll_pais']==''){$erro.='<br>Campo <strong>ll_pais</strong> obrigatÛrio!';}
	if (!isset($resp['ll_idioma']) || $resp['ll_idioma']==''){$erro.='<br>Campo <strong>ll_idioma</strong> obrigatÛrio!';}
	if (!isset($resp['ll_moeda']) || $resp['ll_moeda']==''){$erro.='<br>Campo <strong>ll_moeda</strong> obrigatÛrio!';}
	if (!isset($resp['ll_lote']) || $resp['ll_lote']==''){$erro.='<br>Campo <strong>ll_lote</strong> obrigatÛrio!';}
	if (!isset($resp['ll_descricao']) || $resp['ll_descricao']==''){$erro.='<br>Campo <strong>ll_descricao</strong> obrigatÛrio!';}
	if (!isset($resp['ll_agregador_link']) || $resp['ll_agregador_link']==''){$erro.='<br>Campo <strong>ll_agregador_link</strong> obrigatÛrio!';}
	if (!isset($resp['ll_link']) || $resp['ll_link']==''){$erro.='<br>Campo <strong>ll_link</strong> obrigatÛrio!';}
	if (!isset($resp['ll_agregador']) || $resp['ll_agregador']==''){$erro.='<br>Campo <strong>ll_agregador</strong> obrigatÛrio!';}
	if (!isset($resp['ll_data_1']) || $resp['ll_data_1']==''){$erro.='<br>Campo <strong>ll_data_1</strong> obrigatÛrio!';}
	if (!isset($resp['ll_lance_min_1']) || $resp['ll_lance_min_1']==''){$erro.='<br>Campo <strong>ll_lance_min_1</strong> obrigatÛrio!';}
	if (!isset($resp['ll_comitente']) || $resp['ll_comitente']==''){$erro.='<br>Campo <strong>ll_comitente</strong> obrigatÛrio!';}
	if (!isset($resp['ll_categoria_txt']) || $resp['ll_categoria_txt']==''){$erro.='<br>Campo <strong>ll_categoria_txt</strong> obrigatÛrio!';}
	if (!isset($resp['ll_categoria_rotulo']) || $resp['ll_categoria_rotulo']==''){$erro.='<br>Campo <strong>ll_categoria_rotulo</strong> obrigatÛrio!';}


	if (!isset($resp['ll_uf']) || $resp['ll_uf']==''){$advertencia.='<br>Campo <strong>ll_uf</strong> n„o informado!';}
	if (!isset($resp['ll_cidade']) || $resp['ll_cidade']==''){$advertencia.='<br>Campo <strong>ll_cidade</strong> n„o informado!';}
	if (!isset($resp['ll_foto_1']) || $resp['ll_foto_1']==''){$advertencia.='<br>Campo <strong>ll_foto_1</strong> n„o informado!';}
	if (!isset($resp['ll_data_2']) || $resp['ll_data_2']==''){$advertencia.='<br>Campo <strong>ll_data_2</strong> n„o informado!';}
	if (!isset($resp['ll_lance_min_2']) || $resp['ll_lance_min_2']==''){$advertencia.='<br>Campo <strong>ll_lance_min_2</strong> n„o informado!';}
	if (!isset($resp['ll_endereco']) || $resp['ll_endereco']==''){$advertencia.='<br>Campo <strong>ll_endereco</strong> n„o informado!';}
	if (!isset($resp['ll_bairro']) || $resp['ll_bairro']==''){$advertencia.='<br>Campo <strong>ll_bairro</strong> n„o informado!';}

	if ($erro!=''){$erro='<br><font color="red"><strong>Erros encontrados:</strong>'.$erro.'</font>';}
	if ($advertencia!=''){$erro.='<br><font color="blue"><strong>AdvertÍncias encontradas:</strong>'.$advertencia.'</font>';}

	foreach ($resp as $key => $valor) {
		if ($key!=''){
			if (str_replace('lic_data_','',$key)!=$key || str_replace('lic_abertura_','',$key)!=$key){
					$resposta .= '<br>'.$key.': <strong>'.mostradata($valor).'</strong> (<i>'.$valor.'</i>)';
			} else {
				if ($key=='lic_txt_edital'){
					$resposta .= '<br>'.$key.': <i>'.substr($valor,0,200).'...</i>';
				} else {
					$resposta .= '<br>'.$key.': '.$valor;
				}
			}
		}
	}


	if ($resposta != '| '){	$resposta.='<br>';}
	if (!$retorna_vetor){
		// resposta classica
		return $erro.$resposta; //.$resposta_lotes;
	} else {
		// resposta em vetor
		$vetor_resposta=array();
		$vetor_resposta['id']=$id_licitacao;
		$vetor_resposta['texto']=$erro.$resposta;
		return $vetor_resposta;
	}
	
}

function conta_linhas_sql($db_query,$db=1) {

    if ($db==1){
        global $pdo;
    } else {
        global $pd2o;
    }
//echo '<br>'.$db_query;
//echo '<br>'.$db;
    if ( $db_query !=''){
        if ($db==1) {
            $res = $pdo->query($db_query);
        } else{
            $res = $pd2o->query($db_query);
        }
        return $res->rowCount();
    } else {
      return 0;
    }
}



function isolar($texto,$inicio,$inicio2,$fim) {
// inicio2: segunda ocorrecncia de inicio
   if ( $texto != '' && $inicio != '' && $fim !='') {
    $isolado = stristr($texto, $inicio);
    $isolado = substr( $isolado, strlen($inicio) , strlen($isolado) - strlen($inicio));
//echo '['.$isolado.']';
    if ($inicio2 != '' && $isolado != '') {
       $isolado = stristr($isolado, $inicio2);
       if ($isolado != '') {
          $isolado = substr( $isolado, strlen($inicio2) , strlen($isolado) - strlen($inicio2) );
       }
    }
    if ($isolado != '') {
      $posi = strpos($isolado, $fim);  //posi is equal to 0
      if (is_numeric($posi)){
       $isolado = substr( $isolado, 0 , $posi );
      } else {
         $isolado = '';
      }
    }
    //return !empty($isolado) ? $isolado : FALSE;
    if (strlen($isolado)>0){return $isolado;}else {return false;}
   } else {
    return false;
   }
}

function isolar_limpo($texto,$inicio,$inicio2,$fim) {
	// chama isolar e limpa html
	  $texto=str_replace('<STYLE','<style',$texto);
	  $texto=str_replace('</STYLE','</style',$texto);
  	  $texto=str_replace('<Style','<style',$texto);
  	  $texto=str_replace('</Style','</style',$texto);
	  while ($txtestilo=isolar($texto,'<style','','</style')){
		$texto=str_replace('<style'.$txtestilo.'</style','',$texto);
	  }
	  $texto=str_replace('<SCRIPT','<script',$texto);
	  $texto=str_replace('</SCRIPT','</script',$texto);
  	  $texto=str_replace('<Script','<script',$texto);
  	  $texto=str_replace('</Script','</script',$texto);

	  while ($txtestilo=isolar($texto,'<script','','</script')){
		$texto=str_replace('<script'.$txtestilo.'</script','',$texto);
	  }

	return trim(limpahtml(isolar($texto,$inicio,$inicio2,$fim)));
}
function isolar_amplo($texto,$inicio,$inicio2,$fim) {
	// igual a isolar, porÈm desconsiderando acentos e capitalizaÁ„o na busca
	// inicio2: segunda ocorrecncia de inicio
	$texto='~'.$texto;
	$isolado=false;
   if ( $texto != '' && $inicio != '' && $fim !='') {

    // Retira acentos para comparaÁ„o
    $textosa = strtoupper(strtr($texto, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹« ", "aaaaeeeiioooouuucAAAAEEEIIOOOOUUUC_"));
    $iniciosa = strtoupper(strtr($inicio, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹« ", "aaaaeeeiioooouuucAAAAEEEIIOOOOUUUC_"));
    $inicio2sa = strtoupper(strtr($inicio2, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹« ", "aaaaeeeiioooouuucAAAAEEEIIOOOOUUUC_"));
    $fimsa = strtoupper(strtr($fim, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹« ", "aaaaeeeiioooouuucAAAAEEEIIOOOOUUUC_"));

    $catact_inicio=proxima_ocorrÍncia_limpa($textosa,$iniciosa,0);
    $catact_fim=proxima_ocorrÍncia_limpa($textosa,$fimsa,0);

    if ($catact_inicio>0 && $catact_fim>0){
    $isolado = substr($texto,$catact_inicio+strlen($iniciosa),$catact_fim-$catact_inicio-strlen($iniciosa));

    if ($inicio2 != '' && $isolado != '') {
	   $isoladosa = strtr($isolado, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹« ", "aaaaeeeiioooouuucAAAAEEEIIOOOOUUUC_");
	   $catact_inicio2=proxima_ocorrÍncia_limpa($isoladosa,$inicio2sa,0);
	   if ($catact_inicio2>0){ $isolado = substr($isolado,$catact_inicio2-strlen($isolado)+strlen($inicio2sa));}
    }
    $isolado=trim($isolado);
    return !empty($isolado) ? $isolado : FALSE;
   }
	}
   return trim($isolado);

}

function isolar_reverso($texto,$inicio,$fim){


  $resultado='';
  $inicial=0;
  $final=0;
  $texto='ﬂ'.$texto.'ﬂ';

  $substitui_fim='Ê';
  for ($i=1;$i<strlen($fim);$i++){
  	$substitui_fim.='Ê';
  }
  if ($final=strpos($texto, $fim)){

  	$texto=substr($texto,0,$final).$substitui_fim.substr($texto,-strlen($texto)+$final+strlen($substitui_fim));
	while ($final2=strpos($texto, $fim)){
		if ($final==$final2){goto isolar_reverso_fim1;}
		$final=$final2;

	  	$texto=substr($texto,0,$final).$substitui_fim.substr($texto,-strlen($texto)+$final+strlen($substitui_fim));
	}
	isolar_reverso_fim1:
	$texto=str_replace($substitui_fim,$fim,$texto);
	$texto= substr($texto,0,$final);

	$substitui_inicio='Ê';
	for ($i=1;$i<strlen($inicio);$i++){
	  	$substitui_inicio.='Ê';
	}

  	if ($inicial=strpos($texto, $inicio)){

  	$texto=substr($texto,0,$inicial).$substitui_inicio.substr($texto,-strlen($texto)+$inicial+strlen($substitui_inicio));
	while ($inicial2=strpos($texto, $inicio)){
		if ($inicial==$inicial2){goto isolar_reverso_fim2;}
		$inicial=$inicial2;
	  	if ((-strlen($texto)+$inicial+strlen($substitui_inicio))<0 ){
	  		$texto=substr($texto,0,$inicial).$substitui_inicio.substr($texto,-strlen($texto)+$inicial+strlen($substitui_inicio));
	  	} else {
	  		goto isolar_reverso_fim2;
	  	}
	}
	isolar_reverso_fim2:
	$texto=str_replace($substitui_inicio,$inicio,$texto);
	$inicial+=strlen($inicio);
	$resultado= substr($texto,$inicial,strlen($texto)-$inicial);
	}
  }

  return $resultado;
}

class Crawler {

  protected $markup = '';

  public function __construct($uri) {
    $this->markup = $this->getMarkup($uri);
  }

  public function getMarkup($uri) {

//echo '<br><br>uri='.$uri.'<br><br>';

    $erros=0;
    if ($uri=='') { echo '°';$a='';} else {
    $a= file_get_contents($uri);
    if ($a==''){$a= file_get_contents($uri); echo '[err1]';}
    if ($a==''){$a= file_get_contents($uri); echo '[err2]';}
    if ($a==''){$a= file_get_contents($uri); echo '[err3]';}
    if ($a==''){echo '[err Ò res]';}
	}
    return $a;
  }

  public function get($type) {
    $method = "_get_{$type}";
    if (method_exists($this, $method)){
      //return call_user_method($method, $this);
    }
  }

  protected function _get_images() {
    if (!empty($this->markup)){
      preg_match_all('/<img([^>]+)\/>/i', $this->markup, $images);
      return !empty($images[1]) ? $images[1] : FALSE;
    }
  }

  protected function _get_links() {
    if (!empty($this->markup)){
      preg_match_all('/<a([^>]+)\>(.*?)\<\/a\>/i', $this->markup, $links);
      return !empty($links[1]) ? $links[1] : FALSE;
    }
  }

  protected function _get_textolicit() {
      if (!empty($this->markup)){
      $texto = $this->markup;
      return !empty($texto) ? $texto : FALSE;
      }
  }
}


function diferencadias($data1, $data2=""){

  if($data1=="" || (int)$data1==0){
    $data1 = date("YmdHi");
  }
  if($data2==""){
    $data2 = date("YmdHi");
  }
  $tipo = "h";

  for($i=1;$i<=2;$i++){
    ${"dia".$i} = substr(${"data".$i},6,2);
    ${"mes".$i} = substr(${"data".$i},4,2);
    ${"ano".$i} = substr(${"data".$i},0,4);
    ${"horas".$i} = substr(${"data".$i},8,2);
    ${"minutos".$i} = substr(${"data".$i},10,2);
  }

  $segundos = mktime((int)$horas2,(int)$minutos2,0,(int)$mes2,(int)$dia2,(int)$ano2) - mktime((int)$horas1,(int)$minutos1,0,(int)$mes1,(int)$dia1,(int)$ano1);
  $difere = (int)($segundos/86400);
	return $difere;
}

function diferencaminutos($data1, $data2=""){


  if($data1=="" || (int)$data1==0){
    $data1 = date("YmdHi");
  }
  if($data2==""){
    $data2 = date("YmdHi");
  }
  for($i=1;$i<=2;$i++){
    ${"dia".$i} = substr(${"data".$i},6,2);
    ${"mes".$i} = substr(${"data".$i},4,2);
    ${"ano".$i} = substr(${"data".$i},0,4);
    ${"horas".$i} = substr(${"data".$i},8,2);
    ${"minutos".$i} = substr(${"data".$i},10,2);
  }
  $segundos = mktime((int)$horas2,(int)$minutos2,0,(int)$mes2,(int)$dia2,(int)$ano2) -
	mktime((int)$horas1,(int)$minutos1,0,(int)$mes1,(int)$dia1,(int)$ano1);

  $difere = (int)($segundos/60);
  return $difere;
}

function diferencasegundos($data1, $data2=""){

// OBS: segundos n„o est„o no padr„o de tempo
  if($data1=="" || (int)$data1==0){
    $data1 = date("YmdHis");
  }
  if($data2==""){
    $data2 = date("YmdHis");
  }
  for($i=1;$i<=2;$i++){
    ${"dia".$i} = substr(${"data".$i},6,2);
    ${"mes".$i} = substr(${"data".$i},4,2);
    ${"ano".$i} = substr(${"data".$i},0,4);
    ${"horas".$i} = substr(${"data".$i},8,2);
    ${"minutos".$i} = substr(${"data".$i},10,2);
    ${"segundos".$i} = substr(${"data".$i},12,2);
  }
  $segundos = mktime((int)$horas2,(int)$minutos2,(int)$segundos2,(int)$mes2,(int)$dia2,(int)$ano2) - mktime((int)$horas1,(int)$minutos1,(int)$segundos1,(int)$mes1,(int)$dia1,(int)$ano1);
  return $segundos;
}

function datadiferente($data, $diferencaminutos){

  // Acha a diferenÁa em minutos
  $dia = substr($data,6,2);
  $mes = substr($data,4,2);
  $ano = substr($data,0,4);
  $horas = substr($data,8,2);
  $minutos = substr($data,10,2);

  $novadata = date("YmdHi", mktime((int)$horas,(int)$minutos-(int)$diferencaminutos,0,(int)$mes,(int)$dia,(int)$ano));
  return $novadata;
}

function datadiferente_dias($data, $diferencadias){

  // Acha a diferenÁa em dias
  // Padr„o da data 8 dÌgitos (Ymd)
  $dia = substr($data,6,2);
  $mes = substr($data,4,2);
  $ano = substr($data,0,4);

  $novadata = date("Ymd", mktime(0,0,0,(int)$mes,(int)$dia-(int)$diferencadias,(int)$ano));
  return $novadata;
}

function datafuturo($data, $diferencaminutos){


  $dia = substr($data,6,2);
  $mes = substr($data,4,2);
  $ano = substr($data,0,4);
  $horas = substr($data,8,2);
  $minutos = substr($data,10,2);

  $novadata = date("YmdHi", mktime((int)$horas,(int)$minutos+(int)$diferencaminutos,0,(int)$mes,(int)$dia,(int)$ano));
  return $novadata;
}

function transformadatatrabalho ($texto) {
  // retorna data no formato Ymd
  $texto=str_replace(" ","/",str_replace(":","/",str_replace("-","/",$texto)));
  $data1 = explode("/", $texto);
  if (LANGUAGE == 'pt-BR') {
    if (strlen($data1[1])==1){$data1[1]='0'.$data1[1];}
    if (strlen($data1[0])==1){$data1[0]='0'.$data1[0];}
    return $data1[2] . $data1[1] . $data1[0] ;
  } else {
    return $texto;
  }
}

function transformadataexibicao ($data) {

  // recebe data no formato Ymd e retorna data no formato da linguagem atual
  $dia = substr($data,6,2);
  $mes = substr($data,4,2);
  $ano = substr($data,0,4);

  if (LANGUAGE == 'pt-BR') {
    $novadata = date("d/m/Y", mktime(0,0,0,(int)$mes,(int)$dia,(int)$ano));
    return $novadata;
  } else {
    return $data;
  }
}

function mostradata ($texto){
 if ( strlen($texto)==12) {
  $ano=substr( $texto, 0, 4);
  $mes=substr( $texto, 4, 2);
  $dia=substr( $texto, 6, 2);
  $hora=substr( $texto, 8, 2);
  $min=substr( $texto, 10, 2);
  return $dia . '/' . $mes . '/' . $ano . ' ' . $hora . ':' . $min;
 } else {
   if ( strlen($texto)==8) {
    $ano=substr( $texto, 0, 4);
    $mes=substr( $texto, 4, 2);
    $dia=substr( $texto, 6, 2);
    return $dia . '/' . $mes . '/' . $ano ;
   } else {
     return false;
   }
 }
}

function sonumeros ($texto){

  $resposta= '';
  if (strlen($texto)>0) {
    for ($i = 0; $i<= strlen($texto); $i++) {
      if ( substr($texto,$i,1)>='0' && substr($texto,$i,1)<='9') {
        $resposta .= substr($texto,$i,1);
      }
      if ( substr($texto,$i,1)==',' || substr($texto,$i,1)=='.') {
        $resposta .= '.';
      }
    }
  }
  return $resposta;
}


function sonumeros_sem_virgula ($texto){
    return preg_replace("/[^0-9]/", "", $texto );
}

function limpaedital ($texto){
  // limpa dados deixando somente numeros e barras, tirando zeros a esquerda
  $resposta= '';
  if (strlen($texto)>0) {
    for ($i = 0; $i<= strlen($texto); $i++) {
      if ( $texto[$i]>='/' && $texto[$i]<='9') {
        if ( $resposta != '' || ( $resposta == '' && $texto[$i]!='0')) {
          $resposta .= $texto[$i];
        }
      }
    }
  }
  return $resposta;
}

function limpatexto ($texto0){
  $texto1= str_replace("&nbsp;","",$texto0);
  $texto= str_replace("&amp;","&",$texto1);
  $resposta= '';
  if (strlen($texto)>0) {
    for ($i = 0; $i<= strlen($texto); $i++) {
//      if ( $i>0 ) {
        if ( ( $i==0 && $texto[$i]!=' ') || ( $i>0 && ($texto[$i]!=' ' || ( $texto[$i]==' ' && $texto[($i-1)]!=' '))) ) {
          if ( $texto[$i]>=' ') {
            if ( $resposta!= '' || ($texto[$i]!=' ' && $resposta== '') ) {
              $resposta .= $texto[$i];
            }
          }
        }
//      } else {
//        $resposta = $texto{0};
//      }
    }
  }
  return $resposta;
}

function limpahtml($texto,$limpascript=false) {
        if ($limpascript==true){$texto=limpascript($texto);}
        $resposta = '';
        $STOP = 0;
        for ($i = 0; $i<= strlen($texto); $i++) {
            if ($texto[$i] == "<") $STOP = 1;
            if ($texto[$i] == ">" && $STOP == 0) $resposta = '';
            if ($texto[$i] == ">") $STOP = 0;
            if ($STOP == 0 && $texto[$i] != ">") {$resposta .= $texto[$i];}
        }
        return $resposta ;
}

function acha_db_categoria($texto) {
    global $pdo;
 $resposta=false;
 if ( $texto !='' ) {

  setlocale(LC_CTYPE, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
//  $texto = trim(preg_replace("/[^A-Za-z0-9 ]/", "",strtr($texto, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«∞", "aaaaeeiooouucAAAAEEIOOOUUC∫")));
  $texto=str_replace("N∫","",strtoupper($texto));

	$termos=explode(',',limpaespacos($texto));
	if (sizeof($termos)>0){
		$termos_arrumados=array();
		for ($i=0;$i<sizeof($termos);$i++){
			if ($termos[$i]!=(int)$termos[$i].'' && $termos[$i]!='DE' && $termos[$i]!='PARA' && $termos[$i]!='COM' && $termos[$i]!='EM' && strlen($termos[$i])>1){
				if (!in_array($termos[$i],$termos_arrumados)){$termos_arrumados[]=$termos[$i];}
			}
		}
		$resposta['ll_categoria_txt']=implode(',',$termos_arrumados);

		//arranja cadastro no db
		$termostxt=trim(preg_replace("/[^A-Za-z0-9 ]/", "",strtr(implode(' ',$termos_arrumados), "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«∞", "aaaaeeiooouucAAAAEEIOOOUUC∫")));

		// separa pedaÁos n„o repetidos
		$termos=explode(' ',limpaespacos($termostxt));
		if (sizeof($termos)>0){
			$termos_arrumados=array();
			for ($i=0;$i<sizeof($termos);$i++){
				if ($termos[$i]!=(int)$termos[$i].'' && $termos[$i]!='DE' && $termos[$i]!='PARA' && $termos[$i]!='COM' && $termos[$i]!='EM' && strlen($termos[$i])>1){
					if (!in_array($termos[$i],$termos_arrumados)){$termos_arrumados[]=$termos[$i];}
				}
			}
			sort($termos_arrumados);
			$novos_termos=implode(' ',$termos_arrumados);

            $statement = $pdo->query("SELECT * FROM `db_categorias` WHERE cat_termos LIKE '$novos_termos' LIMIT 1");
			if($categorizado = $statement->fetch(PDO::FETCH_ASSOC)) {
				$resposta['id_db_categoria']=$categorizado['id'];
				$resposta['categoria_principal']=$categorizado['cat_categ_principal'];
			} else {
			   $categoria_principal=0;

				if ((str_replace('CASA','',$novos_termos)!=$novos_termos || str_replace('APARTAMENTO','',$novos_termos)!=$novos_termos || str_replace('COMERCIA','',$novos_termos)!=$novos_termos ||
					str_replace('ESCRITORIO','',$novos_termos)!=$novos_termos || str_replace('AGENCIA','',$novos_termos)!=$novos_termos || str_replace('TERRENO','',$novos_termos)!=$novos_termos ||
					str_replace('IMOVE','',$novos_termos)!=$novos_termos || str_replace('SOBRADO','',$novos_termos)!=$novos_termos || str_replace('GALPAO','',$novos_termos)!=$novos_termos ||
					str_replace('AREA','',$novos_termos)!=$novos_termos || str_replace('RURAL','',$novos_termos)!=$novos_termos || str_replace('URBAN','',$novos_termos)!=$novos_termos ||
					str_replace('GARAGE','',$novos_termos)!=$novos_termos || str_replace('GLEBA','',$novos_termos)!=$novos_termos || str_replace('CHALE','',$novos_termos)!=$novos_termos ||
					str_replace('PREDIO','',$novos_termos)!=$novos_termos || str_replace('RESIDENCIA','',$novos_termos)!=$novos_termos || str_replace('SALA','',$novos_termos)!=$novos_termos ||
					str_replace('SITIO','',$novos_termos)!=$novos_termos || str_replace('FAZENDA','',$novos_termos)!=$novos_termos || str_replace('FLAT','',$novos_termos)!=$novos_termos ||
					str_replace('CANAVIA','',$novos_termos)!=$novos_termos || str_replace('ESTADIO','',$novos_termos)!=$novos_termos || str_replace('HARAS','',$novos_termos)!=$novos_termos ||
					str_replace('POSTO DE COMBUSTIVE','',$novos_termos)!=$novos_termos || str_replace('LOJA','',$novos_termos)!=$novos_termos || str_replace('CHACARA','',$novos_termos)!=$novos_termos ||
					str_replace('CENTRO DE TREINAMENTO','',$novos_termos)!=$novos_termos ||
					str_replace('CONJUNTO','',$novos_termos)!=$novos_termos) && (str_replace(' MOVEL','',$novos_termos)==$novos_termos && str_replace(' MOVEIS','',$novos_termos)==$novos_termos) ){$categoria_principal=1;}
				if (str_replace('VEICULO','',$novos_termos)!=$novos_termos || str_replace('CAMINHAO','',$novos_termos)!=$novos_termos || str_replace('ONIBUS','',$novos_termos)!=$novos_termos ||
					str_replace('EMBARCACAO','',$novos_termos)!=$novos_termos || str_replace('BARCO','',$novos_termos)!=$novos_termos || str_replace('AVIAO','',$novos_termos)!=$novos_termos ||
					str_replace('HELICOPTERO','',$novos_termos)!=$novos_termos || str_replace('AERONAVE','',$novos_termos)!=$novos_termos || str_replace('MOTO','',$novos_termos)!=$novos_termos ||
					str_replace('CARRO','',$novos_termos)!=$novos_termos ){$categoria_principal=2;}
				if (str_replace('PECAS','',$novos_termos)!=$novos_termos || str_replace('SUCATA','',$novos_termos)!=$novos_termos  || str_replace('PARTES','',$novos_termos)!=$novos_termos ||
					str_replace('PNEUS','',$novos_termos)!=$novos_termos || str_replace('MOTOBOMBA','',$novos_termos)!=$novos_termos || str_replace('MOTOREDU','',$novos_termos)!=$novos_termos ){$categoria_principal=0;}
				if (str_replace('SUCATA','',$novos_termos)!=$novos_termos  ){$categoria_principal=3;}

                $pdo->exec("INSERT INTO db_categorias (cat_termos,cat_categ_principal) VALUES ('$novos_termos','".$categoria_principal."')");

                $statement = $pdo->query("SELECT * FROM `db_categorias` WHERE cat_termos LIKE '$novos_termos' LIMIT 1");
                if($categorizado = $statement->fetch(PDO::FETCH_ASSOC)) {
					$resposta['id_db_categoria']=$categorizado['id'];
					$resposta['categoria_principal']=$categorizado['cat_categ_principal'];
				}
			   $mensagem='ID da nova categoria: '.$resposta['id_db_categoria'].'<br>Tags inseridas: '.$novos_termos.'<br>CategorizaÁ„o autom·tica como: <strong>';
			   if ($categoria_principal==0){$mensagem.='OUTROS';}
			   if ($categoria_principal==1){$mensagem.='IM”VEIS';}
			   if ($categoria_principal==2){$mensagem.='VEÕCULOS';}
			   if ($categoria_principal==3){$mensagem.='SUCATA';}
			   $mensagem.='</strong>.';

				envia_mail_interno ('Nova categoria: '.$novos_termos,array(array('titulo' => 'Verificar categorizaÁ„o autom·tica','conteudo' => $mensagem)),array(),'','',EMAIL_DESTINATARIO_TECNICO);

			}
		}
	}


  return $resposta;
 } else {
  return false;
 }
}

function categorizacao_automatica($texto){
	$texto=so_letras_numeros_espacos($texto);
	$resposta['categoria_principal']='0';
	$veiculos_possiveis='VEICULO,CARRO,CARROS,AUTOMOVEL,AUTOMOVEIS,CONVERSIVEL,CONVERSIVEIS,CAMINHAO,CAMINHOES,MOTOCICLETA,HATCH,HATCHE,HATCHES,SEDAN,PERUA,AMBULANCIA,SCOOTER,TRICICLO,QUADRICICLO,AUDI,BENTLEY,BMW,CHRYSLER,CITROEN,CHEVROLET,DODGE,FIAT,FORD,JEEP,JIPE,LIFAN,LEXUS,LAMBORGHINI,MASERATI,NISSAN,OPEL,PORSCHE,PEUGEOT,RENAULT,SUZUKI,HONDA,TOYOTA,VOLVO,VOLKSWAGEN,AGILE,ASTRA,ASTROVAN,BLAZER,BONANZA,BRASINCA,CAMARO,CAPRICE,CAPTIVA,CARAVAN,CAVALIER,CELTA,CHEVELLE,CHEVETTE,CHEVY,CHEYENNE,COBALT,COLORADO,CORSA,CORVETTE,CRUZE,HHR,IMPALA,KADETT,MERIVA,MONZA,OPALA,PICKUP,RAMONA,S10,SILVERADO,SUBURBAN,TAHOE,TRAILBLAZER,VECTRA,ZAFIRA,CINQUECENTO,DOBL“,DUCATO,ELBA,FIORINO,FREEMONT,IDEA,MAREA,MOBI,OGGI,PALIO,PUNTO,SIENA,STRADA,TEMPRA,TORO,UNO,BELINA,CORCEL,DELREY,ECOSPORT,ESCORT,FAIRLANE,FIESTA,FOCUS,FURGLAINE,LANDAU,MAVERICK,MONDEO,MUSTANG,PHAETON,RANGER,THUNDERBIRD,VERONA,VERSAILLES,ACCORD,CIVIC,CRV,HRV,ACCENT,AZERA,ELANTRA,GALLOPER,HB20,HB20S,HB20X,IX35,SONATA,TERRACAN,TIBURON,TUCSON,VELOSTER,ASX,COLT,GALANT,OUTLANDER,PAJERO,HOGGAR,CLIO,DAUPHINE,DUSTER,FLUENCE,GORDINI,KANGOO,LOGAN,M…GANE,SANDERO,SC…NIC,TWINGO,4RUNNER,AVALON,CAMRY,CELICA,COROLLA,ETIOS,FIELDER,HILUX,LEXUS,PASEO,PRIUS,RAV4,TACOMA,TUNDRA,VENZA,AMAROK,APOLLO,BORA,BUGGY,CROSSFOX,EUROVAN,FUSCA,GOLF,JETTA,KARMANN,GHIA,KOMBI,LOGUS,BEETLE,PASSAT,VARIANT,POINTER,SAVEIRO,SCIROCCO,SPACEFOX,TIGUAN,TOUAREG,VOYAGE,FURGOVAN,MARRU¡,BERLINA,SPIDER,TOWNER,BUGGY,CADILLAC,TIGGO,CARAVAN,AIRCROSS,BERLINGO,DAKOTA,DURANGO,JOURNEY,VIPER,FURG√O,PICAPE,VAN,HUMMER,BRAVA,SUPERMINI,IVECO,CHEROKEE,RENEGADE,BESTA,CADENZA,CARNIVAL,CERATO,PICANTO,SORENTO,LAIKA,NIVA,FREELANDER,AMG,MICRO‘NIBUS,SPRINTER,VITO,COUNTRYMAN,ROADSTER,PAJERO,FRONTIER,LIVINA,MURANO,SENTRA,TIIDA,XTERRA,TROLLER,IMPREZA,VITARA,SX4,Lada,Uaz,Zil,Holden,Perodua,Kia,Ssangyoung,Mahindra,Koenigsegg,Saab,Scania,Volvo,Skoda,Tatra,Subaru,Mazda,Mitsuoka,Nismo,Acura ,Daihatsu,Datsun,Honda,Isuzu,Pagani,Lancia,Abarth,Morgan,Noble,Ginetta,Jaguar,Lagonda,McLaren,Ariel,entley,Caterham,Alpine,Bugatti,Tianjin,Trumpchi,Wuling,Hafei,Haima,Hongqi,Maxus,Faw,Fengshen,Geely,Gleagle,Gonow,Changhe,Chery,Donfeng,Emgrand,Englon,Baojun,Bestum,Panoz,Trucks,Scion,Shelby,TesiaMustang,GMC,Fisker,Buick,Wiesmann,Gumpert,pallas,‘NIBUS,VW,HYUNDAI';
    $imoveis_possiveis='CASA,CASAS,APARTAMENTO,APARTAMENTOS,SALA,SALAS,SOBRADO,SOBRADOS,TERRENO,TERRENOS,CHACARA,CHACARA,SITIO,SITIO,LOJA,LOJAS,bairro,rua,avenida,alameda,itaim,BECO,CAMINHO,ESTRADA,FAZENDA,GALERIA,LADEIRA,PRA«A,PARQUE,PRAIA,QUADRA,QUIL‘METRO,RODOVIA,TRAVESSA,VIADUTO,VILA';
    $outros_possiveis='ESCAVADEIRA,RETROESCAVADEIRA,ESCAVADEIRAS,RETROESCAVADEIRAS,TORNO,TORNOS,FRESADORA,FRESADORAS,INJETORA,INJETORAS,'.
      'PRENSA,FURADEIRA,RETIFICA,GUINDASTE,COMPACTADOR,EMPILHADEIRA,TRANSPORTADOR,TRANSPORTADORA,CORREIA,ESTEIRA,PORTICO,TALHA,'.
      'PRENSAS,FURADEIRAS,RETIFICAS,GUINDASTES,COMPACTADORES,EMPILHADEIRAS,TRANSPORTADORES,TRANSPORTADORAS,CORREIAS,ESTEIRAS,PORTICOS,TALHAS,RODA,RESERVATORIO';
    $sucatas_possiveis='SUCATA';

    $veiculos_explodido = explode(",", str_replace(' ',',',strtoupper(strtr($veiculos_possiveis, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"))));
    $imoveis_explodido = explode(",", str_replace(' ',',',strtoupper(strtr($imoveis_possiveis, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"))));
    $outros_explodido = explode(",", str_replace(' ',',',strtoupper(strtr($outros_possiveis, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"))));
    $sucatas_explodido = explode(",", str_replace(' ',',',strtoupper(strtr($sucatas_possiveis, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"))));
    $param_ondeexplodido = explode(",", str_replace(' ',',',strtoupper(strtr($texto, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"))));
//print_r($param_ondeexplodido);
    if (sizeof($param_ondeexplodido)==1 && ($param_ondeexplodido[0]=='IMOVEL' || $param_ondeexplodido[0]=='IMOVEIS')){$param_ondeexplodido=array();$resposta['categoria_principal']='1';}
    if (sizeof($param_ondeexplodido)==1 && ($param_ondeexplodido[0]=='VEICULO' || $param_ondeexplodido[0]=='VEICULOS')){$param_ondeexplodido=array();$resposta['categoria_principal']='2';}
    if (sizeof($param_ondeexplodido)==1 && $param_ondeexplodido[0]=='SUCATA'){$param_ondeexplodido=array();$resposta['categoria_principal']='3';}

    for ($i=0; $i<count($veiculos_explodido); $i++) {
//echo '*'.$veiculos_explodido[$i];
      if ( in_array($veiculos_explodido[$i], $param_ondeexplodido)){
        $resposta['categoria_principal']='2';
//echo '---ok 2---';
        break;
      }
    }
    for ($i=0; $i<count($imoveis_explodido); $i++) {
      if ( in_array($imoveis_explodido[$i], $param_ondeexplodido)){
        $resposta['categoria_principal']='1';
        break;
      }
    }
    for ($i=0; $i<count($outros_explodido); $i++) {
      if ( in_array($outros_explodido[$i], $param_ondeexplodido)){
        $resposta['categoria_principal']='0';
        break;
      }
    }
    for ($i=0; $i<count($sucatas_explodido); $i++) {
      if ( in_array($sucatas_explodido[$i], $param_ondeexplodido)){
        $resposta['categoria_principal']='3';
        break;
      }
    }

	if ($resposta['categoria_principal']=='0'){$resposta['ll_categoria_txt']='OUTROS';}
	if ($resposta['categoria_principal']=='1'){$resposta['ll_categoria_txt']='IM”VEIS';}
	if ($resposta['categoria_principal']=='2'){$resposta['ll_categoria_txt']='VEÕCULOS';}
	if ($resposta['categoria_principal']=='3'){$resposta['ll_categoria_txt']='SUCATA';}

	return $resposta;

}

function adivinha_categoria ($texto){

    $veiculos_possiveis='VEICULO,CARRO,CARROS,AUTOMOVEL,AUTOMOVEIS,CONVERSIVEL,CONVERSIVEIS,CAMINHAO,CAMINHOES,MOTOCICLETA,HATCHE,HATCHES,SEDAN,PERUA,AMBULANCIA,SCOOTER,TRICICLO,QUADRICICLO,'.
      'AUDI,BENTLEY,BMW,CHRYSLER,CITROEN,CHEVROLET,DODGE,FIAT,FORD,JEEP,JIPE,LIFAN,LEXUS,LAMBORGHINI,MASERATI,NISSAN,OPEL,PORSCHE,PEUGEOT,RENAULT,SUZUKI,HONDA,TOYOTA,VOLVO,VOLKSWAGEN'.
      'A10,A20,AGILE,ASTRA,ASTROVAN,BLAZER,BONANZA,BRASINCA,C10,C14,C15,C20,CALIBRA,CAMARO,CAPRICE,CAPTIVA,CARAVAN,CAVALIER,CELTA,CHEVELLE,CHEVETTE,CHEVY,CHEYENNE,COBALT,COLORADO,CORSA,'.
      'CORVETTE,CRUZE,D10,D20,D40,HHR,IMPALA,KADETT,MERIVA,MONZA,OPALA,PICKUP,RAMONA,S10,SILVERADO,SS,SSR,SUBURBAN,TAHOE,TRAILBLAZER,VECTRA,ZAFIRA,CINQUECENTO,DOBL“,DUCATO,ELBA,FIORINO,'.
      'FREEMONT,IDEA,MAREA,MOBI,OGGI,PALIO,PUNTO,SIENA,STRADA,TEMPRA,TORO,UNO,BELINA,CORCEL,DELREY,ECOSPORT,ESCORT,FAIRLANE,FIESTA,FOCUS,FURGLAINE,LANDAU,MAVERICK,MONDEO,MUSTANG,PHAETON,'.
      'RANGER,THUNDERBIRD,VERONA,VERSAILLES,ACCORD,CIVIC,CRV,HRV,ACCENT,AZERA,ELANTRA,GALLOPER,H100,HB20,HB20S,HB20X,IX35,SONATA,TERRACAN,TIBURON,TUCSON,VELOSTER,ASX,COLT,GALANT,L200,L300,'.
      'OUTLANDER,PAJERO,HOGGAR,CLIO,DAUPHINE,DUSTER,FLUENCE,GORDINI,KANGOO,LOGAN,M…GANE,SANDERO,SC…NIC,TWINGO,4RUNNER,AVALON,CAMRY,CELICA,COROLLA,ETIOS,FIELDER,HILUX,LEXUS,PASEO,PRIUS,RAV4,'.
      'TACOMA,TUNDRA,VENZA,AMAROK,APOLLO,BORA,BUGGY,CROSSFOX,EUROVAN,FUSCA,GOLF,GOL,JETTA,KARMANN,GHIA,KOMBI,LOGUS,BEETLE,PASSAT,VARIANT,POINTER,SAVEIRO,SCIROCCO,SP2,SPACEFOX,TIGUAN,TOUAREG,'.
      'VAN,VOYAGE,FURGOVAN,MARRU¡,147,BERLINA,SPIDER,TOWNER,DB7,DB9,DBS,VANQUISH,VIRAGE,RS3,RS4,RS5,RS6,RS7,SQ5,TTS,BUGGY,CADILLAC,TIGGO,CARAVAN,AIRCROSS,BERLINGO,DAKOTA,DURANGO,JOURNEY,VIPER,'.
      'FURG√O,PICAPE,VAN,HUMMER,BRAVA,SUPERMINI,IVECO,CHEROKEE,RENEGADE,BESTA,CADENZA,CARNIVAL,CERATO,PICANTO,SORENTO,LAIKA,NIVA,FREELANDER,AMG,MICRO‘NIBUS,SPRINTER,VITO,COUNTRYMAN,ROADSTER,'.
      'PAJERO,FRONTIER,LIVINA,MURANO,SENTRA,TIIDA,XTERRA,TROLLER,IMPREZA,VITARA,SX4,Lada,Uaz,Zil,Holden,Perodua,Kia,Ssangyoung,Mahindra,Koenigsegg,Saab,Scania,Volvo,Skoda Auto,Tatra,Subaru,'.
      'Mazda,Mitsuoka,Nismo,Acura ,Daihatsu,Datsun,Honda,Isuzu,Pagani,Lancia,Abarth,Morgan,Noble,Ginetta,Jaguar,Lagonda,McLaren,Ariel,entley,Caterham,Alpine,Bugatti,Tianjin,Trumpchi,Wuling,'.
      'Hafei,Haima,Hongqi,Maxus,Faw,Fengshen,Geely,Gleagle,Gonow,Changhe,Chery,Donfeng,Emgrand,Englon,Baojun,Bestum,Panoz,Trucks,Scion,Shelby,SSC,TesiaMustang,GMC,Fisker,Buick,Ruf,Wiesmann,'.
      'Gumpert,pallas,‘NIBUS,VW,HYUNDAI';
    $imoveis_possiveis='CASA,CASAS,SALA,APARTAMENTO,APARTAMENTOS,SOBRADO,SOBRADOS,RESIDENCIAL,TERRENO,TERRENOS,CHACARA,CHACARA,SITIO,SITIO,LOJA,LOJAS,FAZENDA';

    $veiculos_explodido = explode(",", str_replace(':','',str_replace(' ',',',strtoupper(strtr($veiculos_possiveis, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC")))));
    $imoveis_explodido = explode(",", str_replace(':','',str_replace(' ',',',strtoupper(strtr($imoveis_possiveis, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC")))));

    $texto_explodido = explode(",", str_replace(':','',str_replace(' ',',',strtoupper(strtr($texto, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC")))));

    if ( in_array('SUCATA', $texto_explodido) || in_array('SUCATAS', $texto_explodido) || in_array('DESMONTE', $texto_explodido)){ return array('SUCATA');}
    if ( in_array('IMOVEL', $texto_explodido) || in_array('IMOVEIS', $texto_explodido)){ goto imoveis;}
    for ($i=0; $i<count($veiculos_explodido); $i++) {
      if ( $veiculos_explodido[$i]!='' && in_array($veiculos_explodido[$i], $texto_explodido)){return array('VEÕCULOS',$veiculos_explodido[$i]);}
    }
    if ( in_array('VEICULO', $texto_explodido) || in_array('VEICULOS', $texto_explodido) || in_array('IPVA', $texto_explodido) || in_array('CHASSI', $texto_explodido) || in_array('RENAVAM', $texto_explodido)){ return array('VEÕCULOS');}
    imoveis:
    for ($i=0; $i<count($imoveis_explodido); $i++) {
      if ( $imoveis_explodido[$i]!='' &&  in_array($imoveis_explodido[$i], $texto_explodido)){return array('IM”VEIS',$imoveis_explodido[$i]);}
    }
    if ( in_array('IMOVEL', $texto_explodido) || in_array('IMOVEIS', $texto_explodido) || in_array('IPTU', $texto_explodido)){ return array('IM”VEIS');}
    return array('OUTROS');
}

function consulta_organizador($consulta) {
    global $pdo;
    $statement = $pdo->query("SELECT * FROM organizadores WHERE id='" . $consulta . "'");
    if ($r = $statement->fetch(PDO::FETCH_ASSOC)){
        return IDIOMA_BOX_ORGANIZADOR.': <a href="'.$r['site'].'" target="_blank">'.$r['nome'].'</a>';
    } else {
        return false;
    }
}

function consulta_organizador_nome($consulta) {
    global $pdo;
    $statement = $pdo->query("SELECT * FROM organizadores WHERE id='" . $consulta . "'");
    if ($r = $statement->fetch(PDO::FETCH_ASSOC)){
        return $r['nome'];
    } else {
        return false;
    }
}

function limpascript($texto) {

	$resposta = '';
	$texto='</script>'.$texto;
	while(  $resposta2=isolar($texto.'<script','</script','','<script') ) {
		$texto=isolar($texto.'ß©ßßßß','</script'.$resposta2,'','ß©ßßßß');
		if ($resposta2!=''){$resposta.='<'.$resposta2;}
	}
	return $resposta ;
}

function achamodalidade($consulta) {
    global $pdo;
 if ( $consulta !='' ) {
  $db='ll_modalidades' ;

  setlocale(LC_CTYPE, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
  $consulta = substr(trim(preg_replace("/[^A-Za-z0-9 ]/", "",strtr($consulta, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«∞", "aaaaeeiooouucAAAAEEIOOOUUC∫"))),0,128);

  if (strtolower($consulta)!=str_replace("tomada","",strtolower($consulta)) ){$consulta='TOMADA DE PRE«OS'; }
  if (strtolower($consulta)!=str_replace("cotacao","",strtolower($consulta)) ){$consulta='TOMADA DE PRE«OS'; }
  if (strtolower($consulta)!=str_replace("alienacao","",strtolower($consulta)) ){$consulta='ALIENA«√O'; }
  if (strtolower($consulta)!=str_replace("chamada publica","",strtolower($consulta)) ){$consulta='CHAMADA P⁄BLICA'; }
  if (strtolower($consulta)!=str_replace("concurso","",strtolower($consulta)) ){$consulta='CONCURSO'; }
  if (strtolower($consulta)!=str_replace("credenciamento","",strtolower($consulta)) ){$consulta='CREDENCIAMENTO'; }
  if (strtolower($consulta)!=str_replace("dispensa","",strtolower($consulta)) ){$consulta='DISPENSA'; }
  if (strtolower($consulta)!=str_replace("inexigibilidade","",strtolower($consulta)) ){$consulta='DISPENSA'; }
  if (strtolower($consulta)!=str_replace("contratacao direta","",strtolower($consulta)) ){$consulta='DISPENSA'; }
  if (strtolower($consulta)!=str_replace("compra direta","",strtolower($consulta)) ){$consulta='DISPENSA'; }
  if (strtolower($consulta)!=str_replace("leilao","",strtolower($consulta)) ){$consulta='LEIL√O'; }
  if (strtolower($consulta)!=str_replace("pregao eletr","",strtolower($consulta)) ){$consulta='Pregao Eletronico';}
  if (strtolower($consulta)!=str_replace("registro","",strtolower($consulta)) ){$consulta='REGISTRO DE PRECOS';}
  if ($consulta=='' || strtolower($consulta)!=str_replace("pregao presencial","",strtolower($consulta)) ){$consulta='PREGAO PRESENCIAL';}
  if (strtolower($consulta)!=str_replace("convite","",strtolower($consulta)) ){$consulta='CONVITE';}
  if (strtolower($consulta)!=str_replace("concorrencia","",strtolower($consulta)) && strtolower($consulta)==str_replace("internacional","",strtolower($consulta)) ){$consulta='CONCORR NCIA';}
  if (strtolower($consulta)!=str_replace("concorrencia","",strtolower($consulta)) && strtolower($consulta)!=str_replace("internacional","",strtolower($consulta)) ){$consulta='CONCORR NCIA INTERNACIONAL';}
  if (strtolower($consulta)!=str_replace("impugna","",strtolower($consulta)) ){$consulta='IMPUGNA«√O'; }
  if (strtolower($consulta)!=str_replace("srp","",strtolower($consulta)) ){$consulta='TOMADA DE PRE«OS'; }
  if (strtolower($consulta)!=str_replace("rdc","",strtolower($consulta)) ){$consulta='RDC'; }
  if (str_replace(' ','',str_replace('/','',str_replace(':','',$consulta)))==sonumeros(str_replace(' ','',str_replace('/','',str_replace(':','',$consulta)))) ){$consulta='Pregao Eletronico';}
  if ( str_replace(sonumeros(str_replace('.','',str_replace(' ','',str_replace('/','',str_replace(':','',$consulta))))),'',str_replace('.','',str_replace(' ','',str_replace('/','',str_replace(':','',$consulta))))) == 'LEI' ){$consulta='Pregao Eletronico';}
  $consulta=str_replace("N∫","",strtoupper($consulta));

  $sql="SELECT id FROM " . $db . " WHERE CONVERT(txt using utf8)='" . $consulta . "'";
  $res = $pdo->query( $sql );
  $numero_de_linhas = $res->rowCount();

  if ( $numero_de_linhas==0 ) {
   // cadastra nova modalidade

   $consulta0 = strtoupper($consulta);
   $pdo->exec("INSERT INTO " . $db . " (txt) VALUES ('" . $consulta0 . "')");

      // envia e-mail quando h· novo cadastro
   /*mail (EMAIL, 'TÈcnico: Nova Modalidade ' . $consulta0 , 'Nova modalidade cadastrada: ' . $consulta0 . '
       Requer an·lise da tabela ll_modalidades para inspeÁ„o de possÌveis erros.' , "From: ".EMAIL . "\r\nContent-type: text/html; charset=iso-8859-1\r\n");*/
   envia_mail_interno ('TÈcnico: Nova Modalidade ' . $consulta0,array(array('titulo' => 'Nova Modalidade ' . $consulta0,'conteudo' => 'Nova modalidade cadastrada: ' . $consulta0 . '
       Requer an·lise da tabela ll_modalidades para inspeÁ„o de possÌveis erros.')));

   $sql="SELECT id FROM " . $db . " WHERE  CONVERT(txt using utf8)='" . $consulta0 . "'";
  }

  $statement = $pdo->query($sql);
  $r = $statement->fetch(PDO::FETCH_ASSOC);
  return $r['id'];
 } else {
  return false;
 }
}

function consultamodalidade($consulta,$id=false) {
    return true;
}

function achanatureza($consulta) {
    return true;
}

function consultanatureza($consulta,$id=false) {
    return true;
}

function achatipos($consulta) {
    return true;
}
function consultatipos($consulta) {
    return true;
}

function achaparticip($consulta) {
    return true;
}

function consultaparticip($consulta) {
    return true;
}

function achasituacao($consulta) {
    return true;
}
function consultasituacao($consulta) {
    return true;
}

function achasite($consulta,$licitacao) {
    return true;
}

function achaultimasite($consulta) {
    return true;
}

function consultaconfig($parametro) {
    return true;
}


function verifica_pre_cadastro(){
    return false;
}

function achaprimeiraaguardando($consulta) {
    return true;
}

function achaprimeiranaofim($consulta,$forÁaconsulta=false) {
    return true;
}

function achaultimamodificacao($consulta) {
    return true;
}

function consultasite($consulta) {
    return true;
}

function achatratamento($consulta) {
    return true;
}
function consultatratamento($consulta) {
    return true;

}

function achatipolote($consulta) {
    return true;

}
function consultatipolote($consulta) {
    return true;

}

function achacriteriolote($consulta) {
    return true;

}
function consultacritlote($consulta) {
    return true;

}

function achasituacaolote($consulta) {
    return true;

}
function consultasitlote($consulta) {
    return true;

}

function contadb_leiloes($texto,$organizador){
    return true;

}

function ehnoturno() {
  if ( date("H")>=NOVAS_HORA_INICIAL && date("H")<NOVAS_HORA_FINAL && date("N")!=7 ){
    // È diurno
    // verifica se j· È s·bado apÛs 12h
    if (date("N")==6 && date("H")>=12){
		return true;
	} else {
		return false;
	}
  } else {
    return true;
  }
}

function update_historico($tempo_processamento,$novos,$novos_lotes,$pre_cadastros,$aguardando,$mudancas_status){
    return true;

}

function grifapalavra($texto, $palavra, $grifo, $grifofim,$caracteres_min=3,$permite_explosao=true,$grifatodas=true,$qualquerposicao=true){

$resposta = '';

 if ( strlen ($texto) > 0  && strlen ($palavra) > 0) {
  $texto0=' ' . $texto; // EspaÁo inicial inserido para o caso da palavra chave estar no inÌcio do texto (posiÁ„o 0). Ser· retirado depois
  $texto = $texto0;
  if ($grifo=='' || $grifofim =='') { $grifo='<b>'; $grifofim='</b>';}
  // Retira acentos para comparaÁ„o
  $textosa = strtr($texto, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«.,;-/ ", "aaaaeeiooouucAAAAEEIOOOUUC______");

  if ($permite_explosao==true){
	  $palavrasexplodidas = explode(" ", str_replace(","," ",$palavra));
  } else {
	  $palavrasexplodidas = array($palavra);
  }
  for ($i=0; $i<count($palavrasexplodidas); $i++) {
    //$palavrasexplodidas[$i]
    $palavrasa = strtr($palavrasexplodidas[$i], "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹« ", "aaaaeeiooouucAAAAEEIOOOUUC_");
    if (strlen($palavrasa)>=$caracteres_min){

		$caract=0;
	//    $inicio=(int)stripos($textosa,$palavrasa,$caract);
		if ($qualquerposicao==true){
			$inicio=proxima_ocorrÍncia_limpa($textosa,$palavrasa,$caract);
		} else {
			$inicio=proxima_ocorrÍncia_limpa($textosa,'_'.$palavrasa.'_',$caract);
			if ($inicio>0){$inicio+=1;}
		}
		while ($inicio>0){
		  $resposta = substr($texto,0,$inicio) . $grifo . substr($texto,$inicio,strlen($palavrasexplodidas[$i])) . $grifofim . substr($texto,(-1*( strlen($texto)-strlen($palavrasexplodidas[$i])-$inicio )),( strlen($texto)-strlen($palavrasexplodidas[$i])-$inicio )) ;
		  $texto=$resposta;
		  $textosa = strtr($texto, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹« ", "aaaaeeiooouucAAAAEEIOOOUUC_");
		  $caract=$inicio+strlen($grifo)+strlen($grifofim)+strlen($palavrasexplodidas[$i]);
	//      $inicio=(int)(stripos  ($textosa,$palavrasa,$caract));
		  if ($grifatodas==true){
			  //$inicio=proxima_ocorrÍncia_limpa($textosa,$palavrasa,$caract);
			if ($qualquerposicao==true){
				$inicio=proxima_ocorrÍncia_limpa($textosa,$palavrasa,$caract);
			} else {
				$inicio=proxima_ocorrÍncia_limpa($textosa,' '.$palavrasa.' ',$caract);
				if ($inicio>0){$inicio+=1;}
			}
		  }else{$inicio=0;}
		}
	}
  }
  if (strlen($resposta)>0) { $resposta = substr ( $resposta, (-1*(strlen($resposta)-1)) );} // Retira o espaÁo inicial
 }
 if ($resposta==''){$resposta=$texto;}
 return $resposta ; //. '<br>';
}

function semacentos($palavra){
	    return strtr($palavra, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAEEEIIOOOOUUUC");
}

function proxima_ocorrÍncia_limpa ($texto,$ocorrencia,$inicial){
 // informa a prÛxima ocorrencia no texto, partindo do caractere inicial, sem html

 if ($texto!='' && $ocorrencia !=''){
  $parar=0;
  while ($parar == 0){
    $proxima=(int)stripos($texto,$ocorrencia,$inicial);

    $proximahtml_inicio=(int)stripos($texto,'<',$proxima);
    $proximahtml_fim=(int)stripos($texto,'>',$proxima);
    if ( ($proximahtml_inicio>0 || $proximahtml_fim>0) && $proxima>0) {
     //h· html
     if ( $proximahtml_inicio > $proximahtml_fim || ($proximahtml_inicio==0 && $proximahtml_fim>0) ) {
       // palavra est· no html
       $inicial = $proxima+strlen($ocorrencia);
     } else {
       // palavra n„o est· no html
       $parar=1;
     }
    } else {
      // n„o h· html
      $parar=1;
    }
  }
  return $proxima;
 } else {
   return 0;
 }
}


function mostra_imagem($src, $alt = '', $width = '', $height = '', $parameters = '', $stretch='false', $rapido=false) {
    $dir_imagens = '../../licita/imagens/';
    if ( (empty($src) || ($src == $dir_imagens)) ) {
      $src = $dir_imagens . 'imagemnaodisponivel.jpg';
    }
//$src = str_replace('./','',str_replace('./','',str_replace('./','',str_replace('../','',str_replace('../','',str_replace('../','',$src))))));
    $src_mostra=$src;


    //if (strpos($src,'http')==FALSE){$src_mostra = BASE_URL . str_replace('./','',str_replace('./','',str_replace('./','',str_replace('../','',str_replace('../','',str_replace('../','',$src))))));}
    if (str_replace('http','',$src)==$src){$src_mostra = BASE_URL . str_replace('./','',str_replace('./','',str_replace('./','',str_replace('../','',str_replace('../','',str_replace('../','',$src))))));}
//return $src.'<br>'.$src_mostra;
// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
    $image = '<img src="' . tep_output_string($src_mostra) . '" border="0" alt="' . tep_output_string($alt) . '"';
    if (tep_not_null($alt)) {
      $image .= ' title=" ' . tep_output_string($alt) . ' "';
    }
		if ($rapido==false){
			$image_size = @getimagesize($src);
			if (!$image_size){$image_size = @getimagesize($src_mostra);}

			if ($image_size)
			{
				if (empty($width) && tep_not_null($height))
				{
					if (($image_size[1] < $height) && ($stretch=='false'))
					{
						// EC - if width hasn't been passed in, the image height is smaller than the setting, and stretch is false, use original dimensions
						$width=$image_size[0];
						$height=$image_size[1];
					}
					else
					{
						// EC - if width hasn't been passed, and the image height is larger than the setting, height ends up as the setting and width is modified to suit
				  	$ratio = $height / $image_size[1];
				  	$width = $image_size[0] * $ratio;
					}
				}
				elseif (tep_not_null($width) && empty($height))
				{
						// EC - if height hasn't been passed in, the image width is smaller than the setting, and stretch is false, use original dimensions
					if (($image_size[0] < $width) && ($stretch=='false'))
					{
						$width=$image_size[0];
						$height=$image_size[1];
					}
					else
					{
						// EC - if height hasn't been passed, and the image width is larger than the setting, width ends up as the setting and height is modified to suit
					  $ratio = $width / $image_size[0];
					  $height = $image_size[1] * $ratio;
					}
				}
				elseif (empty($width) && empty($height))
				{
					// EC - if neither height nor width are passed in, just use the original dimensions
				  $width = $image_size[0];
				  $height = $image_size[1];
				}
				//EC - added the following elseif for calculating based on stretch/no-stretch
				elseif (tep_not_null($width) && tep_not_null($height))
				{
					if ((($image_size[0] > $width) || ($image_size[1] > $height)) && ($stretch=='false'))
					{
						// EC - if width and height are both passed in, either original height or width are larger than the setting, and stretch is false, resize both dimensions to suit
						$new_ratio=$height / $width;
						$image_ratio=$image_size[1] / $image_size[0];
						if ($new_ratio >= $image_ratio)
						{
							$height=$image_size[1]*($width/$image_size[0]);
						}
						else
						{
							$width=$image_size[0]*($height/$image_size[1]);
						}
					}
					elseif ($stretch=='false')
					{
						// EC - if we got here, both width and height have been passed in, both original height and width are smaller than setting, and stretch is set to false. So just use original dimensions.
						$width=$image_size[0];
						$height=$image_size[1];
					}
				}
			}
			else
			{
				return false;
			}


    if (tep_not_null($width) && tep_not_null($height)) {
      $image .= ' width="' . tep_output_string($width) . '" height="' . tep_output_string($height) . '"';
    }
	}

    if (tep_not_null($parameters)) $image .= ' ' . $parameters;

    $image .= '>';

    return $image;
}

  function tep_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
      return htmlspecialchars($string);
    } else {
      if ($translate == false) {
        return tep_parse_input_field_data($string, array('"' => '&quot;'));
      } else {
        return tep_parse_input_field_data($string, $translate);
      }
    }
  }
// Parse the data used in the html tags to ensure the tags will not break
function tep_parse_input_field_data($data, $parse) {
    return strtr(trim($data), $parse);
}

function tep_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
}

function valida_degustacao($cnpj,$nome,$email,$fone,$ip){
    return true;
}

function achacliente($cnpj) {
    return true;

}

function achacnpj ($idcliente) {
    return true;

}

function mostra_dias_utilizacao($cnpj) {
    return true;

}

function atualiza_degustacao_cadastro($cnpj, $nome, $email, $fone){
    return true;

}

function inicia_cliente($cnpj){
    return true;

}

function atualiza_degustacao_ip($ip){
    return true;

}

function validacnpj($cnpj){
    $clvrerro = 0 ;
    $RecebeCPF=sonumeros($cnpj);
    if (strlen($RecebeCPF) != 11 || $RecebeCPF=="00000000000") {
        $then;
        $clvrerro = 1 ;
    }else{
        $Numero[1]=intval(substr($RecebeCPF,1-1,1)); $Numero[2]=intval(substr($RecebeCPF,2-1,1)); $Numero[3]=intval(substr($RecebeCPF,3-1,1)); $Numero[4]=intval(substr($RecebeCPF,4-1,1)); $Numero[5]=intval(substr($RecebeCPF,5-1,1)); $Numero[6]=intval(substr($RecebeCPF,6-1,1)); $Numero[7]=intval(substr($RecebeCPF,7-1,1)); $Numero[8]=intval(substr($RecebeCPF,8-1,1)); $Numero[9]=intval(substr($RecebeCPF,9-1,1)); $Numero[10]=intval(substr($RecebeCPF,10-1,1)); $Numero[11]=intval(substr($RecebeCPF,11-1,1));
        $soma=10*$Numero[1]+9*$Numero[2]+8*$Numero[3]+7*$Numero[4]+6*$Numero[5]+5*
        $Numero[6]+4*$Numero[7]+3*$Numero[8]+2*$Numero[9];
        $soma=$soma-(11*(intval($soma/11)));
        if ($soma==0 || $soma==1) { $resultado1=0; } else { $resultado1=11-$soma; }
        if ($resultado1==$Numero[10]) {
            $soma=$Numero[1]*11+$Numero[2]*10+$Numero[3]*9+$Numero[4]*8+$Numero[5]*7+$Numero[6]*6+$Numero[7]*5+
            $Numero[8]*4+$Numero[9]*3+$Numero[10]*2;
            $soma=$soma-(11*(intval($soma/11)));
            if ($soma==0 || $soma==1) { $resultado2=0; } else { $resultado2=11-$soma; }
            if ($resultado2 != $Numero[11]) { $clvrerro = 1 ; }
        }else{
            $clvrerro = 1 ;
        }
    }
    // se $clvrerro = 1 n„o È cpf v·lido; checar· cnpj

    if ($clvrerro == 1) {
     $clvrerro = 0 ;
     $RecebeCNPJ=$RecebeCPF;
     if (strlen($RecebeCNPJ) != 14 || $RecebeCNPJ=="00000000000000") {
         $then;
         $clvrerro = 1 ;
     }else{
        $Numero[1]=intval(substr($RecebeCNPJ,1-1,1)); $Numero[2]=intval(substr($RecebeCNPJ,2-1,1)); $Numero[3]=intval(substr($RecebeCNPJ,3-1,1)); $Numero[4]=intval(substr($RecebeCNPJ,4-1,1)); $Numero[5]=intval(substr($RecebeCNPJ,5-1,1)); $Numero[6]=intval(substr($RecebeCNPJ,6-1,1)); $Numero[7]=intval(substr($RecebeCNPJ,7-1,1)); $Numero[8]=intval(substr($RecebeCNPJ,8-1,1)); $Numero[9]=intval(substr($RecebeCNPJ,9-1,1)); $Numero[10]=intval(substr($RecebeCNPJ,10-1,1)); $Numero[11]=intval(substr($RecebeCNPJ,11-1,1)); $Numero[12]=intval(substr($RecebeCNPJ,12-1,1)); $Numero[13]=intval(substr($RecebeCNPJ,13-1,1)); $Numero[14]=intval(substr($RecebeCNPJ,14-1,1));
        $soma=$Numero[1]*5+$Numero[2]*4+$Numero[3]*3+$Numero[4]*2+$Numero[5]*9+$Numero[6]*8+$Numero[7]*7+
        $Numero[8]*6+$Numero[9]*5+$Numero[10]*4+$Numero[11]*3+$Numero[12]*2;
        $soma=$soma-(11*(intval($soma/11)));
        if ($soma==0 || $soma==1) { $resultado1=0; } else { $resultado1=11-$soma; }
        if ($resultado1==$Numero[13]) {
            $soma=$Numero[1]*6+$Numero[2]*5+$Numero[3]*4+$Numero[4]*3+$Numero[5]*2+$Numero[6]*9+
            $Numero[7]*8+$Numero[8]*7+$Numero[9]*6+$Numero[10]*5+$Numero[11]*4+$Numero[12]*3+$Numero[13]*2;
            $soma=$soma-(11*(intval($soma/11)));
            if ($soma==0 || $soma==1) { $resultado2=0; } else { $resultado2=11-$soma; }
            if ($resultado2!=$Numero[14]) { $clvrerro = 1 ; }
        }else{
            $clvrerro = 1 ;
        }
     }
    }

    if ( $clvrerro == 1 ) {
      return false;
    } else {
      return $RecebeCPF;
    }
}

function nomeiadias ($data,$prefixo) {

 if ( $data == date("Ymd") ) {
  return $prefixo . ' ' . IDIOMA_DIA_HOJE ;
 } else {
  if ( $data == datadiferente_dias(date("Ymd"),1) ) {
   return $prefixo . ' ' . IDIOMA_DIA_ONTEM;
  } else {
   if ( $data == datadiferente_dias(date("Ymd"),2) ) {
    return $prefixo . ' ' . IDIOMA_DIA_ANTEONTEM;
   } else {
    return $prefixo . ' ' . mostradata($data) ;
   }
  }
 }
}

function navegador(){
  // detecta navegador utilizado
  // 2020 09 https://stackoverflow.com/questions/11602931/function-getbrowsertype-why-is-chrome-showing-as-mozilla
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
/*
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
*/
    return $bname;
}

function msn_online(){ return '0'; }

function txtboleto ( $txt ){
    return  str_replace(array("&","'"),array("%26","%27"), str_replace(" ","%20",str_replace("+","%2B",str_replace("%","%25",tep_output_string($txt)))) );
}

function boleto_elegivel($idcliente){
    return true;

}


function sicredi_autenticacao (){
    return true;

}

function envia_sicredi_online($dados,$tipo='emissao',$metodo='POST'){
    return true;

}

function digitoVerificador_nossonumero_sicredi($numero) {
	$resto2 = fmodulo_11($numero, 9, 1);
	// esta rotina sofrer algumas alteraÁıes para ajustar no layout do SICREDI
	 $digito = 11 - $resto2;
     if ($digito > 9 ) {
        $dv = 0;
     } else {
        $dv = $digito;
     }
 return $dv;
}

function digitos_verificativos ($n) {

    $Recebe=$n;
    //Retirar todos os caracteres que n„o sejam 0-9
    $s="";
    for ($x=1; $x<=strlen($Recebe); $x=$x+1){
        $ch=substr($Recebe,$x-1,1);
        if (ord($ch)>=48 && ord($ch)<=57) { $s=$s.$ch; }
    }
    $Recebe=$s;
        if (strlen($Recebe) > 8) { $Numero[1]=intval(substr($Recebe,-9,1)); } else { $Numero[1]= 0; }
        if (strlen($Recebe) > 7) { $Numero[2]=intval(substr($Recebe,-8,1)); } else { $Numero[2]= 0; }
        if (strlen($Recebe) > 6) { $Numero[3]=intval(substr($Recebe,-7,1)); } else { $Numero[3]= 0; }
        if (strlen($Recebe) > 5) { $Numero[4]=intval(substr($Recebe,-6,1)); } else { $Numero[4]= 0; }
        if (strlen($Recebe) > 4) { $Numero[5]=intval(substr($Recebe,-5,1)); } else { $Numero[5]= 0; }
        if (strlen($Recebe) > 3) { $Numero[6]=intval(substr($Recebe,-4,1)); } else { $Numero[6]= 0; }
        if (strlen($Recebe) > 2) { $Numero[7]=intval(substr($Recebe,-3,1)); } else { $Numero[7]= 0; }
        if (strlen($Recebe) > 1) { $Numero[8]=intval(substr($Recebe,-2,1)); } else { $Numero[8]= 0; }
        if (strlen($Recebe) > 0) { $Numero[9]=intval(substr($Recebe,-1,1)); } else { $Numero[9]= 0; }

        $soma=10*$Numero[1]+9*$Numero[2]+8*$Numero[3]+7*$Numero[4]+6*$Numero[5]+5*
        $Numero[6]+4*$Numero[7]+3*$Numero[8]+2*$Numero[9];
        $soma =  $soma-(11*(intval($soma/11)));

        if ($soma==0 || $soma==1){
            $resultado1=0;
        } else {
            $resultado1=11-$soma;
        }
        // diferenciaÁ„o dos dv do portal genial:
        $resultado1 += 1;
        if ($resultado1 == 10 ){$resultado1 = 0;}

        $Numero[10] = $resultado1;

        $soma=$Numero[1]*11+$Numero[2]*10+$Numero[3]*9+$Numero[4]*8+$Numero[5]*7+$Numero[6]*6+$Numero[7]*5+
        $Numero[8]*4+$Numero[9]*3+$Numero[10]*2;
        $soma=$soma-(11*(intval($soma/11)));

        if ($soma==0 || $soma==1) {
            $resultado2=0;
        } else {
            $resultado2=11-$soma;
        }
        // diferenciaÁ„o dos dv do portal genial:
        $resultado2 += 1;
        if ($resultado2 == 10 ){$resultado2 = 0;}

        return $resultado1 . $resultado2;

}

function novo_id_investimento () {
     return true;

}

function simbolo_moeda ($moeda){
    global $pdo;
  if ($moeda==''){$moeda='BRL';}
    $statement = $pdo->query("SELECT simbolo FROM moedas WHERE moeda='$moeda'");
    $temp_moeda = $statement->fetch(PDO::FETCH_ASSOC);

  return $temp_moeda['simbolo'];

}

function cria_atalho($encurtada,$url_original,$tipo,$idcliente='',$idlicitacao=''){
    return true;


}


// 3 funÁıes abaixo: extraÌ de http://coding.pressbin.com/6/Convert-tofrom-a-custom-base-in-PHP
function embaralha_base_atalho() {
    return array(0 => 'F', 1 => '6', 2 => '9', 3 => 't', 4 => 'u', 5 => 'B', 6 => 'a', 7 => 'L', 8 => 'm', 9 => 'W', 10 => '8', 11 => 'x', 12 => 'A', 13 => 'n', 14 => 'z', 15 => 'd', 16 => 'M', 17 => '0', 18 => '4', 19 => 'Q', 20 => '3', 21 => 'h', 22 => '1', 23 => 'X', 24 => 'V', 25 => 'w', 26 => 'g', 27 => 'q', 28 => '2', 29 => 'G', 30 => 'i', 31 => 'R', 32 => 'c', 33 => 'T', 34 => 'H', 35 => 'P', 36 => 'C', 37 => 'J', 38 => '7', 39 => 'r', 40 => 'E', 41 => 'p', 42 => 'K', 43 => 'k', 44 => 'U', 45 => 'j', 46 => 'y', 47 => 'e', 48 => 'b', 49 => 'v', 50 => 'N', 51 => 'f', 52 => 'Y', 53 => 'D', 54 => 'Z', 55 => 's', 56 => '5', 57 => 'o', 58 => 'S');
}

function embaralha_base_atalho_consoantes() {
    return array(0 => 'F', 1 => '6', 2 => '9', 3 => 't', 4 => 's', 5 => 'B', 6 => 'Z', 7 => 'L', 8 => 'f', 9 => 'W', 10 => 'x', 11 => 'D', 12 => 'h', 13 => 'n', 14 => 'z', 15 => 'd', 16 => 'M', 17 => '0', 18 => '4', 19 => '2', 20 => '3', 21 => '5', 22 => '1', 23 => 'X', 24 => 'g', 25 => 'w', 26 => 'V', 27 => 'q', 28 => 'Q', 29 => 'G', 30 => 'S', 31 => '8', 32 => 'c', 33 => '7', 34 => 'j', 35 => 'P', 36 => 'Y', 37 => 'J', 38 => 'T', 39 => 'r', 40 => 'R', 41 => 'p', 42 => 'K', 43 => 'k', 44 => 'C', 45 => 'H', 46 => 'y', 47 => 'N', 48 => 'b', 49 => 'v', 50 => 'm');
}

// 3 funÁıes abaixo: extraÌ de http://coding.pressbin.com/6/Convert-tofrom-a-custom-base-in-PHP
function embaralha_base_atalho_maiusculas() {
    return array(0 => '3',  1 => 'W',  2 => 'G',  3 => 'L',  4 => '6',  5 => 'D',  6 => '5',  7 => 'B',  8 => 'M',  9 => '4', 10 => '2', 11 => 'F', 12 => '1', 13 => 'X', 14 => 'V', 15 => 'Q', 16 => '9', 17 => 'R', 18 => 'T', 19 => 'Z', 20 => 'P', 21 => 'C', 22 => 'Y', 23 => 'A', 24 => 'E', 25 => 'K', 26 => 'U', 27 => 'N', 28 => 'J', 29 => '8', 30 => 'S', 31 => 'H', 32 => '7');
}

function embaralha_base_atalho_maiusculas_consoantes() {
    return array( 0 => '3',  1 => 'W',  2 => 'G',  3 => 'L',  4 => '6',  5 => 'D',  6 => '5',  7 => 'B',  8 => 'M',  9 => '4', 10 => '2', 11 => 'F', 12 => '1', 13 => 'X', 14 => 'V', 15 => 'Q', 16 => '9', 17 => 'R', 18 => 'T', 19 => 'Z', 20 => 'P', 21 => 'C', 22 => 'Y', 23 => 'H', 24 => 'K', 25 => 'N', 26 => 'J', 27 => '8', 28 => 'S', 29 => '7');
}

function embaralha_base_atalho_maiusculas_0aZ() {
    return array( 0 => '0',  1 => '1',  2 => '2',  3 => '3',  4 => '4',  5 => '5',  6 => '6',  7 => '7',  8 => '8',  9 => '9', 10 => 'A', 11 => 'B', 12 => 'C', 13 => 'D', 14 => 'E', 15 => 'F', 16 => 'G', 17 => 'H', 18 => 'I', 19 => 'J', 20 => 'K', 21 => 'L', 22 => 'M', 23 => 'N', 24 => 'O', 25 => 'P', 26 => 'Q', 27 => 'R', 28 => 'S', 29 => 'T', 31 => 'U', 32 => 'V', 33 => 'W', 34 => 'X', 35 => 'Y', 36 => 'Z');
}

function custom_to_ten($number,$x=0) {
  if ($x == 0) {
      $n = embaralha_base_atalho();
  } else {
    if ($x == 1) {
        $n = embaralha_base_atalho_maiusculas();
    } else {
      if ($x == 2) {
        $n = embaralha_base_atalho_maiusculas_consoantes();
      } else {
		  if ($x == 4) {
			$n = embaralha_base_atalho_maiusculas_0aZ();
		  } else {
			$n = embaralha_base_atalho_consoantes();
		  }
      }
    }
  }
  $reverse = strrev($number);
   for ($i = 0; $i < strlen($reverse); $i++) {
      $letter = substr($reverse, $i, 1);
      $val = array_search($letter, $n);
      $total = $total + ($val * pow(count($n), $i));
   }
   return $total;
}


function ten_to_custom($number,$x=0) {
  if ($x == 0) {
      $n = embaralha_base_atalho();
  } else {
    if ($x == 1) {
        $n = embaralha_base_atalho_maiusculas();
    } else {
      if ($x == 2) {
        $n = embaralha_base_atalho_maiusculas_consoantes();
      }else{
		  if ($x == 4) {
			$n = embaralha_base_atalho_maiusculas_0aZ();
		  }else{
			$n = embaralha_base_atalho_consoantes();
		  }
      }
    }
  }
   $base = count($n);
   do {
      $mod = $number % $base;
      $string = $n[$mod] . $string;
      $number = ($number - $mod) / $base;
   }
   while($number > 0);
   return $string;
}

function atualiza_aguardando(){
    return true;
}
function atualiza_nao_aguardando($tempo){
    return true;


}

function acessos_dia_anterior() {
    return true;

}

function substitui_txt($texto,$antigo,$novo){
    // funÁ„o para substituir textos prÈ-programados em e-mail
    if ($antigo!=''){
        // existe algo a substituir
        $texto_analisado= $texto;
        while (strpos($texto_analisado, "{") >0 && strpos($texto_analisado, "}") >0 ) {
            $procura=isolar($texto_analisado, '{', '', '}') ;
            if (strpos($procura, $antigo)>0){
                if (str_replace(" ","",$novo)==''){
                    $procura_novo = '';
                } else {
                    $procura_novo=str_replace($antigo,$novo,$procura);
                }
                $texto=str_replace("{".$procura."}",$procura_novo,$texto);
            }
            $texto_analisado=str_replace("{".$procura."}","",$texto_analisado);
        }
        $texto=str_replace($antigo,$novo,$texto);
        return $texto;
    } else {
        return $texto;
    }
}

function autoriza_precad_robos ($organizador,$tipo='consulta') {
    return true;
}

function autoriza_precad_robos_botll_consulta () {
    return true;
}

function arrumadata_robos ($texto,$tipo='1',$invertemes=false) {

	// tipo 7: Y m d H i
  if ((int)sonumeros($texto)==0){
      return false;
  }
  if ($tipo=='6'){
	$meses = array("JAN" => "01","FEB" => "02","MAR" => "03","APR" => "04","MAY" => "05","JUN" => "06","JUL" => "07","AUG" => "08","SEP" => "09","OCT" => "10","NOV" => "11","DEC" => "12");
	$mesesbr = array("JAN" => "01","FEV" => "02","MAR" => "03","ABR" => "04","MAI" => "05","JUN" => "06","JUL" => "07","AGO" => "08","SET" => "09","OUT" => "10","NOV" => "11","DEZ" => "12");
	$texto=strtoupper($texto);
	$texto=str_replace(" de ",' ',str_replace(', a partir das ','/',str_replace('min.','',str_replace('‡s','/',str_replace('horas','/',str_replace(' s ','/',str_replace(' „','/',$texto)))))));
	$texto=str_replace(":","/",str_replace("-","/",preg_replace('/\s\s+/', ' ',str_replace(".","/",$texto))));
	$data0 = explode("/", $texto);
	$texto2='';
	for ($i=0; $i<count($data0); $i++) {
		if ($meses[$data0[$i]]!=''){
			$texto2 .= $meses[$data0[$i]];
		} else {
			if ($mesesbr[$data0[$i]]!=''){
				$texto2 .= $mesesbr[$data0[$i]];}else{$texto2.=$data0[$i];
			}
		}


		$texto2 .='/';
	}
	$texto2=str_replace('h','/',$texto2);
	$texto2=str_replace(" ","",$texto2);
	$data1 = explode("/", $texto2);
	$incremento=0;
	if ($texto!=''){
		while ((int)$data1[$incremento]==0){$incremento+=1;}
		if ($data1[$incremento+2]<100){$data1[$incremento+2]+=2000;}
		if ($data1[$incremento+6]=='PM'){$data1[$incremento+3]+=12;}

		  if ($invertemes==false){
			return trim(sprintf("%40d", (int)$data1[$incremento+2]) . sprintf("%02d", (int)preg_replace("/[^a-zA-Z0-9_]/", "",$data1[$incremento])) . sprintf("%02d", (int)$data1[$incremento+1]) . sprintf("%02d", (int)$data1[$incremento+3]) . sprintf("%02d", (int)$data1[$incremento+4]) );
		  } else {
			if ($data1[$incremento+5]=='PM'){$data1[$incremento+3]+=12;}
			return trim(sprintf("%40d", (int)$data1[$incremento+2]) . sprintf("%02d", (int)preg_replace("/[^a-zA-Z0-9_]/", "",$data1[$incremento+1])) . sprintf("%02d", (int)$data1[$incremento]) . sprintf("%02d", (int)$data1[$incremento+3]) . sprintf("%02d", (int)$data1[$incremento+4]) );
		  }
	}
  }
  if ($tipo=='5'){
	$meses = array("janeiro" => "/01/","fevereiro" => "/02/","marÁo" => "/03/","abril" => "/04/","maio" => "/05/","junho" => "/06/","julho" => "/07/","agosto" => "/08/","setembro" => "/09/","outubro" => "/10/","novembro" => "/11/","dezembro" => "/12/",);
	$texto=strtolower($texto);
	$texto=str_replace(" de ",' ',str_replace(', a partir das ','/',str_replace('min.','',str_replace('‡s','/',str_replace('horas','/',str_replace(' s ','/',str_replace(' „','/',$texto)))))));
	$texto=str_replace(":","/",str_replace("-","/",preg_replace('/\s\s+/', ' ',str_replace(".","/",$texto))));
	$data0 = explode(" ", $texto);
	$texto2='';
	for ($i=0; $i<count($data0); $i++) {
		if ($meses[$data0[$i]]!=''){$texto2 .= $meses[$data0[$i]];}else{$texto2.=$data0[$i];}
	}

	$data0 = explode("/", $texto2);
	$texto2='';
	for ($i=0; $i<count($data0); $i++) {
		if ($texto2!=''){$texto2.='/';}
		if ($meses[$data0[$i]]!=''){$texto2 .= $meses[$data0[$i]];}else{$texto2.=$data0[$i];}
	}
	$texto2=str_replace('//','/',$texto2);


	$texto2=str_replace('h','/',$texto2);
	$texto2=limpacaracteresfantasma(str_replace(" ","",$texto2));
	$data1 = explode("/", $texto2);
	$incremento=0;
	if ($texto!=''){
		while ((int)sonumeros_sem_virgula ($data1[$incremento])==0){$incremento+=1;}
		if ($data1[$incremento+2]<100){$data1[$incremento+2]+=2000;}
				if ($data1[$incremento+5]=='PM'){$data1[$incremento+3]+=12;}
        return trim(sprintf("%40d", (int)$data1[$incremento+2]) . sprintf("%02d", (int)$data1[$incremento+1]) . sprintf("%02d", (int)preg_replace("/[^a-zA-Z0-9_]/", "",$data1[$incremento])) . sprintf("%02d", (int)$data1[$incremento+3]) . sprintf("%02d", (int)$data1[$incremento+4]) );
	}
  }
  if ($tipo=='2'||$tipo=='4'){
    $texto=str_replace(" ","/",$texto);
    if ($tipo=='2'){$tipo='1';}else{$tipo='3';}
  }
  if ($tipo=='1'||$tipo=='3'||$tipo=='7'){
      if ($tipo=='1'){$texto=str_replace(" ","",str_replace(":","/",str_replace("-","/",preg_replace('/\s\s+/', ' ',str_replace(".","/",$texto)))));}
      if ($tipo=='3'){$texto=str_replace(" ","",str_replace(":","/",str_replace("-","/",preg_replace('/\s\s+/', ' ',$texto))));}
      $data1 = explode("/", $texto);
      $incremento=0;
      if ($texto!=''){

          while ((int)$data1[$incremento]==0 && $incremento<200){$incremento+=1;}
			if ($tipo!='7'){
			  if ($data1[$incremento+2]<100){$data1[$incremento+2]+=2000;}
			  if ($data1[$incremento+2]>(date("Y")+3)){return false;}
			  if ($invertemes==false){
				  if ((int)$data1[$incremento]>31){$data1[$incremento]=0;}
				return trim(sprintf("%40d", (int)$data1[$incremento+2]) . sprintf("%02d", (int)$data1[$incremento+1]) . sprintf("%02d", (int)$data1[$incremento]) . sprintf("%02d", (int)$data1[$incremento+3]) . sprintf("%02d", (int)$data1[$incremento+4]) );
			  } else {
				  if ((int)$data1[$incremento+1]>31){$data1[$incremento+1]=0;}
				if ($data1[$incremento+5]=='PM'){$data1[$incremento+3]+=12;}
				return trim(sprintf("%40d", (int)$data1[$incremento+2]) . sprintf("%02d", (int)$data1[$incremento]) . sprintf("%02d", (int)$data1[$incremento+1]) . sprintf("%02d", (int)$data1[$incremento+3]) . sprintf("%02d", (int)$data1[$incremento+4]) );
			  }
		  } else {
			  if ($data1[$incremento]<100){$data1[$incremento]+=2000;}
			  if ($data1[$incremento]>(date("Y")+3)){return false;}
			  if ($invertemes==false){
				return trim(sprintf("%40d", (int)$data1[$incremento]) . sprintf("%02d", (int)$data1[$incremento+1]) . sprintf("%02d", (int)$data1[$incremento+2]) . sprintf("%02d", (int)$data1[$incremento+3]) . sprintf("%02d", (int)$data1[$incremento+4]) );
			  } else {
				if ($data1[$incremento+5]=='PM'){$data1[$incremento+3]+=12;}
				return trim(sprintf("%40d", (int)$data1[$incremento]) . sprintf("%02d", (int)$data1[$incremento+2]) . sprintf("%02d", (int)$data1[$incremento+1]) . sprintf("%02d", (int)$data1[$incremento+3]) . sprintf("%02d", (int)$data1[$incremento+4]) );
			  }
		  }
      }
  }
}

function http_post ($url, $data, $ref='',$cook=''){
    // $data È um array com os valores do post
    // retorna outro vetor, onde o conte˙do est· em ['content']
    // $ref = HTTP REFERER
    if ($data!=''){$data_url = http_build_query ($data);}
//echo '$data_url=['.$data_url.']';
    $data_len = strlen ($data_url);
    if ($ref!=''){$referer= "Referer: $ref\r\n";} else {$referer='';}
    if ($cook!=''){$cookie= "Cookie: $cook\r\n";} else {$cookie='';}

// no vetor de retorno: [content] È o html da p·gina; [headers]; aqui, encontre os cookies
    return array ('content'=>file_get_contents ($url, false, stream_context_create (array ('http'=>array ('method'=>'POST'
            , 'header'=>"Connection: close\r\nContent-Length: $data_len\r\n".$referer.$cookie
            , 'content'=>$data_url
            ))))
        , 'headers'=>$http_response_header
        );
}


function http_post_curl2 ($url, $fields, $agente, $cookies='',$obtemcookies=false, $versaossl=false,$ssl_ignora=false,$referer=''){
	/*
	 * exemplo de envio de post com cookies:

$html=http_get_curl('http://www.samaecaxias.com.br/editais',true,true);
$cabecalio= explode(chr(13),isolar('ß'.$html,'ß','','Date:'));
$cookies=extrai_cookies('',$cabecalio);
$url= isolar($html,'<form method="post" action="','','"');
$data = array("pagina" => '0',
	"palavraChave" => '',
	"dataInicial" => '',
	"dataFinal" => '',
	"modalidadeId" => '0',
	"situacaoEditalId" => '45');
echo http_post_curl ($url, $data, 'ie',$cookies);

ou
*
		$texto=char_convert(http_post_curl ('http://servicos.searh.rn.gov.br/searh/Licitacao/Licitacao', $data,'ie',$cookie0,true));
		$cookie = isolar($texto,'Set-Cookie: ','',chr(13));

	*/

	// exemplo: 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'
	if ($agente){$useragent='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13';}
	if ($agente=='ie'){$useragent='Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Win64; x64; Trident/6.0)';}

	//url-ify the data for the POST
	if ($fields!=''){
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	}

	//open connection
	$ch = curl_init();
	$timeout = 5;

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	if ($useragent!=''){
		curl_setopt($ch, CURLOPT_USERAGENT,$useragent);
	}
	if ($fields!=''){
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	}
	if ($cookies!=''){curl_setopt ($ch, CURLOPT_COOKIE, $cookies );}
	if ($obtemcookies==true){curl_setopt($ch, CURLOPT_HEADER, 1);}
	if ($versaossl!=false){curl_setopt($ch, CURLOPT_SSLVERSION, $versaossl);}
	if ($ssl_ignora==true){curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);}
	if ($referer!=''){curl_setopt($ch, CURLOPT_REFERER, $referer);}

	//execute post
	$result = curl_exec($ch);
	//close connection
	curl_close($ch);
	$result= str_replace("'","",str_replace("∞","∫",limpacaracteresisolatin1(limpacaracteresutf8(str_replace("&nbsp;"," ",$result)))));

    return array ('content'=>$result, 'headers'=>$http_response_header );


}



function http_post_curl ($url, $fields, $agente, $cookies='',$obtemcookies=false){
	/*
	 * exemplo de envio de post com cookies:

$html=http_get_curl('http://www.samaecaxias.com.br/editais',true,true);
$cabecalio= explode(chr(13),isolar('ß'.$html,'ß','','Date:'));
$cookies=extrai_cookies('',$cabecalio);
$url= isolar($html,'<form method="post" action="','','"');
$data = array("pagina" => '0',
	"palavraChave" => '',
	"dataInicial" => '',
	"dataFinal" => '',
	"modalidadeId" => '0',
	"situacaoEditalId" => '45');
echo http_post_curl ($url, $data, 'ie',$cookies);

ou
*
		$texto=char_convert(http_post_curl ('http://servicos.searh.rn.gov.br/searh/Licitacao/Licitacao', $data,'ie',$cookie0,true));
		$cookie = isolar($texto,'Set-Cookie: ','',chr(13));

	*/

	// exemplo: 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'
	if ($agente)      {$useragent='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13';}
	if ($agente=='ie'){$useragent='Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Win64; x64; Trident/6.0)';}

	//url-ify the data for the POST
	if ($fields!=''){
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	}

	//open connection
	$ch = curl_init();
	$timeout = 5;

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	if ($useragent!=''){
		curl_setopt($ch, CURLOPT_USERAGENT,$useragent);
	}
	if ($fields!=''){
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	}
	if ($cookies!=''){curl_setopt ($ch, CURLOPT_COOKIE, $cookies );}
	if ($obtemcookies==true){curl_setopt($ch, CURLOPT_HEADER, 1);}

	//execute post
	$result = curl_exec($ch);
	//close connection
	curl_close($ch);
	return str_replace("'","",str_replace("∞","∫",limpacaracteresisolatin1(limpacaracteresutf8(str_replace("&nbsp;"," ",$result)))));
}

function http_post_curl_headers ($url, $header, $fields, $cookies='',$limpa=true, $json=false, $xml=false, $json_montado='',$ssl_ignora=false,$request="POST"){
	/*
	* posta com header. Extraia do firefox, F12 aba "Console". Veja se o POST È feito com json no firefox
	*
	* exemplo:
 	$header= "-H 'Host: www4.tjrj.jus.br' -H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:46.0) Gecko/20100101 Firefox/46.0' -H 'Accept: text/html,application/ (...)
	$fields = array('ctl00$SISLICWEB$ScriptManager1' => str_replace('AccordionPane1%24content','AccordionPane1_content',str_replace('_','%24',colocaescape('ctl00$SISLICWEB$UPSislic|'.$link))),
		'ctl00_SISLICWEB_ScriptManager1_HiddenField' => '',
		* (...)
		'__ASYNCPOST' => 'true');
	$resposta=http_post_curl_headers ('http://www4.tjrj.jus.br/Sislicweb/lic_dados.aspx', $header, $fields);
	$texto = $resposta['content'];
	*
	*/

	if (!is_array($header)){
		// quebra header fornecido pelo Firefox
		$header0=$header;
		$header=array();
		$header = explode("-H ", str_replace("'",'',$header0));
		$header=array_filter(array_map('trim', $header));
		//print_r($header);
	}
$fields_string='';
	if ($fields!=''){
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
	}


	//open connection
	$ch = curl_init();
	$timeout = 5;

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	if ($fields!=''){
		if ($json){
			$fields_string = json_encode($fields);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		} else {
			if ($xml!=false){
				curl_setopt($ch,CURLOPT_POST, 1);
				curl_setopt($ch,CURLOPT_POSTFIELDS, $xml);
			} else {
				if ($fields_string!=''){
					curl_setopt($ch,CURLOPT_POST, count($fields));
					curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
				}
			}
		}
	} else {
		if ($json==true && $json_montado!=''){
			$fields_string = $json_montado;
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		}
	}
	if ($ssl_ignora==true){curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);}
	if ($cookies!=''){curl_setopt ($ch, CURLOPT_COOKIE, $cookies );}
	$result = curl_exec($ch);

	// quebra o gzip
	$sections = explode("\x0d\x0a\x0d\x0a", $result, 2);
	while (!strncmp($sections[1], 'HTTP/', 5)) {
		$sections = explode("\x0d\x0a\x0d\x0a", $sections[1], 2);
	}
	$headers = $sections[0];
	$data = $sections[1];

	if (preg_match('/^Content-Encoding: gzip/mi', $headers)) {
		//printf("gzip header found\n");
		$resposta_unzipada= gunzip($data);
	}

	//close connection
	//$result = curl_exec($ch);

	if ($resposta_unzipada==''){$resposta_unzipada=$result;}

	if ($limpa==true){
		$resposta_unzipada=limpacaracteresutf8_novo(str_replace('\\','',limpaunicode($resposta_unzipada)));
	}

	$header_considerado=$http_response_header;
	if ($header_considerado==''){
		$header_considerado=$headers;
	}

	return array ('content'=>$resposta_unzipada, 'headers'=>$header_considerado, 'original'=>$result );

}


function http_get_json_zipado ($url, $limpa=true) {
	$ch = curl_init();

	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_ENCODING,'gzip');  // Needed by API
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

	$data = curl_exec($ch);
	if ($limpa==true){$data=str_replace('\\','',limpacaracteresisolatin1($data));}
	return $data;
}

function http_get_curl($url,$agente='',$obtemcookies=false,$limpa=true,$cookie='',$porta='',$versaossl='',$ssl_ignora=true,$tiraaspas=true,$header000='',$timeout = 5, $zipado=false) {

	// veja http://davidwalsh.name/set-user-agent-php-curl-spoof
	// exemplo: 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'
	if ($agente){$useragent='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13';}
	if ($agente=='ie'){$useragent='Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Win64; x64; Trident/6.0)';}
	if ($agente=='firefox'){$useragent='Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:84.0) Gecko/20100101 Firefox/84.0';}

	if ($header000!=''){
		if (!is_array($header000)){
			// quebra header fornecido pelo Firefox
			$header0=$header000;
			$header=array();
			$header = explode("-H ", str_replace("'",'',$header0));
			$header=array_filter(array_map('trim', $header));
			//print_r($header);
		}
	}

	$ch = curl_init();
	//$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	if ($header000!=''){curl_setopt($ch, CURLOPT_HTTPHEADER, $header);}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	//curl_setopt($ch, CURLOPT_ENCODING, "iso-8859-1");
	if ($useragent!=''){curl_setopt($ch, CURLOPT_USERAGENT,$useragent);	}
	if ($porta!=''){curl_setopt($ch, CURLOPT_PORT,$porta);}
	if ($versaossl!=''){curl_setopt($ch, CURLOPT_SSLVERSION,$versaossl); }

	if ($obtemcookies==true){curl_setopt($ch, CURLOPT_HEADER, 1);}
	if ($cookies!=''){curl_setopt ($ch, CURLOPT_COOKIE, $cookies );}
	if ($ssl_ignora==true){curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);}
	if ($zipado){curl_setopt($ch,CURLOPT_ENCODING,'gzip'); }

	$data = curl_exec($ch);


if(curl_errno($ch)){
    return 'Curl error: ' . curl_error($ch);
}

	curl_close($ch);
	//return $data;

	if ($data==''){checa_se_url_mudou($url);}



			if (strtolower($limpa)=='isolatinlatin1+charconvert+utf8'){
				$data=str_replace('\\','',limpacaracteresisolatin1(char_convert(str_replace('&#8220;','',str_replace('&#8221;','',str_replace('&#8211;','-',str_replace('?∞','∫',str_replace('?∫','∫',limpacaracteresutf8_novo($data)))))))));
			} else {
			if (strtolower($limpa)=='charconvert+utf8'){
				$data=str_replace('\\','',char_convert(str_replace('&#8220;','',str_replace('&#8221;','',str_replace('&#8211;','-',str_replace('?∞','∫',str_replace('?∫','∫',limpacaracteresutf8_novo($data))))))));
				} else {
				if (strtolower($limpa)=='utf8'){
					$data=str_replace('&#8220;','',str_replace('&#8221;','',str_replace('&#8211;','-',str_replace('?∞','∫',str_replace('?∫','∫',limpacaracteresutf8_novo($data))))));
				} else {
					if (strtolower($limpa)=='isolatin1'){
						$data=str_replace('&nbsp;','',str_replace('¬∞','∫',str_replace('¬∫','∫',limpacaracteresisolatin1($data))));
					} else {
						if ($limpa==true){$data=limpacaracteresisolatin1(limpacaracteresutf8_novo($data));}
					}
				}
			}}
	if ($tiraaspas){
		return str_replace("&nbsp;"," ",str_replace("'","",str_replace("∞","∫",$data)));
	} else {
		return str_replace("&nbsp;"," ",str_replace("∞","∫",$data));
	}

}


function checa_se_url_mudou($url){
	global $pdo;

	return false; // 2020 11 16

	$url_original=$url;

	$url=str_replace('http:','https:',$url);

	$header="-H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36' ".
		"-H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9' -H 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7,es;q=0.6'";
	// retorna vetor com url certa e texto
	$texto=http_get_curl($url,'ie',false,false);



	if (str_replace('https:','',$url)!=$url && ($texto=='' || str_replace('SERVER ERROR','',strtoupper($texto))!=strtoupper($texto) || str_replace('UNREACHABLE','',strtoupper($texto))!=strtoupper($texto)  || str_replace('CONNECTION REFUSED','',strtoupper($texto))!=strtoupper($texto)  ) ) {

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
			$texto=http_get_curl($url,'ie',false,false);
			$texto_maiusculas=capitalizacao_str($texto);
			if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
		}
	}

	// sem www
	if (str_replace('www.','',$url)!=$url && trim($texto_maiusculas)==''){
		$url=str_replace('//www.','//',$url);
		$texto=http_get_curl($url,'ie',false,false);
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
				$texto=http_get_curl($url,'ie',false,false);
				$texto_maiusculas=capitalizacao_str($texto);
				if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
			}
		}
	}


	// objeto movido?
	if (str_replace('OBJECT MOVED','',$texto_maiusculas)!=$texto_maiusculas || str_replace('DOCUMENT MOVED','',$texto_maiusculas)!=$texto_maiusculas  ||
		str_replace('MOVED PERMANENTLY','',$texto_maiusculas)!=$texto_maiusculas || str_replace('DOCUMENT HAS MOVED','',$texto_maiusculas)!=$texto_maiusculas ||
		str_replace('OBJETO MOVIDO','',$texto_maiusculas)!=$texto_maiusculas || str_replace('DOCUMENTO MOVIDO','',$texto_maiusculas)!=$texto_maiusculas  ||
		str_replace('DOMAIN NOT FOUND','',$texto_maiusculas)!=$texto_maiusculas || str_replace('DOMÕNIO N√O ENCONTRADO','',$texto_maiusculas)!=$texto_maiusculas  ||
		str_replace('MOVIDO PERMANENTEMENTE','',$texto_maiusculas)!=$texto_maiusculas || str_replace('DOCUMENTO FOI MOVIDO','',$texto_maiusculas)!=$texto_maiusculas
		){

		$url2=strtolower(isolar_limpo($texto_maiusculas,'HREF=','"','"'));

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
		$texto=http_get_curl($url,'ie',false,false);
		$texto_maiusculas=capitalizacao_str($texto);
		if (str_replace('CURL ERROR','',$texto_maiusculas)!=$texto_maiusculas || strlen(trim($texto_maiusculas))<5){$texto_maiusculas='';$texto='';}
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

	$texto=corrige_acentos(str_replace(chr(150),'-',str_replace(chr(156),'',$texto)));
	$resposta=array();
	$resposta['url']=$url;
	$resposta['texto']=$texto;

	if ($url_original!=$url && $url_original!='' && $url!=''){
		// mudou URL!

		$qry = "SELECT * FROM organizadores_links_novos WHERE link_antigo='$url_original' OR link_novo='$url' LIMIT 1";
		$statement = $pdo->query($qry);
		if ( $r = $statement->fetch(PDO::FETCH_ASSOC) ){
			if ($r['data']<date("YmdHi",mktime(0,0,0,date("n")-12,date("j"),date("Y")))){
				// faz tempo...
				envia_mail_interno ('[IMPORTANTE][repeteco] Link mudou - Corrigir urgente '.date("d/m/Y H:i"),array(array('titulo' =>'Link mudou, corrigir fonte','conteudo' => 'Link original: '.$url_original.'<br>Link novo encontrado: '.$url)));
				$pdo->exec("UPDATE organizadores_links_novos SET data='".date("YmdHi")."' WHERE id = '" . $r['id']);
			}
		} else {
			envia_mail_interno ('[IMPORTANTE] Link mudou - Corrigir urgente '.date("d/m/Y H:i"),array(array('titulo' =>'Link mudou, corrigir fonte','conteudo' => 'Link original: '.$url_original.'<br>Link novo encontrado: '.$url)));
			$pdo->exec("INSERT INTO organizadores_links_novos (data,link_antigo,link_novo) VALUES ('".date("YmdHi")."','$url_original','$url')");
			exit;
		}
	}

	return $resposta;

}


function http_get_curl_antigo($url,$agente='',$obtemcookies=false,$limpa=true,$cookie='',$porta='',$versaossl='',$ssl_ignora=false) {
	// veja http://davidwalsh.name/set-user-agent-php-curl-spoof
	// exemplo: 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'
	if ($agente){$useragent='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13';}
	if ($agente=='ie'){$useragent='Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Win64; x64; Trident/6.0)';}

	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	if ($useragent!=''){curl_setopt($ch, CURLOPT_USERAGENT,$useragent);	}
	if ($porta!=''){curl_setopt($ch, CURLOPT_PORT,$porta);}
	if ($versaossl!=''){curl_setopt($ch, CURLOPT_SSLVERSION,$versaossl); }

	if ($obtemcookies==true){curl_setopt($ch, CURLOPT_HEADER, 1);}
	if ($cookies!=''){curl_setopt ($ch, CURLOPT_COOKIE, $cookies );}
	if ($ssl_ignora==true){curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);}

	$data = curl_exec($ch);
	curl_close($ch);
	//return $data;
	if ($limpa==true){$data=limpacaracteresisolatin1(limpacaracteresutf8_novo($data));}
	return str_replace("&nbsp;"," ",str_replace("∞","∫",$data));

}

function http_get ($linkcrawl,$limpa=true){
    // consulta simples ‡ p·gina, com correÁ„o de caracteres
	$crawl = new Crawler($linkcrawl  );
	$texto1 = $crawl->get('textolicit');
	if ($texto1==''){
	$crawl = new Crawler($linkcrawl );
	$texto1 = $crawl->get('textolicit');
	}
	if ($limpa==true){
		return str_replace("'","",str_replace("∞","∫",limpacaracteresutf8(limpacaracteresisolatin1(str_replace("&nbsp;"," ",$texto1)))));
	} else {
		return $texto1;
	}
}

function http_get_com_aspas ($linkcrawl,$limpa=true){
    // consulta simples ‡ p·gina, com correÁ„o de caracteres
	$crawl = new Crawler($linkcrawl  );
	$texto1 = $crawl->get('textolicit');
	if ($texto1==''){
	$crawl = new Crawler($linkcrawl );
	$texto1 = $crawl->get('textolicit');
	}
	if ($limpa==true){
		return str_replace("∞","∫",limpacaracteresutf8(limpacaracteresisolatin1(str_replace("&nbsp;"," ",$texto1))));
	} else {
		return $texto1;
	}
}

function http_get_novo ($linkcrawl){
    // consulta simples ‡ p·gina, com correÁ„o de caracteres
	$crawl = new Crawler($linkcrawl  );
	$texto1 = $crawl->get('textolicit');
	if ($texto1==''){
	$crawl = new Crawler($linkcrawl );
	$texto1 = $crawl->get('textolicit');
	}
	return str_replace("'","",str_replace("∞","∫",limpacaracteresutf8_novo(limpacaracteresisolatin1(str_replace("&nbsp;"," ",$texto1)))));
}
function http_get_original ($linkcrawl){
    // consulta simples ‡ p·gina, com correÁ„o de caracteres
	$crawl = new Crawler($linkcrawl  );
	$texto1 = $crawl->get('textolicit');
	if ($texto1==''){
	$crawl = new Crawler($linkcrawl );
	$texto1 = $crawl->get('textolicit');
	}
	return str_replace("&nbsp;"," ",$texto1);
}

function gunzip($zipped) {
  $offset = 0;
  if (substr($zipped,0,2) == "\x1f\x8b")
	 $offset = 2;
  if (substr($zipped,$offset,1) == "\x08")  {
	 # file_put_contents("tmp.gz", substr($zipped, $offset - 2));
	 return gzinflate(substr($zipped, $offset + 8));
  }
  return false;
}


function extrai_cookies($url,$string='',$cabecaliolido=''){
// exemplo de uso misto:
//    $resposta = http_post('http://www.betha.com.br/transparencia/main.faces','');
//    $cookie = extrai_cookies('',$resposta['headers']);
// 	['content'] continua sendo o conte˙do da p·gina
   $cookie='';
   if ($string==''){
	   if ($url!=''){
		$string = get_headers($url);
	   } else {
		   $string = $cabecaliolido;
	   }
	}
   for($i=0;$i<=sizeof($string);$i++){
	   $cookie0=trim(isolar($string[$i].'ß',"Set-Cookie:",'','ß'));
//	   if ($cookie ==''){$cookie=$cookie0;}
//	   if ($cookie0 !=''){$cookie=$cookie0;}
	   if ($cookie0 !=''){
		   if ($cookie!=''){$cookie.='; ';}
		   $cookie.=$cookie0;}
	}

//	$cookie=trim(limpacaracteresespeciais($cookie));

	if ($cookie==''){
		// mÈtodo tabajara
		$string=str_replace('path=/;','', $string);
		$string=str_replace('path=/','', $string);
		$string=str_replace('Path=/;','', $string);
		$string=str_replace('Path=/','', $string);
		while(  $maiscookie=isolar($string,'Set-Cookie:','',chr(10)) ) {
			$string=str_replace('Set-Cookie:'.$maiscookie,'', $string);
			if ($cookie!=''){$cookie.='; ';}
			$cookie.=trim(limpaespacos($maiscookie));
		}
		$cookie=str_replace(';;',';',trim($cookie));


	}

	return $cookie;
}

function bot_detectado() {

  if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
    return TRUE;
  }
  else {
    return FALSE;
  }

}

function maiusculas_acentuadas($texto){
	return strtoupper( iconv( 'UTF-8', 'ISO-8859-1//TRANSLIT', $texto ) );
}

function minusculas_acentuadas($texto){
	return strtolower( iconv( 'UTF-8', 'ISO-8859-1//TRANSLIT', $texto ) );
}

function eh_feriado($data='',$considera_feriadao=false){
  if (!$data){$data=date("Ymd");}
  $data = substr($data,0,8);

  $ano = substr($data,0,4);
  $mes = substr($data,4,2);
  $dia = substr($data,6,2);

  $pascoa     = easter_date($ano); // Limite de 1970 ou apÛs 2037 da easter_date PHP consulta http://www.php.net/manual/pt_BR/function.easter-date.php
  $dia_pascoa = date('d', $pascoa);
  $mes_pascoa = date('m', $pascoa);
  $ano_pascoa = date('Y', $pascoa);

  $feriados = array(
    // Datas Fixas dos feriados Nacionais Basileiros
    date("Ymd",mktime(0, 0, 0, 1,  1,   $ano)), // ConfraternizaÁ„o Universal - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 4,  21,  $ano)), // Tiradentes - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 5,  1,   $ano)), // Dia do Trabalhador - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 9,  7,   $ano)), // Dia da IndependÍncia - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 10,  12, $ano)), // N. S. Aparecida - Lei n∫ 6802, de 30/06/80
    date("Ymd",mktime(0, 0, 0, 11,  2,  $ano)), // Todos os santos - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 11, 15,  $ano)), // ProclamaÁ„o da republica - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 12, 25,  $ano)), // Natal - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 11, 20,  $ano)), // Dia da ConsciÍncia Negra - lei n∫ 12.519, de 10 de novembro de 2011, feriado em cerca de mil cidades e nos estados de Alagoas, Amazonas, Amap·, Mato Grosso e Rio de Janeiro por completo atravÈs de decretos estaduais.

    date("Ymd",mktime(0, 0, 0, 7,  9,   $ano)), // Feriado SP - CompensaÁıes n„o funcionam esse dia.

    // These days have a date depending on easter
    date("Ymd",mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano_pascoa)),//2∫feria Carnaval
    date("Ymd",mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano_pascoa)),//3∫feria Carnaval
    date("Ymd",mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 46,  $ano_pascoa)),//4∫feria cinzas
    date("Ymd",mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano_pascoa)),//6∫feira Santa
    date("Ymd",mktime(0, 0, 0, $mes_pascoa, $dia_pascoa     ,  $ano_pascoa)),//Pascoa
    date("Ymd",mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano_pascoa)),//Corpus Cristi
  );

  // verifica feriados em terÁas e quintas para emendar feriadıes
  if ($considera_feriadao==true){
	  // lista todos os feriados cadastrados, verificando os dias da semana
	  for($i=0;$i<=(sizeof($feriados)-1);$i++){
		if (date("w",mktime(0,0,0,substr($feriados[$i],4,2),substr($feriados[$i],6,2),substr($feriados[$i],0,4)))==2){
			// terÁa-feira
			$feriados[]=date("Ymd",mktime(0,0,0,substr($feriados[$i],4,2),substr($feriados[$i],6,2)-1,substr($feriados[$i],0,4)));
		}
		if (date("w",mktime(0,0,0,substr($feriados[$i],4,2),substr($feriados[$i],6,2),substr($feriados[$i],0,4)))==4){
			// sexta-feira
			$feriados[]=date("Ymd",mktime(0,0,0,substr($feriados[$i],4,2),substr($feriados[$i],6,2)+1,substr($feriados[$i],0,4)));
		}
	}
  }

  return in_array($data, $feriados);
}

function eh_feriado_oficial($data=''){
  if (!$data){$data=date("Ymd");}
  $data = substr($data,0,8);

  $ano = substr($data,0,4);
  $mes = substr($data,4,2);
  $dia = substr($data,6,2);

  $pascoa     = easter_date($ano); // Limite de 1970 ou apÛs 2037 da easter_date PHP consulta http://www.php.net/manual/pt_BR/function.easter-date.php
  $dia_pascoa = date('d', $pascoa);
  $mes_pascoa = date('m', $pascoa);
  $ano_pascoa = date('Y', $pascoa);

  $feriados = array(
    // Tatas Fixas dos feriados Nacionail Basileiras
    date("Ymd",mktime(0, 0, 0, 1,  1,   $ano)), // ConfraternizaÁ„o Universal - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 4,  21,  $ano)), // Tiradentes - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 5,  1,   $ano)), // Dia do Trabalhador - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 9,  7,   $ano)), // Dia da IndependÍncia - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 10,  12, $ano)), // N. S. Aparecida - Lei n∫ 6802, de 30/06/80
    date("Ymd",mktime(0, 0, 0, 11,  2,  $ano)), // Todos os santos - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 11, 15,  $ano)), // ProclamaÁ„o da republica - Lei n∫ 662, de 06/04/49
    date("Ymd",mktime(0, 0, 0, 12, 25,  $ano)), // Natal - Lei n∫ 662, de 06/04/49

    // These days have a date depending on easter
    date("Ymd",mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano_pascoa)),//3∫feria Carnaval
    date("Ymd",mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano_pascoa)),//6∫feira Santa
    date("Ymd",mktime(0, 0, 0, $mes_pascoa, $dia_pascoa     ,  $ano_pascoa)),//Pascoa
    date("Ymd",mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano_pascoa)),//Corpus Cristi
  );

  return in_array($data, $feriados);
}
// Desabilita automaticamente clientes com comportamento previsto
function checa_habilitacao ($id_cliente){
    // retorna 'sim' para habilitado (sem problemas) ou 'n„o' quando identificado problema e desabilitado automaticamente
    // aqui: rotinas implementadas manualmente
    global $pdo;

//return $__usr_mng.'/'.$_COOKIE['__usr_mng'].'/'.$id_cliente;

    $statement = $pdo->query("SELECT * FROM clientes WHERE id='$id_cliente' " );
    if ( $cli = $statement->fetch(PDO::FETCH_ASSOC) ) {

        // 0- Verifica se cookie __usr_mng est· gravado com id diferente
		if( $_COOKIE['__usr_mng']!='' ){
			if (str_replace('l','',$_COOKIE['__usr_mng'])!=$_COOKIE['__usr_mng']) {
				$__usr_mng = explode("l", $_COOKIE['__usr_mng']);
				$id_cliente2=(int)custom_to_ten($__usr_mng[1]);
				$id_dispositivo=$__usr_mng[0];
				if ($id_cliente2>0 && $id_cliente2!=$id_cliente){
					// este dispositivo j· È usado por outro id
					// pesquisa outros usu·rios nesta m·quina
                    $statement = $pdo->query("SELECT * FROM clientes WHERE dispositivo01='$id_dispositivo' OR dispositivo02='$id_dispositivo' OR dispositivo03='$id_dispositivo' OR dispositivo04='$id_dispositivo'" );
                    $txtresposta='';
                    while ( $resposta_usr_mng  = $statement->fetch(PDO::FETCH_ASSOC)){
						$txtresposta.='<br>Dispositivo j· usado pelo usu·rio <a href="'. BASE_URL . 'adm/adm_boletos.php?op=busca&termo=[' . $resposta_usr_mng['id'] . ']" target="_blank">['.$resposta_usr_mng['id'].']</a> '.$resposta_usr_mng['contato'].'/ '.$resposta_usr_mng['razao_social'];
					}

					return 'N√O! Cadastro feito em dispositivo usado por outro usu·rio: '.$cli['ip'].$txtresposta;
				}
			}
		}

        // 1- Verifica se IP est· bloqueado
        $statement = $pdo->query("SELECT * FROM ip_bloqueado WHERE ip='" . $cli['ip'] . "'" );
        if ( $statement->fetch(PDO::FETCH_ASSOC) ) {
            return 'N√O! IP Bloqueado: '.$cli['ip'];
        }
    }
    if ($resposta==''){$resposta='sim';}
    return $resposta;

}

function checa_ataque (){
      return true;

}

function arrumacidade($cidade) {
	// capitaliza cidade e retira uf, quando houver
    global $pdo;

	$cidade=trim(limpaantesletras(limpacaracteresespeciais(str_replace('(',' ',str_replace('/',' ',str_replace('-',' ',capitalizacao_str($cidade)))))));
	if (substr($cidade, -3, 1)==' '){
		// verifica se ˙ltimos caracteres s„o o estado
        $statement = $pdo->query("SELECT * FROM uf WHERE uf = '" . substr($cidade, -2) . "'");
		if ($statement->fetch(PDO::FETCH_ASSOC)){
			// apaga estado do nome da cidade
			$cidade=substr($cidade, 0, strlen($cidade)-3);
		}
	}
	$cidade=str_replace('CIDADE DE','',$cidade);
	return trim($cidade);
}

function capitalizacao_str($text, $maiusculas=true){

	$arrayLower=array('Á','‚','„','‡','·','‰','È','Ë','Í','Î','Ì','Ï','Ó','Ô','Û','Ú','Ù','ı','ˆ','˙','˘','˚','¸');
	$arrayUpper=array('«','¬','√','¿','¡','ƒ','…','»',' ','À','Õ','Ã','Œ','œ','”','“','‘','’','÷','⁄','Ÿ','€','‹');

	if($maiusculas==false) {
		$text=strtolower($text);
		for($i=0;$i<count($arrayLower);$i++) {
		$text=str_replace($arrayUpper[$i], $arrayLower[$i], $text);
		}
	} else {
		$text=strtoupper($text);
		for($i=0;$i<count($arrayLower);$i++) {
		$text=str_replace($arrayLower[$i], $arrayUpper[$i], $text);
		}
	}
	return($text);
}

function limpa_dados_sensiveis ($string,$numeros=true) {
   // retira e-mail, url e telefone de string
   // uso previsto: p·ginas p˙blicas e usu·rios com prazo expirado

   $resposta=$string;

   $string = str_replace('/',' ',$string);
   $string = str_replace(':',' ',$string);
   $string = str_replace(',',' ',$string);
   $string = str_replace(';',' ',$string);
   $string = str_replace('!',' ',$string);
   $string = str_replace('(',' ',$string);
   $string = str_replace(')',' ',$string);
   $string = str_replace("\r\n",' ',$string);
   $string = str_replace("\n",' ',$string);
   foreach(preg_split('/ /', $string) as $token) {
	   //$token=trim($token);

        if (substr($token,-1)==':' || substr($token,-1)=='.' || substr($token,-1)==',' || substr($token,-1)==';' || substr($token,-1)=='/' || substr($token,-1)=='!' || substr($token,-1)=='-'|| substr($token,-1)==')'){$token=substr($token,0,strlen($token)-1);}
        if (substr($token,0,1)==':' || substr($token,0,1)=='.' || substr($token,0,1)==',' || substr($token,0,1)==';' || substr($token,0,1)=='/' || substr($token,0,1)=='!' || substr($token,0,1)=='-'|| substr($token,0,1)=='('){$token=substr($token,1,strlen($token)-1);}

//echo $token.'|';
        // e-mail
        $dadosensivel = filter_var(strtolower($token), FILTER_VALIDATE_EMAIL);
        if ($dadosensivel !== false) {
            $resposta = str_replace($token,'***@***.*.*',$resposta);
        } else {
			// url
			$dadosensivel = filter_var(str_replace('http://http://www.','http://www.',str_replace('www.','http://www.',strtolower($token))), FILTER_VALIDATE_URL);
			if ($dadosensivel !== false) {
				$resposta = str_replace(str_replace('http://','',$token),'www.***.*.*',$resposta);
			} else {
				// verifica se È possÌvel ser um n˙mero telefÙnico
				$dadosensivel = preg_replace('/[^0-9]/', '', $token);
				if( $numeros==true && $token==str_replace('/','',$token) && $token==str_replace(':','',$token) && $token==str_replace('h','',$token) &&
					( strlen($dadosensivel) >=8 ||
					(strlen($dadosensivel) >=4 && ( (int)$dadosensivel<(date("Y")-10) || (int)$dadosensivel>(date("Y")+10) ) )
					|| ((strlen(trim($dadosensivel)) ==2 || strlen(trim($dadosensivel)) ==3) && $token!=str_replace('(','',$token) && $token!=str_replace(')','',$token) ) )) {
					$resposta = str_replace($token,'****',$resposta);
				}
			}
		}
		// OC do bec
		//$resposta=trim($token).'|'.$resposta;
		if( strlen(trim($token))==21 || strlen(trim($token))==22 ) {
			if (substr(strtoupper(trim($token)),15,2)=='OC' || substr(strtoupper(trim($token)),14,2)=='OC'){
				$resposta = str_replace($token,'****',$resposta);
			}
		}

    }
    return $resposta;
}

function geolocalizacao($rua,$bairro='',$cidade='',$uf='',$pais='BRASIL',$permite_google=true){
    global $pdo;

		$coordenadas[0]= 27;
		$coordenadas[1]= -14;
		return $coordenadas;

	$coordenadas=array(0,0);
	/*
	$rua=trim($rua);
	$bairro=trim($bairro);
	$cidade=trim($cidade);
	$uf=trim($uf);
	$pais=trim($pais);
	*/

	if ($rua!=''){$rua=addslashes(substr(trim($rua),0,256));}
	if ($bairro!=''){$bairro=addslashes(substr(trim($bairro),0,128));}
	if ($cidade!=''){$cidade=addslashes(substr(trim($cidade),0,128));}
	if ($uf!=''){$uf=addslashes(substr(trim($uf),0,32));}
	if ($pais!=''){$pais=addslashes(substr(trim($pais),0,64));}

	echo '<br><br><strong>Busca GeolocalizaÁ„o...</strong> $rua='.trim($rua).'/ $bairro='.trim($bairro).'/ $cidade=<strong>'.trim($cidade).'</strong>/ $uf='.trim($uf).'/ $pais=<strong>'.trim($pais).'</strong>';

	if ($rua!='' && $bairro=='' &&  $cidade=='' && $uf=='' && $permite_google){
		$coordenadas=geolocalizacao_google($rua);
	}
	if (strtoupper($pais)!='BRASIL' || (strtoupper($pais)=='BRASIL' && $cidade!='' && $uf!='')){
	//exit;
		// 1. quando n„o h· rua, busca no db interno
	//exit;
		// 2. Busca coordenadas no banco de dados de leilıes

		// 3. Busca em no Geocoder do Google (http://stackoverflow.com/questions/3807963/how-to-get-longitude-and-latitude-of-any-address)
		$endereco=str_replace(',,',',',$rua.','.$bairro.','.$cidade.'-'.$uf.','.$pais);
		//$coordenadas=array(0,0);
		if ($permite_google){
			$coordenadas=geolocalizacao_google($endereco);
		}


echo '<BR><BR>endereÁo:'.$endereco.'<br>vetor:';print_r($coordenadas); //exit;
		// grava no db de geolocalizaÁ„o
		if($rua=='' && abs($coordenadas[0])>0 && abs($coordenadas[1])>0 ){

			if ($cidade==''){$cidade=$coordenadas[3];}
			if ($uf==''){$uf=$coordenadas[2];}
			if ($bairro==''){$bairro=$coordenadas[4];}
		}

		// 4. Nada funcionou! Busca sÛ cidade, uf, paÌs no db. Se n„o for Brasil, procura de forma mais ampla ainda
		if(abs($coordenadas[0])==0 && abs($coordenadas[1])==0 ){
			if ($bairro!='' || !$permite_google){
				echo '<br>UTI1 Buscar· no db geolocalizaÁ„o...'."SELECT * FROM geolocalizacao WHERE geo_cidade='$cidade' AND geo_uf='$uf' AND geo_pais='$pais' LIMIT 1";
					// 3. Busca em no Geocoder do Google (http://stackoverflow.com/questions/3807963/how-to-get-longitude-and-latitude-of-any-address)
					if ($permite_google){
						$endereco=str_replace(',,',',',$cidade.'-'.$uf.','.$pais);
						$coordenadas=geolocalizacao_google($endereco);
						// grava no db de geolocalizaÁ„o
						if(abs($coordenadas[0])>0 && abs($coordenadas[1])>0 ){
							if ($cidade==''){$cidade=$coordenadas[3];}
							if ($uf==''){$uf=$coordenadas[2];}
							if ($bairro==''){$bairro=$coordenadas[4];}

							echo '<br><font color="orange">Coordenadas '.$coordenadas[0].','.$coordenadas[1].' encontradas no google sÛ cidade, uf, paÌs</font><br>';
							return $coordenadas;
						}
					}
				
			}

			if (strtoupper($pais)!='BRASIL'){
				// sÛ uf e paÌs
					// 3. Busca em no Geocoder do Google (http://stackoverflow.com/questions/3807963/how-to-get-longitude-and-latitude-of-any-address)
					if ($permite_google){
						$endereco=str_replace(',,',',',$uf.','.$pais);
						$coordenadas=geolocalizacao_google($endereco);
						// grava no db de geolocalizaÁ„o
						if(abs($coordenadas[0])>0 && abs($coordenadas[1])>0 ){
							if ($uf==''){$uf=$coordenadas[2];}

							echo '<br><font color="pink">Coordenadas '.$coordenadas[0].','.$coordenadas[1].' encontradas no google sÛ uf e paÌs</font><br>';
							return $coordenadas;
						}
					
				}
					// 3. Busca em no Geocoder do Google (http://stackoverflow.com/questions/3807963/how-to-get-longitude-and-latitude-of-any-address)
					if ($permite_google){
						$endereco=str_replace(',,',',',$pais);
						$coordenadas=geolocalizacao_google($endereco);
						// grava no db de geolocalizaÁ„o
						if(abs($coordenadas[0])>0 && abs($coordenadas[1])>0 ){

							echo '<br><font color="pink">Coordenadas '.$coordenadas[0].','.$coordenadas[1].' encontradas no google sÛ paÌs</font><br>';
							return $coordenadas;
						}
					
				}
			}
		}
		
		if ($coordenadas==array(0,0)){echo '* coords n„o encontradas. '; if (!$permite_google){echo 'Proibindo Google.';} return false;}

		echo '<br><font color="blue">Coordenadas '.$coordenadas[0].','.$coordenadas[1].' encontradas no Google</font><br>';

echo '<BR><BR>endereÁo:'.$endereco.'<br>vetor:';print_r($coordenadas); //exit;
	}
	return $coordenadas;
}

function geolocalizacao_google($endereco){

	$coordenadas[0]= 27;
	$coordenadas[1]= -14;
	return $coordenadas;
	// 2018 09 incluÌdo componentes de endereÁo
/*    [0] => -25.4375405 lat
    [1] => -49.1989018 lnt
    [2] => PR
    [3] => Pinhais
    [4] => Est‚ncia Pinhais*/
	// 3. Busca em no Geocoder do Google (http://stackoverflow.com/questions/3807963/how-to-get-longitude-and-latitude-of-any-address)
//echo '<br>buscar·: '.$endereco;
//	$endereco=str_replace(' ','+',mb_convert_encoding($endereco, 'UTF-8', 'ISO-8859-1'));
	if (str_replace('+','',$endereco)==$endereco){$endereco=str_replace(' ','+',str_replace('∫','',str_replace('∞','',strtr($endereco, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹« ", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC_"))));}
	$endereco=str_replace('_','+',str_replace(',-,','',$endereco));

echo '
<hr><strong><font color="#4285F4">G</font><font color="#ea4335">o</font><font color="#fbbc05">o</font><font color="#4285F4">g</font><font color="#34a853">l</font><font color="#ea4335">e</font></strong> ***endereco='.$endereco.'<hr>
';

//echo 'https://maps.google.com/maps/api/geocode/json?address='.$endereco.'&key=AIzaSyA_Ar5p-SW6uh1d6sHFWjrgxXWNOH-C6KE&sensor=false'; exit;
	$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$endereco.'&key='.consultaconfig('chaveapigooglemaps_api').'&sensor=false');

	// api key gerenci·vel em https://console.developers.google.com/apis/credentials/key/0?project=massive-marker-101513
//echo '<br>achou: '.$geocode;
	$output= json_decode($geocode,true);

	$coordenadas[0]= $output['results'][0]['geometry']['location']['lat'];//$output->results[0]->geometry->location->lat; // latitude
	$coordenadas[1]= $output['results'][0]['geometry']['location']['lng'];//$output->results[0]->geometry->location->lng; // longitude


	$componentes_endereco=$output['results'][0]['address_components'];
	
	if (is_array($componentes_endereco)){

		$indice=1;
		$trava=true;
		for ($i=0;$i<sizeof($componentes_endereco);$i++){

			$este_indice=sizeof($componentes_endereco)-$i-1;

			$objeto_de_analise=limpacaracteresutf8_novo($componentes_endereco[$este_indice]['short_name']);

			if (!$trava){
				if ($indice>1 || ($indice==1 && strlen($objeto_de_analise)==2)){

					$indice+=1;
					if ($indice<=4 && $este_indice>=0){$coordenadas[$indice]=$objeto_de_analise;	}
				}
			}
			if ($objeto_de_analise=='BR'){$trava=false;}
		}
	}

	return $coordenadas;
}

function atualiza_geoloc_clientes(){
     return true;


}

function atualiza_geoloc_organizadores(){
	    return true;

}

function _bot_detected() {
  if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
    return true;
  }
  else {
    return false;
  }
}


function atualiza_indicador($ind_robo,$ind_periodo,$ind_numero,$ind_nome,$inicio=false,$ind_processos=''){
    return true;

}

function acha_capital($uf){
	$uf=strtoupper($uf);
	$estados = array("AC"=>"Rio Branco", "AL"=>"MaceiÛ", "AM"=>"Manaus", "AP"=>"Macap·","BA"=>"Salvador","CE"=>"Fortaleza","DF"=>"BrasÌlia","ES"=>"VitÛria","GO"=>"Goi‚nia","MA"=>"S„o LuÌs","MT"=>"Cuiab·","MS"=>"Campo Grande","MG"=>"Belo Horizonte","PA"=>"BelÈm","PB"=>"Jo„o Pessoa","PR"=>"Curitiba","PE"=>"Recife","PI"=>"Teresina","RJ"=>"Rio de Janeiro","RN"=>"Natal","RO"=>"Porto Velho","RS"=>"Porto Alegre","RR"=>"Boa Vista","SC"=>"FlorianÛpolis","SE"=>"Aracaju","SP"=>"S„o Paulo","TO"=>"Palmas");
	if ($estados[$uf]!=''){$resposta=$estados[$uf];}else{$resposta='';}
	return $resposta;
}

function in_array_r($item , $array){
    return preg_match('/"'.$item.'"/i' , json_encode($array));
}


function array_msort($array, $cols)
{
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;

}


function telefone_proximo($uf){
    global $pdo;
	$uf=strtoupper(trim(strtr($uf, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«'", "aaaaeeiooouucAAAAEEIOOOUUC ")));
	if (strlen($uf)!=2){
        $statement = $pdo->query("SELECT uf FROM uf WHERE uf_nome LIKE '$uf'");
		if($ruf = $statement->fetch(PDO::FETCH_ASSOC) ){
			$uf=$ruf['uf'];
		}
	}

   $fone = '(11) 3522-9930';
	if ($uf=='RS'){
	   $fone = '(51) 4063-9920';
	} else {
	 if ($uf=='SC' ){
		 $fone = '(48) 4052-9885';
	 } else {
	  if ($uf=='PR'){
		 $fone = '(41) 4063-9885';
	  } else {
	  if ($uf=='RJ' || $uf=='ES'){
		 $fone = '(21) 3527-0150';
	  } else {
	   if ($uf=='MG' ){
		   $fone = '(31) 4063-9920';
	   } else {
		 if ($uf=='BA' || $uf=='SE' ){
		   $fone = '(71) 4062-9930';
		 } else {
		 if ($uf=='PE' || $uf=='PI' || $uf=='AL' || $uf=='PB' || $uf=='MA' || $uf=='RN'  || $uf=='CE'){
		   $fone = '(81) 4042-1599';
		 } else {
		 if ($uf=='MS' ){
		   $fone = '(67) 4042-1899';
		 } else {
		 if ($uf=='GO' || $uf=='TO' || $uf=='MT' ){
		   $fone = '(62) 3142-0111';
		 } else {
		   if ($uf=='DF' ){
			 $fone = '(61) 4063-7750';
	}}}}}}}}}}
	return $fone;
}

function snippetgoogleanalytics (){
/*
$googleanalyticsscript="
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-139745443-1', 'auto');
  ga('send', 'pageview');

</script>
";
*/

/*

snipet para blog (site secund·rio):

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-139745443-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-139745443-2');
</script>


abaixo: completo considerando site secund·rio:

<script>

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-139745443-2', 'auto', {'allowLinker': true});
ga('require', 'linker');
ga('linker:autoLink', ['licitaja.com.br'] );
ga('send', 'pageview');

</script>


*/
/*$googleanalyticsscript="
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-139745443-1', 'auto', {'allowLinker': true});
ga('require', 'linker');
ga('linker:autoLink', ['leilaoguru.com'] );
  ga('send', 'pageview');

</script>
";*/

$googleanalyticsscript="<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-139745443-1\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-139745443-1');
</script>
";



	return $googleanalyticsscript;
}

function google_analytics_pagamento($id,$rotulo='Antigo'){
	// 2019 05 id= id do cliente; rotulo= Novo | Antigo. "Novo" ir· disparar convers„o
    global $pdo;
    $statement = $pdo->query("SELECT * FROM clientes WHERE id='$id'");
	if ($r = $statement->fetch(PDO::FETCH_ASSOC) ){
		if (trim($r['google_cid'])!=''){
			$resposta=http_get_curl('http://www.google-analytics.com/collect?v=1&tid=UA-139745443-1&cid='.$r['google_cid'].'&t=event&ec=Investimento&ea=Pagamento&el='.$rotulo,'ie');
			return true;
		}
	}
	return false;
}

function eh_cliente_organico ($idcliente=0,$idpedido=0){
    global $pdo;
	if ($idcliente>0){
        $statement = $pdo->query("SELECT estrategia FROM clientes WHERE id='$idcliente' LIMIT 1");
        if ($r = $statement->fetch(PDO::FETCH_ASSOC) ){
			if ((int)$r['estrategia']==0){ return true; } else {return false; }
		}
	}

	if ($idpedido>0){
        $statement = $pdo->query("SELECT estrategia FROM clientes WHERE id IN (SELECT id_cliente FROM investimento_historico WHERE id_pedido='$idpedido') LIMIT 1");
        if ($r = $statement->fetch(PDO::FETCH_ASSOC) ){
			if ((int)$r['estrategia']==0){ return true; } else {return false; }
		}
	}

	return true; // resposta padr„o caso n„o ache nada

}

function array2string($data){
    $log_a = "";
    foreach ($data as $key => $value) {
        if(is_array($value))    $log_a .= "[".$key."] => (". array2string($value). ")<br>";
        else                    $log_a .= "[".$key."] => ".$value."<br>";
    }
    return $log_a;
}

function checkLogin(){
    return true;

}

function autoriza_precad_robos_botlic_consulta () {
    return true;

}

function trata_imagem($figura_endereco,$diretorio='',$novo_nome,$fig_largura=100,$fig_altura=100,$margem_v=0.15,$margem_h=0.15,$compressao=9,$verifica=true){
    global $pdo;

    //$figura_endereco='http://assets.sold.com.br/cdn/imagens/leilao/3507/det/008.jpg';
	// $compressao: 0 a 9 (mais comprimida)

/*
trata_imagem('http://fotos.sodresantoro.com.br/fotos.imoveis/I6028A.JPG','foto1',250,250,0,0);
trata_imagem('http://www.superbid.net/home/photos/foto_1458593598_63034_01_00_00.jpg?size=gallerybox','foto2',250,250,.13,.13);
trata_imagem('http://assets.sold.com.br/cdn/imagens/leilao/3507/det/008.jpg','foto3',250,250,0,0);
*/
	$resposta=true;

	if ($verifica){
		$md5file = md5_file($figura_endereco);
		echo '<br>Tratando imagem: '.$figura_endereco . ' - MD5: '.$md5file;

		$sqlqry="SELECT * FROM fotos_proibidas WHERE md5='$md5file' LIMIT 1";
        $statement = $pdo->query($sqlqry);
        if($statement->fetch(PDO::FETCH_ASSOC)){ echo ' <strong>FOTO PROIBIDA!</strong>'; return false;}
	}

    if ($diretorio==''){$diretorio='imagens/teste/';}
    if (!file_exists(HOME_PATH.$diretorio)) {
        mkdir(HOME_PATH.$diretorio, 0777, true);
    }
    $figura_endereco2=isolar('ß'.str_replace('&','?',$figura_endereco).'?','ß','','?');
    $extensao=strtolower(substr($figura_endereco2,-3));
    if ($extensao=='peg' || $extensao==''){$extensao='jpg';}
    if ($extensao=='ebp' ){$extensao='webp';}
    if ($extensao!='gif' && $extensao!='png' && $extensao!='jpg'){$extensao='jpg';}

      $useragent='Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Win64; x64; Trident/6.0)';
      $ch = curl_init($figura_endereco);
      $fp = fopen(HOME_PATH.$diretorio.$novo_nome, 'wb');
      curl_setopt($ch, CURLOPT_FILE, $fp);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_USERAGENT,$useragent);

      curl_exec($ch);
      curl_close($ch);
      fclose($fp);
/*
      // convers„o para imagem amarelada
      if ($extensao=='gif'){$im = imageCreateFromGif(HOME_PATH.$diretorio.$novo_nome);}
      if ($extensao=='jpg'){$im = imageCreateFromJpeg(HOME_PATH.$diretorio.$novo_nome);}
      if ($extensao=='png'){$im = imageCreateFromPng(HOME_PATH.$diretorio.$novo_nome);}
*/
      // redimensiona e corta
      if ($fig_altura>0 && $fig_largura>0){

        if ($margem_v+$margem_h>=1){$margem_v=0;$margem_h=0;}
        $proporcao_final=$fig_largura/$fig_altura;

        list($larg_original,$alt_original,$tipo_imagem)=getimagesize(HOME_PATH.$diretorio.$novo_nome);

        // convers„o para imagem amarelada 2019 06
        if ($tipo_imagem==IMAGETYPE_GIF){$im = imageCreateFromGif(HOME_PATH.$diretorio.$novo_nome);}
        if ($tipo_imagem==IMAGETYPE_JPEG){$im = imageCreateFromJpeg(HOME_PATH.$diretorio.$novo_nome);}
        if ($tipo_imagem==IMAGETYPE_PNG){$im = imageCreateFromPng(HOME_PATH.$diretorio.$novo_nome);}
        if ($tipo_imagem==IMAGETYPE_WEBP){$im = imageCreateFromwebp(HOME_PATH.$diretorio.$novo_nome);}


        $recorte_v=(int)$alt_original*(1-$margem_v*2);
        $recorte_h=(int)$larg_original*(1-$margem_h*2);
        // corrige recorte
        if ($recorte_h/$recorte_v>$proporcao_final){
          // recorte mais largo que o desejado: diminuir $recorte_h
          $recorte_h=(int)$recorte_v*$proporcao_final;
        }
        if ($recorte_h/$recorte_v<$proporcao_final){
          // recorte mais alto que o desejado: diminuir $recorte_v
          $recorte_v=(int)$recorte_h/$proporcao_final;
        }
        $margem_abs_v=(int)($alt_original-$recorte_v)/2;
        $margem_abs_h=(int)($larg_original-$recorte_h)/2;

        $tmp=imagecreatetruecolor($fig_largura,$fig_altura);

        imagecopyresampled($tmp,$im,0,0,$margem_abs_h,$margem_abs_v,$fig_largura,$fig_altura,$larg_original-2*$margem_abs_h,$alt_original-2*$margem_abs_v);
        $tmp = ImageTrueColorToPalette2($tmp,false,255); // reduz palete e ultra compacta
        $im=$tmp;
        if($im){imagepng($im, HOME_PATH.$diretorio.$novo_nome,$compressao);}
      }


//      if($im && imagefilter($im, IMG_FILTER_COLORIZE, 100, 0, 0)){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}

// filtros teste
/*
      if ($_POST['IMG_FILTER_NEGATE']=='on'){if($im && imagefilter($im, IMG_FILTER_NEGATE)){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
      if ($_POST['IMG_FILTER_GRAYSCALE']=='on'){if($im && imagefilter($im, IMG_FILTER_GRAYSCALE)){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
      if ($_POST['IMG_FILTER_BRIGHTNESS']=='on'){if($im && imagefilter($im, IMG_FILTER_BRIGHTNESS, $_POST['IMG_FILTER_BRIGHTNESS_range'])){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
      if ($_POST['IMG_FILTER_CONTRAST']=='on'){if($im && imagefilter($im, IMG_FILTER_CONTRAST, $_POST['IMG_FILTER_CONTRAST_range'])){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
      if ($_POST['IMG_FILTER_COLORIZE']=='on'){if($im && imagefilter($im, IMG_FILTER_COLORIZE, $_POST['IMG_FILTER_COLORIZE_r'], $_POST['IMG_FILTER_COLORIZE_g'], $_POST['IMG_FILTER_COLORIZE_b'],$_POST['IMG_FILTER_COLORIZE_a'])){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
      if ($_POST['IMG_FILTER_EDGEDETECT']=='on'){if($im && imagefilter($im, IMG_FILTER_EDGEDETECT)){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
      if ($_POST['IMG_FILTER_EMBOSS']=='on'){if($im && imagefilter($im, IMG_FILTER_EMBOSS)){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
      if ($_POST['IMG_FILTER_GAUSSIAN_BLUR']=='on'){if($im && imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR)){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
      if ($_POST['IMG_FILTER_SELECTIVE_BLUR']=='on'){if($im && imagefilter($im, IMG_FILTER_SELECTIVE_BLUR)){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
      if ($_POST['IMG_FILTER_MEAN_REMOVAL']=='on'){if($im && imagefilter($im, IMG_FILTER_MEAN_REMOVAL)){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
      if ($_POST['IMG_FILTER_SMOOTH']=='on'){if($im && imagefilter($im, IMG_FILTER_SMOOTH, $_POST['IMG_FILTER_SMOOTH_range'])){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
      if ($_POST['IMG_FILTER_PIXELATE']=='on'){if($im && imagefilter($im, IMG_FILTER_PIXELATE, $_POST['IMG_FILTER_PIXELATE_1'], $_POST['IMG_FILTER_PIXELATE_2'])){imagepng($im, HOME_PATH.$diretorio.$novo_nome);}}
*/
      imagedestroy($im);


      return $resposta;


}

function ImageTrueColorToPalette2($image, $dither, $ncolors) {
    $width = imagesx( $image );
    $height = imagesy( $image );

    $colors_handle = ImageCreateTrueColor( $width, $height );
    ImageCopyMerge( $colors_handle, $image, 0, 0, 0, 0, $width, $height, 100 );
    ImageTrueColorToPalette( $image, $dither, $ncolors );
    ImageColorMatch( $colors_handle, $image );
    ImageDestroy($colors_handle);
    return $image;
}

function descobre_endereco ($detalhes){


echo '<br><strong>Usando descobre_endereco</strong><br>';

	$endereco='';

	$detalhes=limpaespacos(str_replace('.',' ',str_replace(',',' ',strtoupper(strtr($detalhes, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC")))));

	$detalhes2='';
	$explodido=explode(' ',$detalhes);

	$acheinumero=false;
	for ($i=0;$i<sizeof($explodido);$i++){

		if (!$acheinumero){$detalhes2.=' ';}

		$acheinumero=false;
		$so_letras_numeros_espacos=trim(so_letras_numeros_espacos($explodido[$i]));
		if ($so_letras_numeros_espacos==''.(int)$so_letras_numeros_espacos && $so_letras_numeros_espacos!=''){
			$acheinumero=true;
			$detalhes2.='';
		}

		if (!$acheinumero){$detalhes2.=' ';}
		$detalhes2.=$explodido[$i];

	}

	$detalhes=trim(limpaespacos(str_replace(',',', ',str_replace('-','- ',str_replace('/','/ ',$detalhes2)))));

	$numeroend='';
	if ($endereco==''){$endereco=isolar($detalhes.'ß©ß','SITO A ','','ß©ß');}

	if ($endereco==''){$endereco=isolar($detalhes.'ß©ß','RUA ','','ß©ß'); if ($endereco!=''){$endereco='RUA '.$endereco;}}
	if ($endereco==''){$endereco=isolar($detalhes.'ß©ß','AVENIDA ','','ß©ß'); if ($endereco!=''){$endereco='AVENIDA '.$endereco;}}
	if ($endereco==''){$endereco=isolar($detalhes.'ß©ß',' R ','','ß©ß'); if ($endereco!=''){$endereco='RUA '.$endereco;}}
	if ($endereco==''){$endereco=isolar($detalhes.'ß©ß','AV ','','ß©ß'); if ($endereco!=''){$endereco='AVENIDA  '.$endereco;}}
	if ($endereco==''){$endereco=isolar($detalhes.'ß©ß','ALAMEDA ','','ß©ß'); if ($endereco!=''){$endereco='ALAMEDA '.$endereco;}}
	if ($endereco!=''){
		$endereco_ex=explode(' ',$endereco);

		for ($i=2;$i<sizeof($endereco_ex);$i++){
			$so_letras_numeros_espacos=trim(so_letras_numeros_espacos($endereco_ex[$i]));
			if ($so_letras_numeros_espacos==''.(int)$so_letras_numeros_espacos && $so_letras_numeros_espacos!=''){
				$numeroend=$endereco_ex[$i];
				break;
			}
		}
//echo '<br><br> ==> endereÁo: '.limpaespacos(trim(str_replace('.','',str_replace('-',' ',isolar('ß'.$endereco,'ß','',$numeroend).' '.$numeroend)))).'<br><br>'; exit;
		if ($numeroend!=''){ return limpaespacos(str_replace('N∫',' ',trim(str_replace('.',' ',str_replace('-',' ',isolar('ß'.$endereco,'ß','',$numeroend).' '.$numeroend)))));}
	}
	return false;
//exit;
}

function acha_endereco($texto,$resp=array()){

	$resp['ll_uf']='';
	$extraido_uf=isolar_reverso($texto.'ß','/','ß');
	if (strlen($extraido_uf)==2){
		$extraido_endereco_cidade=isolar('ß'.$texto,'ß','','/');
		$extraido_endereco=isolar_limpo(isolar($lote,'</h4','<a','</a'),'>','-','DescriÁ„o');
		$extraido_bairro=trim(isolar('ß'.$extraido_endereco,'ß','',','));
		if ($extraido_bairro!=''){$extraido_endereco=trim(isolar($extraido_endereco.'ß',',','','ß'));}

		if ($extraido_endereco!=''){
			if ($extraido_endereco!='' && $extraido_endereco_cidade!='' && $extraido_uf!='' ) {
				$resp['ll_endereco']=$extraido_endereco;
				$resp['ll_cidade']=$extraido_endereco_cidade;
				$resp['ll_bairro']=$extraido_bairro;
				$resp['ll_uf']=$extraido_uf;
				$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);

				if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
				if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

			} else {


					$geolocalizacao=geolocalizacao($localizacao.' '.$extraido_endereco_cidade.' '.$extraido_uf,'');
					if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
					if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

					if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
					if ($geolocalizacao[3]!=''){$resp['ll_cidade']=$geolocalizacao[3];}
					if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}
					$resp['ll_endereco']=$localizacao;
			}
		}
	}


	if ($resp['ll_uf']==''){


		$localizacao=trim(str_replace(' ‡ ',' ',str_replace(' na ',' ',str_replace(' no ',' ',isolar(str_replace('localizada','situado',str_replace('localizado','situado',str_replace('situados','situado',str_replace('situada','situado',$texto)))),'situado','','/')))));
		if ($localizacao==''){$localizacao=trim(isolar_amplo(' '.$texto,' rua ','','/'));if ($localizacao!=''){$localizacao='Rua '.$localizacao;}}
		if ($localizacao==''){$localizacao=trim(isolar_amplo(' '.$texto,' av. ','','/'));if ($localizacao!=''){$localizacao='Av. '.$localizacao;}}
		if ($localizacao==''){$localizacao=trim(isolar_amplo(' '.$texto,' avenida ','','/'));if ($localizacao!=''){$localizacao='Avenida '.$localizacao;}}

		if (strlen($localizacao)>100){$localizacao='';}


		if ($localizacao!=''){

			$ll_uf=substr(isolar(str_replace(' ','',$texto).'ß',str_replace(' ','',$localizacao),'/','ß'),0,2);


			$localizacao.=' '.$ll_uf;
			$texto_local= str_replace('+',' ',str_replace('%C3%83%C6%92%C3%82%C2%A3','a',isolar(http_get_curl('https://goo.gl/maps/'.$localizacao,'ie',false,false),'HREF="','place/','/')));

			// algo como R.+Um,+1415+-+Areal,+Pelotas+-+RS,+96081-110
			$texto_local_purificado=trim(str_replace('+',' ',$texto_local));

				$extraido_cep=substr($texto_local_purificado,-9);
				$extraido_uf=substr($texto_local_purificado,-13,2);
				$extraido_endereco=isolar('ß'.$texto_local_purificado,'ß','',',');
				$extraido_endereco_numero=isolar($texto_local_purificado,',','',',');
				$extraido_endereco_bairro=isolar($extraido_endereco_numero.'ß','-','','ß');
				if ($extraido_endereco_bairro!=''){$extraido_endereco_numero=isolar($texto_local_purificado,',','','-');}
				$extraido_endereco_cidade=isolar($texto_local_purificado,',',',','-');

			if ($extraido_endereco!='' && $extraido_endereco_numero!='' && $extraido_endereco_cidade!='' && $extraido_uf!='' && str_replace('-','',trim($extraido_cep))){
				$resp['ll_endereco']=$extraido_endereco.' '.$extraido_endereco_numero;
				$resp['ll_bairro']=$extraido_endereco_bairro;
				$resp['ll_cidade']=$extraido_endereco_cidade;
				$resp['ll_uf']=$extraido_uf;
				$geolocalizacao=geolocalizacao($resp['ll_endereco'],$resp['ll_bairro'],$resp['ll_cidade'],$resp['ll_uf'],$resp['ll_pais']);

				if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
				if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}


			} else {

					$geolocalizacao=geolocalizacao($localizacao,'');
					if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
					if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}

					if ($geolocalizacao[2]!=''){$resp['ll_uf']=$geolocalizacao[2];}
					if ($geolocalizacao[3]!=''){$resp['ll_cidade']=$geolocalizacao[3];}
					if ($geolocalizacao[4]!=''){$resp['ll_bairro']=$geolocalizacao[4];}

					$resp['ll_endereco']=isolar_amplo('ß'.$localizacao,'ß','',$resp['ll_bairro']);
					if ($resp['ll_endereco']==''){$resp['ll_endereco']=isolar_amplo('ß'.$localizacao,'ß','',$resp['ll_cidade']);}

			}
		}
	}


	return $resp;
}

function adivinha_onde($texto,$ll_cidade='',$ll_uf=''){
	// retorna vetor com ll_uf, ll_cidade e ll_cliente prov·veis
    global $pdo;

    $licitacao_plescrada=capitalizacao_str(trim(limpaespacos(str_replace('Publicado por:','',str_replace('C A N C E L A M E N T O','CANCELAMENTO',str_replace('<br>',' PLESCRA ',$texto)))).' PLESCRA'));

	$resp=array();
	$resp['ll_cidade']=$ll_cidade;
	$resp['ll_uf']=$ll_uf;
	$resp['ll_cliente']='';

	$tipo_orgao=false;
	if ($resp['ll_cidade']==''){$resp['ll_cidade']=isolar_limpo($licitacao_plescrada,'MUNICÕPIO DE ','','PLESCRA');if ($resp['ll_cidade']!=''){$tipo_orgao='PREFEITURA MUNICIPAL DE ';}}
	if ($resp['ll_cidade']==''){$resp['ll_cidade']=isolar_limpo($licitacao_plescrada,'MUNICIPIO DE ','','PLESCRA');if ($resp['ll_cidade']!=''){$tipo_orgao='PREFEITURA MUNICIPAL DE ';}}
	if ($resp['ll_cidade']==''){$resp['ll_cidade']=isolar_limpo($licitacao_plescrada,'PREFEITURA MUNICIPAL DE ','','PLESCRA');if ($resp['ll_cidade']!=''){$tipo_orgao='PREFEITURA MUNICIPAL DE ';}}
	if ($resp['ll_cidade']==''){$resp['ll_cidade']=isolar_limpo($licitacao_plescrada,'PREFEITURA DE ','','PLESCRA');if ($resp['ll_cidade']!=''){$tipo_orgao='PREFEITURA MUNICIPAL DE ';}}
	if ($resp['ll_cidade']==''){$resp['ll_cidade']=isolar_limpo($licitacao_plescrada,'C¬MARA MUNICIPAL DE ','','PLESCRA');if ($resp['ll_cidade']!=''){$tipo_orgao='C¬MARA MUNICIPAL DE ';}}
	if ($resp['ll_cidade']==''){$resp['ll_cidade']=isolar_limpo($licitacao_plescrada,'CAMARA MUNICIPAL DE ','','PLESCRA');if ($resp['ll_cidade']!=''){$tipo_orgao='C¬MARA MUNICIPAL DE ';}}
	if ($resp['ll_cidade']==''){$resp['ll_cidade']=isolar_limpo($licitacao_plescrada,'C¬MARA DE ','','PLESCRA');if ($resp['ll_cidade']!=''){$tipo_orgao='C¬MARA MUNICIPAL DE ';}}
	if ($resp['ll_cidade']==''){$resp['ll_cidade']=isolar_limpo($licitacao_plescrada,'CAMARA DE ','','PLESCRA');if ($resp['ll_cidade']!=''){$tipo_orgao='C¬MARA MUNICIPAL DE ';}}

	if ($resp['ll_cidade']!='' && $resp['ll_uf']==''){
        $sql="SELECT * FROM geolocalizacao WHERE cod_IBGE !='' AND geo_cidade LIKE '".$resp['ll_cidade']."'";
        $res = $pdo->query( $sql );
        $numero_de_linhas = $res->rowCount();

		if ( $numero_de_linhas == 1 ) {
            $statement = $pdo->query($sql);
            $r = $statement->fetch(PDO::FETCH_ASSOC);
			$resp['ll_uf']=$r['geo_uf'];
//echo '<font color="pink">* uf encontrado com base na cidade</font>';
		}
	}

	// n„o achou uf?
	if($resp['ll_uf']==''){
        $statement = $pdo->query("SELECT * FROM uf" );
		$achei_uf=0;
		$uf_encontrado='';
		while ( $verifica_uf=$statement->fetch(PDO::FETCH_ASSOC)) {
			if (str_replace(capitalizacao_str($verifica_uf['uf_nome']),'',$licitacao_plescrada)!=$licitacao_plescrada){
				if ($achei_uf>0 && $uf_encontrado==$verifica_uf['uf']){$achei_uf+= -1;}
				$uf_encontrado=$verifica_uf['uf'];
				$achei_uf+=1;
			}
			if ($verifica_uf['uf']!='SE' && str_replace('ß'.$verifica_uf['uf'].'ß','',str_replace('.','ß',str_replace('-','ß',str_replace(' ','ß',str_replace('/','ß',str_replace(',','ß',str_replace(':','ß',str_replace('(','ß',str_replace(')','ß',
				str_replace('[','ß',str_replace(']','ß',$licitacao_plescrada)))))))))))!=str_replace('.','ß',str_replace('-','ß',str_replace(' ','ß',str_replace('/','ß',str_replace(',','ß',str_replace(':','ß',str_replace('(','ß',str_replace(')','ß',
				str_replace('[','ß',str_replace(']','ß',$licitacao_plescrada)))))))))) ){
				if ($achei_uf>0 && $uf_encontrado==$verifica_uf['uf']){$achei_uf+= -1;}
				$uf_encontrado=$verifica_uf['uf'];
				$achei_uf+=1;
			}
		}
		if ($achei_uf<=2 && str_replace('MATO GROSSO','',$licitacao_plescrada)!=$licitacao_plescrada && str_replace('DO SUL','',$licitacao_plescrada)!=$licitacao_plescrada){$uf_encontrado='MS';$achei_uf=1;}
		if ($achei_uf==1){
			$resp['ll_uf']=$uf_encontrado;
//echo '<font color="pink">* uf encontrado com base no texto</font>';
		}

	}


	// busca cidade - forÁa bruta
	if($resp['ll_uf']!='' && $resp['ll_cidade']==''){
		$todas_palavras=explode('ß',str_replace('.','ß',str_replace('-','ß',str_replace(' ','ß',str_replace('/','ß',str_replace(',','ß',str_replace(':','ß',str_replace('(','ß',str_replace(')','ß',
				str_replace('[','ß',str_replace(']','ß',$licitacao_plescrada)))))))))));
		sort($todas_palavras);
		$termo_busca_cidade='';
		$termo_anterior='';
		if (sizeof($todas_palavras)>1){
			for ($i=0;$i<sizeof($todas_palavras);$i++){
				if ($todas_palavras[$i]!='' && $todas_palavras[$i]!='REGISTRO' && $todas_palavras[$i]!=$termo_anterior){
					if ($termo_busca_cidade!=''){$termo_busca_cidade.=',';}
					$termo_busca_cidade.="'".addslashes(trim($todas_palavras[$i]))."'";
				}
			}
		}
		if ($termo_busca_cidade!=''){
            $sql="SELECT * FROM geolocalizacao WHERE cod_IBGE !='' AND geo_cidade IN ($termo_busca_cidade) AND geo_uf='".$resp['ll_uf']."'";
            $res = $pdo->query( $sql );
            $numero_de_linhas = $res->rowCount();

            if ( $numero_de_linhas == 1 ) {
                $statement = $pdo->query($sql);
                $r = $statement->fetch(PDO::FETCH_ASSOC);
				$resp['ll_cidade']=$r['geo_cidade'];
//echo '<font color="pink">* cidade encontrada com base no uf e texto</font>';

			}
		}
	}

	if ($resp['ll_cidade']=='' && $resp['ll_uf']!=''){
		$vetor_cadastro=explode('PLESCRA',$licitacao_plescrada);
		for ($i=0;$i<sizeof($vetor_cadastro);$i++){
			$linha_maiusculas=str_replace('∞','∫',capitalizacao_str(trim(limpaespacos($vetor_cadastro[$i]))));

			$ll_cidade=isolar_limpo(str_replace(' ','',$linha_maiusculas),'WWW.','','.'.$resp['ll_uf'].'.GOV.BR');
			if ($ll_cidade==''){$ll_cidade=isolar_limpo(str_replace(' ','',$linha_maiusculas),'WWW.','','.COM.BR');if (str_replace('SAAE','',$ll_cidade)==''){$ll_cidade='';}}
			$ll_cidade=str_replace('PREFEITURADE','',$ll_cidade);
			$ll_cidade=str_replace('PREFEITURA','',$ll_cidade);

			if (str_replace('SAAE','',$ll_cidade)==$ll_cidade && str_replace('PREGAOBANRISUL','',$ll_cidade)==$ll_cidade && str_replace('BEC','',$ll_cidade)==$ll_cidade &&
				str_replace('COMPRAS','',$ll_cidade)==$ll_cidade && $ll_cidade!='' && str_replace('CENTRALDECOMPRAS','',$ll_cidade)==$ll_cidade &&
				str_replace('SINFRA','',$ll_cidade)==$ll_cidade && str_replace('TCE','',$ll_cidade)==$ll_cidade){
				$tipo_orgao='PREFEITURA MUNICIPAL DE ';
				if (str_replace('SAAE','',$ll_cidade)!=$ll_cidade){$tipo_orgao='SAAE ';$ll_cidade=str_replace('SAAE','',$ll_cidade);}

                $sql="SELECT * FROM geolocalizacao WHERE cod_IBGE !='' AND REPLACE(`geo_cidade`,' ','') LIKE '".$ll_cidade."' AND geo_uf='".$resp['ll_uf']."'";
                $res = $pdo->query( $sql );
                $numero_de_linhas = $res->rowCount();

                if ( $numero_de_linhas == 1 ) {
                    $statement = $pdo->query($sql);
                    $r = $statement->fetch(PDO::FETCH_ASSOC);
					$resp['ll_cidade']=capitalizacao_str($r['geo_cidade']);
//echo '<font color="pink">* cidade encontrada com base no uf e link</font>';
				}

			}
		}
	}

	// n„o achou cidade? busca na data da publicaÁ„o
	if($resp['ll_cidade']==''){
		$vetor_cadastro=explode('PLESCRA',$licitacao_plescrada);
		for ($i=0;$i<sizeof($vetor_cadastro);$i++){
			$linha_maiusculas=str_replace('ESPECÕFICA.','',str_replace('ESPECÕFICA','',str_replace('∞','∫',capitalizacao_str(trim(limpaespacos($vetor_cadastro[$i]))))));
			if ($resp['ll_cidade']==''){
				$acheidata=isolar('ß'.$linha_maiusculas,'ß','','DE '.date("Y"));
				if ($acheidata==''){$acheidata=isolar('ß'.$linha_maiusculas,'ß','','DE '.$meses2[date("n",mktime(0,0,0,date("m"),date("j"),date("Y")))].' '.date("Y"));	}
				if ($acheidata==''){$acheidata=isolar('ß'.$linha_maiusculas,'ß','','DE '.$meses2[date("n",mktime(0,0,0,date("m")-1,date("j"),date("Y")))].' '.date("Y"));	}
				$acheidata=trim(isolar('ß'.$acheidata,'ß','',','));
				if ($acheidata!=''){
					//$resp['ll_cidade']=$acheidata;
					$qry_uf="";
					if ($resp['ll_uf']!=""){$qry_uf=" AND geo_uf='".$resp['ll_uf']."'";}

                    $sql="SELECT * FROM geolocalizacao WHERE cod_IBGE !='' AND REPLACE(`geo_cidade`,' ','') LIKE '".$acheidata."' $qry_uf";
                    $res = $pdo->query( $sql );
                    $numero_de_linhas = $res->rowCount();

                    if ( $numero_de_linhas == 1 ) {
                        $statement = $pdo->query($sql);
                        $r = $statement->fetch(PDO::FETCH_ASSOC);
						$resp['ll_cidade']=capitalizacao_str($r['geo_cidade']);
//echo '<font color="pink">* cidade encontrada com base na data de publicaÁ„o</font>';
					}

				}
			}
		}
	}

	$resp['ll_cidade']=trim(isolar('ß'.str_replace('-'.$resp['ll_uf'],'.',str_replace('- '.$resp['ll_uf'],'.',str_replace(',','.',str_replace('/','.',str_replace('(','.',str_replace(')','.',
		str_replace(';','.',str_replace(' TORNA ','.',str_replace(' OU ','.',str_replace(' AOS ','.',str_replace(' ABERTURA ','.',str_replace(' COM ','.',str_replace(' E ','.',str_replace(' POR ','.',str_replace(' PARA ','.',str_replace('AVISO ','.',$resp['ll_cidade'])))))))))))))))).'.','ß','','.'));

	if ($tipo_orgao && $resp['ll_cidade']!=''){$resp['ll_cliente']=$tipo_orgao.$resp['ll_cidade'].' - '.$resp['ll_uf'];}
	if ($resp['ll_cliente']=='' && $resp['ll_cidade']!='' && $resp['ll_uf']!='' && str_replace('PREFEIT','',$licitacao_plescrada)!=$licitacao_plescrada){$resp['ll_cliente']='PREFEITURA MUNICIPAL DE '.$resp['ll_cidade'].' - '.$resp['ll_uf'];}

	return $resp;


}

function cliente_elegivel_banner_promo($idcliente,$cnpj_usado,$cookies){
    return true;

}

function organizador_inicia ($organizador){
    global $pdo;
	return false;
}

function organizador_tempo_limite_atingido ($organizador,$extra=''){
	return false;
}

function organizador_finaliza ($organizador){

	return false;
}

function real_escape_string_mimic($inp) {
    if(is_array($inp))
        return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }

    return $inp;
}

function cliente_desde ($id){
    return true;

}

function adivinha_data ($texto){
	global $pdo;

	$meses = array("JANEIRO" => "01","FEVEREIRO" => "02","MAR«O" => "03","ABRIL" => "04","MAIO" => "05","JUNHO" => "06","JULHO" => "07","AGOSTO" => "08","SETEMBRO" => "09","OUTUBRO" => "10","NOVEMBRO" => "11","DEZEMBRO" => "12");

	$licitacao_plescrada=capitalizacao_str(trim(limpaespacos(str_replace('Publicado por:','',str_replace('C A N C E L A M E N T O','CANCELAMENTO',str_replace('<br>',' PLESCRA ',$texto)))).' PLESCRA'));

	$lic_abertura_propostas=str_replace(' ','/',str_replace(' ¿S ','/',str_replace(' A S ','/',str_replace(',','',str_replace(' DE ','/',isolar_limpo($licitacao_plescrada,'ABERTURA:','','PLESCRA'))))));
	$termos=array('ABERTURA ENVELOPES','ABERTURA DE ENVELOPES','DATA HOR¡RIO','DATA/HOR¡RIO','DATA/ HOR¡RIO','DATA/HORA','DATA/ HORA','DATA DA LICITA«√O','ENVELOPES DIA ','ENVELOPE DIA ','ABERTURA DE ENVELOPES','ABERTURA ENVELOPES','ABERTURA PROPOSTAS','DATA DISPUTA',
		'DATA REALIZA«√O SESS√O','DATA SESS√O','ABERTURA PROCESSO','INÕCIO DISPUTA','ABERTURA JULGAMENTO','SER¡ REALIZADA NA DATA ','HORAS DIA ','NO DIA ','SER¡ REALIZADA NA DATA ','AT… DIA ','SER¡ DIA','HORA LOCAL','HORA/ LOCAL','HORA/LOCAL','ABERTURA AS','ABERTURA','SESS√O:'
	);
	for ($i=0;$i<sizeof($termos);$i++){
		if ($lic_abertura_propostas==''){$lic_abertura_propostas=str_replace(' ','/',str_replace(' ¿S ','/',str_replace(' A S ','/',str_replace(',','',str_replace(' DE ','/',str_replace(' DIA','',
			isolar_limpo(limpaespacos(str_replace(':','',str_replace(' EM ',' ',str_replace(' DA ',' ',str_replace(' DAS ',' ',str_replace(' DO ',' ',str_replace(' DOS ',' ',str_replace(' SER¡ ',' ',str_replace(' E ',' ',$licitacao_plescrada))))))))),$termos[$i],'','PLESCRA')
		))))));}
	}
	if ($lic_abertura_propostas==''){$lic_abertura_propostas=str_replace(' ','/',str_replace(' ¿S ','/',str_replace(' A S ','/',str_replace(',','',str_replace(' DE ','/',isolar_limpo($licitacao_plescrada,'DO DIA ','','PLESCRA'))))));}
	if ($lic_abertura_propostas==''){$lic_abertura_propostas=str_replace(' ','/',str_replace(' ¿S ','/',str_replace(' A S ','/',str_replace(',','',str_replace(' DE ','/',isolar_limpo($licitacao_plescrada,'DO DIA:','','PLESCRA'))))));}
	if ($lic_abertura_propostas==''){$lic_abertura_propostas=str_replace(' ','/',str_replace(' ¿S ','/',str_replace(' A S ','/',str_replace(',','',str_replace(' DE ','/',str_replace(' DIA','',isolar_limpo(limpaespacos(str_replace(':','',str_replace(' DE ',' DOS ',$licitacao_plescrada))),'DOS ENVELOPES','','PLESCRA')))))));}
	if ($lic_abertura_propostas==''){$lic_abertura_propostas=str_replace(' ','/',str_replace(' ¿S ','/',str_replace(' A S ','/',str_replace(',','',str_replace(' DE ','/',isolar_limpo($licitacao_plescrada,'REALIZAR EM ','','PLESCRA'))))));}
	if ($lic_abertura_propostas==''){$lic_abertura_propostas=str_replace(' ','/',str_replace(' ¿S ','/',str_replace(' A S ','/',str_replace(',','',str_replace(' DE ','/',isolar_limpo($licitacao_plescrada,'DATA:','','PLESCRA'))))));}


	$lic_abertura_propostas=str_replace('DIA/','',$lic_abertura_propostas);

	$data0 = explode("/", $lic_abertura_propostas);
	$lic_abertura_propostas='';
	$comecou_data=0;
	for ($i=0; $i<count($data0); $i++) {
		if ($meses[$data0[$i]]!='' && $comecou_data==1){
			$lic_abertura_propostas .= $meses[$data0[$i]].'/';
			$comecou_data+=1;
		}else{
			if ((int)$data0[$i]>0 && $comecou_data<3){
				$lic_abertura_propostas.=$data0[$i].'/'; $comecou_data+=1;
			}
		}
	}


	if ($lic_abertura_propostas!=''){$lic_abertura_propostas=substr(arrumadata_robos($lic_abertura_propostas),0,8).'0000';}

	return $lic_abertura_propostas;

}

function sistema_sobrecarregado($tempomaximo=3,$cargamaxima=1){

	
	return false;
}

function foto_tamanho($url){
	return @getimagesize(str_replace(BASE_URL, '', foto_endereco($url)));
}


function foto_endereco($url){
	return BASE_URL.str_replace('http://www.leilaoguru.com.br/', '',str_replace('https://www.leilaoguru.com.br/', '', str_replace(BASE_URL, '', $url)));
}

?>
