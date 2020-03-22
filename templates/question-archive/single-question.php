<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	$qa_question_excerpt_length = get_option('qa_question_excerpt_length' , 20 );
	$category 	= get_the_terms( get_the_ID(), 'question_cat' );			
	
    $qa_featured_questions 	= get_post_meta(get_the_ID(), 'qa_featured_questions', true);


    $is_featured = ($qa_featured_questions == 'yes') ? 'featured':'';
	

    $question_post = get_post(get_the_ID());

    $author_id = $question_post->post_author;
	
	?>
	
	<div class="single-question <?php echo $is_featured; ?>">

        <?php
        do_action( 'qa_action_question_archive_vote' );
        do_action( 'qa_action_question_archive_answer_count' );
        do_action( 'qa_action_question_archive_view_count' );
        ?>
        <div class="thumb">
            <?php echo get_avatar( $author_id, "45" ); ?>
        </div>

		<div class="question-details">


        
			<div class="title"><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></div>
			<div class="excerpt"><?php 
			
			$post_status 	= get_post_status( get_the_ID());
			
			if($post_status=='private'){
						
				
				}
			else{
				//echo wp_trim_words(get_the_content(), $qa_question_excerpt_length,'...');
				}
			
			
			?>
            </div>

            <?php
            do_action( 'qa_action_question_archive_question_meta' );
            ?>

		</div>

	</div>