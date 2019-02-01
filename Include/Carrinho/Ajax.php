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

/**
 * Definindo a constante de segurança
 * Todas as páginas deve verificar se a mesma existe
 */
if( ! DEFINED( "SECURITY" ) ) { 
    DEFINE( "SECURITY", "0x001" );
} 
 
require_once( "../../bootstrap.php" ); 
 

if( isset( $_POST['id_item'] ) && isset( $_POST['userid'] ) && isset( $_POST['total_item'] ) ){
	
	/**
	 * Limpando os post via Ajax
	 */
	$item		=	$web->Limpar( $_POST['id_item'] );
	$user  		=	$web->Limpar( $_POST['userid'] );
	$quatidade	=	$web->Limpar( $_POST['total_item'] );
	 
	/**
	 * Verificando se o id do item é um numero
	 */
	if( !is_numeric( $item ) or !is_numeric( $quatidade ) ){
		echo 'item inválido!';
		exit();
	}
	
	/**
	 * Query Geral
	 */
	$QueryGeral	 =	$sql->Selecionar( "Classic_Carrinho", array(), 0, "item_id = '{$item}' AND UserID = '{$user}'", null );
	
	/**
	 * Se o item não exitir no carrinho dessa conta
	 */
	if( $sql->nRows( $QueryGeral ) <> 0 ){
	
		echo 'item já existente no carrihno de compras!';
	} else {
	
		/**
		 * Inserindo item no carrinho de compras.
		 */
		$Inserir_No_carrinho	=	 $sql->Inserir( "Classic_Carrinho", array(
															"item_id" => $item,
															"UserID"  => $user,
															"item_quantidade" => $quatidade ));
											
		if( $Inserir_No_carrinho ){
		
			echo 'item inserido no carrinho de compras!';
		} else {
		
			echo 'erro ao inserir item no carrinho de compras!';
		}
	}
	
} else {
	echo 'erro no ao inserir itens!';
}

?>
