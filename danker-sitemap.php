<?php
/*
Plugin Name: Danker Sitemap
Plugin URI: http://www.dankedev.com
Description: Easy To make sitemap page.
Author: Hadie Danker
Version: 1.0
Author URI: http://www.dankedev.com
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define('DNSTMP_VERSION','1.0');
define('DNSTMP_REQUIRED_WP_VERSION','4.6');
define('DNSTMP_PLUGIN',__FILE__);
define( 'DNSTMP_PLUGIN_BASENAME', plugin_basename( DNSTMP_PLUGIN ) );
define( 'DNSTMP_PLUGIN_NAME', trim( dirname( DNSTMP_PLUGIN_BASENAME ), '/' ) );
define( 'DNSTMP_PLUGIN_DIR', untrailingslashit( dirname( DNSTMP_PLUGIN ) ) );
if (!defined('DNSTMP_OPTIONS_KEY')) define('DNSTMP_OPTIONS_KEY', 'dnstmp_opt');
if (!defined('DNSTMP_PLUGIN_URL')) define('DNSTMP_PLUGIN_URL', WP_PLUGIN_URL . '/' . DNSTMP_PLUGIN_NAME);


require_once 'libs/DNSTMP.php';

$dnstmp = new DNSTMP();


/**
 * Display All Sitemap
 */
function danker_sitemap(){
    global $dnstmp;
   $pages = $dnstmp->pages();
   $np = isset($_REQUEST['np'])? $_REQUEST['np']: 1;
    $posts = $dnstmp->posts(5,'',$np,true);

    $categories = $dnstmp->categories();
    return $categories;

}



add_shortcode('danker-sitemap', 'danker_sitemap' );
