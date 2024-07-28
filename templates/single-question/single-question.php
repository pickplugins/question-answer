<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 


global $current_user;

wp_enqueue_style('single-question');



?>
<div class="qa-wrapper">
<?php

    $question_id = get_the_id();
    $a_subscriber = get_post_meta($question_id, 'q_subscriber', true);
    $qa_visiblity = get_post_meta($question_id, 'qa_visiblity', true);



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
<?php

wp_enqueue_style('qa-wrapper');
wp_enqueue_style('qa-wrapper-top-nav');

