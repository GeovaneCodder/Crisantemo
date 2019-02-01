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

class Sql {

    private $__db_host;
    private $__db_username;
    private $__db_password;
    private $__db_name;
    private $__db_handle;
    private $resultado;
    public $web;

    function __construct( $host, $username, $password, $db_name, $db_handle = '' ) {

        global $web;

        $this->web = $web;

        if( empty( $db_handle ) ) {
            $this->__db_host = $host;
            $this->__db_username = $username;
            $this->__db_password = $password;
            $this->__db_name = $db_name;
            $this->connect();
        } else {
            $this->__db_handle = $db_handle;
        }
    }

    private function connect() {
        if( ! $this->__db_handle = mssql_connect( $this->__db_host, $this->
            __db_username, $this->__db_password ) ) {
            $this->throw_error( __method__, __line__, 'Could not connect to SQL server.' );
        }

        if( ! mssql_select_db( $this->__db_name, $this->__db_handle ) ) {
            $this->throw_error( __method__, __line__, 'Could not select database ' . $this->
                __db_name );
        }
    }

    public function Query( $instrucao ) {
        $Query = @mssql_query( $instrucao, $this->__db_handle );
        if( ! $Query ) {
            $this->throw_error( __method__, __line__, "Erro ao execultar a query " . $instrucao );
        }
        $this->resultado = $Query;
        return $this->resultado;
    }

    function Rows_Afetados() {
        return mssql_rows_affected( $this->__db_handle );
    }

    function Selecionar( $Tabela, $Campos, $Quantidade = 0, $Condicao = null, $Ordernar = null ) {
        $Query = "SELECT ";

        if( is_numeric( $Quantidade ) && $Quantidade > 0 ) {
            $Query .= "TOP " . $Quantidade . " ";
        }

        if( empty( $Campos ) || count( $Campos ) == 0 ) {
            $Query .= "* ";
        } else {
            while ( @list( $key, $value ) = @each( $Campos ) ) {
                $campo[] = $value;
            }

            $Query .= @implode( ", ", $campo );
        }

        $Query .= " FROM " . $Tabela;

        if( $Condicao != null ) {
            if( strpos( strtolower( $Condicao ), "where " ) !== false ) {
                $Query .= " " . $Condicao;
            } else {
                $Query .= " WHERE " . $Condicao;
            }
        }

        if( $Ordernar != null ) {
            if( strpos( strtolower( $Ordernar ), "order by " ) !== false ) {
                $Ordernar .= " " . $Ordernar;
            } else {
                $Query .= " ORDER BY " . $Ordernar;
            }
        }

        return $this->Query( $Query );
    }

    function Inserir( $Tabela, $Dados ) {
        if( $Tabela && ( is_array( $Dados ) ) ) {
            $array_func = array( "GETDATE()", "NULL" );

            $Query = "INSERT INTO [" . $Tabela . "] (";

            while ( @list( $key, $value ) = @each( $Dados ) ) {
                $colunas[] = $key;
                $valores[] = ( in_array( $value, $array_func ) ) ? $value : "'" . $value . "'";
            }

            $Query .= implode( ", ", $colunas );

            $Query .= ") VALUES (" . implode( ", ", $valores ) . ")";

            return $this->Query( $Query );
        }
    }

    public function nRows() {
        return @mssql_num_rows( $this->resultado );
        //return $NumRows;
    }

    public function fRows() {
        return @mssql_fetch_row( $this->resultado );
        //return $FetchRow;
    }

    public function inObject() {
        return @mssql_fetch_object( $this->resultado );
        //return $FetchObject;
    }

    public function liparRes() {
        $this->resultado = null;
    }

    private function throw_error( $function_name, $line_number, $error_msg = '' ) {
        die( '<font style="color: red; font-weight: bold;">-- Houve um erro! --</font><br />' .
            $function_name . ' Na linha ' . $line_number . '<br />' . ( ! empty( $error_msg ) ?
            "<br />Menssagem: $error_msg" : "Query inválida: {$this->__sql}" ) );
    }


}

?>