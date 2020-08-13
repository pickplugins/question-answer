<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

class class_qa_post_meta_question{
	
	public function __construct(){

		add_action('add_meta_boxes', array($this, '_post_meta_question'));
		add_action('save_post', array($this, '_post_meta_question_save'));



		}


	public function _post_meta_question($post_type){

            add_meta_box('metabox-question-data',__('Question options', 'question-answer'), array($this, 'post_meta_question_data'), 'question', 'normal', 'high');

		}






	public function post_meta_question_data($post) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field('question_nonce_check', 'question_nonce_check_value');
 
        // Use get_post_meta to retrieve an existing value from the database.

        $post_id = $post->ID;



        $settings_tabs_field = new settings_tabs_field();

        $qa_settings_tabs = array();
        $question_answer_options = get_post_meta($post_id,'question_answer_options', true);
        $current_tab = isset($question_answer_options['current_tab']) ? $question_answer_options['current_tab'] : 'general';


        $qa_settings_tabs[] = array(
            'id' => 'general',
            'title' => sprintf(__('%s Admin action','question-answer'),'<i class="fas fa-code"></i>'),
            'priority' => 1,
            'active' => ($current_tab == 'general') ? true : false,
        );


//        $qa_settings_tabs[] = array(
//            'id' => 'help_support',
//            'title' => sprintf(__('%s Help & support','question-answer'),'<i class="fas fa-hands-helping"></i>'),
//            'priority' => 95,
//            'active' => ($current_tab == 'help_support') ? true : false,
//        );
//
//        $qa_settings_tabs[] = array(
//            'id' => 'buy_pro',
//            'title' => sprintf(__('%s Buy Pro','question-answer'),'<i class="fas fa-store"></i>'),
//            'priority' => 99,
//            'active' => ($current_tab == 'buy_pro') ? true : false,
//        );


        $qa_settings_tabs = apply_filters('qa_question_metabox_navs', $qa_settings_tabs);

        $tabs_sorted = array();

        if(!empty($qa_settings_tabs))
        foreach ($qa_settings_tabs as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
        array_multisort($tabs_sorted, SORT_ASC, $qa_settings_tabs);

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script('jquery-ui-accordion');

        wp_enqueue_style( 'jquery-ui');
        wp_enqueue_style( 'font-awesome-5' );
        wp_enqueue_style( 'settings-tabs' );
        wp_enqueue_script( 'settings-tabs' );
        wp_enqueue_style('font-awesome-5');


		?>


        <div class="settings-tabs vertical">
            <input class="current_tab" type="hidden" name="question_answer_options[current_tab]" value="<?php echo $current_tab; ?>">

            <ul class="tab-navs">
                <?php
                foreach ($qa_settings_tabs as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                    $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                    ?>
                    <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
                    <?php
                }
                ?>
            </ul>
            <?php
            foreach ($qa_settings_tabs as $tab){
                $id = $tab['id'];
                $title = $tab['title'];
                $active = $tab['active'];
                ?>

                <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                    <?php
                    do_action('qa_question_metabox_content_'.$id, $post_id);
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="clear clearfix"></div>

        <?php

   		}




	public function _post_meta_question_save($post_id){

        /*
         * We need to verify this came from the our screen and with
         * proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST['question_nonce_check_value']))
            return $post_id;

        $nonce = $_POST['question_nonce_check_value'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'question_nonce_check'))
            return $post_id;

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id))
                return $post_id;

        } else {

            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        do_action('qa_post_meta_save_question', $post_id);


	}
	

}


new class_qa_post_meta_question();