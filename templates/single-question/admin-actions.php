<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$post_statuses = get_post_statuses();
$current_post_status = get_post_status(get_the_id());

//var_dump($post_statuses);

$post_id = get_the_id();


//echo '<pre>'.var_export($post_id, true).'</pre>';

?>

<?php

if(current_user_can('manage_options')):

    ?>
    <div class="admin-actions">

        <?php

        if(!empty($_POST['hidden_update_post_status'])){

            $nonce = sanitize_text_field($_POST['_wpnonce']);
            if(wp_verify_nonce( $nonce, 'nonce_qa_update_post_status' ) && $_POST['hidden_update_post_status'] == 'Y') {

                $post_id = sanitize_text_field($_POST['post_id']);
                $post_status = sanitize_text_field($_POST['post_status']);


                $current_post = array(
                    'ID'           => $post_id,
                    'post_status'   => $post_status,

                );

                // Update the post into the database
                $has_update = wp_update_post( $current_post );
                $current_post_status = $post_status;
                if($has_update){

                    $post_url = get_permalink($post_id);
                    wp_safe_redirect($post_url);
                }
            }
        }


        ?>

        <form class="post-status" action="#" method="post">
            <input type="hidden" value="Y" name="hidden_update_post_status">
            <input type="hidden" value="<?php echo get_the_id(); ?>" name="post_id">
            <?php
            foreach($post_statuses as $status_index=>$status_name){
                ?>
                <label>
                    <input <?php if($current_post_status==$status_index) echo 'checked'; ?>  name="post_status" type="radio" value="<?php echo $status_index; ?>"> <?php echo $status_name; ?>

                </label>
                <?php


            }
             wp_nonce_field( 'nonce_qa_update_post_status' ); ?>
            <input type="submit" value="<?php echo __('Update', 'question-answer'); ?>">
        </form>

    </div>
    <?php

endif;
?>


