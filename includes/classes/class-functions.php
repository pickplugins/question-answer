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
							'title'=>__('Core', 'question-answer'),
							'items'=>array(
							
							
											array(
												'question'=>__('Single question page full width issue', 'question-answer'),
												'answer_url'=>'https://www.pickplugins.com/documentation/question-answer/faq/single-question-page-full-width-issue/',
					
												),							
											
											array(
												'question'=>__('Question page 404 error', 'question-answer'),
												'answer_url'=>'https://www.pickplugins.com/documentation/question-answer/faq/question-page-404-error/',
					
												),												
											
											
												
											),

								
							);

		$faq = apply_filters('qa_filters_faq', $faq);

		return $faq;

		}		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function qa_social_share_items() {
		
		$items = array(
			
			'facebook' => array(
				'name' => __('Facebook', 'question-answer'),
				'icon' => '<i class="fab fa-facebook-square"></i>',
				'class' => 'qa-social-facebook',
				'share' => 'https://www.facebook.com/sharer/sharer.php?u=',
				'bg_color' => '#4061a5',
				
			),
			'twitter' => array(
				'name' => __('Twitter', 'question-answer'),
				'icon' => '<i class="fab fa-twitter-square"></i>',
				'class' => 'qa-social-twitter',
				'share' => 'https://twitter.com/share?url=',
				'bg_color' => '#55acee',
			),
			'gplus' => array(
				'name' => __('Google Plus', 'question-answer'),
				'icon' => '<i class="fab fa-google-plus-square"></i>',
				'class' => 'qa-social-gplus',
				'share' => 'https://plus.google.com/share?url=',
				'bg_color' => '#e02f2f',
			),

		);
		
		return apply_filters( 'qa_filter_social_share_items', $items );
	}
	
	

	
	public function order_by_args() {
		
		$sorter = array(
			'' => __( 'Select orderby', 'question-answer' ),
            'date' => __( 'Date', 'question-answer' ),
			'title' => __( 'Title', 'question-answer' ),
            'rand' => __( 'Random', 'question-answer' ),
			'comment_count' => __( 'Comment Count', 'question-answer' ),
            'answer_count' => __( 'Answer Count', 'question-answer' ),
            'view_count' => __( 'View Count', 'question-answer' ),
            'vote_count' => __( 'Vote Count', 'question-answer' ),

		);
		
		return apply_filters( 'order_by_args', $sorter );
	}
	
	
	
	public function qa_question_list_sections() {
		
		$sections = array(
			'question_icon' => array(
				'css_class'	=> 'question_icon',
				'title'		=> '<i class="fa fa-angle-down"></i>',
			),
			'question_title' => array(
				'css_class'	=> 'question_title',
				'title'		=> __('Question Title', 'question-answer'),
			),
			'question_status' => array(
				'css_class'	=> 'question_status',
				'title'		=> __('Status', 'question-answer'),
			),
			'question_date' => array(
				'css_class'	=> 'question_date',
				'title'		=> __('Date', 'question-answer'),
			),
			'question_answer' => array(
				'css_class'	=> 'question_answer',
				'title'		=> __('Answers', 'question-answer'),
			),
			
		);
		
		return array_merge($sections, apply_filters( 'qa_filters_question_list_sections',array() ) );
	}
	
	public function qa_question_status() {
		return array(
			''    => __('All', 'question-answer'),
			'processing'    => __('Processing', 'question-answer'),
			'hold'			=> __('Hold', 'question-answer'),
			'solved'		=> __('Solved', 'question-answer'),
		);
	}


    public function filter_by_args() {
        return array(
            ''			=> __('Select filter by', 'question-answer'),

            'featured'			=> __('Featured', 'question-answer'),
            'solved'		=> __('Solved', 'question-answer'),
            'unsolved'		=> __('unsolved', 'question-answer'),
        );
    }


	public function qa_get_pages() {
		$array_pages[''] = __('None','question-answer');
		
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
														'title'=>__('reCaptcha', 'question-answer'),
														'option_details'=>__('reCaptcha test.', 'question-answer'),					
														'input_type'=>'recaptcha', // text, radio, checkbox, select,
														'input_values'=>get_option('qa_reCAPTCHA_site_key'), // could be array
														//'field_args'=> array('size'=>'',),
														),																		
								'post_title'=>array(
														'meta_key'=>'post_title',
														'css_class'=>'post_title',
														'placeholder'=>'',
														'required'=>'yes',
														'title'=>__('Question Title', 'question-answer'),
														'option_details'=>__('Write question title', 'question-answer'),					
														'input_type'=>'text', // text, radio, checkbox, select,
														'input_values'=>'', // could be array
														//'field_args'=> array('size'=>'',),
														),
								'post_content'=>array(
														'meta_key'=>'post_content',
														'css_class'=>'post_content',
														'required'=>'yes',
														'placeholder'=>'',
														'title'=>__('Question Descriptions', 'question-answer'),
														'option_details'=>__('Write question descriptions here', 'question-answer'),					
														'input_type'=>'wp_editor', // text, radio, checkbox, select,
														'input_values'=>'', // could be array
														//'field_args'=> array('size'=>'',),
														),	
														
														
								'post_status'=>array(
														'meta_key'=>'post_status',
														'css_class'=>'post_status',
														'required'=>'yes',
														'placeholder'=>'',
														'title'=>__('Is private?', 'question-answer'),
														'option_details'=>__('If this is private question.', 'question-answer'),
														'input_type'=>'select',
														'input_values'=>'',
														'input_args'=> apply_filters( 'qa_filter_quesstion_status', array( 'default'=>__('Public', 'question-answer'), 'private'=>__('Private', 'question-answer') ) ),
														),															
																
																											
								
								'post_taxonomies'=>array(	
								
														'question_cat'=>array(
															'meta_key'=>'question_cat',
															'css_class'=>'question_cat',
															'placeholder'=>'',
															'required'=>'yes',
															'title'=>__('Question Category', 'question-answer'),
															'option_details'=>__('Select question category.', 'question-answer'),					
															'input_type'=>'select', // text, radio, checkbox, select,
															'input_values'=>'', // could be array
															'input_args'=> qa_get_terms('question_cat'),
															//'field_args'=> array('size'=>'',),
															),

														'question_tags'=>array(
															'meta_key'=>'question_tags',
															'css_class'=>'question_tags',
															'placeholder'=>'Tags 1, Tags 2',
															'title'=>__('Question tags', 'question-answer'),
															'option_details'=>__('Choose question tags, comma separated.', 'question-answer'),					
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
														'title'=>__('Polls', 'question-answer'),
														'option_details'=>__('Add your polls', 'question-answer'),					
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