<?php

// G U R U B O T
// Módulo Leilões BB
// (c) 2010 05 Marcelon

function limpa_vetor($vetor){
    if ($vetor==array()){return array(); }

    array_walk(
        $vetor,
        function (&$entry) {
            if (is_array($entry)){
                $entry=limpa_vetor($entry);
            } else {
            $entry = limpacaracteresutf8_novo($entry);
            }
        }
    );

    return $vetor;
}

function limpacaracteresutf8_automatico ( $string ) {
	
	//$string=limpacaracteresespeciais($string);
	// antiga
	$pattern = array( 'Ã£', 'Ã¡',  'Ã¢', 'Ã‚', 'Ã€', 'Ã<81>', 
	'Ãª', 'Ã©',  
	'Ã³', 
	'Ãº', 'Ã§', 'Ã‡', 'Â°');

	$replace = array( 'ã', 'á', 'â', 'Â', 'À', 'Á', 
	'ê', 'é', 
	'ó', 
	'ú',  'ç', 'Ç', 'º');
	
	if( $string !=str_replace( $pattern, $replace, $string )){return str_replace('&nbsp;','',limpacaracteresisolatin1(limpacaracteresutf8_novo($string),2)) ;}else{return str_replace('&nbsp;','',limpacaracteresisolatin1($string,2)) ;}	
}

function limpacaracteresutf8 ( $string ) {
	// antiga
	$pattern = array( 'Ã£', 'Ã¡', 'Ã ', 'Ã¢', 'Ã‚', 'Ã€', 'Ã<81>', 'Ãƒ', 'ÃŠ', 'Ãˆ', 'Ã‰', 'Ãª', 'Ã©', 'Ã¨', 'Ã<8d>', 'ÃŒ', 'Ä¨', 'ÃŽ', 'Ã¬', 'Ã®', 'Ä©', 'Ã´', 'Ãµ', 'Ã³', 'Ã²', 'Ã´', 'Ã”', 'Ã•', 'Ã“', 'Ã“', 'Ã»', 'Ãº', 'Å©', 
	'Ã¹', 'Ã›', 'Ãš', 'Ã™', 'Å¨', 'Ã§', 'Ã‡', 'Â°', 'â€“', 'Âº',  'â'.chr(128) );

	$replace = array( 'ã', 'á', 'à', 'â', 'Â', 'À', 'Á', '{§A+TIL§}', 'Ê', 'È', 'É', 'ê', 'é', 'è', 'Í', 'Ì', '&#38;#296;', 'Î',  'ì', 'î', '&#38;#297;', 'ô', 'õ', 'ó', 'ò', 'ô', 'Ô', 'Õ', 'Ó', 'Ó', 'û', 'ú', '&#38;#361;', 'ù', 'Û', 'Ú', 'Ù', '&#38;#360;', 'ç', 'Ç', 'º', '-', '°', '"' );
	return str_replace(chr(129),'',str_replace('{§A+TIL§}','Ã',str_replace('Ã','A',str_replace('Ã'.chr(141),'Í',str_replace( $pattern, $replace, $string )))));
}

function limpacaracteresutf8_novo ( $string, $versao=1 ) {

	$string=str_replace('º','simbolonumero',$string);// 2020 06
	$string=str_replace('Ãsimbolonumero','Ãº',$string);// 2020 06

	if ($versao==2){$string=str_replace('?°','º',str_replace('?º','º',str_replace('\\','',str_replace('\\r','',str_replace('\\n','',str_replace('&#8220;','',str_replace('&#8221;','',str_replace('&#8211;','-',$string))))))));}

	return str_replace('simbolonumero','º',mb_convert_encoding($string,'CP1252','UTF-8'));
}

