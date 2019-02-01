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
 * Definindo titulo da SubPágina
 */
$web->Titulo( "inicio" );

/**
 * Iniciando a class INDEX
 */
$Index = new Index();


/**
 * Top Player Ranking
 */
$Index->TopRanking( "individual" );

/**
 * Top Clan Ranking
 */
$Index->TopRanking( "clan" );

/**
 * Index Servidor Estatus
 */
//TODAS CONTAS
$Index->TotalInfoIndex( "contas" );

//TODOS CLAN
$Index->TotalInfoIndex( "equipes" );

//TODOS CHARACTER
$Index->TotalInfoIndex( "character" );

//Status Server
$Index->StatusServer( MIP, MPORT );

//RECORDE ONLINE
$Index->RecordeOnline();

/**
 * Total de jogadoes On-Line
 */
$Index->TotalOnline();

/**
 * Noticias index
 */
$Index->TopNoticias();

/**
 * Assinando os Downloads
 */
$smarty->assign( "Downloads", $Downloads );

/**
 * Pessoas OnLine no Site
 */
if( isset( $_SESSION['classic'] ) ) {

    $Index->UsuarioOnline( null, $web->Limpar( $_SESSION['classic'] ) );
	$Index->LogadoInfo( $_SESSION['classic'] );
	$Index->ContagemCarrinho( $_SESSION['classic'] );
} else {

    $Index->UsuarioOnline( $web->Limpar( $_SERVER['REMOTE_ADDR'] ), null );
}

?>