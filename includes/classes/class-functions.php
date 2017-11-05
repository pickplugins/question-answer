<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_qa_functions{
	
	public function __construct() {

		//add_action('add_meta_boxes', array($this, 'meta_boxes_question'));
		//add_action('save_post', array($this, 'meta_boxes_question_save'));

	}
	
	
	
	
	
	
	public function faq(){

		$faq['core'] = array(
							'title'=>__('Core', QA_TEXTDOMAIN),
							'items'=>array(
							
							
											array(
												'question'=>__('Single question page full width issue', QA_TEXTDOMAIN),
												'answer_url'=>'https://goo.gl/VUOFKM',
					
												),							
											
											array(
												'question'=>__('Question page 404 error', QA_TEXTDOMAIN),
												'answer_url'=>'https://goo.gl/mX1tsq',
					
												),												
											
											
												
											),

								
							);

		$faq = apply_filters('accordions_filters_faq', $faq);		

		return $faq;

		}		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function qa_social_share_items() {
		
		$items = array(
			
			'facebook' => array(
				'name' => __('Facebook', QA_TEXTDOMAIN),
				'icon' => '<i class="fa fa-facebook"></i>',
				'class' => 'qa-social-facebook',
				'share' => 'https://www.facebook.com/sharer/sharer.php?u=',
				'bg_color' => '#4061a5',
				
			),
			'twitter' => array(
				'name' => __('Twitter', QA_TEXTDOMAIN),
				'icon' => '<i class="fa fa-twitter"></i>',
				'class' => 'qa-social-twitter',
				'share' => 'https://twitter.com/share?url=',
				'bg_color' => '#55acee',
			),
			'gplus' => array(
				'name' => __('Google Plus', QA_TEXTDOMAIN),
				'icon' => '<i class="fa fa-google-plus"></i>',
				'class' => 'qa-social-gplus',
				'share' => 'https://plus.google.com/share?url=',
				'bg_color' => '#e02f2f',
			),
/*

			'pinterest' => array(
				'name' => __('Pinterest', QA_TEXTDOMAIN),
				'icon' => '<i class="fa fa-pinterest"></i>',
				'class' => 'qa-social-pinterest',
				'share' => 'https://www.pinterest.com/pin/create/button/?url=',
				'bg_color' => '#cd151e',
			),

*/
			
		);
		
		return apply_filters( 'qa_filter_social_share_items', $items );
	}
	
	
	public function qa_breadcrumb_menu_items_function() {
		
		$page_id_ask_question_id 	= get_option( 'qa_page_question_post', '' );
		$page_id_ask_question_title = get_the_title($page_id_ask_question_id);
		
		$qa_page_myaccount_id 		= get_option( 'qa_page_myaccount', '' );
		$qa_page_myaccount_title = get_the_title($qa_page_myaccount_id);

		$qa_page_question_archive_id 		= get_option( 'qa_page_question_archive', '' );

		$current_user = wp_get_current_user();
		if( $current_user->ID != 0 ) {
			$author_id = $current_user->user_login; 
			
			}
		else{$author_id='';}
		
		
		$menu_items = array(
			
			'add_question' => array(
				'title' => empty( $page_id_ask_question_title ) ? __( 'Ask Question', QA_TEXTDOMAIN ) : $page_id_ask_question_title,
				'link'	=> empty( $page_id_ask_question_id ) ? '' : get_the_permalink( $page_id_ask_question_id ),
			),
			
			'my_account' => array(
				'title' => empty( $qa_page_myaccount_title ) ? __( 'My Account', QA_TEXTDOMAIN ) : $qa_page_myaccount_title,
				'link'	=> empty( $qa_page_myaccount_id ) ? '' : get_the_permalink( $qa_page_myaccount_id ),
			),
			
			'my_question' => array(
				'title' => __( 'My Question', QA_TEXTDOMAIN ),
				'link'	=> empty( $qa_page_question_archive_id ) ? '#' : get_the_permalink( $qa_page_question_archive_id ).'?author='.$author_id,
			),			
			
			
		);
		
		return apply_filters( 'qa_filter_breadcrumb_menu_items', $menu_items );
	}
	
	public function qa_question_archive_filter_options() {
		
		$sorter = array(
			'' => __( 'Default Sorting', QA_TEXTDOMAIN ),
			'title' => __( 'Sort by Title', QA_TEXTDOMAIN ),
			'comment_count' => __( 'Sort by Comment Count', QA_TEXTDOMAIN ),
			'date_older' => __( 'Sort by Older Questions', QA_TEXTDOMAIN ),
		);
		
		return apply_filters( 'qa_question_archive_filter_options', $sorter );
	}
	
	
	
	public function qa_question_list_sections() {
		
		$sections = array(
			'question_icon' => array(
				'css_class'	=> 'question_icon',
				'title'		=> '<i class="fa fa-angle-down"></i>',
			),
			'question_title' => array(
				'css_class'	=> 'question_title',
				'title'		=> __('Question Title', QA_TEXTDOMAIN),
			),
			'question_status' => array(
				'css_class'	=> 'question_status',
				'title'		=> __('Status', QA_TEXTDOMAIN),
			),
			'question_date' => array(
				'css_class'	=> 'question_date',
				'title'		=> __('Date', QA_TEXTDOMAIN),
			),
			'question_answer' => array(
				'css_class'	=> 'question_answer',
				'title'		=> __('Answers', QA_TEXTDOMAIN),
			),
			
		);
		
		return array_merge($sections, apply_filters( 'qa_filters_question_list_sections',array() ) );
	}
	
	public function qa_question_status() {
		return array(
			''    => __('All', QA_TEXTDOMAIN),
			'processing'    => __('Processing', QA_TEXTDOMAIN),
			'hold'			=> __('Hold', QA_TEXTDOMAIN),
			'solved'		=> __('Solved', QA_TEXTDOMAIN),
		);
	}
		
	public function qa_get_pages() {
		$array_pages[''] = __('None',QA_TEXTDOMAIN);
		
		foreach( get_pages() as $page )
		if ( $page->post_title ) $array_pages[$page->ID] = $page->post_title;
		
		return $array_pages;
	}
	
	
	
	
	
	
	public function post_type_input_fields(){
		
		
		
		
	
			$input_fields = array(
								
								'recaptcha'=>array(
														'meta_key'=>'recaptcha',
														'css_class'=>'recaptcha',
														'required'=>'no', // (yes, no) is this field required.
														'display'=>'yes', // (yes, no)
														//'placeholder'=>'',
														'title'=>__('reCaptcha', QA_TEXTDOMAIN),
														'option_details'=>__('reCaptcha test.', QA_TEXTDOMAIN),					
														'input_type'=>'recaptcha', // text, radio, checkbox, select,
														'input_values'=>get_option('qa_reCAPTCHA_site_key'), // could be array
														//'field_args'=> array('size'=>'',),
														),																		
								'post_title'=>array(
														'meta_key'=>'post_title',
														'css_class'=>'post_title',
														'placeholder'=>'',
														'required'=>'yes',
														'title'=>__('Question Title', QA_TEXTDOMAIN),
														'option_details'=>__('Write question title', QA_TEXTDOMAIN),					
														'input_type'=>'text', // text, radio, checkbox, select,
														'input_values'=>'', // could be array
														//'field_args'=> array('size'=>'',),
														),
								'post_content'=>array(
														'meta_key'=>'post_content',
														'css_class'=>'post_content',
														'required'=>'yes',
														'placeholder'=>'',
														'title'=>__('Question Descriptions', QA_TEXTDOMAIN),
														'option_details'=>__('Write question descriptions here', QA_TEXTDOMAIN),					
														'input_type'=>'wp_editor', // text, radio, checkbox, select,
														'input_values'=>'', // could be array
														//'field_args'=> array('size'=>'',),
														),	
														
														
								'post_status'=>array(
														'meta_key'=>'post_status',
														'css_class'=>'post_status',
														'required'=>'yes',
														'placeholder'=>'',
														'title'=>__('Question Status', QA_TEXTDOMAIN),
														'option_details'=>__('Set the question status', QA_TEXTDOMAIN),					
														'input_type'=>'select',
														'input_values'=>'',
														'input_args'=> apply_filters( 'qa_filter_quesstion_status', array( 'default'=>__('Default', QA_TEXTDOMAIN), 'private'=>__('Private', QA_TEXTDOMAIN) ) ),
														),															
																
																											
								
								'post_taxonomies'=>array(	
								
														'question_cat'=>array(
															'meta_key'=>'question_cat',
															'css_class'=>'question_cat',
															'placeholder'=>'',
															'required'=>'yes',
															'title'=>__('Question Category', QA_TEXTDOMAIN),
															'option_details'=>__('Select question category.', QA_TEXTDOMAIN),					
															'input_type'=>'select', // text, radio, checkbox, select,
															'input_values'=>'', // could be array
															'input_args'=> qa_get_terms('question_cat'),
															//'field_args'=> array('size'=>'',),
															),

														'question_tags'=>array(
															'meta_key'=>'question_tags',
															'css_class'=>'question_tags',
															'placeholder'=>'Tags 1, Tags 2',
															'title'=>__('Question tags', QA_TEXTDOMAIN),
															'option_details'=>__('Choose question tags, comma separated.', QA_TEXTDOMAIN),					
															'input_type'=>'text', // text, radio, checkbox, select,
															'input_values'=>'', // could be array
															//'input_args'=> '',
															//'field_args'=> array('size'=>'',),
															),

							

														),							
														
								'meta_fields'=>array(



/*

													'polls'=>array(
														'meta_key'=>'polls',
														'css_class'=>'polls',
														'placeholder'=>'',
														'required'=>'no',														
														'title'=>__('Polls', QA_TEXTDOMAIN),
														'option_details'=>__('Add your polls', QA_TEXTDOMAIN),					
														'input_type'=>'text_multi', // text, radio, checkbox, select,
														'input_values'=>array(time()=>'',), // could be array
														'field_args'=> array('dummy'=>'Dummy',),
														),

*/






													)
								);
	
	
		
		$input_fields_all = apply_filters( 'qa_filter_question_input_fields', $input_fields );

		return $input_fields_all;
	}
	

} new class_qa_functions();