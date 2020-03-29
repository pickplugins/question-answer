<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 


add_action('question_answer_dashboard','question_answer_dashboard_notice', 5);

function question_answer_dashboard_notice($question_id){

    $question_answer_settings = get_option('question_answer_settings');
    $dashboard_notice = isset($question_answer_settings['dashboard_notice']) ? $question_answer_settings['dashboard_notice'] : '';

    if(!empty($dashboard_notice)):
        ?>
        <div class="qa-notice">
            <?php echo $dashboard_notice; ?>
        </div>
        <link rel="stylesheet" href="<?php echo QA_PLUGIN_URL.'assets/front/css/qa-wrapper-top-nav.css'; ?>">

    <?php
    endif;



}


add_action('question_answer_dashboard' ,'question_answer_dashboard');
function question_answer_dashboard($atts){

    if (is_user_logged_in() ):

        do_action('question_answer_dashboard_logged', $atts);

    else:

        do_action('question_answer_dashboard_not_logged', $atts);

    endif;

}
add_action('question_answer_dashboard_logged' ,'question_answer_dashboard_logged');
function question_answer_dashboard_logged($atts){

    $qa_page_myaccount_id = get_option('qa_page_myaccount');
    $qa_page_myaccount_url = get_permalink($qa_page_myaccount_id);


    $dashboard_tabs = array();



    $dashboard_tabs['account'] =array(
        'title'=>__('Account', 'question-answer'),

    );


    $dashboard_tabs['account_edit'] =array(
        'title'=>__('Account edit', 'question-answer'),

    );

    $dashboard_tabs['my_notifications'] =array(
        'title'=>__('Notifications', 'question-answer'),
    );

    $dashboard_tabs['my_questions'] =array(
        'title'=>__('Questions', 'question-answer'),
    );

    $dashboard_tabs['my_answers'] =array(
        'title'=>__('Answers', 'question-answer'),
    );






    ?>
    <ul class="navs">
        <?php

        foreach($dashboard_tabs as $tabs_key=>$tabs){

            $title = $tabs['title'];
            ?>
            <li>
                <a href="<?php echo $qa_page_myaccount_url; ?>?tabs=<?php echo $tabs_key; ?>">
                    <?php echo $title; ?>
                </a>

            </li>
            <?php
        }
        ?>
    </ul>
    <div class="navs-content">
        <?php

        if(!empty($_GET['tabs'])){
            $current_tabs = sanitize_text_field($_GET['tabs']);

            //echo '<pre>'.var_export($current_tabs, true).'</pre>';

        }
        else{
            $current_tabs = 'account';

        }


        foreach($dashboard_tabs as $tabs_key=>$tabs){

            $title = isset($tabs['title']) ? $tabs['title'] : '';

            if($current_tabs== $tabs_key):

                ?>
                <div class="<?php echo $tabs_key; ?>">
                    <?php
                    do_action('question_answer_dashboard_tabs_html_'.$tabs_key);
                    ?>
                </div>
            <?php

            endif;


        }
        ?>
    </div>
    <?php

}


add_action('question_answer_dashboard_tabs_html_account' ,'question_answer_dashboard_tabs_html_account');
function question_answer_dashboard_tabs_html_account($atts){

    echo do_shortcode('[qa_my_account]');
}

add_action('question_answer_dashboard_tabs_html_account_edit' ,'question_answer_dashboard_tabs_html_account_edit');
function question_answer_dashboard_tabs_html_account_edit($atts){

    echo do_shortcode('[qa_edit_account]');
}


add_action('question_answer_dashboard_tabs_html_my_notifications' ,'question_answer_dashboard_tabs_html_my_notifications');
function question_answer_dashboard_tabs_html_my_notifications($atts){

    echo do_shortcode('[qa_my_notifications]');
}



add_action('question_answer_dashboard_tabs_html_my_questions' ,'question_answer_dashboard_tabs_html_my_questions');
function question_answer_dashboard_tabs_html_my_questions($atts){

   echo do_shortcode('[qa_my_questions]');
}

add_action('question_answer_dashboard_tabs_html_my_answers' ,'question_answer_dashboard_tabs_html_my_answers');
function question_answer_dashboard_tabs_html_my_answers($atts){

    echo do_shortcode('[qa_my_answers]');
}




add_action('question_answer_dashboard_not_logged' ,'question_answer_dashboard_not_logged');
function question_answer_dashboard_not_logged($atts){

    $qa_myaccount_show_register_form		= get_option( 'qa_myaccount_show_register_form', 'yes' );
    $qa_myaccount_show_login_form 			= get_option( 'qa_myaccount_show_login_form', 'yes' );
    $qa_myaccount_show_question_list 		= get_option( 'qa_myaccount_show_question_list', 'yes' );
    $login_redirect_page 		= get_option( 'qa_myaccount_login_redirect_page', '' );
    $qa_page_myaccount 						= get_option( 'qa_page_myaccount', '' );


    if( $qa_myaccount_show_register_form == 'yes' ) {

        ?>
        <div class="qa_register">
            <h3><?php echo __('Register', 'question-answer'); ?></h3>
            <?php echo do_shortcode('[qa_registration_form]') ?>
        </div>
        <?php

        $token = 1;
    }



    if( $qa_myaccount_show_login_form == 'yes' ) {

        $login_redirect_page_url = !empty($login_redirect_page) ? get_permalink($login_redirect_page) : '';
        $qa_page_myaccount_url = !empty($qa_page_myaccount) ? get_permalink($qa_page_myaccount) : wp_login_url($_SERVER['REQUEST_URI']);


        ?>
        <div class="qa_login">
            <h3><?php echo __('Login', 'question-answer'); ?></h3>
            <?php

            $args = array(
                'echo'           => true,
                'remember'       => true,
                'redirect'        => $login_redirect_page_url,
                'form_id'        => 'loginform',
                'id_username'    => 'user_login',
                'id_password'    => 'user_pass',
                'id_remember'    => 'rememberme',
                'id_submit'      => 'wp-submit',
                'label_username' => __( 'Username or email address', 'question-answer' ),
                'label_password' => __( 'Password' , 'question-answer'),
                'label_remember' => __( 'Remember Me', 'question-answer' ),
                'label_log_in'   => __( 'Login', 'question-answer' ),
                'value_username' => '',
                'value_remember' => false
            );

            wp_login_form($args);

            ?>
        </div>
        <?php

        $token = 1;
    }



}






