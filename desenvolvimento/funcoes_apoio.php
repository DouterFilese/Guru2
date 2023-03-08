<?php

function NovoLeilao ($resp,$a=array(),$b=0,$c=0,$d=0,$e=0){
	print_r($resp);
}

function organizador_inicia ($organizador) { 
	return 0;
	return true;
}
function organizador_tempo_limite_atingido ($organizador) { 
	return true;
}
function organizador_finaliza ($organizador) { 
	return true;
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

function geolocalizacao($rua,$bairro='',$cidade='',$uf='',$pais='BRASIL'){

	$coordenadas=array();

	$coordenadas[0]= '-99.9999999'; // latitude fake
	$coordenadas[1]= '-99.9999999'; // longitude fake
	$coordenadas[2]= $uf;
	$coordenadas[3]= $cidade;
	$coordenadas[4]= $bairro;
	return $coordenadas;
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
    return !empty($isolado) ? $isolado : FALSE;
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

function limpahtml($texto,$limpascript=false) {
        if ($limpascript==true){$texto=limpastyle(limpascript($texto));}
        $resposta = '';
        $STOP = 0;
        for ($i = 0; $i<= strlen($texto); $i++) {
            if ($texto{$i} == "<") $STOP = 1;
            if ($texto{$i} == ">" && $STOP == 0) $resposta = '';
            if ($texto{$i} == ">") $STOP = 0;
            if ($STOP == 0 && $texto{$i} != ">") {$resposta .= $texto{$i};}
        }
        return $resposta ;
}

function VerificaCadastroLeilao($vetor){
	// funÁ„o fake com mesma funcionalidade da funÁ„o real, somente para teste de novos scripts
	// respostas:
	// true: lote j· est· cadastrado
	// false: lote ainda n„o cadastrado.
	
	
return false;
	//if (rand(0,100)<=5){return false;}else{return true;}
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
		if ($json==true){
			$fields_string = json_encode($fields);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		} else {
			if ($xml!=false){
				curl_setopt($ch,CURLOPT_POST, 1);
				curl_setopt($ch,CURLOPT_POSTFIELDS, $xml);
			} else {
				curl_setopt($ch,CURLOPT_POST, count($fields));
				curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
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
	$result = curl_exec($ch);

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
      'Gumpert,pallas,‘NIBUS,VW,HYUNDAI,ipva,chassi';
    $imoveis_possiveis='CASA,CASAS,SALA,APARTAMENTO,APARTAMENTOS,SOBRADO,SOBRADOS,RESIDENCIAL,TERRENO,TERRENOS,CHACARA,CHACARA,SITIO,SITIO,LOJA,LOJAS,FAZENDA,iptu';

    $veiculos_explodido = explode(",", str_replace(' ',',',strtoupper(strtr($veiculos_possiveis, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"))));
    $imoveis_explodido = explode(",", str_replace(' ',',',strtoupper(strtr($imoveis_possiveis, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"))));

    $texto_explodido = explode(",", str_replace(' ',',',strtoupper(strtr($texto, "·‡„‚ÈÍËÌÏÛÙıÚ˙¸˘Á¡¿√¬… »ÃÕ“”‘’Ÿ⁄‹«", "aaaaeeeiioooouuucAAAAAEEIIOOOOUUUC"))));

    if ( in_array('SUCATA', $texto_explodido) || in_array('SUCATAS', $texto_explodido) || in_array('DESMONTE', $texto_explodido)){ return array('SUCATA');}
    if ( in_array('IMOVEL', $texto_explodido) || in_array('IMOVEIS', $texto_explodido)){ goto imoveis;}
    for ($i=0; $i<count($veiculos_explodido); $i++) {
      if ( $veiculos_explodido[$i]!='' && in_array($veiculos_explodido[$i], $texto_explodido)){return array('VEÕCULOS',$veiculos_explodido[$i]);}
    }
    if ( in_array('VEICULO', $texto_explodido) || in_array('VEICULOS', $texto_explodido) || in_array('IPVA', $texto_explodido)){ return array('VEÕCULOS');}
    imoveis:
    for ($i=0; $i<count($imoveis_explodido); $i++) {
      if ( $imoveis_explodido[$i]!='' &&  in_array($imoveis_explodido[$i], $texto_explodido)){return array('IM”VEIS',$imoveis_explodido[$i]);}
    }
    if ( in_array('IMOVEL', $texto_explodido) || in_array('IMOVEIS', $texto_explodido) || in_array('IPTU', $texto_explodido)){ return array('IM”VEIS');}
    return array('OUTROS');
}
?>
