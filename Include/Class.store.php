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

class WebStore {

    private $sql;

    private $smarty;

    private $web;

    function __construct() {

        global $sql, $smarty, $web;

        $this->sql = $sql;
        $this->smarty = $smarty;
        $this->web = $web;

    }


    function ListarItens( $complementos, $quantidade ) {

        /**
         * Se nao existir a get pagina
         * atibuibos um valor automatico
         */
        if( ! isset( $_GET['pg'] ) ) {
            $page = 1;
        } else {
            $page = sprintf( '%d', $this->web->Limpar( $_GET['pg'] ) );
        }

        /**
         * Maximo de resultados por página
         */
        $PagMax = sprintf( '%d', $quantidade );

        /**
         * Contando resultados
         * para a query
         */
        $Contagem = $quantidade * ( $page - 1 );

        /**
         * Verificando se o parametro $complemento
         * é um array
         */
        if( ! is_array( $complementos ) ) {
            @header( "HTTP/1.0 404 Not Found" );
            @header( "Status: 404 Not Found" );
            exit();
        }

        if( $page > 1 ) {
            /**
             * Query com itens não relacionados
             */
            if( isset( $_GET['tipo'] ) && $_GET['tipo'] == "todos" ) {

                if( isset( $_GET['sexo'] ) ) {

                    $Query = $this->sql->Query( sprintf( "SELECT TOP %d * FROM Classic_Shop WHERE item_id NOT IN ( SELECT TOP %s item_id FROM Classic_Shop WHERE item_sexo = %s ORDER BY %s %s ) AND item_sexo = %s ORDER BY %s %s;",
                        $quantidade, $Contagem, $complementos['int_sexo'], $complementos['str_ordem'], $complementos['str_cond'],
                        $complementos['int_sexo'], $complementos['str_ordem'], $complementos['str_cond'] ) );

                } else {

                    $Query = $this->sql->Query( sprintf( "SELECT TOP %d * FROM Classic_Shop WHERE item_id NOT IN ( SELECT TOP %s item_id FROM Classic_Shop ORDER BY %s %s ) ORDER BY %s %s;",
                        $quantidade, $Contagem, $complementos['str_ordem'], $complementos['str_cond'], $complementos['str_ordem'],
                        $complementos['str_cond'] ) );

                }


            } else {

                if( isset( $_GET['sexo'] ) ) {

                    $Query = $this->sql->Query( sprintf( "SELECT TOP %d * FROM Classic_Shop WHERE item_id NOT IN ( SELECT TOP %s item_id FROM Classic_Shop WHERE item_tipo = '%d' AND item_sexo = %s ORDER BY %s %s ) AND item_tipo = '%d' AND item_sexo = %s ORDER BY %s %s;",
                        $quantidade, $Contagem, $complementos['int_Tipo'], $complementos['str_ordem'], $complementos['int_sexo'],
                        $complementos['str_cond'], $complementos['int_Tipo'], $complementos['int_sexo'],
                        $complementos['str_ordem'], $complementos['str_cond'] ) );

                } else {

                    $Query = $this->sql->Query( sprintf( "SELECT TOP %d * FROM Classic_Shop WHERE item_id NOT IN ( SELECT TOP %s item_id FROM Classic_Shop WHERE item_tipo = '%d' ORDER BY %s %s ) AND item_tipo = '%d' ORDER BY %s %s;",
                        $quantidade, $Contagem, $complementos['int_Tipo'], $complementos['str_ordem'], $complementos['str_cond'],
                        $complementos['int_Tipo'], $complementos['str_ordem'], $complementos['str_cond'] ) );

                }

            }

        } else {

            if( isset( $_GET['tipo'] ) && $_GET['tipo'] == "todos" ) {

                if( isset( $_GET['sexo'] ) ) {

                    $Query = $this->sql->Query( sprintf( "SELECT TOP %d * FROM Classic_Shop WHERE item_sexo = %s ORDER BY %s %s;",
                        $quantidade, $complementos['int_sexo'], $complementos['str_ordem'], $complementos['str_cond'] ) );

                } else {
                    $Query = $this->sql->Query( sprintf( "SELECT TOP %d * FROM Classic_Shop ORDER BY %s %s;",
                        $quantidade, $complementos['str_ordem'], $complementos['str_cond'] ) );
                }

            } else {

                if( isset( $_GET['sexo'] ) ) {

                    $Query = $this->sql->Query( sprintf( "SELECT TOP %d * FROM Classic_Shop WHERE item_tipo = '%d' ORDER BY %s %s;",
                        $quantidade, $complementos['int_Tipo'], $complementos['str_ordem'], $complementos['str_cond'] ) );

                } else {

                    $Query = $this->sql->Query( sprintf( "SELECT TOP %d * FROM Classic_Shop WHERE item_tipo = '%d' AND item_sexo = %s ORDER BY %s %s;",
                        $quantidade, $complementos['int_Tipo'], $complementos['int_sexo'], $complementos['str_ordem'],
                        $complementos['str_cond'] ) );

                }

            }

        }

        if( $this->sql->nRows( $Query ) != 0 ) {

            while ( $itens_res = $this->sql->inObject( $Query ) ) {

                $ItemNome[] = utf8_encode( $itens_res->item_nome );
                $ItemPreco[] = $itens_res->item_preco;
                if( empty( $itens_res->item_imagem ) ) {
                    $itens_img[] = "sem_imagem.png";
                } else {
                    $itens_img[] = $itens_res->item_imagem;
                }

            }

            $this->smarty->assign( "itens_nomes", $ItemNome );
            $this->smarty->assign( "itens_preco", $ItemPreco );
            $this->smarty->assign( "itens_imagem", $itens_img );

        } else {
            $this->smarty->assign( "res_nulo", "Nenhum item encontrado no banco de dados!" );
        }

        $this->sql->liparRes();

        if( isset( $_GET['tipo'] ) && $_GET['tipo'] == "todos" ) {

            if( isset( $_GET['sexo'] ) ) {
                $QueryPaginacao = $this->sql->Query( sprintf( "SELECT * FROM Classic_Shop WHERE item_sexo = %s ORDER BY %s %s;",
                    $complementos['int_sexo'], $complementos['str_ordem'], $complementos['str_cond'] ) );
            } else {
                $QueryPaginacao = $this->sql->Query( sprintf( "SELECT * FROM Classic_Shop ORDER BY %s %s;",
                    $complementos['str_ordem'], $complementos['str_cond'] ) );
            }

        } else {

            if( isset( $_GET['sexo'] ) ) {
                $QueryPaginacao = $this->sql->Query( sprintf( "SELECT * FROM Classic_Shop WHERE item_tipo = '%d' AND item_sexo = %s  ORDER BY %s %s;",
                    $complementos['int_Tipo'], $complementos['int_sexo'], $complementos['str_ordem'],
                    $complementos['str_cond'] ) );
            } else {
                $QueryPaginacao = $this->sql->Query( sprintf( "SELECT * FROM Classic_Shop WHERE item_tipo = '%d' ORDER BY %s %s;",
                    $complementos['int_Tipo'], $complementos['str_ordem'], $complementos['str_cond'] ) );
            }
        }

        $stages = 3;
        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil( $this->sql->nRows( $QueryPaginacao ) / $PagMax );
        $LastPagem1 = $lastpage - 1;
        $paginate = '';

        /**
         * Gerando a porra do link!
         */

        $pag_liks = "index.php?url=store";

        if( isset( $_GET['tipo'] ) ) {
            $pag_liks .= "&tipo=" . $this->web->Limpar( $_GET['tipo'] );
        }

        if( isset( $_GET['ordernar'] ) ) {
            $pag_liks .= "&ordernar=" . $this->web->Limpar( $_GET['ordernar'] );
        }

        if( isset( $_GET['valores'] ) ) {
            $pag_liks .= "&valores=" . $this->web->Limpar( $_GET['valores'] );
        }

        if( isset( $_GET['sexo'] ) ) {
            $pag_liks .= "&sexo=" . $this->web->Limpar( $_GET['sexo'] );
        }


        /**
         * Link gerado
         */


        if( $lastpage > 1 ) {
            if( $page > 1 ) {
                $paginate .= "<a href='$pag_liks&pg=$prev'>&laquo</a> ";
            }
            if( $lastpage < 7 + ( $stages * 2 ) ) {
                for ( $counter = 1; $counter <= $lastpage; $counter++ ) {
                    if( $counter == $page ) {
                        $paginate .= " [$counter] ";
                    } else {
                        $paginate .= " <a href='$pag_liks&pg=$counter'>[$counter]</a> ";
                    }
                }
            } elseif ( $lastpage > 5 + ( $stages * 2 ) ) {
                if( $page < 1 + ( $stages * 2 ) ) {
                    for ( $counter = 1; $counter < 4 + ( $stages * 2 ); $counter++ ) {
                        if( $counter == $page ) {
                            $paginate .= " [$counter] ";
                        } else {
                            $paginate .= " <a href='$pag_liks&pg=$counter'>[$counter]</a> ";
                        }
                    }
                    $paginate .= " ... ";
                    $paginate .= " <a href='$pag_liks&pg=$LastPagem1'>[$LastPagem1]</a> ";
                    $paginate .= " <a href='$pag_liks&pg=$lastpage'>[$lastpage]</a> ";
                } elseif ( $lastpage - ( $stages * 2 ) > $page && $page > ( $stages * 2 ) ) {
                    $paginate .= " <a href='$pag_liks&pg=1'>[1]</a> ";
                    $paginate .= " <a href='$pag_liks&pg=2'>[2]</a> ";
                    $paginate .= " ... ";
                    for ( $counter = $page - $stages; $counter <= $page + $stages; $counter++ ) {
                        if( $counter == $page ) {
                            $paginate .= " [$counter] ";
                        } else {
                            $paginate .= " <a href='$pag_liks&pg=$counter'>[$counter]</a> ";
                        }
                    }
                    $paginate .= " ... ";
                    $paginate .= " <a href='$pag_liks&pg=$LastPagem1'>[$LastPagem1]</a> ";
                    $paginate .= " <a href='$pag_liks&pg=$lastpage'>[$lastpage]</a> ";
                } else {
                    $paginate .= " <a href='$pag_liks&pg=1'>[1]</a> ";
                    $paginate .= " <a href='$pag_liks'&pg=2'>[2]</a> ";
                    $paginate .= " ... ";
                    for ( $counter = $lastpage - ( 2 + ( $stages * 2 ) ); $counter <= $lastpage; $counter++ ) {
                        if( $counter == $page ) {
                            $paginate .= " [$counter] ";
                        } else {
                            $paginate .= " <a href='$pag_liks'&pg=$counter'>[$counter]</a> ";
                        }
                    }
                }
            }
            if( $page < $counter - 1 ) {
                $paginate .= " <a href='$pag_liks&pg=$next'>&raquo;</a>";
            }
        }

        $this->smarty->assign( "Paginas_Paginacao", $paginate );

    }
	
