<?php	


/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



class class_qa_settings_page  {
	
	
    public function __construct(){
		
    }
	
	public function qa_settings_options($options = array()){
		
		$class_qa_functions = new class_qa_functions();
		
		$section_options = array(
			
			'qa_options_filter_badwords'=>array(
				'css_class'=>'qa_options_filter_badwords',					
				'title'=>__('Filter badword ?', QA_TEXTDOMAIN),
				'option_details'=>__('Do you want to filter badwords automatically? <br>Default: Yes.',QA_TEXTDOMAIN),					
				'input_type'=>'select',
				'input_values'=> 'yes',
				'input_args'=> array( 'no'=>__('No',QA_TEXTDOMAIN), 'yes'=>__('Yes',QA_TEXTDOMAIN),),
			),
			
			'qa_options_badwords'=>array(
				'css_class'=>'qa_options_badwords',					
				'title'=>__('Define badwords ?',QA_TEXTDOMAIN),
				'option_details'=>__('Add all the possible badwords here.(Comma separeted)',QA_TEXTDOMAIN),					
				'input_type'=>'textarea',
				'input_values'=> '',
			),
			
			'qa_options_badwords_replacer'=>array(
				'css_class'=>'qa_options_badwords_replacer',					
				'title'=>__('Badwords replacer ?',QA_TEXTDOMAIN),
				'option_details'=>__('What you want to show in the place of any badwords. You can use HTML formating also.',QA_TEXTDOMAIN),					
				'input_type'=>'textarea',
				'input_values'=> '',
			),
			
			'qa_options_quick_notes'=>array(
				'css_class'=>'qa_options_quick_notes',					
				'title'=>__('Quick note for answers ?',QA_TEXTDOMAIN),
				'option_details'=>__('Useful for quick reply.',QA_TEXTDOMAIN),					
				'input_type'=>'text-multi',
				'input_values'=> '',
				'input_args'=> array('dummy'=>__('Dummy', QA_TEXTDOMAIN)),
				
			),

            'qa_who_can_see_quick_notes'=>array(
                'css_class'=>'qa_who_can_see_quick_notes',
                'title'=>__('Who can see quick notes (by role) ?', QA_TEXTDOMAIN),
                'option_details'=>__('You can select roles to set who can see quick notes.', QA_TEXTDOMAIN),
                'input_type'=>'selectmultiple',
                'input_values'=> array('administrator'),
                'input_args'=> qa_all_roles(),
            ),






		);
		$options['<i class="fa fa-wrench"></i> '.__('Options', QA_TEXTDOMAIN)] = apply_filters( 'qa_settings_section_email', $section_options );
		
		$section_options = array(
			
			'qa_question_item_per_page'=>array(
				'css_class'=>'qa_question_item_per_page',					
				'title'=>__('Question - Item per Page', QA_TEXTDOMAIN),
				'option_details'=>__('Question per page in Question Archive page. <br>Default: 10.', QA_TEXTDOMAIN),						
				'input_type'=>'text', 
				'placeholder'=>'10',
			),
			'qa_question_excerpt_length'=>array(
				'css_class'=>'qa_question_excerpt_length',					
				'title'=>__('Question - Excerpt Length in Question Archive', QA_TEXTDOMAIN),
				'option_details'=>__('Set the maximum words count should show in the question archove. <br>Default: 20.', QA_TEXTDOMAIN),						
				'input_type'=>'text', 
				'placeholder'=>'50',
			),
			'qa_account_required_post_question'=>array(
				'css_class'=>'qa_account_required_post_question',					
				'title'=>__('Account Required ?', QA_TEXTDOMAIN),
				'option_details'=>__('Account required to post new Question from frontend. <br>Default: Yes', QA_TEXTDOMAIN),						
				'input_type'=>'select', 
				'input_values'=>'yes',
				'input_args'=> array( 'yes'=>__('Yes',QA_TEXTDOMAIN), 'no'=>__('No',QA_TEXTDOMAIN),),
			),
			'qa_submitted_question_status'=>array(
					'css_class'=>'qa_submitted_question_status',					
					'title'=>__('New Submitted Question Status ?', QA_TEXTDOMAIN),
					'option_details'=>__('Submitted question status.<br>Default: Pending.', QA_TEXTDOMAIN),						
					'input_type'=>'select', 
					'input_values'=> 'pending',
					'input_args'=> array( 'draft'=>__('Draft', QA_TEXTDOMAIN), 'pending'=>__('Pending', QA_TEXTDOMAIN), 'publish'=>__('Published', QA_TEXTDOMAIN), 'private'=>__('Private', QA_TEXTDOMAIN), 'trash'=>__('Trash', QA_TEXTDOMAIN)),
			),
			'qa_allow_question_comment'=>array(
					'css_class'=>'qa_allow_question_comment',					
					'title'=>__('Allow Comments in Question ?', QA_TEXTDOMAIN),
					'option_details'=>__('<br>Default: Yes.', QA_TEXTDOMAIN),						
					'input_type'=>'select', 
					'input_values'=> 'yes',
					'input_args'=> array( 'yes'=>__('Yes', QA_TEXTDOMAIN), 'no'=>__('No', QA_TEXTDOMAIN) ),
			),
			
			
			'qa_enable_poll'=>array(
					'css_class'=>'qa_enable_poll',					
					'title'=>__('Enable poll ?', QA_TEXTDOMAIN),
					'option_details'=>__('Enable polls on question', QA_TEXTDOMAIN),						
					'input_type'=>'select', 
					'input_values'=> 'no',
					'input_args'=> array(  'no'=>__('No', QA_TEXTDOMAIN), 'yes'=>__('Yes', QA_TEXTDOMAIN), ),
			),
						
			
			
			
		);	
		$options['<i class="fa fa-question-circle"></i> '.__('Question', QA_TEXTDOMAIN)] = apply_filters( 'qa_settings_archive_options', $section_options );

		$section_options = array(
			'qa_answer_item_per_page'=>array(
				'css_class'=>'qa_answer_item_per_page',					
				'title'=>__('Answer - Item per Page',QA_TEXTDOMAIN),
				'option_details'=>__('Answer per page in Answer list. <br>Default: 10.', QA_TEXTDOMAIN),						
				'input_type'=>'text', 
				'placeholder'=>'10',
			),
			'qa_account_required_post_answer'=>array(
				'css_class'=>'required_post_answer',					
				'title'=>__('Account Required ?', QA_TEXTDOMAIN),
				'option_details'=>__('Account required to post new Answer from frontend. <br>Default: Yes', QA_TEXTDOMAIN),						
				'input_type'=>'select', 
				'input_values'=>'yes',
				'input_args'=> array( 'yes'=>__('Yes', QA_TEXTDOMAIN), 'no'=>__('No', QA_TEXTDOMAIN),),
			),
			'qa_submitted_answer_status'=>array(
				'css_class'=>'qa_submitted_answer_status',					
				'title'=>__('New Submitted Answer Status ?', QA_TEXTDOMAIN),
				'option_details'=>__('Submitted answer status.<br>Default: Pending.', QA_TEXTDOMAIN),						
				'input_type'=>'select', 
				'input_values'=> 'pending',
				'input_args'=> array( 'draft'=>__('Draft', QA_TEXTDOMAIN), 'pending'=>__('Pending', QA_TEXTDOMAIN), 'publish'=>__('Published', QA_TEXTDOMAIN), 'private'=>__('Private', QA_TEXTDOMAIN), 'trash'=>__('Trash', QA_TEXTDOMAIN)),
			),
			'qa_show_answer_filter'=>array(
				'css_class'=>'qa_show_answer_filter',					
				'title'=>__('Show Answer filtering ?', QA_TEXTDOMAIN),
				'option_details'=>__('Do you want to show filtering in answer section under single question. <br>Default: Yes.', QA_TEXTDOMAIN),						
				'input_type'=>'select', 
				'input_values'=> 'yes',
				'input_args'=> array( 'yes'=>__('Yes', QA_TEXTDOMAIN), 'no'=>__('No', QA_TEXTDOMAIN),),
			),
			'qa_answer_filter_options'=>array(
				'css_class'=>'qa_answer_filter_options',					
				'title'=>__('Select Filter Options.', QA_TEXTDOMAIN),
				'option_details'=>__('Select answer filtering options. <br>Default: All.', QA_TEXTDOMAIN),						
				'input_type'=>'checkbox', 
				'input_values'=> array( 'answers_voted', 'answers_top_voted', 'answers_older'),
				'input_args'=> array( 
					'answers_voted'		=>__('Voted Answer', QA_TEXTDOMAIN), 
					'answers_top_voted'	=>__('Top Voted Answer', QA_TEXTDOMAIN),
					'answers_older'		=>__('Older Answer', QA_TEXTDOMAIN),
				),
			),
			
			
			
			'qa_who_can_answer'=>array(
				'css_class'=>'qa_who_can_answer',					
				'title'=>__('Who can post answer (by role) ?', QA_TEXTDOMAIN),
				'option_details'=>__('You can select roles to set who can only post answer for question.', QA_TEXTDOMAIN),						
				'input_type'=>'selectmultiple', 
				'input_values'=> array('administrator'),
				'input_args'=> qa_all_roles(),
			),			
			
			'qa_who_can_comment_answer'=>array(
				'css_class'=>'qa_who_can_comment_answer',					
				'title'=>__('Who can post comment on answer (by role) ?', QA_TEXTDOMAIN),
				'option_details'=>__('You can select roles to set who can only post comment on answer.', QA_TEXTDOMAIN),						
				'input_type'=>'selectmultiple', 
				'input_values'=> array('administrator'),
				'input_args'=> qa_all_roles(),
			),


            'qa_answer_editor_type'=>array(
                'css_class'=>'qa_answer_editor_type',
                'title'=>__('Editor type for answer posting.', QA_TEXTDOMAIN),
                'option_details'=>__('Choose editor type on answer posting.', QA_TEXTDOMAIN),
                'input_type'=>'select',
                'input_values'=> array('wp_editor'),
                'input_args'=> array('textarea'=>'Textarea', 'wp_editor'=>'WP Editor'),
            ),


            'qa_answer_editor_media_buttons'=>array(
                'css_class'=>'qa_answer_editor_media_buttons',
                'title'=>__('Enable media upload button on editor.', QA_TEXTDOMAIN),
                'option_details'=>'',
                'input_type'=>'select',
                'input_values'=> 'no',
                'input_args'=> array('yes'=>'Yes', 'no'=>'No'),
            ),









		);
		$options['<i class="fa fa-comments"></i> '.__('Answer', QA_TEXTDOMAIN)] = apply_filters( 'qa_settings_section_question_post', $section_options );

		$section_options = array(
			
			'qa_page_question_post'=>array(
				'css_class'=>'qa_page_question_post',					
				'title'=>__('Page - Question Submission', QA_TEXTDOMAIN),
				'option_details'=>__('Select the page where you want to do question submission. <br>Default: N/A.', QA_TEXTDOMAIN),						
				'input_type'=>'select', 
				'input_args'=> $class_qa_functions->qa_get_pages(),
			),
			'qa_page_question_archive'=>array(
				'css_class'=>'qa_page_question_archive',					
				'title'=>__('Page - Question Archive', QA_TEXTDOMAIN),
				'option_details'=>__('Select the page where you want to display all questions. <br>Default: N/A.', QA_TEXTDOMAIN),						
				'input_type'=>'select', 
				'input_args'=> $class_qa_functions->qa_get_pages(),
			),
			
			'qa_page_myaccount'=>array(
				'css_class'=>'qa_page_myaccount',					
				'title'=>__('Page - Account', QA_TEXTDOMAIN),
				'option_details'=>__('Select the page where you want to display Account. <br>Default: N/A.', QA_TEXTDOMAIN),						
				'input_type'=>'select', 
				'input_args'=> $class_qa_functions->qa_get_pages(),
			),			
			
			
			
			
			
			
			
		);
		
		
		$options['<i class="fa fa-folder"></i> '.__('Pages', QA_TEXTDOMAIN)] = apply_filters( 'qa_settings_section_question_post', $section_options );

		$section_options = array(
			
			'qa_myaccount_question_per_page'=>array(
				'css_class'=>'qa_myaccount_question_per_page',					
				'title'=>__('Question Per Page', QA_TEXTDOMAIN),
				'option_details'=> __('Set the value for question per page in my account page. <br>Default: 10.', QA_TEXTDOMAIN),					
				'input_type'=>'text',
				'input_values'=> '',
				'placeholder' => __('10',QA_TEXTDOMAIN),					
			),			
			
			'qa_myaccount_show_profile_management'=>array(
				'css_class'=>'qa_myaccount_show_profile_management',					
				'title'=>__('Show profile management?', QA_TEXTDOMAIN),
				'option_details'=> __('Show profile management in My Account page. <br>Default: Yes.', QA_TEXTDOMAIN),					
				'input_type'=>'select',
				'input_values'=> '',
				'input_args'=> array( 'yes'=>__('Yes', QA_TEXTDOMAIN), 'no'=>__('No', QA_TEXTDOMAIN),),
			),			
			
			'qa_myaccount_show_question_list'=>array(
				'css_class'=>'qa_myaccount_show_question_list',					
				'title'=>__('Show Question List?', QA_TEXTDOMAIN),
				'option_details'=> __('Show questions by you list in My Account page. <br>Default: Yes.', QA_TEXTDOMAIN),					
				'input_type'=>'select',
				'input_values'=> '',
				'input_args'=> array( 'yes'=>__('Yes', QA_TEXTDOMAIN), 'no'=>__('No', QA_TEXTDOMAIN),),
			),			
			
			'qa_myaccount_show_login_form'=>array(
				'css_class'=>'qa_myaccount_show_login_form',					
				'title'=>__('Show Login Form?', QA_TEXTDOMAIN),
				'option_details'=> __('Show login form in My Account page for logged out users. <br>Default: Yes.', QA_TEXTDOMAIN),					
				'input_type'=>'select',
				'input_values'=> '',
				'input_args'=> array( 'yes'=>__('Yes', QA_TEXTDOMAIN), 'no'=>__('No', QA_TEXTDOMAIN),),
			),			
			
			
			'qa_myaccount_login_redirect_page'=>array(
				'css_class'=>'login_redirect_page',					
				'title'=>__('After login redirect to page', QA_TEXTDOMAIN),
				'option_details'=>__('You can set custom page to redirect after login.', QA_TEXTDOMAIN),						
				'input_type'=>'select', 
				'input_args'=> $class_qa_functions->qa_get_pages(),
			),	
			
			
			'qa_myaccount_show_register_form'=>array(
				'css_class'=>'qa_myaccount_show_register_form',					
				'title'=>__('Show Register Form?', QA_TEXTDOMAIN),
				'option_details'=> __('Show register form in My Account page for logged out users. <br>Default: Yes.',QA_TEXTDOMAIN),					
				'input_type'=>'select',
				'input_values'=> '',
				'input_args'=> array( 'yes'=>__('Yes', QA_TEXTDOMAIN), 'no'=>__('No', QA_TEXTDOMAIN),),
			),			
			
			
		);
		$options['<i class="fa fa-briefcase"></i> '.__('My Account', QA_TEXTDOMAIN)] = apply_filters( 'qa_settings_section_notification', $section_options );
		
		$section_options = array(
			
			'qa_color_archive_answer_count'=>array(
				'css_class'=> 'qa_color_archive_answer_count',					
				'title'=>__( 'Question Archive', QA_TEXTDOMAIN ),
				'option_details'=>__('Answer count text color', QA_TEXTDOMAIN),					
				'input_type'=>'text',
				'input_values'=>'',
			),
			
			'qa_color_archive_view_count'=>array(
				'css_class'=> 'qa_color_archive_view_count',					
				'title'=>__( 'Question view count color', QA_TEXTDOMAIN ),
				'option_details'=>__('View count text color', QA_TEXTDOMAIN),					
				'input_type'=>'text',
				'input_values'=>'',
			),			
			
			
			'qa_color_single_user_role'=>array(
				'css_class'=> 'qa_color_single_user_role',					
				'title'=>__( 'User role text color', QA_TEXTDOMAIN ),
				'option_details'=>__('User role text color in single question page.', QA_TEXTDOMAIN),					
				'input_type'=>'text',
				'input_values'=>'',
			),
			'qa_color_single_user_role_background'=>array(
				'css_class'=> 'qa_color_single_user_role_background',					
				'title'=>__( 'User role background color', QA_TEXTDOMAIN ),
				'option_details'=>__('User role background color in single question page.', QA_TEXTDOMAIN),					
				'input_type'=>'text',
				'input_values'=>'',
			),
			'qa_color_add_comment_background'=>array(
				'css_class'=> 'qa_color_add_comment_background',					
				'title'=>__( 'Comment button background color', QA_TEXTDOMAIN ),
				'option_details'=>__('Comment button background color in single question page.', QA_TEXTDOMAIN),					
				'input_type'=>'text',
				'input_values'=>'',
			),
			'qa_color_best_answer_background'=>array(
				'css_class'=> 'qa_color_best_answer_background',					
				'title'=>__( 'Best answer background color', QA_TEXTDOMAIN ),
				'option_details'=>__('Best answer background color in single question page.', QA_TEXTDOMAIN),					
				'input_type'=>'text',
				'input_values'=>'',
			),

            'qa_ask_button_bg_color'=>array(
                'css_class'=> 'qa_ask_button_bg_color',
                'title'=>__( 'Ask button background color', QA_TEXTDOMAIN ),
                'option_details'=>__('Select background color for ask button on top.', QA_TEXTDOMAIN),
                'input_type'=>'text',
                'input_values'=>'',
            ),

            'qa_ask_button_text_color'=>array(
                'css_class'=> 'qa_ask_button_text_color',
                'title'=>__( 'Ask button text color', QA_TEXTDOMAIN ),
                'option_details'=>__('Select text color for ask button on top.', QA_TEXTDOMAIN),
                'input_type'=>'text',
                'input_values'=>'',
            ),


            'qa_vote_button_bg_color'=>array(
                'css_class'=> 'qa_vote_button_bg_color',
                'title'=>__( 'Vote button background color', QA_TEXTDOMAIN ),
                'option_details'=>__('Select Vote button background color.', QA_TEXTDOMAIN),
                'input_type'=>'text',
                'input_values'=>'',
            ),

            'qa_flag_button_bg_color'=>array(
                'css_class'=> 'qa_flag_button_bg_color',
                'title'=>__( 'Flag button background color', QA_TEXTDOMAIN ),
                'option_details'=>__('Select Flag button background color.', QA_TEXTDOMAIN),
                'input_type'=>'text',
                'input_values'=>'',
            ),





		);
		$options['<i class="fa fa-css3"></i> '.__('Colors', QA_TEXTDOMAIN)] = apply_filters( 'qa_settings_section_colors', $section_options );
		
		
		$section_options = array(
			
			'qa_reCAPTCHA_enable_question'=>array(
				'css_class'=>'qa_reCAPTCHA_enable_question',					
				'title'=>__('reCAPTCHA enable in Question?', QA_TEXTDOMAIN),
				'option_details'=>__('Enable reCAPTCHA to protect spam while posting new Question. <br>Default: No.', QA_TEXTDOMAIN),					
				'input_type'=>'select',
				'input_values'=> 'no',
				'input_args'=> array( 'no'=>__('No', QA_TEXTDOMAIN), 'yes'=>__('Yes', QA_TEXTDOMAIN),),
			),			
			'qa_reCAPTCHA_site_key'=>array(
				'css_class'=>'reCAPTCHA_site_key',					
				'title'=>__('reCAPTCHA site key', QA_TEXTDOMAIN),
				'option_details'=>__('reCAPTCHA site key, please go <a href="https://www.google.com/recaptcha">google.com/reCAPTCHA</a> and register your site to get site key.',QA_TEXTDOMAIN),						
				'input_type'=>'text', 
				'input_values'=> '',
			),		
			'qa_reCAPTCHA_secret_key'=>array(
				'css_class'=>'reCAPTCHA_secret_key',					
				'title'=>__('reCAPTCHA secret key', QA_TEXTDOMAIN),
				'option_details'=>__('reCAPTCHA site key, please go <a href="https://www.google.com/recaptcha">google.com/reCAPTCHA</a> and register your site to get secret key.', QA_TEXTDOMAIN),						
				'input_type'=>'text', 
				'input_values'=> '',
			),

		);
		$options['<i class="fa fa-eye"></i> '.__('Recapcha', QA_TEXTDOMAIN)] = apply_filters( 'qa_settings_section_email', $section_options );
		
		$options = apply_filters( 'qa_filter_settings_options', $options );
		
		return $options;
	}
	
	
	public function qa_settings_options_form(){
		
			global $post;
			
			$qa_settings_options = $this->qa_settings_options();
			$html = '';

			$html.= '<div class="para-settings qa-settings">';			

			$html_nav = '';
			$html_box = '';
					
			$i=1;
			foreach($qa_settings_options as $key=>$options){
			
			if( $i == 1 ) $html_nav.= '<li nav="'.$i.'" class="nav'.$i.' active">'.$key.'</li>';				
			else $html_nav.= '<li nav="'.$i.'" class="nav'.$i.'">'.$key.'</li>';
				
			if( $i == 1 ) $html_box.= '<li style="display: block;" class="box'.$i.' tab-box active">';				
			else $html_box.= '<li style="display: none;" class="box'.$i.' tab-box">';

			$single_html_box = '';
			
			foreach( $options as $option_key => $option_info ){
				
				$option_value =  get_option( "$option_key", '' );				
				if( empty( $option_value ) )
				$option_value = isset( $option_info['input_values'] ) ? $option_info['input_values'] : '';
				
				$placeholder = isset( $option_info['placeholder'] ) ? $option_info['placeholder'] : ''; 
				
				$single_html_box.= '<div class="option-box '.$option_info['css_class'].'">';
				$single_html_box.= '<p class="option-title">'.$option_info['title'].'</p>';
				$single_html_box.= '<p class="option-info">'.$option_info['option_details'].'</p>';
				
				if($option_info['input_type'] == 'text')
				$single_html_box.= '<input type="text" id="'.$option_key.'" placeholder="'.$placeholder.'" name="'.$option_key.'" value="'.$option_value.'" /> ';					
	
				elseif( $option_info['input_type'] == 'text-multi' ) {
					
/*

					$input_args = $option_info['input_args'];
					foreach( $input_args as $input_args_key => $input_args_values ) {
						if(empty($option_value[$input_args_key]))
						$option_value[$input_args_key] = $input_args[$input_args_key];
							
						$single_html_box.= '<label>'.ucfirst($input_args_key).'<br/><input class="job-bm-color" type="text" placeholder="'.$placeholder.'" name="'.$option_key.'['.$input_args_key.']" value="'.$option_value[$input_args_key].'" /></label><br/>';	
					}	

*/	
					
					$input_values = $option_value;
					$option_id = $option_key;
					
					$single_html_box.= '<div class="repatble">';
					$single_html_box.= '<div class="repatble-items">';
					
					if(!empty($input_values)){
						if(is_array($input_values)){
							
							foreach($input_values as $key=>$value){
								
								$single_html_box.= '<div class="single">';
								$single_html_box.= '<input type="text" name="'.$option_id.'['.$key.']" value="'.$input_values[$key].'" />';
								$single_html_box.= '<input class="remove-field button" type="button" value="'.__('Remove').'" />';	
								
								$single_html_box.= '</div>';
								}
	
							
							}
						else{
							$single_html_box.= '<input type="text" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
							$single_html_box.= '<input class="remove-field button" type="button" value="'.__('Remove').'" />';
							}
						}
					else{
						$single_html_box.= '<input type="text" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
						$single_html_box.= '<input class="remove-field button" type="button" value="'.__('Remove').'" />';
						}
					$single_html_box.= '</div>';
					//$html.= '<input type="text" placeholder="" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
					$single_html_box.= '<input  class="add-field button" option-id="'.$option_id.'" type="button" value="'.__('Add more').'" /> ';
					$single_html_box.= '</div>';
					
					//$html.= '<br /><br />';						
				
				}
					
				elseif($option_info['input_type'] == 'textarea')
				$single_html_box.= '<textarea placeholder="'.$placeholder.'" name="'.$option_key.'" >'.$option_value.'</textarea> ';
					
				elseif( $option_info['input_type'] == 'radio' ) {
					
					$input_args = $option_info['input_args'];
					foreach( $input_args as $input_args_key => $input_args_values ) {
						
						$checked = ( $input_args_key == $option_value ) ? $checked = 'checked' : '';
							
						$html_box.= '<label><input class="'.$option_key.'" type="radio" '.$checked.' value="'.$input_args_key.'" name="'.$option_key.'"   >'.$input_args_values.'</label><br/>';
					}
				}
					
				elseif( $option_info['input_type'] == 'select' ) {
					
					$input_args = $option_info['input_args'];
					$single_html_box 	.= '<select name="'.$option_key.'" >';
					
					foreach( $input_args as $input_args_key => $input_args_values ) {
						$selected = ( $input_args_key == $option_value ) ? 'selected' : '';
						$single_html_box.= '<option '.$selected.' value="'.$input_args_key.'">'.$input_args_values.'</option>';
					}
					
					$single_html_box.= '</select>';
				}					
				
				elseif( $option_info['input_type'] == 'selectmultiple' ) {
					
					$input_args = $option_info['input_args'];
					$single_html_box.= '<select multiple="multiple" size="6" name="'.$option_key.'[]" >';

					foreach($input_args as $input_args_key=>$input_args_values){
						
						$selected = in_array( $input_args_key, $option_value ) ? 'selected' : '';
						$single_html_box.= '<option '.$selected.' value="'.$input_args_key.'">'.$input_args_values.'</option>';
					}
					$single_html_box.= '</select>';
				}				

				elseif( $option_info['input_type'] == 'checkbox' ) {
					foreach($option_info['input_args'] as $input_args_key=>$input_args_values){

						$checked = in_array( $input_args_key, $option_value ) ? 'checked' : '';
						$single_html_box.= '<label><input '.$checked.' value="'.$input_args_key.'" name="'.$option_key.'['.$input_args_key.']"  type="checkbox" >'.$input_args_values.'</label><br/>';
					}
				}
					
				elseif( $option_info['input_type'] == 'file' ){
					
					$single_html_box.= '<input type="text" id="file_'.$option_key.'" name="'.$option_key.'" value="'.$option_value.'" /><br />';
					$single_html_box.= '<input id="upload_button_'.$option_key.'" class="upload_button_'.$option_key.' button" type="button" value="Upload File" />';					
					$single_html_box.= '<br /><br /><div style="overflow:hidden;max-height:150px;max-width:150px;" class="logo-preview"><img style=" width:100%;" src="'.$option_value.'" /></div>';
					$single_html_box.= '
					<script>jQuery(document).ready(function($){
					var custom_uploader; 
					jQuery("#upload_button_'.$option_key.'").click(function(e) {
						e.preventDefault();
						if (custom_uploader) {
							custom_uploader.open();
							return;
						}
						custom_uploader = wp.media.frames.file_frame = wp.media({
							title: "Choose File",
							button: { text: "'.__('Choose File', QA_TEXTDOMAIN).'" },
							multiple: false
						});
						custom_uploader.on("select", function() {
							attachment = custom_uploader.state().get("selection").first().toJSON();
							jQuery("#file_'.$option_key.'").val(attachment.url);
							jQuery(".logo-preview img").attr("src",attachment.url);											
						});
						custom_uploader.open();
					});
					})
					</script>';					
				}
				$single_html_box.= '</div>';
			}
			
			
			// $html_box .= apply_filters( 'qa_filters_setting_box_'.$key , $single_html_box );
			$html_box .= $single_html_box;
			
			$html_box.= '</li>';
			
			$i++;
			}
			
			
			$html.= '<ul class="tab-nav">';
			$html.= $html_nav;			
			$html.= '</ul>';
			$html.= '<ul class="box">';
			$html.= $html_box;
			$html.= '</ul>';		
			
			
			
			$html.= '</div>';			
			return $html;
		}

}

