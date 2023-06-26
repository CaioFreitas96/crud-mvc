<?php
//CONFIGURAÇÕES GERAIS
if (isset($_GET['debug'])){
	define( 'DEBUG', true);
}else{
	define( 'DEBUG', false);
}

define( 'ABSPATH', dirname( __FILE__ ) );
define( 'DS', DIRECTORY_SEPARATOR);

define( 'SISTEMA_DESATIVADO', false);

// time zone padrão fora do horario de verão
define( 'TIME_ZONE', 'America/Sao_Paulo' );

define( 'HOME_URI', '/');
define( 'URL_SISTEMA', 'http://'.$_SERVER['SERVER_NAME'].'/');

//AMBIENTE DE HOMOLOG
define( 'TIPO_AMBIENTE', 'homolog');

// CONFIGURAÇÕES BANCO DE DADOS
define("HOSTNAME", "localhost");
define("DB_NAME", "base");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_PORT", "");
define("DB_CHARSET", 'utf8' );



