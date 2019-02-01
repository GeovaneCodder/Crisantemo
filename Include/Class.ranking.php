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


class Ranking {

    private $web;

    private $sql;

    private $smarty;

    function __construct() {

        global $sql, $web, $smarty;

        $this->sql = $sql;
        $this->web = $web;
        $this->smarty = $smarty;

    }

    function WebRanking( $Tipo, $TotalPorPagina ) {

        if( $Tipo == "individual" ) {

            $Completar = array(
                "ID" => "CID",
                "Tipo" => "Character",
                "Ordenar" => "XP" );

        }

        if( $Tipo == "clan" ) {

            $Completar = array(
                "ID" => "CLID",
                "Tipo" => "Clan",
                "Ordenar" => "Point" );
        }

        if( ! isset( $_GET['pg'] ) ) {

            $page = 1;

        } else {

            $page = sprintf( "%d", $this->web->Limpar( $_GET['pg'] ) );

        }

        $Contagem = $TotalPorPagina * ( $page - 1 );

        if( $page > 1 ) {
            
            $Consulta = "SELECT TOP " . $TotalPorPagina . " * FROM " . $Completar["Tipo"] .
                " WHERE " . $Completar["ID"] . " NOT IN (SELECT TOP " . $Contagem . " " . $Completar["ID"] .
                " FROM " . $Completar["Tipo"] . " WHERE DeleteFlag = 0 OR DeleteFlag = NULL";
            if( $Tipo == "individual" ) {
                $Consulta .= " AND " . $Completar["Ordenar"] . " > 1 ";
            }
            $Consulta .= " ORDER BY " . $Completar["Ordenar"] .
                " DESC) AND DeleteFlag = 0 OR DeleteFlag = NULL AND Name != ''";
            if( $Tipo == "individual" ) {
                $Consulta .= " AND " . $Completar["Ordenar"] . " > 1 ";
            }
            $Consulta .= " ORDER BY " . $Completar["Ordenar"] . " DESC;";

            $PlayerQuery = $this->sql->Query( $Consulta );

        } else {

            $Consulta = "SELECT TOP " . $TotalPorPagina . " * FROM " . $Completar["Tipo"] .
                " WHERE DeleteFlag = 0 OR DeleteFlag = NULL AND Name != ''";

            if( $Tipo == "individual" ) {
                $Consulta .= " AND " . $Completar["Ordenar"] . " > 1 ";
            }

            $Consulta .= " ORDER BY " . $Completar["Ordenar"] . " DESC;";

            $PlayerQuery = $this->sql->Query( $Consulta );

        }

        if( $this->sql->nRows( $PlayerQuery ) == 0 ) {

            $this->smarty->assign( "RankingEmpty", "&bull;Nada encontrado&bull;" );

        } else {
            while ( $resultado = $this->sql->inObject( $PlayerQuery ) ) {

                $_Contagem[] = $Contagem + 1;
                $Nomes[] = utf8_encode( $resultado->Name );

                if( $Completar["Tipo"] == "Character" ) {
                    $ID[] = $resultado->CID;
                    $Level[] = $resultado->Level;
                    $Ganhou[] = number_format( $resultado->KillCount, 0, ".", "." );
                    $Perdeu[] = number_format( $resultado->DeathCount, 0, ".", "." );
                    $Exp[] = number_format( $resultado->XP, 0, ".", "." );
                    $Porcentagem[] = $this->web->porcentagem( $resultado->KillCount, $resultado->
                        DeathCount, null, $Completar["Tipo"] );
                }

                if( $Completar["Tipo"] == "Clan" ) {
                    $ID[] = $resultado->CLID;
                    $Pontos[] = number_format( $resultado->Point, 0, ".", "." );
                    $Ganhou[] = number_format( $resultado->Wins, 0, ".", "." );
                    $Perdeu[] = number_format( $resultado->Losses, 0, ".", "." );
                    $Empates[] = number_format( $resultado->Draws, 0, ".", "." );
                    $Porcentagem[] = $this->web->porcentagem( $resultado->Wins, $resultado->Losses,
                        $resultado->Draws, $Completar["Tipo"] );
                }

                $Contagem++;

            }

            $this->smarty->assign( "Ranking_Contagem", $_Contagem );
            $this->smarty->assign( "RankingNome", $Nomes );
            $this->smarty->assign( "Viewer_Id", $ID );

            if( $Completar["Tipo"] == "Character" ) {
                $this->smarty->assign( "Level", $Level );
                $this->smarty->assign( "exp", $Exp );
                $this->smarty->assign( "porcentagem", $Porcentagem );
            }

            if( $Completar["Tipo"] == "Clan" ) {
                $this->smarty->assign( "Pontos", $Pontos );
                $this->smarty->assign( "empates", $Empates );
                $this->smarty->assign( "porcentagem", $Porcentagem );
            }

            $this->smarty->assign( "Win", $Ganhou );
            $this->smarty->assign( "Looses", $Perdeu );

        }

        $this->sql->liparRes();

        $QueryPaginacao = $this->sql->Query( sprintf( "SELECT * FROM %s WHERE (DeleteFlag=0 OR DeleteFlag=NULL) ORDER BY %s DESC;",
            $Completar["Tipo"], $Completar["Ordenar"] ) );

        $stages = 3;


        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil( $this->sql->nRows( $QueryPaginacao ) / $TotalPorPagina );
        $LastPagem1 = $lastpage - 1;

        $paginate = '';
        if( $lastpage > 1 ) {
            if( $page > 1 ) {
                $paginate .= "<a href='index.php?url=ranking&tipo=$Tipo&pg=$prev'>&laquo;</a> ";
            }
            if( $lastpage < 7 + ( $stages * 2 ) ) {
                for ( $counter = 1; $counter <= $lastpage; $counter++ ) {
                    if( $counter == $page ) {
                        $paginate .= " [$counter] ";
                    } else {
                        $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo&pg=$counter'>[$counter]</a> ";
                    }
                }
            } elseif ( $lastpage > 5 + ( $stages * 2 ) ) {
                if( $page < 1 + ( $stages * 2 ) ) {
                    for ( $counter = 1; $counter < 4 + ( $stages * 2 ); $counter++ ) {
                        if( $counter == $page ) {
                            $paginate .= " [$counter] ";
                        } else {
                            $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo&pg=$counter'>[$counter]</a> ";
                        }
                    }
                    $paginate .= " ... ";
                    $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo&pg=$LastPagem1'>[$LastPagem1]</a> ";
                    $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo&pg=$lastpage'>[$lastpage]</a> ";
                } elseif ( $lastpage - ( $stages * 2 ) > $page && $page > ( $stages * 2 ) ) {
                    $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo&pg=1'>[1]</a> ";
                    $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo&pg=2'>[2]</a> ";
                    $paginate .= " ... ";
                    for ( $counter = $page - $stages; $counter <= $page + $stages; $counter++ ) {
                        if( $counter == $page ) {
                            $paginate .= " [$counter] ";
                        } else {
                            $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo&pg=$counter'>[$counter]</a> ";
                        }
                    }
                    $paginate .= " ... ";
                    $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo&pg=$LastPagem1'>[$LastPagem1]</a> ";
                    $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo&pg=$lastpage'>[$lastpage]</a> ";
                } else {
                    $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo&pg=1'>[1]</a> ";
                    $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo'&pg=2'>[2]</a> ";
                    $paginate .= " ... ";
                    for ( $counter = $lastpage - ( 2 + ( $stages * 2 ) ); $counter <= $lastpage; $counter++ ) {
                        if( $counter == $page ) {
                            $paginate .= " [$counter] ";
                        } else {
                            $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo'&pg=$counter'>[$counter]</a> ";
                        }
                    }
                }
            }
            if( $page < $counter - 1 ) {
                $paginate .= " <a href='index.php?url=ranking&tipo=$Tipo&pg=$next'>&raquo;</a>";
            }
        }

        $this->smarty->assign( "Paginas_Paginacao", $paginate );
        $this->smarty->assign( "TotalEncontrado", $this->sql->nRows( $QueryPaginacao ) );
    }

