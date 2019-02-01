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
$web->Titulo( "registro" );

/**
 * Somente computadores deslogados
 */
$web->SemLogin();

$Registro = new Registro();

    if( ! isset( $_POST['classicgunz_reg'] ) ) {

        /**
         * Dias para formulário do registro
         */
        for ( $d = 1; $d <= 31; $d++ ) {
            $dias[] = $d;
        }

        /**
         * Mes para formulário do registro
         */
        $meses = array(
            "01" => "Janeiro",
            "02" => "Fevereiro",
            "03" => "Março",
            "04" => "Abril",
            "05" => "Maio",
            "06" => "Junho",
            "07" => "Julho",
            "08" => "Agosto",
            "09" => "Setembro",
            "10" => "Outubro",
            "11" => "Novembro",
            "12" => "Dezembro" );

        /**
         * Anos para o formulário do registro
         */
        for ( ( $a = date( "Y" ) - 20 ); $a <= date( "Y" ); $a++ ) {
            $anos[] = $a;
        }

        /**
         * Perguntas secretas para o formulário do registro
         */
        $PerguntasSecretas = array(
            "Qual é o nome da sua mãe",
            "Sua música preferida",
            "Comida que mais gosta",
            "Nome da sua namorada",
            "Melhor time do mundo",
            "Cantor(a) que mais gosta",
            "Melhor marca de tênis",
            "Animal preferido",
            "Filme que mais gosta" );

		/**
		 * Assinando o codigo de segurança
		 */
		$smarty->assign( 'Codigo_Capatcha', "Libs/Captcha.class.php" );
		
        /**
         * Assinindoa as variaveis
         * do formulário de registro
         */
        //DIAS
        $smarty->assign( "dias_reg", $dias );

        //MESES
        $smarty->assign( "meses_reg", $meses );

        //ANOS
        $smarty->assign( "anos_reg", $anos );

        //PERGUNTAS SECRETAS
        $smarty->assign( "perguntas_reg", $PerguntasSecretas );

    } else {

        /**
         * Variavel que armazenará os erros!
         */
        $erros = "";

        /**
         * Nome a registrar
         */
        $Nome = $web->Limpar( $_POST['reg_nome'] );

        /**
         * Email a registrar
         */
        $Email = $web->Limpar( $_POST['reg_email_1'] );
        if( $Registro->Verificar( null, $Email ) === true ) {
            $erros .= "&bull; E-mail j&aacute; cadastrado em nosso banco de dados! <br />";
        }

        /**
         * Data De Nascimento a registrar
         */
        $DataNascimento = sprintf( "%d / %d / %d", $web->Limpar( $_POST['reg_dia_nas'] ),
            $web->Limpar( $_POST['reg_mes_nas'] ), $web->Limpar( $_POST['reg_ano_nas'] ) );

        /**
         * UserID a Registrar
         */
        $UserID = $web->Limpar( $_POST['reg_userid'] );
        if( $Registro->Verificar( $UserID, null ) === true ) {
            $erros .= "&bull; UserID já cadastrado em nosso banco de dados! <br />";
        }
        /**
         * Senha a registrar
         */
        $Senha = $web->Limpar( $_POST['reg_senha_1'] );

        /**
         * Pergunta Secreta
         */
        $PerguntaSecreta = $web->Limpar( $_POST['reg_peg_sec'] );

        /**
         * Resposta secreta a registrar
         */
        $RespostaSecreta = $web->Limpar( $_POST['reg_res_sec'] );

        /**
         * Verificar se o computador já foi cadastrado
         */
        if( $Registro->VerificarIP( $_SERVER['REMOTE_ADDR'] ) === true ) {
            $erros .= "&bull; IP já cadastrado em nosso banco de dados, é permitido apenas 1 conta por computador! <br />";
        }

		/**
		 * Verificar se o codigo de segurança está correto
		 */
		if( $_POST['reg_codigo'] != $_SESSION['codigo'] ){
			$erros .= "&bull; C&oacute;digo de seguran&ccedil;a incorreto! <br />";
		}

        if( $erros === "" ) {

            $Registro->Cadastrar( $Nome, $Email, $DataNascimento, $UserID, $Senha, $PerguntaSecreta,
                $RespostaSecreta, $_SERVER['REMOTE_ADDR'] );

        } else {

            $_SESSION['reg_erro'] = "<font color='darkorange'>Erros</font> :&nbsp;<br />" .
                $erros;
            $web->redir( "index.php?url=registro", 0 );

        }


    }

?>