<?php

class blocksModel
{
    static function create_blocks_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'blocks';


        $sql = "CREATE TABLE $table_name (
                id  int NOT NULL AUTO_INCREMENT ,
                name  text NULL ,
                domain  varchar(255) NULL ,
                url_category  varchar(255) NULL ,
                list_pattern  varchar(255) NULL ,
                a_pattern  varchar(255) NULL ,
                title_pattern  varchar(255) NULL ,
                content_pattern  varchar(255) NULL ,
                except_pattern  varchar(255) NULL ,
                created_date  datetime NULL ,
                PRIMARY KEY (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

}