    function Buscar( $buscando, $por, $tipo ) {

        if( $por == "nome" ) {

            if( $tipo == 1 ) {
                $QueryChar = $this->sql->Selecionar( "Character", array(), 0, "Name Like '%$buscando%' AND DeleteFlag = 0 OR DeleteFlag = NULL",
                    "XP DESC" );
            }

            if( $tipo == 2 ) {
                $QueryClan = $this->sql->Selecionar( "Clan", array(), 0, "Name Like '%$buscando%' AND DeleteFlag = 0 OR DeleteFlag = NULL",
                    "Point DESC" );
            }
        }

        if( $por == "id" ) {

            if( $tipo == 1 ) {
                $QueryChar = $this->sql->Selecionar( "Character", array(), 0, "CID = '$buscando' AND DeleteFlag = 0 OR DeleteFlag = NULL",
                    "XP DESC" );
            }

            if( $tipo == 2 ) {
                $QueryClan = $this->sql->Selecionar( "Clan", array(), 0, "CLID = '$buscando' AND DeleteFlag = 0 OR DeleteFlag = NULL",
                    "Point DESC" );
            }
        }

        $Cont = 1;

        if( $tipo == 1 ) {
            if( $this->sql->nRows( $QueryChar ) != 0 ) {
                while ( $char_res = $this->sql->inObject( $QueryChar ) ) {
                    $CharID[] = $char_res->CID;
                    $CharNames[] = utf8_encode( $char_res->Name );
                    $CharLevel[] = $char_res->Level;
                    $CharMatou[] = number_format( $char_res->KillCount, 0, ".", "." );
                    $CharMorreu[] = number_format( $char_res->DeathCount, 0, ".", "." );
                    $CharEXP[] = number_format( $char_res->XP, 0, ".", "." );
                    $CharPorcent[] = $this->web->porcentagem( $char_res->KillCount, $char_res->
                        DeathCount, null, "Character" );
                    $Contagem[] = $Cont;

                    $Cont++;
                }
                $this->smarty->assign( "res_char_id", $CharID );
                $this->smarty->assign( "res_char_nome", $CharNames );
                $this->smarty->assign( "res_char_level", $CharLevel );
                $this->smarty->assign( "res_char_matou", $CharMatou );
                $this->smarty->assign( "res_char_morreu", $CharMorreu );
                $this->smarty->assign( "res_char_xp", $CharEXP );
                $this->smarty->assign( "res_char_porcent", $CharPorcent );


                $this->smarty->assign( "contagem_busca", $Contagem );
            }
        }

        if( $tipo == 2 ) {
            if( $this->sql->nRows( $QueryClan ) != 0 ) {
                while ( $clan_res = $this->sql->inObject( $QueryClan ) ) {
                    $ClanID[] = $clan_res->CLID;
                    $ClanNames[] = utf8_encode( $clan_res->Name );
                    $ClanPontos[] = number_format( $clan_res->Point, 0, ".", "." );
                    $ClanVitorias[] = number_format( $clan_res->Wins, 0, ".", "." );
                    $ClanDerrotas[] = number_format( $clan_res->Losses, 0, ".", "." );
                    $ClanEmpates[] = number_format( $clan_res->Draws, 0, ".", "." );
                    $ClanPorcent[] = $this->web->porcentagem( $clan_res->Wins, $clan_res->Losses, $clan_res->
                        Draws, "Clan" );


                    $Contagem[] = $Cont;
                    $Cont++;
                }
                $this->smarty->assign( "res_clan_id", $ClanID );
                $this->smarty->assign( "res_clan_nome", $ClanNames );
                $this->smarty->assign( "res_clan_pontos", $ClanPontos );
                $this->smarty->assign( "res_clan_vitorias", $ClanVitorias );
                $this->smarty->assign( "res_clan_derrotas", $ClanDerrotas );
                $this->smarty->assign( "res_clan_empates", $ClanEmpates );
                $this->smarty->assign( "res_clan_porcent", $ClanPorcent );


                $this->smarty->assign( "contagem_busca", $Contagem );

            }
        }


    }

}

?>