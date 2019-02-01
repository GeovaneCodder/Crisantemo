<?php

/**
 * @author Geovane Souza
 * @copyright 2013
 * @package Classic Gunz
 * @license
 * esse software é de uso gratuito desde que preservem
 * os créditos do autor em suas págias,
 * GNU/FREE Open Soucer
 * Executado sob a lisceca do PHP e da
 * ZendStudio Corporation.
 * Todos os direitos resevados.
 * Escrito por Geovane Souza
 * Aka . AvadaKedavra 
 */
if( ! defined( "SECURITY" ) ) {
    @header( "HTTP/1.0 404 Not Found" );
    @header( "Status: 404 Not Found" );
    exit();
}

/**
 * Caso esteja deslogado, exibimos o erro 404
 */
if( ! isset( $_SESSION['classic'] ) ){
	@header( "HTTP/1.0 404 Not Found" );
    @header( "Status: 404 Not Found" );
    exit();
}

// Setando a class carrinho
$Carrinho	=	new Carrinho();

// Se nao existir a get sub
if( !isset( $_GET['sub'] ) ){
	
	$Carrinho->ListarCarrinho( $_SESSION['classic'] );	
}

?>
