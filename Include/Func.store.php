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
$web->Titulo( "web store" );

/**
 * chamando a class web store
 */
$Shop = new WebStore();

/**
 * Caso não esteja visualizando nenhum item!
 */
if( ! isset( $_GET['item'] ) ) {

    /**
     * Verificando o tipo a buscar
     */
    if( ! isset( $_GET['tipo'] ) ) {
        $tipo_extenso = "todos";
        $BuscarTipo = 0;
    } else {
        $tipo_extenso = $web->Limpar( $_GET['tipo'] );
        switch ( $_GET['tipo'] ) {

            case "todos":
                $BuscarTipo = 0;
                break;

            case "cabeca":
                $BuscarTipo = 1;
                break;

            case "corpo":
                $BuscarTipo = 2;
                break;

            case "calcas":
                $BuscarTipo = 3;
                break;

            case "maos":
                $BuscarTipo = 4;
                break;

            case "pes":
                $BuscarTipo = 5;
                break;

            case "adagas":
                $BuscarTipo = 6;
                break;

            case "espadas":
                $BuscarTipo = 7;
                break;

            case "shotgun":
                $BuscarTipo = 8;
                break;

            case "bazucas":
                $BuscarTipo = 9;
                break;

            case "pistolas-revolvers":
                $BuscarTipo = 10;
                break;

            case "rifles":
                $BuscarTipo = 11;
                break;

            case "snipes":
                $BuscarTipo = 12;
                break;

            case "aneis":
                $BuscarTipo = 13;
                break;

            case "meds":
                $BuscarTipo = 14;
                break;

            default:
                @header( "HTTP/1.0 404 Not Found" );
                @header( "Status: 404 Not Found" );
                exit();
        }
    }

    /**
     * tratando o post ordernar
     */
    if( ! isset( $_GET['ordernar'] ) ) {
        $ordem = "item_preco";
    } else {
        switch ( $_GET['ordernar'] ) {
            case "preco":
                $ordem = "item_preco";
                break;

            case "level":
                $ordem = "item_level";
                break;

            case "damage":
                $ordem = "item_damege";
                break;

            case "ap":
                $ordem = "item_ap";
                break;

            case "hp":
                $ordem = "item_hp";
                break;

            default:
                @header( "HTTP/1.0 404 Not Found" );
                @header( "Status: 404 Not Found" );
                exit();
        }
    }

    /**
     * tratando o post valores
     */
    if( ! isset( $_GET['valores'] ) ) {
        $valores = "ASC";
    } else {
        switch ( $_GET['valores'] ) {
            case "crescente":
                $valores = "ASC";
                break;

            case "decrescente":
                $valores = "DESC";
                break;

            default:
                @header( "HTTP/1.0 404 Not Found" );
                @header( "Status: 404 Not Found" );
                exit();
        }
    }

    /**
     * tratando o get sexo
     */
    if( ! isset( $_GET['sexo'] ) ) {
        $sexo = 0;
    } else {
        switch ( $_GET['sexo'] ) {
            case "unissex":
                $sexo = "'1' or item_sexo = '2'";
                break;

            case "masculino":
                $sexo = "'1'";
                break;

            case "feminino":
                $sexo = "'2'";
                break;
                
            default:
                @header( "HTTP/1.0 404 Not Found" );
                @header( "Status: 404 Not Found" );
                exit();
        }
    }

    /**
     * Array com informações a buscar no banco de dados
     */
    $Implementos_De_Busca = array(
        "int_Tipo" => $BuscarTipo,
        "str_ordem" => $ordem,
        "str_cond" => $valores,
        "int_sexo" => $sexo );

    /**
     * chamando a função de listar itens
     */
    $Shop->ListarItens( $Implementos_De_Busca, 16 );

}

if( isset( $_GET['item'] ) ){

	if( ! empty( $_GET['item'] ) ){	
		$Item_Nome	=	$web->Limpar( $_GET['item'] );	
		$Shop->VisualizarItem( $Item_Nome );
	}

}

?>