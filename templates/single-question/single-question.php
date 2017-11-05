<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


$question_id = get_the_id();

	//get_header();

	do_action('qa_action_before_single_question');

	//while ( have_posts() ) : the_post();
	?>


       <?php

       if(isset($_GET['question_edit'])):

           do_action('qa_action_question_edit');


       elseif(isset($_GET['answer_edit'])):

           do_action('qa_action_answer_edit');

       else:
           ?>
           <div itemscope itemtype="http://schema.org/Question" id="question-<?php echo $question_id;  ?>" <?php post_class('single-question entry-content'); ?>>
            <?php

           do_action('qa_action_single_question_main');

           ?>
           </div>
           <?php

       endif;

       ?>


    <?php //do_action('qa_action_single_question_main'); ?>
	

	<?php
	//endwhile;
    //do_action('qa_action_single_question_sidebar');

    do_action('qa_action_after_single_question');
	//echo '</div>';

	
	//get_sidebar();

	//get_footer();