function limpacaractereshex ( $string ) {
	$pattern = array( '&#xAA;', '&#xB0;', '&#xB2;', '&#xB3;', '&#xB9;', '&#xBA;', '&#xC0;', '&#xC1;', '&#xC2;', '&#xC3;', '&#xC7;', '&#xC8;', '&#xC9;', '&#xCA;', '&#xCC;', '&#xCD;', '&#xD1;', '&#xD2;', '&#xD3;', '&#xD4;', '&#xD5;', '&#xD9;', '&#xDA;', '&#xDB;', '&#xDC;', '&#xE0;', '&#xE1;', '&#xE2;', '&#xE3;', '&#xE7;', '&#xE8;', '&#xE9;', '&#xEA;', '&#xEC;', '&#xED;', '&#xEE;', '&#xF1;', '&#xF2;', '&#xF3;', '&#xF4;', '&#xF5;', '&#xF9;', '&#xFA;', '&#xFB;', '&#xFC;' );

	$replace = array( 'ª', '°', '²', '³', '¹', 'º', 'À', 'Á', 'Â', 'Ã', 'Ç', 'È', 'É', 'Ê', 'Ì', 'Í', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ù', 'Ú', 'Û', 'Ü', 'à', 'á', 'â', 'ã', 'ç', 'è', 'é', 'ê', 'ì', 'í', 'î', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ù', 'ú', 'û', 'ü' );
	return str_replace( $pattern, $replace, $string ); 
}

function codificacaractereshex ( $string ) {
    $replace = array( '\\xaa', '\\xb0', '\\xb2', '\\xb3', '\\xb9', '\\xba', '\\xc0', '\\xc1', '\\xc2', '\\xc3', '\\xc7', '\\xc8', '\\xc9', '\\xca', '\\xcc', '\\xcd', '\\xd1', '\\xd2', '\\xd3', '\\xd4', '\\xd5', '\\xd9', '\\xda', '\\xdb', '\\xdc', '\\xe0', '\\xe1', '\\xe2', '\\xe3', '\\xe7', '\\xe8', '\\xe9', '\\xea', '\\xec', '\\xed', '\\xee', '\\xf1', '\\xf2', '\\xf3', '\\xf4', '\\xf5', '\\xf9', '\\xfa', '\\xfb', '\\xfc' );

    $pattern = array( 'ª', '°', '²', '³', '¹', 'º', 'À', 'Á', 'Â', 'Ã', 'Ç', 'È', 'É', 'Ê', 'Ì', 'Í', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ù', 'Ú', 'Û', 'Ü', 'à', 'á', 'â', 'ã', 'ç', 'è', 'é', 'ê', 'ì', 'í', 'î', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ù', 'ú', 'û', 'ü' );
    return str_replace( $pattern, $replace, $string ); 
}

function limpacaracteresisolatin1($texto, $versao=1){

    $texto=str_replace("&aacute;","á",$texto);
    $texto=str_replace("&acirc;","â",$texto);
    $texto=str_replace("&agrave;","à",$texto);
    $texto=str_replace("&atilde;","ã",$texto);
    $texto=str_replace("&ccedil;","ç",$texto);
    $texto=str_replace("&eacute;","é",$texto);
    $texto=str_replace("&ecirc;","ê",$texto);
    $texto=str_replace("&iacute;","í",$texto);
    $texto=str_replace("&oacute;","ó",$texto);
    $texto=str_replace("&ocirc;","ô",$texto);
    $texto=str_replace("&otilde;","õ",$texto);
    $texto=str_replace("&uacute;","ú",$texto);
    $texto=str_replace("&uuml;","ü",$texto);
    $texto=str_replace("&Aacute;","Á",$texto);
    $texto=str_replace("&Acirc;","Â",$texto);
    $texto=str_replace("&Agrave;","À",$texto);
    $texto=str_replace("&Atilde;","Ã",$texto);
    $texto=str_replace("&Ccedil;","Ç",$texto);
    $texto=str_replace("&Eacute;","É",$texto);
    $texto=str_replace("&Ecirc;","Ê",$texto);
    $texto=str_replace("&Iacute;","Í",$texto);
    $texto=str_replace("&Oacute;","Ó",$texto);
    $texto=str_replace("&Ocirc;","Ô",$texto);
    $texto=str_replace("&Otilde;","Õ",$texto);
    $texto=str_replace("&Uacute;","Ú",$texto);
    $texto=str_replace("&Uuml;","Ü",$texto);
    $texto=str_replace("&ordm;","º",$texto);
    $texto=str_replace("&ndash;","-",$texto);
    $texto=str_replace("&deg;","°",$texto);
    $texto=str_replace("&gt;",">",$texto);
    $texto=str_replace("&quot;",'"',$texto);
    $texto=str_replace("&amp;","&",$texto);
    $texto=str_replace("&lt;","<",$texto);
    $texto=str_replace("&circ;","^",$texto);
    $texto=str_replace("&tilde;","~",$texto);
    $texto=str_replace("&ensp;"," ",$texto);
    $texto=str_replace("&minus;","-",$texto);
    $texto=str_replace("&ordf;","ª",$texto);
    $texto=str_replace("&#8211;","-",$texto);

    if ($versao==2){$texto=str_replace('?°','º',str_replace('?º','º',str_replace('&ldquo;','',str_replace('&rdquo;','',str_replace('\\','',str_replace('\\r','',str_replace('\\n','',str_replace('&nbsp;','',str_replace('Â°','º',str_replace('Âº','º',$texto))))))))));}

    return $texto;
}


