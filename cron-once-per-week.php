<?php

if (!defined('ABSPATH')) {
    require_once(dirname( __FILE__ ) . '/wp-load.php');
}

if ( !defined('ABSPATH') ) {
    /** Set up WordPress environment */
    require_once( dirname( __FILE__ ) . '/wp-load.php' );
}

define( 'MY_PLUGIN_PATH', ABSPATH . 'wp-content/plugins/kz-crawler' );

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}



require_once(MY_PLUGIN_PATH.'/libs/simplehtmldom/simple_html_dom.php');

require_once(MY_PLUGIN_PATH.'/app/controllers/crawler-controller.php');
require_once(MY_PLUGIN_PATH.'/app/controllers/block-controller.php');
require_once(MY_PLUGIN_PATH.'/app/controllers/kz-controller.php');
require_once(MY_PLUGIN_PATH.'/app/models/blocks.php');


$crawlerCtr = new crawlerController();

global $wpdb;
$table_name = $wpdb->prefix . 'blocks';

$blocks = $wpdb->get_results( "SELECT * FROM $table_name "); /*mulitple row results can be pulled from the database with get_results function and outputs an object which is stored in $result */

foreach($blocks as $block) {

    if($block->cron_type == 2) {
        $crawlerCtr->craw($block->id);
    }
}

?>