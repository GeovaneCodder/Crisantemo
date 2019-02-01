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

class Login {

    private $sql;
    private $web;

    function __construct() {

        global $sql, $web;

        $this->sql = $sql;

        $this->web = $web;

    }

    function Logar( $UserID = null, $Email = null, $Senha ) {
        if( $UserID != null && $Email == null ) {

            $Query = $this->sql->Selecionar( "Login", array(), 1, "UserID = '{$UserID}' AND Password = '{$Senha}'", null );

            if( $this->sql->nRows( $Query ) != 0 ) {

                $Resultado = $this->sql->inObject( $Query );

                $_SESSION['classic'] = $Resultado->UserID;

                if( ! isset( $_GET['redir'] ) ) {
                    $this->web->redir( "index.php", 0 );
                } else {
                    $this->web->redir( urldecode( $_GET['redir'] ), 0 );
                }

                exit();


            } else {

                $_SESSION['login_err'] =
                    "Chave de acesso ou senha não correspodem ou não existe!";
            }


        } else {

            $QueryPegarUserID = $this->sql->Selecionar( "Account", array( "UserID" ), 1,
                "Email = '{$Email}'", null );

            if( $this->sql->nRows( $QueryPegarUserID ) != 0 ) {

                $MeuRes = $this->sql->fRow( $QueryPegarUserID );
                $this->sql->liparRes();

                $Query = $this->sql->Selecionar( "Login", array(), 1, "UserID = '{$MeuRes['0']}' AND Password = '{$Senha}'", null );

                if( $this->sql->nRows( $Query ) != 0 ) {

                    $Resultado = $this->sql->inObject( $Query );

                    $_SESSION['classic'] = $Resultado->UserID;

                    if( ! isset( $_GET['redir'] ) ) {
                        $this->web->redir( "index.php", 0 );
                    } else {
                        $this->web->redir( urldecode( $_GET['redir'] ), 0 );
                    }


                    exit();

                } else {

                    $_SESSION['login_err'] =
                        "Chave de acesso ou senha não correspodem ou não existe!";

                }

            } else {

                $_SESSION['login_err'] =
                    "Chave de acesso ou senha não correspodem ou não existe!";

            }

        }


    }


}

?>