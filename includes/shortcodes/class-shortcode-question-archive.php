<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_qa_shortcode_question_archive{
	
    public function __construct(){
		add_shortcode( 'question_archive', array( $this, 'question_archive' ) );

   	}	
		
	public function question_archive($atts, $content = null ) {
			
		$atts = shortcode_atts( array(
				
			'keywords'=> '',
			'cat_slug'=> '',
			'order_by'=> '',
			'qa_post_per_page'=> 10,
					
		), $atts);
					
		$keywords 			= empty( $atts['keywords'] ) ? '' : $atts['keywords'];
		$date 				= empty( $atts['date'] ) ? '' : $atts['date'];
		$category 			= empty( $atts['category'] ) ? '' : $atts['category'];
		$order_by 			= empty( $atts['order_by'] ) ? '' : $atts['order_by'];
		$order	 			= empty( $atts['order'] ) ? '' : $atts['order'];
		$filter_by	 		= empty( $atts['filter_by'] ) ? '' : $atts['filter_by'];
		$qa_post_per_page 	= empty( $atts['qa_post_per_page'] ) ? '' : $atts['qa_post_per_page'];




        $question_answer_settings = get_option('question_answer_settings');

        $font_aw_version = isset($question_answer_settings['general']['font_aw_version']) ? $question_answer_settings['general']['font_aw_version'] : 'v_5';


        if($font_aw_version == 'v_5'){
            $separator_icon = '<i class="fas fa-angle-double-right"></i>';
            $home_icon = '<i class="fas fa-home"></i>';
            $trash_icon = '<i class="fas fa-trash"></i>';
            $pencil_icon = '<i class="far fa-edit"></i>';
            $globe_icon = '<i class="fas fa-globe-asia"></i>';
            $lock_icon = '<i class="fas fa-lock"></i>';
            $check_icon = '<i class="fas fa-check"></i>';
            $eye_icon = '<i class="fas fa-eye"></i>';
            $clone_icon = '<i class="far fa-clone"></i>';


            wp_enqueue_style('font-awesome-5');
        }elseif ($font_aw_version == 'v_4'){

            $separator_icon = '<i class="fa fa-angle-double-right"></i>';
            $home_icon = '<i class="fa fa-home"></i>';
            $trash_icon = '<i class="fa fa-trash"></i>';
            $pencil_icon = '<i class="fa fa-pencil-square-o"></i>';
            $globe_icon = '<i class="fa fa-globe"></i>';
            $lock_icon = '<i class="fa fa-lock"></i>';
            $check_icon = '<i class="fa fa-check"></i>';
            $eye_icon = '<i class="fa fa-eye"></i>';
            $clone_icon = '<i class="fa fa-clone" ></i>
';

            wp_enqueue_style('font-awesome-4');
        }

        $atts['icons'] = array(
            'separator_icon' => $separator_icon,
            'home_icon' => $home_icon,
            'trash_icon' => $trash_icon,
            'pencil_icon' => $pencil_icon,
            'globe_icon' => $globe_icon,
            'lock_icon' => $lock_icon,
            'check_icon' => $check_icon,
            'eye_icon' => $eye_icon,
            'clone_icon' => $clone_icon,

        );

        $atts = apply_filters('question_archive_atts', $atts);


        wp_enqueue_style('font-awesome-5');
        wp_enqueue_style('qa-notifications');
        wp_enqueue_style('qa_style');
        wp_enqueue_style('question-archive');
        wp_enqueue_style('qa-wrapper');
        wp_enqueue_style('qa-wrapper-top-nav');

        wp_enqueue_script('question-archive');

        ob_start();
        ?>
        <div class="questions-archive">
            <?php
            do_action('question_archive', $atts);
            ?>
        </div>
        <?php


		return ob_get_clean();
	}
	
} new class_qa_shortcode_question_archive();