function limpacaracteresisolatin1_v2($texto){
    $texto=str_replace("&aacute;","á",$texto);
    $texto=str_replace("&acirc;","â",$texto);
    $texto=str_replace("&agrave;","à",$texto);
    $texto=str_replace("&atilde;","ã",$texto);
    $texto=str_replace("&ccedil;","ç",$texto);
    $texto=str_replace("&eacute;","é",$texto);
    $texto=str_replace("&ecirc;","ê",$texto);
    $texto=str_replace("&iacute;","í",$texto);
    $texto=str_replace("&oacute;","ó",$texto);
    $texto=str_replace("&ocirc;","ô",$texto);
    $texto=str_replace("&otilde;","õ",$texto);
    $texto=str_replace("&uacute;","ú",$texto);
    $texto=str_replace("&uuml;","ü",$texto);
    $texto=str_replace("&Aacute;","Á",$texto);
    $texto=str_replace("&Acirc;","Â",$texto);
    $texto=str_replace("&Agrave;","À",$texto);
    $texto=str_replace("&Atilde;","Ã",$texto);
    $texto=str_replace("&Ccedil;","Ç",$texto);
    $texto=str_replace("&Eacute;","É",$texto);
    $texto=str_replace("&Ecirc;","Ê",$texto);
    $texto=str_replace("&Iacute;","Í",$texto);
    $texto=str_replace("&Oacute;","Ó",$texto);
    $texto=str_replace("&Ocirc;","Ô",$texto);
    $texto=str_replace("&Otilde;","Õ",$texto);
    $texto=str_replace("&Uacute;","Ú",$texto);
    $texto=str_replace("&Uuml;","Ü",$texto);
    $texto=str_replace("&ordm;","º",$texto);
    $texto=str_replace("&ndash;","-",$texto);
    $texto=str_replace("&deg;","°",$texto);
    $texto=str_replace("&gt;",">",$texto);
    $texto=str_replace("&quot;",'"',$texto);
    $texto=str_replace("&amp;","&",$texto);
    $texto=str_replace("&lt;","<",$texto);
    $texto=str_replace("&circ;","^",$texto);
    $texto=str_replace("&tilde;","~",$texto);
    $texto=str_replace("&ensp;"," ",$texto);
    $texto=str_replace("&minus;","-",$texto);
    $texto=str_replace("&ordf;","ª",$texto);
    $texto=str_replace("&#8211;","-",$texto);
    
    $texto=str_replace("&sup2;","²",$texto);
    $texto=str_replace("&rdquo;","",$texto);
    $texto=str_replace("&ldquo;","",$texto);
    $texto=str_replace("&nbsp;","",$texto);

    return $texto;
}
function encodeurl2($text) {
	$ENCODE_TABLE = ARRAY(33=>'%21', 35=>'%23', 36=>'%24', 37=>'%25', 38=>'%26', 40=>'%28', 41=>'%29', 43=>'%2B', 44=>'%2C', 47=>'%2F', 58=>'%3A', 59=>'%3B', 60=>'%3C', 61=>'%3D', 62=>'%3E', 63=>'%3F', 91=>'%5B', 92=>'%5C', 93=>'%5D', 123=>'%7B', 124=>'%7C', 125=>'%7D', 142=>'%C5%BD', 192=>'%C3%80', 193=>'%C3%81', 194=>'%C3%82', 195=>'%C3%83', 196=>'%C3%84', 197=>'%C3%85', 199=>'%C3%87', 200=>'%C3%88', 201=>'%C3%89', 202=>'%C3%8A', 203=>'%C3%8B', 204=>'%C3%8C', 205=>'%C3%8D', 206=>'%C3%8E', 207=>'%C3%8F', 210=>'%C3%92', 211=>'%C3%93', 212=>'%C3%94', 213=>'%C3%95', 214=>'%C3%96', 217=>'%C3%99', 218=>'%C3%9A', 219=>'%C3%9B', 220=>'%C3%9C', 221=>'%C3%9D', 224=>'%C3%A0', 225=>'%C3%A1', 226=>'%C3%A2', 227=>'%C3%A3', 228=>'%C3%A4', 229=>'%C3%A5', 231=>'%C3%A7', 232=>'%C3%A8', 233=>'%C3%A9', 234=>'%C3%AA', 235=>'%C3%AB', 236=>'%C3%AC', 237=>'%C3%AD', 238=>'%C3%AE', 239=>'%C3%AF', 242=>'%C3%B2', 243=>'%C3%B3', 244=>'%C3%B4', 245=>'%C3%B5', 246=>'%C3%B6', 249=>'%C3%B9', 250=>'%C3%BA', 251=>'%C3%BB', 252=>'%C3%BC', 253=>'%C3%BD', 255=>'%C3%BF');
    while(list($ord, $enc) = each($ENCODE_TABLE)) {
    $text = str_replace(chr($ord), $enc, $text);
    }
    $text = str_replace(' ', '%20', $text);
	return $text;
}

