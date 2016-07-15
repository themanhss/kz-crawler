<?php

/*
 * Process craw data
 * use : simple_html_dom.php
 * */
class crawlerController {

    public function __construct()
    {

    }

    public function craw($block_id){

        $block = $this->getBlockByID($block_id);


        $detail_news_pattern = $block->a_pattern;
        $title_pattern = $block->title_pattern;
        $description_pattern = $block->content_pattern;
        $description_pattern_delete = $block->except_pattern;


        $link =  $block->url_category;

        $html = file_get_html($link);

        $detail_item = $html->find($detail_news_pattern,2)->href;

        $post = array();


        $detail_link = file_get_html($detail_item);

        // Get Title
        foreach($detail_link->find($title_pattern) as $element)
        {
            $post['title'] = trim($element->plaintext); // Chỉ lấy phần text
        }

//        var_dump($post['title']); die();
        // Check if post exits
        if($this->wp_exist_page_by_title($post['title'])){
            var_dump('Post exits'); die();
        }

        // Get main content

        foreach($detail_link->find($description_pattern) as $element)
        {

            // Xóa các mẫu trong miêu tả
            if($description_pattern_delete){
                $arr = explode(',',$description_pattern_delete);
                for($j=0;$j<count($arr);$j++){
                    foreach($element->find($arr[$j]) as $e){
                        $e->outertext='';
                    }
                }
            }

            $post['content'] = $element->innertext; // Lấy toàn bộ phần html

            // Remove toàn bộ thẻ a
            $post['content'] = preg_replace("/<a[^>]+>/i", "", $post['content']);

            // Find all images
            foreach($element->find('img') as $img) {
                $img_link = $img->src;

                // Get Path to image
                $new_url = ABSPATH.ltrim(parse_url($img_link, PHP_URL_PATH), '/');
                $parts = explode('/',$new_url);
                $dir = '';
                for ($i = 0; $i < count($parts) - 1; $i++) {
                    $dir .= $parts[$i] . "/";
                }


                // Create folder wrap image if not exits
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                // save Image localhost

                $content = file_get_contents($img_link);

                $fp = fopen($new_url, "w");
                fwrite($fp, $content);
                fclose($fp);
            };

            $post['content'] = $this->removeDomain($post['content']);

        }


        $val = array(
            'post_title'    => mysql_real_escape_string($post['title']),
            'post_content'  => $post['content'],
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_category' => array( $block->category_id )
        );

        $posts = wp_insert_post($val);

    }

    /*
     * Get block by ID
     * */
    public function getBlockByID($block_id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'blocks';

        $query = "SELECT * FROM $table_name WHERE $table_name.id=$block_id";
        $block = $wpdb->get_row($query); /*mulitple row results can be pulled from the database with get_results function and outputs an object which is stored in $result */

        return $block;
    }

    /*
     *  Trim server URL
     * */

    public function removeDomain($string) {

        $string = preg_replace("/http:\/\/.*?\//", "/", $string);
        $string = preg_replace('#\s(srcset)="[^"]+"#', '', $string);



        return $string;

    }

    /*
     * Check if post exits
     *
     * */
    public function wp_exist_page_by_title($title_str) {
        global $wpdb;
        $post_table = $wpdb->prefix.'posts';

        $query = "SELECT ID FROM $post_table WHERE post_title = '" . $title_str . "' && post_status = 'publish'";
        $result =  $wpdb->get_row($query);

        return $result;
    }

}