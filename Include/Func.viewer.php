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

if( isset( $_GET['tipo'] ) ) {

    if( isset( $_GET['id'] ) ) {
        $ID = sprintf( '%d', $web->Limpar( $_GET['id'] ) );
        $Viewer = new Viewer();
    } else {
        @header( "HTTP/1.0 404 Not Found" );
        @header( "Status: 404 Not Found" );
        exit();
    }

    if( $_GET['tipo'] == "individual" ) {
        /**
         * Definindo titulo da SubPágina
         */
        $web->Titulo( "visualizar &raquo; character" );
        $Viewer->Visualizar( "individual", $ID );
    }

    if( $_GET['tipo'] == "clan" ) {
        /**
         * Definindo titulo da SubPágina
         */
        $web->Titulo( "visualizar &raquo; clan" );
        $Viewer->Visualizar( "clan", $ID );                
    }
    
    
} else {
    @header( "HTTP / 1.0404Not Found" );
    @header( "Status : 404Not Found" );
    exit();
}

?>
