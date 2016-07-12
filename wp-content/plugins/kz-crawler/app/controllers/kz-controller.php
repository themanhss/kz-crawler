<?php
class kzController extends WP_List_Table
{
    public function __construct()
    {
        define( 'MY_PLUGIN_PATH', ABSPATH . 'wp-content/plugins/kz-crawler' );
        if (is_admin()) {
            $this->init();
        }
    }

    public function init()
    {

        require_once MY_PLUGIN_PATH.'/libs/simplehtmldom/simple_html_dom.php';

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


        add_submenu_page('kz-crawler', 'Add Block', 'Add Block', 'manage_options', 'kz-crawler/add-block', array($this, 'add_block'));
        add_submenu_page('kz-crawler', 'About', 'About', 'manage_options', 'kz-crawler/about', array($this, 'clivern_render_about_page'));
    }

    public function wporg_options_page(){
        echo 'hello';
    }

    public function add_block(){
        ?>
        <div class='wrap'>
            <h2>Add New Blocks</h2>
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