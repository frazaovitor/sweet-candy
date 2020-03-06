<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'db_tuxcar' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         's;pw)%5ss;@cwwErH@c&Y;sF2qPXQo1l~V63`NBzXH92kKW{j1jJoHfj~hr7SA{=' );
define( 'SECURE_AUTH_KEY',  '$|}}_]JW n-^nWR DXie`,0Nc!db{e)5:B}q#DGIzDxb)8q3[HhU</W,u&bndGZL' );
define( 'LOGGED_IN_KEY',    'mpxc@1~hy0[Vm76V>2NT^fJAN6$S}hI01;VwIdOA1U7MWv@@[NIey/;z $::v,qv' );
define( 'NONCE_KEY',        'git~X=Pb^wo`p1rfN#~$~9[pi%EbPxsDZ5O12`PGuic6nX_l%-e@DS)nO<X6Fzci' );
define( 'AUTH_SALT',        'Mdv~A7*C6V|Md9LG2*ayq9;xK27Cw$j~nw{s2=NQ9SCbOPSwO7;2DB5ii0ujRy<]' );
define( 'SECURE_AUTH_SALT', '>aQJ4pwE{(_R6WCnnGjN%]!jH,4XJkuu~J uiQl1(lOp-ywpCINYui[pzBi@&iP,' );
define( 'LOGGED_IN_SALT',   '(YxsF6*V`n=K,RBmk_zDt-Q3[`h_pI+mxR;moDOm[25g~23m.c*`O93,|U7Mn@E&' );
define( 'NONCE_SALT',       'O41~b0;e~MFG}1KTx^ zH80{i9:[O$/W*CgIinqKM`fDF!M#TwzqTC`2/_MNC0lj' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
