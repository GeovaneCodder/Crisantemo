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


class Index {

    public $PlayerTopRankingTotal = 7;

    public $ClanTopRankingTotal = 7;

    public $TotalTopItens = 12;

    private $sql;

    private $smarty;

    private $web;


    function __construct() {
        global $sql, $smarty, $web;

        $this->sql = $sql;
        $this->smarty = $smarty;
        $this->web = $web;
    }


    function TopRanking( $tipo ) {

        switch ( $tipo ) {
            case "individual":
                $montar_query = array(
                    "Tipo" => "Character",
                    "Criterios" => "   DeleteFlag = '0' OR 
                                       DeleteFlag = NULL
                                       ",
                    "Ordem" => "XP Desc",
                    "Top" => $this->PlayerTopRankingTotal );
                break;
            case "clan":
                $montar_query = array(
                    "Tipo" => "Clan",
                    "Criterios" => "
                                       Name <> NULL OR 
                                       Name <> '' AND 
                                       DeleteFlag = '0' OR 
                                       DeleteFlag = NULL
                                       ",
                    "Ordem" => "Point Desc",
                    "Top" => $this->ClanTopRankingTotal );
                break;
        }

        //QUERY
        $Query = $this->sql->Selecionar( $montar_query["Tipo"], array(), $montar_query["Top"],
            $montar_query["Criterios"], $montar_query["Ordem"] );

        if( $this->sql->nRows( $Query ) != 0 ) {

            //CASO SE CHARACTER
            if( $montar_query["Tipo"] == "Character" ) {

                //CONTAGEM
                $contagem = 1;

                while ( $TopPlayerRes = $this->sql->inObject( $Query ) ) {
                    $Total[] = $contagem;
                    $Resultado[] = array(
                        "Nome" => $TopPlayerRes->Name,
                        "Level" => $TopPlayerRes->Level,
                        "ID" => $TopPlayerRes->CID );
                    $contagem++;
                }

                for ( $i = 0; $i < $this->sql->nRows( $Query ); $i++ ) {
                    $TopPlayerNome[] = utf8_encode( $Resultado[$i]["Nome"] );
                    $TopPlayerLevel[] = $Resultado[$i]["Level"];
                    $TopPlayerID[] = $Resultado[$i]["ID"];
                }

                //ASSINANDO NA INDEX.
                $this->smarty->assign( "PlayerContagem", $Total );
                $this->smarty->assign( "PlayerNome", $TopPlayerNome );
                $this->smarty->assign( "PlayerLevel", $TopPlayerLevel );
                $this->smarty->assign( "PlayerID", $TopPlayerID );
            }


            if( $montar_query["Tipo"] == "Clan" ) {

                //CONTAGEM
                $contagem = 1;

                while ( $TopClanRes = $this->sql->inObject( $Query ) ) {
                    $Total[] = @$contagem;
                    $Resultado[] = array(
                        "Nome" => $TopClanRes->Name,
                        "Pontos" => $TopClanRes->Point,
                        "ID" => $TopClanRes->CLID );
                    $contagem++;
                }

                for ( $i = 0; $i < $this->sql->nRows( $Query ); $i++ ) {
                    $TopClanNome[] = utf8_encode( $Resultado[$i]["Nome"] );
                    $TopClanPontos[] = $Resultado[$i]["Pontos"];
                    $TopClanID[] = $Resultado[$i]["ID"];
                }
                //ASSINANDO NA INDEX.
                $this->smarty->assign( "ClanContagem", $Total );
                $this->smarty->assign( "ClanNome", $TopClanNome );
                $this->smarty->assign( "ClanPontos", $TopClanPontos );
                $this->smarty->assign( "ClanID", $TopClanID );

            }

        }

    }

    function TotalOnline() {

        $Query = $this->sql->Selecionar( "ServerStatus", array(), 1, "Opened = '1'", null );
        $this->smarty->assign( "StatusServidor", number_format( $this->sql->inObject( $Query )->
            CurrPlayer, 0, ".", "." ) );

    }

