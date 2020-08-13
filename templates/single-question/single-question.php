<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 


global $current_user;


?>
<div class="qa-wrapper">
<?php

    $question_id = get_the_id();
    $a_subscriber = get_post_meta($question_id, 'q_subscriber', true);

    //var_dump($a_subscriber);

	do_action('question_answer_single_question_before');


	if( isset( $_GET['question_edit'] ) ) :

		do_action( 'qa_action_question_edit' );


   elseif(isset($_GET['answer_edit'])):

       do_action('qa_action_answer_edit');


   else:
       ?>
        <div itemscope itemtype="http://schema.org/Question" id="question-<?php echo $question_id;  ?>" <?php post_class('single-question entry-content'); ?>>
            <?php

            do_action('question_answer_single_question', $question_id);

            ?>
        </div>
       <?php

   endif;

       ?>


	<?php do_action('question_answer_single_question_after'); ?>

</div>
<link rel="stylesheet" href="<?php echo QA_PLUGIN_URL.'assets/front/css/qa-wrapper.css'; ?>">
<link rel="stylesheet" href="<?php echo QA_PLUGIN_URL.'assets/front/css/qa-wrapper-top-nav.css'; ?>">