new class_qa_settings_page();







if(empty($_POST['qa_hidden']))
	{


		$class_qa_settings_page = new class_qa_settings_page();
		
			$qa_settings_options = $class_qa_settings_page->qa_settings_options();
			
			foreach($qa_settings_options as $options_tab=>$options){
				
				foreach($options as $option_key=>$option_data){
					
					${$option_key} = get_option( $option_key );
		
					//var_dump(${$option_key});
					}
				}






	}
else
	{	
		if($_POST['qa_hidden'] == 'Y') {
			//Form data sent

	
			$class_qa_settings_page = new class_qa_settings_page();
			
			$qa_settings_options = $class_qa_settings_page->qa_settings_options();
			
			foreach($qa_settings_options as $options_tab=>$options){
				
				foreach($options as $option_key=>$option_data){

					if(!empty($_POST[$option_key])){
						${$option_key} = stripslashes_deep($_POST[$option_key]);
						update_option($option_key, ${$option_key});
						}
					else{
						${$option_key} = array();
						update_option($option_key, ${$option_key});
						
						}


					// var_dump($option_key);
					
					}
				}
	
	
	
	

			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.', QA_TEXTDOMAIN ); ?></strong></p></div>
	
			<?php
			} 
	}
	
	

	
	
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".sprintf(__('%s Settings', QA_TEXTDOMAIN), QA_PLUGIN_NAME)."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="qa_hidden" value="Y">
        <?php settings_fields( 'qa_plugin_options' );
				do_settings_sections( 'qa_plugin_options' );
			
			
	$class_qa_settings_page = new class_qa_settings_page();
    echo $class_qa_settings_page->qa_settings_options_form(); 
	
			
			
		?>

    






<p class="submit">
                    <input class="button button-primary" type="submit" name="submit" value="<?php _e('Save Changes',QA_TEXTDOMAIN ); ?>" />
                </p>
		</form>


</div>
