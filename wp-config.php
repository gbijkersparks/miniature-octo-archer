<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'Atlantes2');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'admin');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '1234');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'y/]^Zs4cgMo^ I?)p#i$-(@s.EU).Wi NEGt-eSF7*-wN4bETS-Xp86@mFj]X9}[');
define('SECURE_AUTH_KEY',  'oc?_t*a#:|b?0Co%EavgYU}qB/7/^y/0ZI)LX[d:]iQ?hNum1~o$G,XRDKsZ4=NC');
define('LOGGED_IN_KEY',    'w/wuw r{VOO]#E&;a8{I.0rxrQZ;s|]~:GU_fHsjm=KdCR{yE!8x>%!UcoCGX{0J');
define('NONCE_KEY',        'O^raEA+!_bq#C^-enKkUTp64*I*lU{{:m.*%0vAk0.aW<^9~14wu~RgW6 H|*$eb');
define('AUTH_SALT',        'j_@XJMn|2G&8T;ENugq8xqbX3Wr$R?M$[N_/=#w{+6}USLn@br(n#s({0XOT.,%<');
define('SECURE_AUTH_SALT', 'v! t!Y|+;Fk@9p}tPQawOz`<M-ub>tO(VMUU.8Q%q!:^:V2S^I8V]hr#K~E&Wb+h');
define('LOGGED_IN_SALT',   '<2u[wm?PCl>;aVaebmT$7Emm2Hk~~~%q>^;p(sK hI$R4gGU-Y(gK4W:1JX1*9_/');
define('NONCE_SALT',       'r])`K:L1ahwi5 JT3MLr.WDHDmzfF&=$Q,egPdd }JfQacyIXx<il73?t/.BqR~$');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * O idioma localizado do WordPress é o inglês por padrão.
 *
 * Altere esta definição para localizar o WordPress. Um arquivo MO correspondente ao
 * idioma escolhido deve ser instalado em wp-content/languages. Por exemplo, instale
 * pt_BR.mo em wp-content/languages e altere WPLANG para 'pt_BR' para habilitar o suporte
 * ao português do Brasil.
 */
define('WPLANG', 'pt_BR');

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
