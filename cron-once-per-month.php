<?php
if (!defined('ABSPATH')) {
    require_once(dirname( __FILE__ ) . '/wp-load.php');
}
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

require_once('libs/simplehtmldom/simple_html_dom.php');

require_once('app/controllers/crawler-controller.php');
require_once('app/controllers/block-controller.php');
require_once('app/controllers/kz-controller.php');
require_once('app/models/blocks.php');


    $crawlerCtr = new crawlerController();

    global $wpdb;
    $table_name = $wpdb->prefix . 'blocks';

    $blocks = $wpdb->get_results( "SELECT * FROM $table_name "); /*mulitple row results can be pulled from the database with get_results function and outputs an object which is stored in $result */

    foreach($blocks as $block) {
        $crawlerCtr->craw($block->id);
    }

?>