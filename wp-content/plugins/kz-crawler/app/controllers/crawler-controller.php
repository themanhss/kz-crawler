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

        // Save link to commom DB
        $servername = "www.db4free.net";
        $username = "themanhss";
        $password = "themanh2311";
        $dbname  = 'kz_manager';

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

      /*  $sql = "INSERT INTO links (url, title, description, created_at, updated_at)VALUES ('".$post_url."', null, null, '2016-07-28 09:22:18', '2016-07-28 09:22:18')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }*/

        $sql = "SELECT * FROM links";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Url: " . $row["url"]. " " . $row["title"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();

        die();

        // Begin craw

        $block = $this->getBlockByID($block_id);


        $detail_news_pattern = $block->a_pattern;
        $title_pattern = $block->title_pattern;
        $description_pattern = $block->content_pattern;
        $description_pattern_delete = $block->except_pattern;


        $link =  $block->url_category;

        $html = file_get_html($link);

        $detail_item = $html->find($detail_news_pattern,0)->href;

        $post = array();



        if (!filter_var($detail_item, FILTER_VALIDATE_URL)) {
            $detail_item = $block->domain.$detail_item;
        }


        $detail_link = file_get_html($detail_item);

        // Get Title
        foreach($detail_link->find($title_pattern) as $element)
        {
            $post['title'] = trim($element->plaintext); // Chỉ lấy phần text
        }

//        var_dump($post['title']); die();
        // Check if post exits
        if($this->wp_exist_page_by_title($post['title'])){
//            var_dump('Post exits'); die();
//            return false;
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


            $featured_img = '';
            // Find all images
            foreach($element->find('img') as $img) {


                $img_link = $img->src;

                // Trim / first in link
                $img_link = ltrim($img_link, '/');


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

                if (strpos($img_link,'http://') === false){
                    $img_link = 'http://'.$img_link;
                }

                $content = file_get_contents($img_link);

                $fp = fopen($new_url, "w");
                fwrite($fp, $content);
                fclose($fp);

                if(!$featured_img) {
                    $featured_img = $new_url;
                }

            };

            $post['content'] = $this->removeDomain($post['content']);

        }


        $val = array(
            'post_title'    => $post['title'],
            'post_content'  => $post['content'],
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_category' => array( $block->category_id )
        );

        $post_id = wp_insert_post($val);
        $this->Generate_Featured_Image( $featured_img,   $post_id );

        $post_url =  get_permalink( $post_id );




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

    /*
     *  Insert featured image
     *
     * */
    public function Generate_Featured_Image( $image_url, $post_id  ){
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);
        $filename = basename($image_url);
        if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
        else                                    $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents($file, $image_data);

        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
        $res2= set_post_thumbnail( $post_id, $attach_id );
    }

}