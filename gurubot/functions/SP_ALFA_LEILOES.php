<?php

$inicializacaocards=(int)organizador_inicia (SITE_SP_ALFA_LEILOES);
$contacards=0;
$pagina = 1;

// controle de tempo de execu??o
$tempolimite = 90;
$tempoinicio=strtotime(date("Y-m-d H:i:s"));




$site = 'https://www.alfaleiloes.com/';
$html = mb_convert_encoding(file_get_contents($site),'CP1252','UTF-8');
//echo $html;

$menu = isolar($html,'<ul ng-if="vm.dropdown[0]" class="dropdown-menu" style="width: 650px">','','<div class="dropdown col-md-2">');
//echo $menu;

while($categorias_menu = isolar($menu,'<spa','','</ol>')){
    $menu = str_replace('<spa'.$categorias_menu,'',$menu);
    $nome_categoria = isolar($categorias_menu,'n>','','</span>');
    $categorias_menu = str_replace('n>'.$nome_categoria,'',$categorias_menu);

        
    while($subcategoria = isolar($categorias_menu,'ng-checked="vm.optionChecked','','</li>')){
          $categorias_menu = str_replace('ng-checked="vm.optionChecked'.$subcategoria,'',$categorias_menu);
          $id_subcategoria = isolar($subcategoria,'(','',',');
          $nome_subcategoria = isolar($subcategoria,'>','','<');
          $pagina = 1;
          while($pagina >= 1){

            $leilao = 'https://www.alfaleiloes.com/leiloes?s=%7B%22categories%22%3A%5B'.$id_subcategoria.'%5D%7D&pagina='.$pagina;
            //$leilao = 'https://www.alfaleiloes.com/leiloes?s=%7B%22categories%22%3A%5B31%5D%7D&pagina='.$pagina;
            $conteudo_leilao = mb_convert_encoding(file_get_contents($leilao),'CP1252','UTF-8');
            $conteudo = isolar($conteudo_leilao,'<div class="col-sm-3 item">','','</center>');
            if($conteudo != ''){
             /*   echo 'tem conteudo';
                echo '<br>';
                echo '*****<br>';
               */
            while($cards = isolar($conteudo_leilao,'<div class="col-sm-3 item">','','</center>')){
                $conteudo_leilao = str_replace('<div class="col-sm-3 item">'.$cards,'',$conteudo_leilao);
               // echo $cards;

                
                    $status = isolar($cards,'<div class="status ','"><h5>','</');
                    $status = strtoupper($status);
                    $url_card = isolar($cards,'<div class="box">','<a href="','">');
                    $url_card = 'https://www.alfaleiloes.com'.$url_card;

                    //echo $url_card;
                    //echo '<br>';
                    $verifica_lotes = strpos($url_card,'lotes');

                    if($verifica_lotes === false){
                        if($status == 'ABERTO'){
                            
                            /* echo 'Nome da categoria '.$nome_categoria;
                            echo '<br>';
                            echo 'id da subcategoria '.$id_subcategoria;
                            echo '<br>';
                            echo 'nome subcategoria' .$nome_subcategoria;
                            echo '<br>';
                            echo $leilao;
                            echo '<br>';
                            echo 'status '.$status;
                            echo '<br>';
                            echo $url_card;
                            echo '<br>';
                            echo '<br>';
                            echo '*****';
                            echo '<br>';*/
                            $contacards+=1;
                            if ($contacards>=$inicializacaocards){
                            echo '['.$contacards.']';
                            $resp = array();
                            
                            $resp['organizador']=SITE_SP_ALFA_LEILOES; // nome do script [int]
                            $resp['ll_pais']='BRASIL'; // Pa?s [varchar 64]
                            $resp['ll_idioma']='pt-BR'; // Idioma do texto [varchar 8]
                            $resp['ll_moeda']='BRL'; // Moeda (BRL= Real Brasileiro) [varchar 4]
                            $resp['ll_link'] = $url_card;
                            $resp['ll_agregador_link'] = $url_card;//$leilao; 
                            
                            if (!VerificaCadastroLeilao($resp)){
                                cadastraSP_ALFA_LEILOES($resp,$nome_categoria,$nome_subcategoria);//chamando a função
            
                                //controle de tempo
                                $tempoexecucao=strtotime(date("Y-m-d H:i:s"))-$tempoinicio;
                                if ($tempoexecucao>=$tempolimite){goto fim_antecipado;}
                            }
                            }
                                                   
                        }
                        
                        
                    }else {
                        $link_leilao = mb_convert_encoding(file_get_contents($url_card),'CP1252','UTF-8');
                        //echo $link_leilao;
                        while($card_lote = isolar($link_leilao,'<div class="col-xs-12">','','</center>')){
                            $link_leilao = str_replace('<div class="col-xs-12">'.$card_lote,'',$link_leilao);
                            //echo $card_lote;
                            $ll_link = isolar($card_lote,'<center>','<a href="','"');
                            $status = isolar($card_lote,'<div class="status','<h5>','</h5>');
                            if($status == 'Aberto'){
                               /* echo $ll_link;
                                echo '<br>';
                                echo $status;
                                echo '<br>';
                                echo $card_lote;*/
                            

                                $contacards+=1;
                                if ($contacards>=$inicializacaocards){
                                echo '['.$contacards.']';
                                $resp = array();
                                
                                $resp['organizador']=SITE_SP_ALFA_LEILOES; // nome do script [int]
                                $resp['ll_pais']='BRASIL'; // Pa?s [varchar 64]
                                $resp['ll_idioma']='pt-BR'; // Idioma do texto [varchar 8]
                                $resp['ll_moeda']='BRL'; // Moeda (BRL= Real Brasileiro) [varchar 4]
                                $resp['ll_link'] = 'https://www.alfaleiloes.com'.$ll_link;
                                $resp['ll_agregador_link'] = $url_card;//$leilao; 
                                
                                                                
                            // $resp['ll_descricao'] = '';
                                //print_r($resp);
                                if (!VerificaCadastroLeilao($resp)){
                                 cadastraSP_ALFA_LEILOES($resp,$nome_categoria,$nome_subcategoria);//chamando a função
                
                                    //controle de tempo
                                    $tempoexecucao=strtotime(date("Y-m-d H:i:s"))-$tempoinicio;
                                    if ($tempoexecucao>=$tempolimite){goto fim_antecipado;}
                                }
                                }
                            }//if
                        } //fechamento while
                      /*  echo $url_card;
                        echo '<br>';
                        
                        echo '<br>';
                        echo 'Nome da categoria '.$nome_categoria;
                        echo '<br>';
                        echo 'id da subcategoria '.$id_subcategoria;
                        echo '<br>';
                        echo 'nome subcategoria' .$nome_subcategoria;
                        echo '<br>';
                        echo $leilao;
                        echo '<br>';*/
                    }

                    if($status == 'ABERTO'){
/*
                        echo 'Nome da categoria '.$nome_categoria;
                        echo '<br>';
                        echo 'id da subcategoria '.$id_subcategoria;
                        echo '<br>';
                        echo 'nome subcategoria' .$nome_subcategoria;
                        echo '<br>';
                        echo $leilao;
                        echo '<br>';
                        echo 'status '.$status;
                        echo '<br>';
                        echo $url_card;
                        echo '<br>';
                        echo '<br>';
                       */
                    }
                 /*   echo 'paginação'.$pagina;
                    echo '<br>';
                    echo 'proxima categoria*****';
                    echo '<br>';
                    */
            }
            $pagina ++;
            }else{
              /*  echo 'SEM CONTEUDO';
                echo '<br>';
                echo 'Pagina'.$pagina;
                echo '<br>';*/
                $pagina = 0;
            }


          }//while paginação

    }

}