    function TotalInfoIndex( $tipo ) {

        switch ( $tipo ) {

            case "contas":
                $montar_query = array( "Tipo" => "Account", "Criterio" => "UGradeID != 253" );
                break;
            case "equipes":
                $montar_query = array( "Tipo" => "Clan", "Criterio" => "DeleteFlag = '0' OR
                                                   DeleteFlag = NULL" );
                break;
            case "character":
                $montar_query = array( "Tipo" => "Character", "Criterio" => "DeleteFlag = '0' OR
                                                   DeleteFlag = NULL" );
                break;

        }

        //QUERY
        $Query = $this->sql->Selecionar( $montar_query["Tipo"], array(), 0, $montar_query["Criterio"], null );

        //TODAS AS CONTAS
        if( $montar_query["Tipo"] == "Account" ) {
            $this->smarty->assign( "TodasAsContas", number_format( $this->sql->nRows( $Query ),
                0, ".", "." ) );
        }

        //TODOS OS CLANS
        if( $montar_query["Tipo"] == "Clan" ) {
            $this->smarty->assign( "TodasOsClan", number_format( $this->sql->nRows( $Query ),
                0, ".", "." ) );
        }

        //TODOS OS PESONAGENS
        if( $montar_query["Tipo"] == "Character" ) {
            $this->smarty->assign( "TodasOsCharacter", number_format( $this->sql->nRows( $Query ),
                0, ".", "." ) );
        }

    }

    function StatusServer( $MatchServerIP, $MatchServerPort ) {

        if( SITEDEBUG == false ) {
            if( @fsockopen( $MatchServerIP, $MatchServerPort, $errno, $errstr, 0.5 ) ) {
                $this->smarty->assign( "StatusServer", "<font color='gree'>Ligado</font>" );
            } else {
                $this->smarty->assign( "StatusServer", "<font color='red'>Desligado</font>" );
            }
        } else {
            $this->smarty->assign( "StatusServer", "<font color='orange'>Em Teste</font>" );
        }

    }

    function RecordeOnline() {

        $Query = $this->sql->Selecionar( "Serverlog", array(), 1, null,
            "PlayerCount Desc" );
        $this->smarty->assign( "RecordeOnline", number_format( $this->sql->inObject( $Query )->
            PlayerCount ), 0, ".", "." );

    }

    function TopNoticias() {

        $Query = $this->sql->Selecionar( "Classic_Noticias", array(), 3, null, "ID Desc" );
        if( $this->sql->nRows( $Query ) != 0 ) {

            $NoticiaCont = 1;

            while ( $Res = $this->sql->inObject( $Query ) ) {
                $NoticiaTotal[] = $NoticiaCont;

                $Data[] = $Res->Data;
                $Titulo[] = utf8_encode( $Res->Titulo );
                $Texto[] = utf8_encode( $Res->Noticia );
                $Autor[] = $Res->Autor;
                $NoticiaCont++;
            }

            $this->smarty->assign( "TopNoticiaCont", $NoticiaTotal );
            $this->smarty->assign( "TopNoticiaData", $Data );
            $this->smarty->assign( "TopNoticiaTitulo", $Titulo );
            $this->smarty->assign( "TopNoticiaTexto", $Texto );
            $this->smarty->assign( "TopNoticiaAutor", $Autor );

        }

    }

    function UsuarioOnline( $Ip = null, $UserID = null ) {

        $Hora = time();
        $Fim = $Hora - 60;

        if( $UserID == null ) {
            $Query = $this->sql->Selecionar( "Classic_Online", array(), 0, "IP = '{$Ip}'", null );
        } else {
            $Query = $this->sql->Selecionar( "Classic_Online", array(), 0, "UserID = '{$UserID}'", null );
        }

        if( $this->sql->nRows( $Query ) == 0 ) {
            if( $UserID != null ) {
                $this->sql->Inserir( "Classic_Online", array(
                    "UserID" => $UserID,
                    "IP" => "",
                    "Horario" => $Hora ) );
            } else {
                $this->sql->Inserir( "Classic_Online", array(
                    "UserID" => "",
                    "IP" => $Ip,
                    "Horario" => $Hora ) );
            }
        } else {
            if( $UserID != null ) {
                $this->sql->Query( sprintf( "UPDATE Classic_Online SET Horario = '%s' WHERE UserID = '%s'",
                    $Hora, $UserID ) );
            } else {
                $this->sql->Query( sprintf( "UPDATE Classic_Online SET Horario = '%s' WHERE IP = '%s'",
                    $Hora, $Ip ) );
            }
        }

        //DELETANDO QUANDO EXPIRAR
        $this->sql->Query( sprintf( "DELETE From Classic_Online WHERE Horario < '%s'", $Fim ) );

        //TOTAL ONLINE NO SITE
        $TotalLogados = $this->sql->Selecionar( "Classic_Online", array(), 0, null, null );
        $Resultado_1 = array( "TotalOnline" => $this->sql->nRows( $TotalLogados ) );
        $this->sql->liparRes();

        //TOTAL DE MEMBROS ONLINE
        $TotalMembro = $this->sql->Selecionar( "Classic_Online", array(), 0, "IP = ''", null );
        $Resultado_2 = array( "TotalMembro" => $this->sql->nRows( $TotalMembro ) );
        $this->sql->liparRes();

        //TOTAL DE VISITANTES ONLINE
        $TotalVisitantes = $this->sql->Selecionar( "Classic_Online", array(), 0,
            "UserID = ''", null );
        $Resultado_3 = array( "TotalVisitas" => $this->sql->nRows( $TotalVisitantes ) );
        $this->sql->liparRes();


        $String = sprintf( "Online no site: %s <br />( %s Membros e %s Visitantes )", $Resultado_1["TotalOnline"],
            $Resultado_2["TotalMembro"], $Resultado_3["TotalVisitas"] );

        $UltimaQuery = $this->sql->Selecionar( "Classic_Online", array(), 30,
            "UserID != ''", null );

        if( $this->sql->nRows( $UltimaQuery ) > 0 ) {
            $x = 1;
            while ( $res = $this->sql->inObject( $UltimaQuery ) ) {
                $OnlinesNoSite[] = "<a href='#' title='" . ucfirst( $res->UserID ) . "'>" .
                    ucfirst( $res->UserID ) . "</a>, ";
                if( $x <= 20 ) {
                    $x++;
                }
            }
            $this->smarty->assign( "NomesOnlineNoSite", $OnlinesNoSite );
        }

        /**
         * Assinando a variavel
         */
        $this->smarty->assign( "LegendaOnNoSite", $String );


    }
	
	function LogadoInfo( $UserID ){
		
		/**
		 * Pegando o ID Do Usuario passado por parametro
		 * Limpamos e colocar em uma variavel
		 */
		$User	=	$this->web->Limpar( $UserID );
		
		//Query Gereal Account
		$QueryAccount	=	$this->sql->Selecionar( "Account", array(), 1, "UserID = '{$User}'", null );
		$AccountInfo	=	$this->sql->inObject( $QueryAccount );
		$this->sql->liparRes();
		
		//Assinando as variáveis!
		
			//Nome
			$this->smarty->assign( 'LogadoNome', $AccountInfo->Name );
			
			//Cash
			if( $AccountInfo->Cash > 0 OR $AccountInfo->Cash != null ){
			
				$this->smarty->assign( 'LogadoCash', 'voc&ecirc; possui "' . $AccountInfo->Cash .'" Cash para gastar como quiser em nossa loja.'  );				
			} else {
			
				$this->smarty->assign( 'LogadoCash', 'voc&ecirc; n&atilde;o possui Cash, para conseguir cash, fa&ccedil;a uma doa&ccedil;&atilde;o!' );
			}		
	}
	
	function ContagemCarrinho( $UserID ){
		
		/**
		 * Pegando o ID Do Usuario passado por parametro
		 * Limpamos e colocar em uma variavel
		 */
		$User	=	$this->web->Limpar( $UserID );
		
		/**
		 * Query Geral
		 */
		$QueryGeral		=	$this->sql->Selecionar( "Classic_Carrinho", array(), 0, "UserID = '{$User}'", null  );
		
		/**
		 * Retornando o tatal de itens no carrinho de compras
		 */
		if( $this->sql->nRows( $QueryGeral ) > 0 ){
		
			$this->smarty->assign( 'IndexTotalCarrinho', '"' . $this->sql->nRows( $QueryGeral ) . '" itens no carrinho' );
		} else {
		
			$this->smarty->assign( 'IndexTotalCarrinho', 'Nenhum item no carrinho' );
		}
		
	}

}

?>