function encodeurl3($string) {
	$pattern = array( 'À','Á','Â','Ã','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ù','Ú','Û','Ü','à','á','â','ã','ç','è','é','ê','ì','í','î','ñ','ò','ó','ô','õ','ù','ú','û','ü');
	$replace = array( '%C3%80','%C3%81','%C3%82','%C3%83','%C3%87','%C3%88','%C3%89','%C3%8A','%C3%8B','%C3%8C','%C3%8D','%C3%8E','%C3%8F','%C3%91','%C3%92','%C3%93','%C3%94','%C3%95','%C3%99','%C3%9A','%C3%9B','%C3%9C','%C3%A0','%C3%A1','%C3%A2','%C3%A3','%C3%A7','%C3%A8','%C3%A9','%C3%AA','%C3%AC','%C3%AD','%C3%AE','%C3%B1','%C3%B2','%C3%B3','%C3%B4','%C3%B5','%C3%B9','%C3%BA','%C3%BB','%C3%BC' );
	return str_replace( $pattern, $replace, $string ); 
}

function encodeurl5($string) {
    return str_replace('+','%20',str_replace('%26','&',str_replace('%3D','=',str_replace('%C2%96','%E2%80%93',urlencode(utf8_encode($string ))))));
}


function encode_parametros_get($text){
	while ( $parametro=stristr($text, '=') ){
		$parametro=isolar($parametro.'&','=','','&');
		$text=str_replace('='.$parametro,'plescraigual'.encodeurl2($parametro),$text);
	}
	$text=str_replace('plescraigual','=',$text);
	return $text;
}

function limpaunicode($string){
	$pattern = array( '\u00e1', '\u00e0', '\u00e2', '\u00e3', '\u00e4', '\u00c1', '\u00c0', '\u00c2', '\u00c3', '\u00c4', '\u00e9', '\u00e8', '\u00ea', '\u00ea', '\u00c9', '\u00c8', '\u00ca', '\u00cb', '\u00ed', '\u00ec', '\u00ee', '\u00ef', '\u00cd', '\u00cc', '\u00ce', '\u00cf', '\u00f3', '\u00f2', '\u00f4', '\u00f5', '\u00f6', '\u00d3', '\u00d2', '\u00d4', '\u00d5', '\u00d6', '\u00fa', '\u00f9', '\u00fb', '\u00fc', '\u00da', '\u00d9', '\u00db', '\u00e7', '\u00c7', '\u00f1', '\u00d1', '\u0026', '\u0027', '\u00ba', '\u00b0' , '\u00b2');
	$replace = array( 'á', 'à', 'â', 'ã', 'ä', 'Á', 'À', 'Â', 'Ã', 'Ä', 'é', 'è', 'ê', 'ê', 'É', 'È', 'Ê', 'Ë', 'í', 'ì', 'î', 'ï', 'Í', 'Ì', 'Î', 'Ï', 'ó', 'ò', 'ô', 'õ', 'ö', 'Ó', 'Ò', 'Ô', 'Õ', 'Ö', 'ú', 'ù', 'û', 'ü', 'Ú', 'Ù', 'Û', 'ç', 'Ç', 'ñ', 'Ñ', '&', "'", 'º','°', '²' );
	return str_replace( $pattern, $replace, $string ); 
}

