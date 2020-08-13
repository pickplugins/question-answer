<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

?><div class="qa-migration"> <?php
	
	if ( get_query_var('paged') ) { $paged = get_query_var('paged');} 
	elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } 
	else { $paged = 1; }
	
	$posts_per_page = 1;
	
	$action = isset( $_GET['action'] ) ? sanitize_text_field($_GET['action']) : ''; 
	
	$wp_query = new WP_Query( array (
		'post_type' => 'answer',
		'post_status' => array( 'publish', 'pending' ),
		'posts_per_page' => $posts_per_page,
		'paged' => $paged,
	) );
	
	echo '<div style="font-size: 18px;font-weight: bold;padding:10px;background:#e1e1e1;margin:10px 0;">'.__('Answers:', 'question-answer').' '.$posts_per_page.'/'.$wp_query->found_posts.'</div>';
	
	
	if( $action != 'running' ) {
		
		echo '<center style="margin:30px 0;"><a style="text-decoration:none;padding:10px 35px;background:#e1e1e1;" href="?action=running">'.__('Start Update', 'question-answer').'</a></center>';
	}
	
	if( $action == 'running' ) {
	
		echo '<center><img style="padding: 50px;" src="'.plugins_url( '/question-answer/assets/global/images/loading1.gif' ).'" /></center>';
		
		
		if ( $wp_query->have_posts() ) : 
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			
			$answer_id = get_the_ID();
			
			$qa_answer_question_id_2 = get_post_meta( $answer_id, 'qa_answer_question_id_2', true );
			
			if( !empty( $qa_answer_question_id_2 ) ) {
			
				$wp_query_question = new WP_Query( array (
					'post_type' => 'question',
					'post_status' => array( 'publish', 'pending' ),
					'posts_per_page' => -1,
					'meta_query' => array(
						array(
							'key'     => 'qa_question_pre_postid',
							'value'   => $qa_answer_question_id_2,
							'compare' => '=',
						),
					),
				) );
			
				if ( $wp_query_question->have_posts() ) : while ( $wp_query_question->have_posts() ) : $wp_query_question->the_post();
				
					update_post_meta( $answer_id, 'qa_answer_question_id', get_the_ID() );
				
				endwhile;
				wp_reset_query();
				endif;
			}
			

		endwhile;

		$big = 999999999;
		$paginate = array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, $paged ),
			'total' => $wp_query->max_num_pages
		);
				
		echo '<div class="qa-paginate">'.paginate_links($paginate).'</div>';
		wp_reset_query();
		endif;
				


	}

	


?>
</div>

<style>

.qa-migration .qa-paginate, .container-answer-section .qa-paginate {
  margin: 30px 0;
  text-align: center;
}
.qa-migration .qa-paginate .page-numbers, .container-answer-section .qa-paginate .page-numbers {
  background: #5f6caf none repeat scroll 0 0;
  margin: 0 2px;
  padding: 9px 15px;
  text-decoration: none;
}

.qa-migration .qa-paginate .current, .container-answer-section .qa-paginate .current {
  background: #ddd none repeat scroll 0 0;
}
.qa-migration .qa-paginate .pre,
.container-answer-section .qa-paginate .prev{

}

.qa-migration .qa-paginate .next,
.container-answer-section .qa-paginate .next{
}

</style>