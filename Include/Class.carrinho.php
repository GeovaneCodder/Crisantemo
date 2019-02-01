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


class Carrinho {

	private $sql;
	private $web;
	private $smarty;
	
	function __construct(){
		global $sql, $web, $smarty;
		$this->sql  	=  $sql;
		$this->web  	=  $web;
		$this->smarty	=  $smarty;	
	}
	
	function ListarCarrinho( $UserID ){
		
		/**
		 * Tratando parametros
		 */
		$user	=	$this->web->Limpar( $UserID );
		
		/**
		 * Query principal
		 */
		$QueryListarCarrinho	=	$this->sql->Query( "SELECT Shop.item_id, Shop.item_nome, Shop.item_preco, Car.item_quantidade FROM Classic_Shop As Shop INNER JOIN Classic_Carrinho As Car ON Shop.item_id = Car.item_id WHERE UserID = '{$user}' ORDER BY Shop.item_preco ASC" );
				
		/**
		 * Verifica se algum item foi encontrada
		 */
		if( $this->sql->nRows( $QueryListarCarrinho ) <> 0 ){
					
			/**
			 * Colocando intens no array $itens
			 */
			while( $res_item	=	$this->sql->fRows( $QueryListarCarrinho ) ){
				
				//Ids dos itens econtrados
				$ids_itens[]		=	$res_item[0];
				
				//Nome dos itens encontrados
				$nomes_itens[]	=	$res_item[1];
				
				//Quantidade total a ser comprado
				$Qtd_itens[]		=	$res_item[3];
				
				//Preco por quantidade
				$Preco_itens[]	=	$res_item[2] * $res_item[3];
				
			}
			
			//Assinindo valores dos itens encontrados;
				//ID
				$this->smarty->assign( 'lista_id', $ids_itens );
				
				//Nome
				$this->smarty->assign( 'lista_nome', $nomes_itens );
				
				//Quantidade
				$this->smarty->assign( 'listar_qtd', $Qtd_itens );
				
				//Total preco do item x
				$this->smarty->assign( 'listar_preco', $Preco_itens );
				
		} else {
		
			/**
			 * Assinindo erros quando nenhum item for encontrado!
			 */			 
			$this->smarty->assign( 'resultado_zero', '&bull; Nenhum item encontrado em seu carrinho &bull;' );
		}
	
	}

}

?>
