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

class Registro {

    private $sql;

    private $web;

    function __construct() {
        global $sql, $web;
        $this->sql = $sql;
        $this->web = $web;
    }

    function Verificar( $UserID = null, $Email = null ) {

        if( $UserID != null ) {

            $Criterio = "UserID = '{$UserID}'";

        }

        if( $Email != null ) {

            $Criterio = "Email = '{$Email}'";

        }

        $Query = $this->sql->Selecionar( "Account", array(), 1, $Criterio, null );

        if( $this->sql->nRows( $Query ) <> 0 ) {
            return true;
        } else {
            return false;
        }

        $this->sql->liparRes();


    }

    function Cadastrar( $Nome, $Email, $DataNascimento, $UserID, $Senha, $PerguntasSecretas,
        $RespostaSecreta, $Ip ) {

        /**
         * Inserindo a conta na tabela Account
         */
        $Inserir_Conta = $this->sql->Inserir( "Account", array(
            "Name" => $Nome,
            "Email" => $Email,
            "UGradeID" => 0,
            "PGradeID" => 0,
            "RegDate" => "00:00:00",
            "DataDeNascimento" => $DataNascimento,
            "UserID" => $UserID,
            "IP" => $Ip,
            "PerguntaSecreta" => $PerguntasSecretas,
            "RespostaSecreta" => $RespostaSecreta,
            "Cash" => 0 ) );

        /**
         * Limpando cache da Query
         */
        $this->sql->liparRes();

        if( $Inserir_Conta ) {

            $NovoAID = $this->sql->Selecionar( "Account", array(), 1, "UserID = '{$UserID}'", null );
            $LoginAID = $this->sql->inObject( $NovoAID );
            $this->sql->liparRes();

            $Inserir_Login = $this->sql->Inserir( "Login", array(
                "UserID" => $UserID,
                "AID" => $LoginAID->AID,
                "Password" => $Senha ) );
                
            $this->sql->liparRes();

            if( $Inserir_Login ) {

                $_SESSION['reg_erro'] = "Conta cadastrada com sucesso!";

            } else {

                $_SESSION['reg_erro'] =
                    "Houve um erro ao cadastrar a sua conta.<br />ErroID : 02xx15, contate um administrador!";

            }

        } else {

            $_SESSION['reg_erro'] =
                "Houve um erro ao cadastrar a sua conta.<br />ErroID : 02xx15, contate um administrador!";

        }


    }

    function VerificarIP( $Ip ) {

        $Query = $this->sql->Selecionar( "Account", array(), 1, "Ip = '{$Ip}'", null );

        if( $this->sql->nRows( $Query ) != 0 ) {
            $this->sql->liparRes();
            return true;
        } else {
            $this->sql->liparRes();
            return false;
        }


    }
	
}

?>