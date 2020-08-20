<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



function question_answer_ajax_search() {

    $response = array();
    //$keyword	= $_POST['keyword'];

    $form_data_arr 		= isset( $_POST['form_data'] ) ? $_POST['form_data'] : array();
    $page 		= isset( $_POST['page'] ) ? $_POST['page'] : 1;

    $form_data_new = array();

    foreach( $form_data_arr as $data ) {
        $form_data_new[$data['name']] = $data['value'];

    }

    $qa_keyword = isset($form_data_new['qa_keyword']) ? sanitize_text_field($form_data_new['qa_keyword']) : '';
    $filter_by = isset($form_data_new['filter_by']) ? sanitize_text_field($form_data_new['filter_by']) : '';
    $category = isset($form_data_new['category']) ? sanitize_text_field($form_data_new['category']) : '';
    $order_by = isset($form_data_new['order_by']) ? sanitize_text_field($form_data_new['order_by']) : '';
    $order = isset($form_data_new['order']) ? sanitize_text_field($form_data_new['order']) : '';


    $posts_per_page = get_option('qa_question_item_per_page', 10);




    $qa_archive_query = new WP_Query( array (
        'post_type' => 'question',
        'post_status' => 'publish',
        's' => $qa_keyword,
        'posts_per_page' => $posts_per_page,
        'paged' => $page,


    ) );

    ob_start();


    if ( $qa_archive_query->have_posts() ) :
        do_action( 'question_archive_loop_before', $qa_archive_query );

        while ( $qa_archive_query->have_posts() ) : $qa_archive_query->the_post();

            $post_id = get_the_ID();
            $qa_featured_questions 	= get_post_meta($post_id, 'qa_featured_questions', true);
            $is_featured = ($qa_featured_questions == 'yes') ? 'featured': '';
            ?>
            <div class="single-question <?php echo $is_featured; ?>">

                <?php
                do_action( 'question_archive_loop', $post_id,  $qa_archive_query );

                ?>
            </div>
        <?php

        endwhile;
        //do_action( 'question_archive_loop_after', $qa_archive_query );

        $big = 999999999;
        $pagination = paginate_links(array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $page ),
            'total' => $qa_archive_query->max_num_pages
        ));

        $response['pagination'] = $pagination;


        wp_reset_query();
    else:
        do_action( 'question_archive_no_post', $qa_archive_query );

    endif;




    $response['html'] = ob_get_clean();






    //echo 'gggggggggggggg';

    echo json_encode($response);
    die();
}


add_action('wp_ajax_question_answer_ajax_search', 'question_answer_ajax_search');
add_action('wp_ajax_nopriv_question_answer_ajax_search', 'question_answer_ajax_search');
