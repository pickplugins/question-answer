<?php


if ( ! defined('ABSPATH')) exit;  // if direct access



	$class_qa_functions = new class_qa_functions();


	$qa_post_per_page = get_option( 'qa_question_item_per_page', 10 );

	if ( get_query_var('paged') ) { $paged = get_query_var('paged');}
	elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
	else { $paged = 1; }




    $qa_featured_questions = get_option( 'qa_featured_questions', array('') );

	//var_dump($qa_featured_questions);

    $query_args_sticky = array (
        'post_type' => 'question',
        'post__in' => $qa_featured_questions,
        'ignore_sticky_posts'=>true,
        'posts_per_page' => $qa_post_per_page,
        //'tax_query' => $tax_query,
        //'meta_query' => $meta_query_sticky,
    );

    $query_args_sticky = apply_filters('qa_query_sticky_args', $query_args_sticky);

    $wp_query_sticky = new WP_Query($query_args_sticky);

    //var_dump($wp_query_sticky->found_posts);

    $query_args = array (
        'post_type' => 'question',
        'post_status' => array( 'publish', 'private' ),
        //'author_name' => $user_slug,
        'post__not_in' => $qa_featured_questions,
        'ignore_sticky_posts'=>true,
        //'s' => $keywords,
        'order' => empty( $order ) ? 'DESC' : $order,
        'orderby' => empty( $order_by ) ? 'modified' : $order_by,
        //'meta_key'   => 'last_activity_time',
        //'tax_query' => $tax_query,
        //'meta_query' => $meta_query,
        //'date_query' => $date_query,
        'posts_per_page' => $qa_post_per_page,
        'paged' => $paged,
    );



    $query_args = apply_filters('qa_query_args', $query_args);
    //var_dump($query_args);

    $wp_query = new WP_Query( $query_args);





	?>

<div class="qa-wrapper">
    <div class="questions-archive">
        <?php

        do_action('question_answer_archive');

        ?>

        <div class="question-list">

        <?php

        if($paged==1 && !empty($qa_featured_questions)):

            if ( $wp_query_sticky->have_posts() ) :
                while ( $wp_query_sticky->have_posts() ) : $wp_query_sticky->the_post();

                    do_action( 'qa_action_question_archive_single', $wp_query_sticky );

                endwhile;
            endif;

        endif;



        if ( $wp_query->have_posts() ) :
        while ( $wp_query->have_posts() ) : $wp_query->the_post();

            do_action( 'qa_action_question_archive_single', $wp_query );

        endwhile;

        $big = 999999999;
        $paginate = array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $paged ),
            'total' => $wp_query->max_num_pages
        );

        ?>
        </div>
            <div class="qa-paginate"> <?php echo paginate_links($paginate); ?> </div> <?php

        wp_reset_query();

        else:

            //var_dump($wp_query_sticky->found_posts);

            if($wp_query_sticky->found_posts <= 0){
                ?>

                <span><?php echo __('No question found', 'question-answer'); ?></span>

                <?php
            }
        endif;

        ?>


    </div>
</div>


<?php

wp_enqueue_style('qa-wrapper');
wp_enqueue_style('qa-wrapper-top-nav');
wp_enqueue_style('question-archive');