function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}
function limpaunicode_v2($str) {
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $str);
}

function limpaoctl($string){
	$pattern = array( '\041', '\042', '\043', '\044', '\045', '\046', '\047', '\050', '\051', '\052', '\053', '\054', '\055', '\056', '\057', '\060', '\071', '\072', '\073', '\074', '\075', '\076', '\077', '\100', '\101', '\132', '\133', '\134', '\135', '\136', '\137', '\140', '\141', '\172', '\173', '\174', '\175', '\176', '\241', '\242', '\243', '\244', '\245', '\246', '\247', '\250', '\251', '\252', '\253', '\254', '\255', '\256', '\257', '\260', '\261', '\262', '\263', '\264', '\265', '\266', '\267', '\270', '\271', '\272', '\273', '\274', '\275', '\276', '\277', '\300', '\301', '\302', '\303', '\304', '\305', '\306', '\307', '\310', '\311', '\312', '\313', '\314', '\315', '\316', '\317', '\320', '\321', '\322', '\323', '\324', '\325', '\326', '\327', '\330', '\331', '\332', '\333', '\334', '\335', '\336', '\337', '\340', '\341', '\342', '\343', '\344', '\345', '\346', '\347', '\350', '\351', '\352', '\353', '\354', '\355', '\356', '\357', '\360', '\361', '\362', '\363', '\364', '\365', '\366', '\367', '\370', '\371', '\372', '\373', '\374', '\375', '\376', '\377');
	$replace = array( '!', '"', '#', '$', '%', '&', "'", '(', ')', '*', '+', ',', '-', '.', '/', '0', '9', ':', ';', '<', '=', '>', '?', '@', 'A', 'Z', '[', '\\', ']', '^', '_', '`', 'a', 'z', '{', '|', '}', '~', '¡', '¢', '£', '¤', '¥', '¦', '§', '¨', '©', 'ª', '«', '¬', '­', '®', '¯', '°', '±', '²', '³', '´', 'µ', '¶', '·', '¸', '¹', 'º', '»', '¼', '½', '¾', '¿', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ' );
	return str_replace( $pattern, $replace, $string ); 
}

function limpaescape($string){
	$pattern = array( '%24', '%20', '%3C', '%3E', '%23', '%25', '%2B', '%7B', '%7D', '%7C', '%5C', '%5E', '%7E', '%5B', '%5D', '%60', '%3B', '%2F', 
	'%3F', '%3A', '%40' ,'%3D', '%26', '%24', '%2C', '%E1', '%E0', '%E2', '%E3', '%E4', '%C1', '%C0', '%C2', '%C3', '%C4', '%E9', '%E8', '%EA', 
	'%EA', '%C9', '%C8', '%CA', '%CB', '%ED', '%EC', '%EE', '%EF', '%CD', '%CC', '%CE', '%CF', '%F3', '%F2', '%F4', '%F5', '%F6', '%D3', '%D2', 
	'%D4', '%D5', '%D6', '%FA', '%F9', '%FB', '%FC', '%DA', '%D9', '%DB', '%E7', '%C7', '%F1', '%D1', '%26', '%27');
	$replace = array( '$' , ' ', '<', '>', '#', '%', '+', '{', '}', '|', '/', '^', '~', '[', ']', "'", ';', '/', '?', ':', '@','=', '&', '$', ',','á', 'à', 'â', 'ã', 'ä', 'Á', 'À', 'Â', 'Ã', 'Ä', 'é', 'è', 'ê', 'ê', 'É', 'È', 'Ê', 'Ë', 'í', 'ì', 'î', 'ï', 'Í', 'Ì', 'Î', 'Ï', 'ó', 'ò', 'ô', 'õ', 'ö', 'Ó', 'Ò', 'Ô', 'Õ', 'Ö', 'ú', 'ù', 'û', 'ü', 'Ú', 'Ù', 'Û', 'ç', 'Ç', 'ñ', 'Ñ', '&', "'");

	return str_replace( $pattern, $replace, $string ); 
}

function char_convert($string) {

    $replace = array("©","Û","®","z","Ü","Y","Ý","$","Þ","%","¡","ß","¢","à","£","á","À","¤","â","Á","¥","ã","Â","¦","ä","Ã","§","å","Ä","¨","æ","Å","©","ç","Æ","ª","è","Ç","«","é","È","¬","ê","É","­","ë","Ê","®","ì","Ë","¯","í","Ì","°","î","Í","±","ï","Î","²","ð","Ï","³","ñ","Ð","´","ò","Ñ","µ","ó","Õ","¶","ô","Ö","·","õ","Ø","¸","ö","Ù","¹","÷","Ú","º","ø","Û","»","ù","Ü","@","¼","ú","Ý","½","û","Þ","EURO","¾","ü","ß","¿","ý","à",",","À","þ","á","f","Á","ÿ","å",",,","Â","æ","...","Ã","ç","+","Ä","è","+","Å","é","^","Æ","ê","%o","Ç","ë","S","È","ì","<","É","í","CE","Ê","î","Ë","ï","Z","Ì","ð","Í","ñ","Î","ò","'","Ï","ó","'","Ð","ô","''","Ñ","õ","''","Ò","ö",".","Ó","ø","-","Ô","ù","-","Õ","ú","~","Ö","û","TM","×","ý","s","Ø","þ",">","Ù","ÿ","ae","Ú");
    $pattern = array("&copy;","&#219;","&reg;","&#158;","&#220;","&#159;","&#221;","&#36;","&#222;","&#37;","&#161;","&#223;","&#162;","&#224;","&#163;","&#225;","&Agrave;","&#164;","&#226;","&Aacute;","&#165;","&#227;","&Acirc;","&#166;","&#228;","&Atilde;","&#167;","&#229;","&Auml;","&#168;","&#230;","&Aring;","&#169;","&#231;","&AElig;","&#170;","&#232;","&Ccedil;","&#171;","&#233;","&Egrave;","&#172;","&#234;","&Eacute;","&#173;","&#235;","&Ecirc;","&#174;","&#236;","&Euml;","&#175;","&#237;","&Igrave;","&#176;","&#238;","&Iacute;","&#177;","&#239;","&Icirc;","&#178;","&#240;","&Iuml;","&#179;","&#241;","&ETH;","&#180;","&#242;","&Ntilde;","&#181;","&#243;","&Otilde;","&#182;","&#244;","&Ouml;","&#183;","&#245;","&Oslash;","&#184;","&#246;","&Ugrave;","&#185;","&#247;","&Uacute;","&#186;","&#248;","&Ucirc;","&#187;","&#249;","&Uuml;","&#64;","&#188;","&#250;","&Yacute;","&#189;","&#251;","&THORN;","&#128;","&#190;","&#252","&szlig;","&#191;","&#253;","&agrave;","&#130;","&#192;","&#254;","&aacute;","&#131;","&#193;","&#255;","&aring;","&#132;","&#194;","&aelig;","&#133;","&#195;","&ccedil;","&#134;","&#196;","&egrave;","&#135;","&#197;","&eacute;","&#136;","&#198;","&ecirc;","&#137;","&#199;","&euml;","&#138;","&#200;","&igrave;","&#139;","&#201;","&iacute;","&#140;","&#202;","&icirc;","&#203;","&iuml;","&#142;","&#204;","&eth;","&#205;","&ntilde;","&#206;","&ograve;","&#145;","&#207;","&oacute;","&#146;","&#208;","&ocirc;","&#147;","&#209;","&otilde;","&#148;","&#210;","&ouml;","&#149;","&#211;","&oslash;","&#150;","&#212;","&ugrave;","&#151;","&#213;","&uacute;","&#152;","&#214;","&ucirc;","&#153;","&#215;","&yacute;","&#154;","&#216;","&thorn;","&#155;","&#217;","&yuml;","&#156;","&#218;");

	return str_replace( $pattern, $replace, $string ); 
 }

function colocaescape($string){
	$pattern = array( ' ', '<', '>', '#', '%', '+', '{', '}', '|',  '^', '~', '[', ']', "'", ';', '/', '?', ':', '@','=', '&', '$', ',','á', 'à', 'â', 'ã', 'ä', 'Á', 'À', 'Â', 'Ã', 'Ä', 'é', 'è', 'ê', 'ê', 'É', 'È', 'Ê', 'Ë', 'í', 'ì', 'î', 'ï', 'Í', 'Ì', 'Î', 'Ï', 'ó', 'ò', 'ô', 'õ', 'ö', 'Ó', 'Ò', 'Ô', 'Õ', 'Ö', 'ú', 'ù', 'û', 'ü', 'Ú', 'Ù', 'Û', 'ç', 'Ç', 'ñ', 'Ñ', '&', "'");
	$replace = array( '%20', '%3C', '%3E', '%23', '%25', '%2B', '%7B', '%7D', '%7C', '%5E', '%7E', '%5B', '%5D', '%60', '%3B', '%2F', 
	'%3F', '%3A', '%40' ,'%3D', '%26', '%24', '%2C', '%E1', '%E0', '%E2', '%E3', '%E4', '%C1', '%C0', '%C2', '%C3', '%C4', '%E9', '%E8', '%EA', 
	'%EA', '%C9', '%C8', '%CA', '%CB', '%ED', '%EC', '%EE', '%EF', '%CD', '%CC', '%CE', '%CF', '%F3', '%F2', '%F4', '%F5', '%F6', '%D3', '%D2', 
	'%D4', '%D5', '%D6', '%FA', '%F9', '%FB', '%FC', '%DA', '%D9', '%DB', '%E7', '%C7', '%F1', '%D1', '%26', '%27');

	return str_replace( $pattern, $replace, $string ); 
}

function limpaespacos($texto){
	return trim(preg_replace( '/\s+/', ' ', $texto ));
}

function limpacaracteresfantasma($texto){
    for ($i=1; $i<=31; $i++) {
        $texto=str_replace(chr($i),"",$texto);
        $texto=str_replace(chr(156),"",$texto);
    }
    return $texto;
}
function limpacaracteresespeciais($texto){
    for ($i=128; $i<=191; $i++) {
        $texto=str_replace(chr($i),"",$texto);
    }
    return $texto;
}
function limpaantesletras($texto){
    for ($i=1; $i<65; $i++) {
        if (chr($i)!=' '){$texto=str_replace(chr($i),"",$texto);}
    }
    return $texto;
}

function limpacomentarios($texto){
	
	$continua=true;
	while ($continua==true){
		$comentario=isolar($texto,'<!--','','-->');
		if ($comentario==''){
			$continua=false;
		} else {
			$texto=str_replace('<!--'.$comentario.'-->','',$texto);
		}
	}
	return $texto;
}

function espacapontuacao_v0($texto,$limpaespacos=true){
    $caracteres=explode('a','/a.a,a;a|a:a=a-a+a(a)a[a]a{a}a!a?');
    for ($i=0;$i<sizeof($caracteres);$i++){
        $texto=str_replace($caracteres[$i],$caracteres[$i].' ',$texto);
    }
    if ($limpaespacos==true){$texto=limpaespacos($texto);}
    return $texto;
}

function espacapontuacao($texto,$limpaespacos=true){

    if (strlen($texto)>1){
        $var0=substr($texto,-1);
        $eh_caractere0=preg_match('/^[a-zA-Z0-9À-ÿ ]+$/', $var0);
        for ($i=(strlen($texto)-1);$i>=0;$i--){
            $var=substr($texto,$i,1);
            $eh_caractere=preg_match('/^[a-zA-Z0-9À-ÿ ]+$/', $var);
            if (!$eh_caractere && $eh_caractere0){
                // caractere atual não é (letra/nº ou espaço) mas o posterior era!
                if ($var0!=' '){
                    $texto=substr($texto,0,$i+1).' '.substr($texto,$i-strlen($texto)+1);
                }
            }
            $var0=$var;
            $eh_caractere0=$eh_caractere;
        }
    }
    if ($limpaespacos==true){$texto=limpaespacos($texto);}
    return $texto;
}

function so_letras_numeros_espacos($texto){

    if (strlen($texto)>0){
        $texto_inicial=$texto;
        $texto='';
        for ($i=0;$i<strlen($texto_inicial);$i++){
            $var=substr($texto_inicial,$i,1);
            if (preg_match('/^[a-zA-Z0-9À-ÿ ]+$/', $var)){$texto.=$var;}
        }
    }
    return $texto;
}

function so_letras_numeros_espacos_virgula($texto){

    if (strlen($texto)>0){
        $texto_inicial=$texto;
        $texto='';
        for ($i=0;$i<strlen($texto_inicial);$i++){
            $var=substr($texto_inicial,$i,1);
            if (preg_match('/^[a-zA-Z0-9À-ÿ ,]+$/', $var)){$texto.=$var;}
        }
    }
    return $texto;
}

?>
