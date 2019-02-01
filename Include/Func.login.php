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
$web->Titulo( "login" );

/**
 * Somente deslogados
 */
$web->SemLogin();

if( isset( $_POST['classicgunz_login'] ) ) {

    /**
     * Chave para login
     */
    $Chave = $web->Limpar( $_POST['login_chave'] );

    /**
     * Senha para login
     */
    $Senha = $web->Limpar( $_POST['login_senha'] );
    
    /**
     * Iniciando a Class Login
     */
    $__Login  =   new Login();
     

    /**
     * Verificando se é Email ou UserID
     */
    if( ! @eregi( "^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$", $Chave ) ) {
        
        $__Login->Logar( $Chave, null, $Senha );
        
    } else {
        
        $__Login->Logar(  null, $Chave, $Senha );
        
    }


}

?>