<?php
class kzController
{
    public function __construct()
    {
        if (is_admin()) {
            $this->init();
        }
    }

    public function init()
    {
        define( 'MY_PLUGIN_PATH', ABSPATH . 'wp-content/plugins/kz-crawler' );
        require_once MY_PLUGIN_PATH.'/libs/simplehtmldom/simple_html_dom.php';

        // Include 'blocks' table
        include_once  MY_PLUGIN_PATH.'/app/models/blocks.php';

        register_activation_hook( __FILE__, array( 'blocksModel', 'jal_install' ) );
        register_activation_hook( __FILE__, array( 'blocksModel', 'jal_install_data' ) );


        // Add action
        add_action( 'admin_menu', array($this,'add_my_custom_menu') );
    }

    public function add_my_custom_menu() {
        //add an item to the menu
        add_menu_page(
            'kz Crawler',
            'Kz Crawler',
            'manage_options',
            'kz-crawler',
            array($this, 'wporg_options_page'),
            'dashicons-sticky',
            '23.56'
        );


        add_submenu_page('kz-crawler', 'Custom', 'Custom', 'manage_options', 'kz-crawler/custom', array($this, 'clivern_render_custom_page'));
        add_submenu_page('kz-crawler', 'About', 'About', 'manage_options', 'kz-crawler/about', array($this, 'clivern_render_about_page'));
    }

    public function wporg_options_page(){

        echo 'hello';

    }

    public function clivern_render_custom_page(){
        ?>
        <div class='wrap'>
            <h2>Custom</h2>
        </div>
        <?php
    }

    public function clivern_render_about_page(){
        ?>
        <div class='wrap'>
            <h2>About</h2>
        </div>
        <?php
    }
}

$foo = new kzController();
?>