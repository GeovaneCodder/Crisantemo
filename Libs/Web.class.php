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


class WebClass {

    private $sql;

    function __construct() {
        /**
         * Definindo sql a varial global;
         */
        global $sql;

        /**
         * Atribuindo a variavel global sql
         * a private $this->sql;
         */
        $this->sql = $sql;
    }

    function Titulo( $string ) {
            $_SESSION['SUBTITULO'] = $string;
    }

    function redir( $Para, $Tempo ) {

        $Redir = sprintf( "<meta http-equiv='refresh' content='%d; url=%s'>", $Tempo, $Para );
        print ( $Redir );

    }

    function porcentagem( $matou, $morreu, $empate = null, $tipo ) {

        if( $tipo == "Character" ) {
            $total = $matou + $morreu;
            $porcentagem = @round( ( 100 * $matou ) / $total, 2 );
            if( $matou == 0 && $morreu == 0 ) {
                return "100";
            } else {
                return sprintf( "%d", $porcentagem );
            }
        }

        if( $tipo == "Clan" ) {
            $total = $matou + $morreu + $empate;
            $porcentagem = @round( ( 100 * $matou ) / $total, 2 );
            if( $matou == 0 && $morreu == 0 ) {
                return "100";
            } else {
                return sprintf( "%d", $porcentagem );
            }
        }
    }

    function Limpar( $szValor ) {

        $pArray = str_split( $szValor );

        foreach ( $pArray as $i => $pvalue ) {
            if( $pvalue == '\'' || $pvalue == '\"' || $pvalue == '-' ) {
                str_ireplace( $pvalue, "", $pArray );
            }
        }

        $check = $szValor;

        $search = array(
            'chr(',
            'chr=',
            'chr%20',
            '%20chr',
            'wget%20',
            '%20wget',
            'wget(',
            'cmd=',
            '%20cmd',
            'cmd%20',
            'rush=',
            '%20rush',
            'rush%20',
            'union%20',
            '%20union',
            'union(',
            'union=',
            'echr(',
            '%20echr',
            'echr%20',
            'echr=',
            'esystem(',
            'esystem%20',
            'cp%20',
            '%20cp',
            'cp(',
            'mdir%20',
            '%20mdir',
            'mdir(',
            'mcd%20',
            'mrd%20',
            'rm%20',
            '%20mcd',
            '%20mrd',
            '%20rm',
            'mcd(',
            'mrd(',
            'rm(',
            'mcd=',
            'mrd=',
            'mv%20',
            'rmdir%20',
            'mv(',
            'rmdir(',
            'chmod(',
            'chmod%20',
            '%20chmod',
            'chmod(',
            'chmod=',
            'chown%20',
            'chgrp%20',
            'chown(',
            'chgrp(',
            'locate%20',
            'grep%20',
            'locate(',
            'grep(',
            'diff%20',
            'kill%20',
            'kill(',
            'killall',
            'passwd%20',
            '%20passwd',
            'passwd(',
            'telnet%20',
            'vi(',
            'vi%20',
            'insert%20into',
            'select%20',
            'fopen',
            'fwrite',
            '%20like',
            'like%20',
            '$_request',
            '$_get',
            '$request',
            '$get',
            '.system',
            'HTTP_PHP',
            '&aim',
            '%20getenv',
            'getenv%20',
            'new_password',
            '&icq',
            '/etc/password',
            '/etc/shadow',
            '/etc/groups',
            '/etc/gshadow',
            'HTTP_USER_AGENT',
            'HTTP_HOST',
            '/bin/ps',
            'wget%20',
            'uname\x20-a',
            '/usr/bin/id',
            '/bin/echo',
            '/bin/kill',
            '/bin/',
            '/chgrp',
            '/chown',
            '/usr/bin',
            'g\+\+',
            'bin/python',
            'bin/tclsh',
            'bin/nasm',
            'perl%20',
            'traceroute%20',
            'ping%20',
            '.pl',
            'lsof%20',
            '/bin/mail',
            '.conf',
            'motd%20',
            'HTTP/1.',
            '.inc.php',
            'config.php',
            'cgi-',
            '.eml',
            'file\://',
            'window.open',
            '<script>',
            'javascript\://',
            'img src',
            'img%20src',
            '.jsp',
            'ftp.exe',
            'xp_enumdsn',
            'xp_availablemedia',
            'xp_filelist',
            'xp_cmdshell',
            'nc.exe',
            '.htpasswd',
            'servlet',
            '/etc/passwd',
            'wwwacl',
            '~root',
            '~ftp',
            '.js',
            '.jsp',
            'admin_',
            '.history',
            'bash_history',
            '.bash_history',
            '~nobody',
            'server-info',
            'server-status',
            'reboot%20',
            'halt%20',
            'powerdown%20',
            '/home/ftp',
            '/home/www',
            'secure_site, ok',
            'chunked',
            'org.apache',
            '/servlet/con',
            '<script',
            'UPDATE',
            'SELECT',
            'DROP',
            '/robot.txt',
            '/perl',
            'mod_gzip_status',
            'db_mysql.inc',
            '.inc',
            'select%20from',
            'select from',
            'drop%20',
            'getenv',
            'http_',
            '_php',
            'php_',
            'phpinfo()',
            '<?php',
            '?>',
            'sql=',
            ';',
            "'",
            '--',
            '"' );


        for ( $i = 0; $i <= 50; $i++ ) {
            $szValor = str_ireplace( $search, "", $szValor );
            $szValor = preg_replace( @sql_regcase( "/(shutdown|drop|backup|select|request|from|insert|delete|union|0x|table|exec|varchar|insert into|delete from|update account|update login|update character|ugradeid|drop table|show tables|name|password|login|account|login|clan|0x|;|character|set|where|#|%27|\*|--|\\\\)/" ),
                "", $szValor );
            $szValor = trim( $szValor );
            $szValor = strip_tags( $szValor );
            $szValor = addslashes( $szValor );
            $szValor = str_ireplace( "'", "`", $szValor );
            $szValor = stripcslashes( $szValor );
            $szValor = htmlspecialchars( $szValor );
        }

        if( isset( $_SESSION['classic'] ) ) {
            $UserId = $_SESSION['classic'];
        } else {
            $UserId = "Anonimo";
        }

        if( $check != $szValor ) {
            $logf = fopen( "Docs/Logs/logs.txt", "a+" );
            fprintf( $logf, "%s?url=%s.php\r\nUserID = %s\r\nData : %s\r\nIP : %s\r\nValor: %s\r\nCorrigido para: %s\r\n\r\n=============================================================================================\r\n \r\n",
                str_replace( "/", "", $_SERVER['PHP_SELF'] ), $_GET['url'], $UserId, date( "d/m/Y" ) .
                " ás " . date( "H:i:s" ), $_SERVER['REMOTE_ADDR'], $check, $szValor );
            fclose( $logf );
        }

        return ( $szValor );
    }


    function SemLogin() {

        if( isset( $_SESSION['classic'] ) ) {
            @header( "HTTP/1.0 404 Not Found" );
            @header( "Status: 404 Not Found" );
            exit();
        }

    }

    function GunzSexo( $Tipo ) {

        switch ( $Tipo ) {

            case 0:
                $retorno = "Masculino";
                break;

            case 1:
                $retorno = "Feminino";
                break;

            case 2:
                $retorno = "Unissex";
                break;
        }

        return $retorno;
    }

}

?>