<?php

class createBlockView {


    public static function render(){
        ?>
            <h2>Create New Block</h2>
        <?php
        echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
        echo '<p>';

        echo 'Name<br/>';
        echo '<input type="text" name="name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["name"] ) ? esc_attr( $_POST["name"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';

        echo 'Domain <br/>';
        echo '<input type="text" name="domain" value="' . ( isset( $_POST["domain"] ) ? esc_attr( $_POST["domain"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';

        echo 'URL Category <br/>';
        echo '<input type="text" name="url-category" value="' . ( isset( $_POST["url-category"] ) ? esc_attr( $_POST["url-category"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';

        echo 'List Pattern<br/>';
        echo '<input type="text" name="list-pattern" value="' . ( isset( $_POST["list-pattern"] ) ? esc_attr( $_POST["list-pattern"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';

        echo 'A Pattern<br/>';
        echo '<input type="text" name="a-pattern" value="' . ( isset( $_POST["a-pattern"] ) ? esc_attr( $_POST["a-pattern"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';

        echo 'Title Pattern<br/>';
        echo '<input type="text" name="title-pattern" value="' . ( isset( $_POST["title-pattern"] ) ? esc_attr( $_POST["title-pattern"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';

        echo 'Content Pattern<br/>';
        echo '<input type="text" name="content-pattern" value="' . ( isset( $_POST["content-pattern"] ) ? esc_attr( $_POST["content-pattern"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';

        echo 'Except Pattern<br/>';
        echo '<input type="text" name="except-pattern" value="' . ( isset( $_POST["except-pattern"] ) ? esc_attr( $_POST["except-pattern"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';

        echo '</p>';
        echo '<p><input type="submit" name="cf-submitted" value="Add Block"></p>';
        echo '</form>';
    }

}