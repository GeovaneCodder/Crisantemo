<?php

	/**
 	* Array com os valores possiveis a ser gerados
 	*/
	$input = array( "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" );

	/**
 	* Escolher 8 elementos do array para se o código
 	*/
	$rand_keys = array_rand( $input, 8 );

	/**
 	* Cria o código com o elementos selecionado
 	*/
	$codigo		=	"";	
	for( $i = 0; $i <= 8; $i++ ){
		$codigo .= $input[$rand_keys[$i]];	
	}
	
	/**
 	* Define o tipo de arquivo com imagem em formato GIF
 	*/
	@header( "Content-type:image/gif" );

	/**
 	* Cria a imagem com o phpcredits
 	*/
	$img = imagecreate( 150, 20 );

	/**
 	* Coloca um fundo preto
 	*/
	$preto = imagecolorallocate( $img, 0, 0, 0 );

	/**
 	* Define a cor da fonte como branca
 	*/
	$branco = imagecolorallocate( $img, 255, 255, 255 );

	/**
 	* Seleciona a fonte a ser utilizada
 	*/
	imagettftext( $img, 15, 0, 10, 18, $branco, "../Public/verdana.ttf", $codigo );

	/**
 	* Seta a imagem como GIF
 	*/
	imagegif( $img );

	/**
 	* Detroi a imagem da memória
 	*/
	imagedestroy( $img );

	/**
 	* Seta a session codigo com o captcha
 	*/
	$_SESSION['codigo'] = $codigo ;
?>