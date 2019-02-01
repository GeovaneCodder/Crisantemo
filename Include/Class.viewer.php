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

class Viewer {

    private $sql;

    private $smarty;

    private $web;

    function __construct() {
        global $sql, $web, $smarty;

        $this->sql = $sql;
        $this->web = $web;
        $this->smarty = $smarty;
    }

    function Visualizar( $Tipo, $Id ) {

        if( $Tipo == "individual" ) {
            $Completar = array( "Tabela" => "Character", "ID" => "CID" );
        }

        if( $Tipo == "clan" ) {
            $Completar = array( "Tabela" => "Clan", "ID" => "CLID" );
        }


        $Query = $this->sql->Selecionar( $Completar['Tabela'], array(), 1, $Completar['ID'] .
            " = " . $Id, null );

        if( $this->sql->nRows( $Query ) != 0 ) {
            
                $Viewer = $this->sql->inObject( $Query );
                
                $this->smarty->assign( "Viewer_Nome", utf8_encode( $Viewer->Name ) );

                if( $Tipo == "individual" ) {
                    $this->smarty->assign( "Viewer_Vitorias", number_format( $Viewer->KillCount, 0, ".", "." ) );
                    $this->smarty->assign( "Viewer_Derrotas", number_format( $Viewer->DeathCount, 0, ".", "." ) );
                    $this->smarty->assign( "Viewer_Sexo", $this->web->GunzSexo( $Viewer->Sex ) );
                    $this->smarty->assign( "Viewer_colocacao_by", number_format( $Viewer->XP, 0, ".", "." ) );

                    $xx = explode( " ", $Viewer->RegDate );
                    $nn = explode( " ", $Viewer->LastTime );
                    
                    $this->smarty->assign( "Viewer_Criado", @sprintf( "%s %s %s ás %s", $xx[1], $xx[0],
                        $xx[2], $xx[4] ) );
                    $this->smarty->assign( "Viewer_UltimoLogin", @sprintf( "%s %s %s ás %s", $nn[1],
                        $nn[0], $nn[2], $nn[4] ) );
                }

                if( $Tipo == "clan" ) {
                    
                    $this->smarty->assign( "Viewer_Vitorias", number_format( $Viewer->Wins, 0, ".", "." ) );
                    $this->smarty->assign( "Viewer_Derrotas", number_format( $Viewer->Losses, 0, ".", "." ) );
                    $this->smarty->assign( "Viewer_colocacao_by", number_format( $Viewer->Point, 0, ".", "." ) );
                    $this->smarty->assign( "Viewer_Empates", number_format( $Viewer->Draws, 0, ".", "." ) );
                    $this->smarty->assign( "Viewer_Clan_Percentual", $this->web->porcentagem( $Viewer->Wins, $Viewer->Losses, $Viewer->Draws, "Clan" ) );
                    
                    $xx = explode( " ", $Viewer->RegDate );
                    $this->smarty->assign( "Viewer_Criado", @sprintf( "%s %s %s ás %s", $xx[1], $xx[0],
                        $xx[2], $xx[4] ) );

                    /**
                     * Query Membros do clan
                     */
                    $QueryMembros = $this->sql->Query( sprintf( "SELECT Character.Name, ClanMember.Grade, Character.CID FROM Character INNER JOIN ClanMember ON Character.CID = ClanMember.CID WHERE (ClanMember.CLID = '%d') AND (Character.DeleteFlag = 0 OR Character.DeleteFlag = NULL) ORDER BY ClanMember.Grade ASC",
                    $Viewer->CLID ) );
                      
                    while( $Membros_Res =   $this->sql->inObject( $QueryMembros ) ){
                        
                        $Membros_Nomes[]    =   utf8_encode( $Membros_Res->Name );
                        $Membros_IDS[]      =   $Membros_Res->CID;
                        
                        if( $Membros_Res->Grade == 1 ){
                            $Membros_Grade[]    =   "<font color='red'>Lider</font>";                            
                        }
                        
                        if( $Membros_Res->Grade == 2 ){
                            $Membros_Grade[]    =   "<font color='darkorange'>Admin</font>";                            
                        }
                        
                        if( $Membros_Res->Grade == 9 ){
                            $Membros_Grade[]    =   "<font color='#FFFFFFF'>Membro</font>";                            
                        }                                    
                                                    
                    }
                    
                    $this->smarty->assign( "Membros_Nome", $Membros_Nomes );
                    $this->smarty->assign( "Membros_IDS", $Membros_IDS );
                    $this->smarty->assign( "Membros_Grade", $Membros_Grade );    
                        

                }

        } else {
            @header( "HTTP/1.0 404 Not Found" );
            @header( "Status: 404 Not Found" );
            exit();
        }
    }

}

?>