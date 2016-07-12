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
            array($this, 'tt_render_list_page'),
            'dashicons-sticky',
            '23.56'
        );


        add_submenu_page('kz-crawler', 'Add Block', 'Add Block', 'manage_options', 'kz-crawler/add-block', array($this, 'add_block'));
        add_submenu_page('kz-crawler', 'About', 'About', 'manage_options', 'kz-crawler/about', array($this, 'clivern_render_about_page'));
    }



    public function tt_render_list_page(){


        //Create an instance of our package class...
        $testListTable = new kz_Blocks_Table();


        //Fetch, prepare, sort, and filter our data...
        $testListTable->prepare_items();

        ?>
        <div class="wrap">

            <div id="icon-users" class="icon32"><br/></div>
            <h2>List Block</h2>

            <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
            <form id="movies-filter" method="get">
                <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <!-- Now we can render the completed list table -->
                <?php $testListTable->display() ?>
            </form>

        </div>
        <?php
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