<?php
    /*
    Plugin Name: Kz Crawler
    Plugin URI:  http://kiza.vn
    Description: This describes my plugin in a short sentence
    Version:     1.0.0
    Author:      manhnt
    Author URI:  http://kiza.vn
    License:     GPL2
    License URI: https://www.gnu.org/licenses/gpl-2.0.html
    Domain Path: /languages
    Text Domain: kz-crawler
    */

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

require_once('libs/simplehtmldom/simple_html_dom.php');

require_once('app/controllers/crawler-controller.php');
require_once('app/controllers/block-controller.php');
require_once('app/controllers/kz-controller.php');
require_once('app/models/blocks.php');

register_activation_hook( __FILE__, array( 'blocksModel', 'create_blocks_table' ) );

?>