	function VisualizarItem( $Nome ){
		
		$ItemNome			=	$this->web->Limpar( $Nome );
		$PegarInfosItem		=	$this->sql->Selecionar( "Classic_Shop", array(), 1, "item_nome = '{$ItemNome}'", null);
		$ItemInfo			=	$this->sql->inObject( $PegarInfosItem );
		
		// Assinando variaveis!
		$this->smarty->assign( 'ItemNome', $ItemInfo->item_nome );
		
		// Assinando variaveis!
		$this->smarty->assign( 'Item_Identificacao', $ItemInfo->item_id );
		
		switch ( $ItemInfo->item_tipo ) {

            case 1:
                $Tipo = "Cabeça";
                break;

            case 2:
                $Tipo = "Corpo";
                break;

            case 3:
                $Tipo = "Calcas";
                break;

            case 4:
                $Tipo = "Mãos";
                break;

            case 5:
                $Tipo = "Pés";
                break;

            case 6:
            case 7:
                $Tipo = "Curta distâcia";
                break;

            case 8:
            case 9:
            case 10:
			case 11:
			case 12:
                $Tipo = "Longa distâcia";
                break;

            case 13:
                $Tipo = "aneis";
                break;

            case 14:
                $Tipo = "meds";
                break;

            default:
                @header( "HTTP/1.0 404 Not Found" );
                @header( "Status: 404 Not Found" );
                exit();
        }		
		// Assinando variaveis!
		$this->smarty->assign( 'ItemTipo', $Tipo );
		
		
		switch( $ItemInfo->item_sexo ){
			
			case 0:
				$Sexo = "Masculino";
				break;
				
			case 1:
				$Sexo = "Feminino";
				break;
				
			case 2:
				$Sexo = "&Acirc;mbos";
				break;
		
		}
		// Assinando variaveis!
		$this->smarty->assign( 'ItemSexo', $Sexo );
		
		// Assinando variaveis!
		$this->smarty->assign( 'ItemLevel', $ItemInfo->item_level );
		
		// Assinando variaveis!
		$this->smarty->assign( 'ItemPeso', $ItemInfo->item_peso );
		
		// Assinando variaveis!
		$this->smarty->assign( 'ItemCash', $ItemInfo->item_preco );
		
		// Assinando variaveis!
		$this->smarty->assign( 'ItemDesc', $ItemInfo->item_desc );
		
		if( $ItemInfo->item_damege == NULL ){
			// Assinando variaveis!
			$this->smarty->assign( 'ItemDamage', 0 );
		} else {
			// Assinando variaveis!
			$this->smarty->assign( 'ItemDamage', $ItemInfo->item_damege );
		}
		
		if( $ItemInfo->item_delay == NULL ){
			// Assinando variaveis!
			$this->smarty->assign( 'ItemAtrazo', 0 );
		} else {
			// Assinando variaveis!
			$this->smarty->assign( 'ItemAtrazo', $ItemInfo->item_delay );
		}
		
		if( $ItemInfo->item_magazine == NULL ){
			// Assinando variaveis!
			$this->smarty->assign( 'ItemBalas', 0 );
		} else {
			// Assinando variaveis!
			$this->smarty->assign( 'ItemBalas', $ItemInfo->item_magazine );
		}
		
		if( $ItemInfo->item_maxbullet == NULL ){
			// Assinando variaveis!
			$this->smarty->assign( 'ItemBullent', 0 );
		} else {
			// Assinando variaveis!
			$this->smarty->assign( 'ItemBullent', $ItemInfo->item_maxbullet );
		}
		
		if( $ItemInfo->item_hp == NULL ){
			// Assinando variaveis!
			$this->smarty->assign( 'ItemHP', 0 );
		} else {
			// Assinando variaveis!
			$this->smarty->assign( 'ItemHP', $ItemInfo->item_hp );
		}
		
		if( $ItemInfo->item_ap == NULL ){
			// Assinando variaveis!
			$this->smarty->assign( 'ItemAP', 0 );
		} else {
			// Assinando variaveis!
			$this->smarty->assign( 'ItemAP', $ItemInfo->item_ap );
		}
		
	}

}

?>