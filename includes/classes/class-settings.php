<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if (!defined('ABSPATH')) exit;  // if direct access 


class class_qa_settings
{

	public function __construct()
	{

		add_action('admin_menu', array($this, 'admin_menu'), 12);
	}

	public function admin_menu()
	{

		$qa_welcome = get_option('qa_welcome');
		$question_answer_info = get_option('question_answer_info');
		$settingsUpdate = isset($question_answer_info['settingsUpdate']) ? $question_answer_info['settingsUpdate'] : 'no';


		add_dashboard_page('', '', 'manage_options', 'qa-setup', '');
		add_submenu_page('edit.php?post_type=question', __('Settings', 'question-answer'), __('Settings', 'question-answer'), 'manage_options', 'settings', array($this, 'settings'));

		if ($qa_welcome != 'done')
			add_submenu_page('edit.php?post_type=question', __('Welcome', 'question-answer'), __('Welcome', 'question-answer'), 'manage_options', 'qa_welcome', array($this, 'qa_welcome'));

		// if ($settingsUpdate != 'done')
		// 	add_submenu_page('edit.php?post_type=question', __('Settings Update', 'question-answer'), __('Settings Update', 'question-answer'), 'manage_options', 'QAsettingsUpdate', array($this, '_settings_update'));



		do_action('qa_action_admin_menus');
	}

	public function settings()
	{
		include(QA_PLUGIN_DIR . 'includes/menus/settings-new.php');
	}


	public function qa_welcome()
	{
		include(QA_PLUGIN_DIR . 'includes/menus/welcome.php');
	}

	public function _settings_update()
	{
		include(QA_PLUGIN_DIR . 'includes/menus/settings-update.php');
	}
}
new class_qa_settings();

//
//$qa_settings_general = array(
//
//    'page_nav' 	=> __( 'General', 'user-profile' ),
//    'priority' => 10,
//    'page_settings' => array(
//
//        'section_question' => array(
//            'title' 	=> 	__('Question Settings','user-profile'),
//            'description' 	=> __('Settings for question','user-profile'),
//            'options' 	=> array(
//                array(
//                    'id'		=> 'qa_question_item_per_page',
//                    'title'		=> __('Question - Item per Page','user-profile'),
//                    'details'	=> __('Question per page in Question Archive page. <br>Default: 10.','user-profile'),
//                    'type'		=> 'text',
//                    'placeholder'		=> 10,
//                ),
//                array(
//                    'id'		=> 'qa_account_required_post_question',
//                    'title'		=> __('Account Required?','user-profile'),
//                    'details'	=> __('Account required to post new question from frontend. <br>Default: Yes','user-profile'),
//                    'type'		=> 'select',
//                    'args'		=> array(
//                        'yes'	=> __('Yes','text-domain'),
//                        'no'	=> __('No','text-domain'),
//                    ),
//                ),
//
//                array(
//                    'id'		=> 'qa_submitted_question_status',
//                    'title'		=> __('New Submitted Question Status?','user-profile'),
//                    'details'	=> __('Submitted question status.<br>Default: Pending.','user-profile'),
//                    'type'		=> 'select',
//                    'args'		=> array( 'draft'=>__('Draft', 'question-answer'), 'pending'=>__('Pending', 'question-answer'), 'publish'=>__('Published', 'question-answer'), 'private'=>__('Private', 'question-answer'), 'trash'=>__('Trash', 'question-answer')),
//                ),
//
//
//                array(
//                    'id'		=> 'qa_allow_question_comment',
//                    'title'		=> __('Allow Comments in Question?','user-profile'),
//                    'details'	=> __('User will able to post comments on question.','user-profile'),
//                    'type'		=> 'select',
//                    'args'		=> array( 'yes'=>__('Yes', 'question-answer'), 'no'=>__('No', 'question-answer') ),
//                ),
//
//                array(
//                    'id'		=> 'qa_enable_poll',
//                    'title'		=> __('Enable poll?','user-profile'),
//                    'details'	=> __('Enable polls on question','user-profile'),
//                    'type'		=> 'select',
//                    'args'		=> array( 'no'=>__('No', 'question-answer'), 'yes'=>__('Yes', 'question-answer') ),
//                ),
//
//
//
//
//            )
//        ),
//
//        'section_answer' => array(
//            'title' 	=> 	__('Answer Settings','user-profile'),
//            'description' 	=> __('Settings for answer','user-profile'),
//            'options' 	=> array(
//                array(
//                    'id'		=> 'qa_options_quick_notes',
//                    'title'		=> __('Quick note for answers?','user-profile'),
//                    'details'	=> __('You can add some quick notes for quick reply.','user-profile'),
//                    'type'		=> 'text_multi',
//                    'placeholder'		=> __('Quick note','text-domain'),
//                ),
//                array(
//                    'id'		=> 'qa_who_can_see_quick_notes',
//                    'title'		=> __('Who can see quick notes (by role)?','user-profile'),
//                    'details'	=> __('You can select roles to set who can see quick notes.','user-profile'),
//                    'type'		=> 'select_multi',
//                    'args'		=> array(),
//                ),
//
//                array(
//                    'id'		=> 'qa_submitted_question_status',
//                    'title'		=> __('New Submitted Question Status?','user-profile'),
//                    'details'	=> __('Submitted question status.<br>Default: Pending.','user-profile'),
//                    'type'		=> 'select',
//                    'args'		=> array( 'draft'=>__('Draft', 'question-answer'), 'pending'=>__('Pending', 'question-answer'), 'publish'=>__('Published', 'question-answer'), 'private'=>__('Private', 'question-answer'), 'trash'=>__('Trash', 'question-answer')),
//                ),
//
//
//                array(
//                    'id'		=> 'qa_allow_question_comment',
//                    'title'		=> __('Allow Comments in Question?','user-profile'),
//                    'details'	=> __('User will able to post comments on question.','user-profile'),
//                    'type'		=> 'select',
//                    'args'		=> array( 'yes'=>__('Yes', 'question-answer'), 'no'=>__('No', 'question-answer') ),
//                ),
//
//                array(
//                    'id'		=> 'qa_enable_poll',
//                    'title'		=> __('Enable poll?','user-profile'),
//                    'details'	=> __('Enable polls on question','user-profile'),
//                    'type'		=> 'select',
//                    'args'		=> array( 'no'=>__('No', 'question-answer'), 'yes'=>__('Yes', 'question-answer') ),
//                ),
//
//
//
//
//            )
//        ),
//
//
//
//    ),
//);
//
//
//
//
//
//
//
//
//
//
//
//$args = array(
//    'add_in_menu'       => true,
//    'menu_type'         => 'submenu',
//    'menu_title'        => __( 'Settings', 'user-profile' ),
//    'page_title'        => __( 'Question Answer - Settings', 'user-profile' ),
//    'menu_page_title'   => __( 'Question Answer - Settings', 'user-profile' ),
//    'capability'        => "manage_options",
//    'menu_slug'         => "qa-settings",
//    'parent_slug'       => "edit.php?post_type=question",
//    'menu_icon'         => "dashicons-businessman",
//    'pages' 	        => array(
//        'qa_settings_general'    => $qa_settings_general,
//
//
//    ),
//);
//
//$WPAdminSettings = new WPAdminSettings( $args );
//
//
//
