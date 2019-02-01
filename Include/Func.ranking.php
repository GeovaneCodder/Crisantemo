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

$Ranking = new Ranking();


$Tipo = "";

if( ! isset( $_GET['tipo'] ) or $_GET['tipo'] == "individual" ) {
    /**
     * Definindo titulo da SubPágina
     */
    $web->Titulo( "ranking &raquo; individual" );

    $Tipo = "individual";
}

if( isset( $_GET['tipo'] ) and $_GET['tipo'] == "clan" ) {
    /**
     * Definindo titulo da SubPágina
     */
    $web->Titulo( "ranking &raquo; clan" );
    $Tipo = "clan";
}

if( isset( $_GET['tipo'] ) and $_GET['tipo'] == "buscar" ) {
    /**
     * Definindo titulo da SubPágina
     */
    $web->Titulo( "ranking &raquo; buscar" );
    $Tipo = "buscar";
}

if( $Tipo == "clan" or $Tipo == "individual" ) {
    $Ranking->WebRanking( $Tipo, 13 );
}

if( $Tipo == "buscar" ) {

    if( isset( $_GET['por'] ) ) {

        switch ( $_GET['por'] ) {
            case "ID":
                $BuscarPor = "id";
                break;

            case "Nome":
                $BuscarPor = "nome";
                break;

            default:
                @header( "HTTP/1.0 404 Not Found" );
                @header( "Status: 404 Not Found" );
                exit();
                break;
        }

    } else {
        @header( "HTTP/1.0 404 Not Found" );
        @header( "Status: 404 Not Found" );
        exit();
    }

    if( isset( $_GET['q'] ) && $web->Limpar( $_GET['q'] ) != "" ) {

        if( isset( $_GET['option'] ) ) {
            $LimpandoQ = sprintf( "%s", $web->Limpar( $_GET['q'] ) );

            if( $_GET['option'] == "Char" ) {
                $Ranking->Buscar( $LimpandoQ, $BuscarPor, 1 );
            }

            if( $_GET['option'] == "Clan" ) {
                $Ranking->Buscar( $LimpandoQ, $BuscarPor, 2 );
            }

        } else {
            @header( "HTTP/1.0 404 Not Found" );
            @header( "Status: 404 Not Found" );
            exit();
        }


    } else {
        @header( "HTTP/1.0 404 Not Found" );
        @header( "Status: 404 Not Found" );
        exit();
    }

}

?>