goto fim;
fim_antecipado:
echo '<br>Terminou antes do previsto. Tempo de execução: '.$tempoexecucao;


organizador_tempo_limite_atingido (SITE_SP_ALFA_LEILOES,$contacards);
goto fim2;

fim:
organizador_finaliza (SITE_SP_ALFA_LEILOES);
echo '<br>Terminei tudo. Tempo de execução: '.$tempoexecucao.'s';

fim2:
//chama a fun??o



function cadastraSP_ALFA_LEILOES($resp,$nome_categoria,$nome_subcategoria){
    

        //$conteudo_extraido = file_get_contents($resp['ll_link']);
        $conteudo_extraido = str_replace('&nbsp;',' ',limpacaracteresisolatin1(mb_convert_encoding(file_get_contents($resp['ll_link']),'CP1252','UTF-8')));
        

        $ll_natureza = str_replace('&NBSP;','',strtoupper(isolar($conteudo_extraido,'<div class="col-sm-12" style="text-align:center">','<h3>','<span')));
        if($ll_natureza == 'JUDICIAL'){
            $ll_natureza = 1;
        }elseif ($ll_natureza == 'EXTRA JUDICIAL') {
            $ll_natureza = 0;
        }elseif ($ll_natureza == 'PÚBLICO') {
            $ll_natureza = 2;
        }elseif (stristr($ll_natureza,'PARTICULAR',true)) {
            $ll_natureza = 0;
        }
        $resp['ll_natureza'] = $ll_natureza; // 0=extra judicial; 1=judicial; 2=p?blico [int]
		$resp['ll_venda_direta'] = $ll_venda_direta; // 0=n?o; 1=sim [int]

		$resp['ll_comitente']= $ll_comitente;//***sem nome // nome do comitente do lote [varchar 256]
		
		//$resp['ll_agregador_link'] = $ll_agregador_link; // link para ver todos os lotes (leil?o que inclui os lotes) [varchar 512]
		//$resp['url_card'] = $url_card;
		$resp['ll_lote']= $ll_lote; // n?mero do lote [varchar 8]
		$resp['ll_obs'] = $ll_obs; // observa??es relevantes, quando dispon?veis [varchar 256]
        $ll_avaliacao = trim(str_replace('&nbsp;','',str_replace(',','.',str_replace('.','',isolar($conteudo_extraido,'<strong>Valor d','R$','<')))));
		$resp['ll_avaliacao'] = $ll_avaliacao; // valor de avalia??o, quando dispon?vel [varchar 32]

            //Captura das fotos
	$contapix=0;
	$pix0=$conteudo_extraido;
	while(  $pix=isolar($pix0,'<div class="bg-img" style="background-image: url(','',');') ) {
		$pix0=str_replace('<div class="bg-img" style="background-image: url('.$pix,'', $pix0);
        $thumb = stripos($pix,'thumb');
      //  $pix = stristr($pix,'thumb');
        if($thumb !== false){
            $pix =  'achei thumb';
        }
        if($pix !='achei thumb' && $pix !='assets/new_layout/img/logo.png' && $pix !='/upload/imagem/logo_gray_n.png' ){
            $contapix+=1;
        if ($contapix<=8){
            $resp['ll_foto_'.$contapix]='https://www.alfaleiloes.com'.str_replace("'","",$pix);
           
        } else {
            $pix0='';
        }
    }
	}


        $lances = explode('<br>',isolar($conteudo_extraido,'<div class="table-lances small-view">','','<div class="table-lances large-view"'));
       // $resp['lances'] = $lances;
        $data_1 = $lances[3].stristr($lances[4],'</',true);
        $ll_data_1= str_replace(':','',str_replace(' ','',str_replace('/','',trim($data_1))));
		$resp['ll_data_1'] = substr($ll_data_1,4,4).substr($ll_data_1,2,2).substr($ll_data_1,0,2).substr($ll_data_1,8,4);// data da primeira pra?a [YYYYmmddHHii]
        $ll_lance_min_1 = str_replace(',','.',str_replace('.','',str_replace('R$','',str_replace('<s>','',stristr($lances[5],'</',true)))));
		$resp['ll_lance_min_1'] = trim($ll_lance_min_1); // lance m?nimo da primeira pra?a [varchar 32]

        $data_2 = $lances[8].stristr($lances[9],'</',true);
        $ll_data_2 = str_replace(':','',str_replace(' ','',str_replace('/','',trim($data_2))));
        $resp['ll_data_2'] = substr($ll_data_2,4,4).substr($ll_data_2,2,2).substr($ll_data_2,0,2).substr($ll_data_2,8,4);
		//$resp['ll_data_2'] = str_replace(':','',str_replace(' ','',str_replace('/','',trim($ll_data_2))));// data da segunda pra?a, quando houver [YYYYmmddHHii]

        $ll_lance_min_2 = str_replace(',','.',str_replace('.','',str_replace('R$','',stristr($lances[10],'</div>',true))));					 
		$resp['ll_lance_min_2'] = trim($ll_lance_min_2); // lance m?nimo da segunda pra?a [varchar 32]

        $ll_processo = isolar($conteudo_extraido,'<strong>Processo</strong><br>','target="_blank">','</a>');
		$resp['ll_processo'] = $ll_processo;// n?mero do processo, quando dispon?vel [varchar 64]

		$resp['ll_categoria_rotulo'] = $nome_subcategoria;// texto da ?ltima categoria ao qual o lote de enquadra. Exemplo: "UTILIT?RIOS" ,"TRATOR", "TERRENO", "APARTAMENTO", "CASA" ** SEMPRE QUE SE TRATAR DE SUCATA, CADASTRAR COM O TERMO "SUCATA" [varchar 64]
       // $categoria_txt
        if($nome_subcategoria){
            $nome_categoria_final = 'Imóveis';
        }elseif($nome_subcategoria){
            $resp["ll_categoria_txt"] = $nome_subcategoria;
        }
        $resp["ll_categoria_txt"] = $nome_categoria_final.', '.$nome_subcategoria;
        if($nome_categoria == 'Outros'){
            $resp["ll_categoria_txt"] = $nome_subcategoria;
        }
        
		if (str_replace('SUCATA','',strtoupper($resp['ll_descricao']))!=strtoupper($resp['ll_descricao']) || str_replace('SUCATA','',strtoupper($resp['ll_detalhes']))!=strtoupper($resp['ll_detalhes']) || str_replace('SUCATA','',strtoupper($resp['ll_agregador']))!=strtoupper($resp['ll_agregador'])){
			$resp['ll_categoria_txt'].=','.'SUCATAS';
			$resp['ll_categoria_rotulo']=' SUCATAS';
		}
		

        $endereco = isolar($conteudo_extraido,'<h1 class="title-lote">','','</h1>');
        $endereco = stristr($endereco,')',true);
        $ll_endereco = str_replace('&nbsp;','',isolar($conteudo_extraido,'Situad','<u>','/u>'));
		$resp['ll_endereco'] = str_replace('<','',$ll_endereco);// Endere?o. Quando for im?vel, usar sua localiza??o. Quando outra categoria sem esta informa??o, incluir localiza??o do p?tio do leiloeiro [varchar 256]
        $ll_bairro = isolar($ll_endereco,'no bairro','','<');
		$resp['ll_bairro'] = $ll_bairro;// bairro. Quando for im?vel, usar sua localiza??o. Quando outra categoria sem esta informa??o, incluir localiza??o do p?tio do leiloeiro [varchar 128]
		$resp['ll_cidade'] = trim(stristr($endereco,'(',true));// cidade [varchar 128]
		$resp['ll_uf'] = trim(str_replace('(','',stristr($endereco,'(')));// UF/ sigla do estado [varchar 2]

        
		if (str_replace('IMÓVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) || str_replace('IMOVE','',capitalizacao_str($resp['ll_categoria_txt']))!=capitalizacao_str($resp['ll_categoria_txt']) ){
			echo '<br><font color="green">* Imóvel</font>';
			$geolocalizacao=geolocalizacao($ll_endereco,'',$resp['ll_cidade'],$resp['ll_uf']);
		} else {
			$geolocalizacao=geolocalizacao($ll_endereco,'',$resp['ll_cidade'],$resp['ll_uf'],'',false);
		}

        if ($geolocalizacao[0]!=''){$resp['ll_latitude']=$geolocalizacao[0];}
        if ($geolocalizacao[1]!=''){$resp['ll_longitude']=$geolocalizacao[1];}
    
        if ($geolocalizacao[2]!='' && $resp['ll_uf']==''){$resp['ll_uf']=$geolocalizacao[2];}
        if ($geolocalizacao[3]!='' && $resp['ll_cidade']==''){$resp['ll_cidade']=trim(str_replace('?','',$geolocalizacao[3]));}
        if ($geolocalizacao[4]!='' ){$resp['ll_bairro']=$geolocalizacao[4];}

	//	$resp['ll_latitude'] = $ll_latitude; // latitude. Quando for im?vel, coordenada exata da localiza??o. Quando outra categoria sem esta informa??o, incluir coordenada do p?tio do leiloeiro [varchar 32]
	//	$resp['ll_longitude'] = $ll_longitude;// longitude. Quando for im?vel, coordenada exata da localiza??o. Quando outra categoria sem esta informa??o, incluir coordenada do p?tio do leiloeiro [varchar 32] 

        //$ll_detalhes = str_replace('&nbsp;','',str_replace('</div>','',str_replace('<p style="margin-left:0cm; margin-right:0cm">','',str_replace('<strong>','',str_replace('</strong>','',str_replace('<u>','',str_replace('</u>','',isolar($conteudo_extraido,'<h3 class="aberto">Descri','<div class="scroll">','<div class="abertura-em aberto">'))))))));
        $ll_detalhes = isolar($conteudo_extraido,'<h3 class="aberto">Descri','<div class="scroll">','<div class="abertura-em aberto">');
       // $inicio_detalhes = stristr($ll_detalhes,'<a',true);
      //  $final_detalhes = stristr($ll_detalhes,'</a>');
       // $ll_detalhes = str_replace('</a>','',$inicio_detalhes.$final_detalhes);
        //$resp['inicio_detalhes'] = $inicio_detalhes;
        //$resp['Final_detalhes'] = $final_detalhes;
		$resp['ll_detalhes']=limpahtml(limpaespacos(str_replace('~ ~','~',str_replace('</p>','~',str_replace('<p>','~',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',str_replace('.~ .~ ','.~ ',
		str_replace(chr(10),' ',str_replace('<br>','.~ ',str_replace('<br />','~',$ll_detalhes)))))))))))))));
		//$resp["ll_avaliacao"] = $ll_avaliacao;		
		$resp["ll_numero"] = $ll_numero;
        $ll_descricao = isolar($conteudo_extraido,'<h1 class="title-lote">','','</h1>');
		$resp['ll_descricao'] = $ll_descricao;// descri??o sint?tica do lote (t?tulo) [varchar 256]
		$resp['ll_marca'] = $ll_marca; //'TOYOTA' //  [varchar 64]
		$resp['ll_modelo'] = $ll_modelo;// 'YARIS' //  [varchar 64]
		$resp['ll_capacidade'] = $ll_capacidade; //  [varchar 32]
        $ll_ano_modelo = isolar($conteudo_extraido,'<h3 class="aberto">Descri','Ano',',');
        $ll_placa = isolar($conteudo_extraido,'<h3 class="aberto">Descri','placa',',');
        $ll_cor = isolar($conteudo_extraido,'<h3 class="aberto">Descri','cor','.');
        if($nome_categoria != 'Veículos'){
            $ll_ano_modelo = '';
            $ll_placa = '';
            $ll_cor = '';
        }
        
		$resp['ll_ano_modelo'] = trim($ll_ano_modelo);// '2007' //  [varchar 16]
        
		$resp['ll_placa'] = trim($ll_placa);// 'ABC-1234' //  [varchar 16]
        
		$resp['ll_cor'] = trim($ll_cor);// 'CINZA' // [varchar 16]
		$resp['ll_setor'] = $ll_setor; //  [varchar 64]
		$resp['ll_quilometragem'] = $ll_quilometragem;// '150000' //  [varchar 16]
       
		$resp['ll_combustivel'] = $ll_combustivel;// 'GASOLINA' //  [varchar 16]
		$resp['ll_area_terreno'] = $ll_area_terreno; // '250' //  [varchar 32]
		$resp['ll_area_construida'] = $ll_area_construida;// '150'; //   [varchar 32]
		$resp['ll_area_util'] = $ll_area_util;// '100'; //   [varchar 32]
		$resp['ll_area_total'] = $ll_area_total;// '980'; //   [varchar 32]
		$resp['ll_dormitorios'] = $ll_dormitorios; //'2'; //   [varchar 32]
        $resp['ll_suites']= ''; //   [varchar 32]
        $resp['ll_vagas_garagem']= ''; //   [varchar 32]
        $resp['ll_sn']= ''; // n?mero de s?rie  [varchar 32]




        echo NovoLeilao ($resp,array(),0.15,0.15,0,0); //exit;
}
?>
