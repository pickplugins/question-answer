<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 

	$class_qa_functions = new class_qa_functions();
	
	$qa_reCAPTCHA_enable_question		= get_option('qa_reCAPTCHA_enable_question');	
	$qa_question_login_page_id 			= get_option('qa_question_login_page_id');
	$login_page_url 					= get_permalink($qa_question_login_page_id);
    $qa_page_question_post_redirect 	= get_option('qa_page_question_post_redirect');
    $redirect_page_url 					= get_permalink($qa_page_question_post_redirect);
    $qa_account_required_post_question 	= get_option('qa_account_required_post_question', 'yes');
	$qa_submitted_post_status 			= get_option('qa_submitted_question_status', 'pending' );
	$qa_page_myaccount 			        = get_option('qa_page_myaccount', '' );
    $qa_page_myaccount_url              = !empty($qa_page_myaccount) ? get_permalink($qa_page_myaccount) : wp_login_url($_SERVER['REQUEST_URI']);


?>



<div class="submit-question">

    <?php
    if(!empty($_POST)){
        do_action('qa_question_submit_data', $_POST);
    }
    ?>

    <?php do_action('question_answer_submit_question_before'); ?>

    <form enctype="multipart/form-data" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <?php
		do_action('question_answer_submit_question');
		?>
    </form>
    <link rel="stylesheet" href="<?php echo QA_PLUGIN_URL.'assets/front/css/qa-wrapper-top-nav.css'; ?>">

    <?php do_action('question_answer_submit_question_after'); ?>
        
</div>