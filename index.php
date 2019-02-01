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
 * Defininda data e área local.
 */
date_default_timezone_set( "America/Sao_Paulo" );

/**
 * Iniciando sessoes
 */
@session_start();

/**
 * Definindo a constante de segurança
 * Todas as páginas deve verificar se a mesma existe
 */
if( ! DEFINED( "SECURITY" ) ) { 
    DEFINE( "SECURITY", "0x001" );
}

/**
 * Tipo de character a ser usado
 */
@header( 'Content-Type: text/html; charset=utf-8' );

/**
 * Verificando a versão do PHP
 */
if( version_compare( PHP_VERSION, '5.2.0', '<' ) ) {
    echo "Seu servidor tem o php (" . PHP_VERSION . ") e n&atilde;o esse site.\n";
    exit();
}

/**
 * Verificando se existe o Boot Strap
 * caso exitir, incluimos caso contrário
 * retornamos um erro
 */
if( file_exists( "bootstrap.php" ) && is_file( "bootstrap.php" ) ) {
    include_once( "bootstrap.php" );
}

/**
 * Caso estiver em mode de Depuração( DEBUG ) exibirá os erros
 * Caso contrário, oucutará!
 */
if( SITEDEBUG == false ){
    @error_reporting( 0 );
    @ini_set( "display_errors", 0 );
} else {
    @error_reporting( E_ALL ^ E_WARNING );
    @ini_set( "display_errors", 1 );        
}

/**
 * Assinando o diretorio em formato .tpl
 */
$smarty->assign( "tpl", "Public" . DIRECTORY_SEPARATOR );

/**
 * Site Nova Session
 */
if( isset( $_GET['new'] ) && ! isset( $_COOKIE["SiteCarregado"] ) && isset( $_COOKIE['classic'] ) ){
    
    /**
     * Setando cookie
     */    
    @setcookie( "SiteCarregado", 1, time()+1200, "/", $_SERVER['SERVER_NAME'], false );
    sleep(3);
    print( "<script>document.location.reload();</script>" );    
}

/**
 * Classic Gunz Ant Ddos
 */
if( ! isset( $_COOKIE["SiteCarregado"] ) && SITEDEBUG == false && $_SERVER['REMOTE_ADDR'] != "127.0.0.1" ) {
    $smarty->display( "Public" . DIRECTORY_SEPARATOR . "Carregando" .
        DIRECTORY_SEPARATOR . "carregando.classic" );
    exit();
}

/**
 * Verificando se está banido
 */


/**
 * Verificando as GET's
 */
if( ! isset( $_GET['url'] ) ) {
    $get = "index";
} else {
    $get = $_GET['url'];
}

/**
 * Caso exista as get
 * Assinamos e incluimos
 * os arquivos.
 */
if( file_exists( DIR . "Public" . DIRECTORY_SEPARATOR . $get . ".classic" ) &&
    file_exists( DIR . "Include" . DIRECTORY_SEPARATOR . "Func." . $get . ".php" ) &&
    file_exists( DIR . "Include" . DIRECTORY_SEPARATOR . "Class." . $get . ".php" ) ) {

    //REQUISITANDO A LIB DA PÁGINA
    require_once ( DIR . "Include" . DIRECTORY_SEPARATOR . "Class.index.php" );
    require_once ( DIR . "Include" . DIRECTORY_SEPARATOR . "Class." . $get . ".php" );

    //REQUISITANDO O Controller DA PáGina
    require_once ( DIR . "Include" . DIRECTORY_SEPARATOR . "Func.index.php" );
    require_once ( DIR . "Include" . DIRECTORY_SEPARATOR . "Func." . $get . ".php" );


    //ASSINANDO...
    $smarty->assign( "get", DIR . "Public" . DIRECTORY_SEPARATOR . $get . ".classic" );
} else {

    @header( "HTTP/1.0 404 Not Found" );
    @header( "Status: 404 Not Found" );
    exit();
}

/**
 * Deslogando acc's
 */
if( isset( $_GET['conta'] ) && isset( $_SESSION['classic'] ) && $_GET['conta'] == "deslogar" ){
    
    /**
     * Deletando dos conectador no site
     */
    $sql->Query( sprintf( "DELETE From Classic_Online WHERE UserID = '%s'", $web->Limpar( $_SESSION['classic'] ) ) );
    
    /**
     * Limpando todas as sessões
     */
    @session_unset();
    
    /**
     * Destruindo todas as sessões
     */
    @session_destroy();
    
    /**
     * Redirecionando
     */
    $web->redir( "index.php", 0 );
    
}

/**
 * Exibindo o template
 */
$smarty->display( "index.classic" );

/**
 * Apangando sessoes extras
 */
if( isset( $_SESSION['reg_erro'] ) ) {
    
    unset( $_SESSION['reg_erro'] );
   
}

if( isset( $_SESSION['reg_fim'] ) ){
    
     unset( $_SESSION['reg_fim'] );
    
}

if( isset( $_SESSION['login_err'] ) ) {
    
    unset( $_SESSION['login_err'] );
    
}

/**
 * Finalizando o Aplicativo
 */
exit();

?>