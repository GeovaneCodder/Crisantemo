<?php

/**
 * @author Geovane Souza
 * @copyright 2013
 * @package Classic Gunz
 * @license
 * esse software � de uso gratuito desde que preservem
 * os cr�ditos do autor em suas p�gias,
 * GNU/FREE Open Soucer
 * Executado sob a lisceca do PHP e da
 * ZendStudio Corporation.
 * Todos os direitos resevados.
 * Escrito por Geovane Souza
 * Aka . AvadaKedavra 
 */
 
 
 /**  MUDAR SOMENTE O SEGUNDO PARAMETRO DAS CONSTANTES CASO CONSTR�RIO
  *   O SITE N�O FUNCIONAR� CORRETAMENTE, N�O EFERECEREI SUPORTE SOBRE
  *   ESSE SITE, TEMPLATE � DO FREESTYLE GUNZ
  *   Template Criado por McSic.
  *   C�digos GeovaneSouza
  *   
  *   TEMPLATE ROUBADO( Cr�ditos, n�o sei quem fez );        
  */

if( ! defined( "SECURITY" ) ) {
    @header( "HTTP/1.0 404 Not Found" );
    @header( "Status: 404 Not Found" );
    exit();
}

/************  SQL CONFIG   **************/

/**
 * Caso o sql precise de alguma porta
 * para acesso remoto, ensira a mesma
 * na linha abaixo.
 */
DEFINE( "SQLHOST", "MEUPC\SQLEXPRESS" );


/**
 * Definindo a usuario a da database do SQl
 * por padr�o da Microsoft esse valor vem setado
 * como "sa"
 */
DEFINE( "SQLUSER", "sa" );

/**
 * Definindo a senha da database do SQL
 */
DEFINE( "SQLSENHA", "minha senha sql" );

/**
 * Definindo a database a ser ultilizada
 * o Gunz por padr�o vem com o
 * nome de "GunzDB"
 */
DEFINE( "SQLDATA", "minha database" );

/***********  SQL CONFIG FIM ************/


/***********  WEB SITE CONFIG ***********/

/**
 * Definindo o titulo que ser� exibido no
 * site.
 * Ultilizado para localiza��o do site
 * no Robots do Google
 * Yahoo, e outro site de Busca.
 */
if( ! DEFINED( "TITULO" ) ) {
    DEFINE( "TITULO", "Classic Gunz" );
}

/**
 * Definindo o link do f�rum do jogo
 * Mudar somente o link
 */
if( ! DEFINED( "FORUM_LINK" ) ){
    DEFINE( "FORUM_LINK", "http://ragezone.com.br" );
}

/**
 * Site em modo de teste
 */
if( ! DEFINED( "SITEDEBUG" ) ) {
    DEFINE( "SITEDEBUG", false );
}

/**
 * Definindo o local dos diret�rios
 * Ultilizado para requisitar
 * class e fun��es do Web Site
 */
if( ! DEFINED( "DIR" ) ) {
    DEFINE( "DIR", dirname( __file__ ) . DIRECTORY_SEPARATOR );
}

/**
 * Ip e Port Do Match Server
 * Para Status do Servidor
 */

//MATCH SERVER IP
if( ! DEFINED( "MIP" ) ) {
    DEFINE( "MIP", "127.0.0.1" );
}

//MATCH SERVER PORTA
if( ! DEFINED( "MPORT" ) ) {
    DEFINE( "MPORT", 6000 );
}

/**
 * Downloads
 */
$Downloads  = array(
              "4Shared"     =>  "http://www.4shared.com/file/h8AAKjvJ/ClassicGunz.html?",
              "HotFile"     =>  "https://hotfile.com/dl/220055676/6490ac3/ClassicGunz.exe.html",
              "SendSpace"   =>  "http://www.sendspace.com/file/a8jjzj",
              "Mega"        =>  "https://mega.co.nz/#!2kpRURTD!BTGo_S8cFncb6r-Fcbd8vxRy9c0t2WYjO7ZpyzTDUeQ" );


/***********  WEB SITE CONFIG FIM ***********/


/*********** INCLUINDO AQUIVOS  *************/

/**
 * Incluindo a blibioteca Smarty Template Engine
 * <pre>
 *  @version Smarty 3.1.13
 *  Author: Monte Ohrt <monte at ohrt dot com >
 *  Author: Uwe Tews
 * </pre>
 * @package http://www.smarty.net/documentation
 */
include_once ( DIR . "Libs" . DIRECTORY_SEPARATOR . "Smarty" .
    DIRECTORY_SEPARATOR . "Smarty.class.php" );
$smarty = new Smarty();
$smarty->debug_tpl = DIR . "Public" . DIRECTORY_SEPARATOR . "debug.classic";
$smarty->setCacheDir( DIR . "Cache" );
$smarty->setCompileDir( DIR . "Cache" );
$smarty->setTemplateDir( DIR . "Public" );
$smarty->compile_check = false;
$smarty->force_compile = true;


/**
 * Incluindo a blibioteca SQL
 */
include_once ( DIR . "Libs" . DIRECTORY_SEPARATOR . "Sql.class.php" );
$sql = new Sql( SQLHOST, SQLUSER, SQLSENHA, SQLDATA );

/**
 * Incluindo a blibioteca Web
 */
include_once ( DIR . "Libs" . DIRECTORY_SEPARATOR . "Web.class.php" );
$web = new WebClass();

?>