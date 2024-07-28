<?php
if (!defined('ABSPATH')) exit;  // if direct access



function question_answer_archive_ajax_search()
{

    $response = array();
    //$keyword	= $_POST['keyword'];

    $form_data_arr         = isset($_POST['form_data']) ? $_POST['form_data'] : array();
    $page         = isset($_POST['page']) ? $_POST['page'] : 1;

    error_log(serialize($form_data_arr));

    $form_data_new = array();

    foreach ($form_data_arr as $data) {
        $form_data_new[$data['name']] = $data['value'];
    }

    $qa_keyword = isset($form_data_new['qa_keyword']) ? sanitize_text_field($form_data_new['qa_keyword']) : '';
    $filter_by = isset($form_data_new['filter_by']) ? sanitize_text_field($form_data_new['filter_by']) : '';
    $qa_category = isset($form_data_new['qa_category']) ? sanitize_text_field($form_data_new['qa_category']) : '';
    $order_by = isset($form_data_new['order_by']) ? sanitize_text_field($form_data_new['order_by']) : 'date';
    $order = isset($form_data_new['order']) ? sanitize_text_field($form_data_new['order']) : 'DESC';
    $question_status = isset($form_data_new['question_status']) ? sanitize_text_field($form_data_new['question_status']) : '';
    $per_page = isset($form_data_new['per_page']) ? sanitize_text_field($form_data_new['per_page']) : 10;


    $posts_per_page = get_option('qa_question_item_per_page', 10);
    $posts_per_page = !empty($per_page) ? $per_page : $posts_per_page;

    $query_args = array();

    $tax_query = array();
    $meta_query = array();

    if (!empty($filter_by) && $filter_by == 'featured') {

        $meta_query[] = array(
            'key'     => 'qa_featured_questions',
            'value'   => 'yes',
            'compare' => '=',
        );
    } elseif (!empty($filter_by) && $filter_by == 'solved') {

        $meta_query[] = array(
            'key'     => 'qa_question_status',
            'value'   => 'solved',
            'compare' => '=',
        );
    } elseif (!empty($filter_by) && $filter_by == 'unsolved') {

        $meta_query[] = array(
            'key'     => 'qa_question_status',
            'value'   => '',
            'compare' => 'NOT EXISTS',
        );
    }



    if ($order_by == 'view_count') {

        $order_by = 'meta_value_num';
        $query_args['meta_key'] = 'qa_view_count';
    } elseif ($order_by == 'answer_count') {

        $order_by = 'meta_value_num';
        $query_args['meta_key'] = 'answer_count';
    } elseif ($order_by == 'vote_count') {

        $order_by = 'meta_value_num';
        $query_args['meta_key'] = 'vote_count';
    }



    if (!empty($qa_category)) :
        $tax_query[] = array(
            array(
                'taxonomy' => 'question_cat',
                'field' => 'slug',
                'terms' => $qa_category,
            )
        );
    endif;

    if (!empty($question_status)) :
        $meta_query[] = array(
            'key'     => 'qa_question_status',
            'value'   => $question_status,
            'compare' => '=',
        );
    endif;





    $query_args['post_type'] = 'question';
    $query_args['post_status'] = array('publish', 'private');
    $query_args['order'] = $order;
    $query_args['orderby'] = $order_by;

    if (!empty($qa_keyword)) {
        $query_args['s'] = $qa_keyword;
    }

    if (!empty($tax_query)) {
        $query_args['tax_query'] = $tax_query;
    }

    if (!empty($meta_query)) {
        $query_args['meta_query'] = $meta_query;
    }

    $query_args['posts_per_page'] = $posts_per_page;
    $query_args['paged'] = $page;

    error_log(serialize($query_args));



    $qa_archive_query = new WP_Query($query_args);

    ob_start();


    if ($qa_archive_query->have_posts()) :
        do_action('question_archive_loop_before', $qa_archive_query);

        while ($qa_archive_query->have_posts()) : $qa_archive_query->the_post();

            $post_id = get_the_ID();
            $qa_featured_questions     = get_post_meta($post_id, 'qa_featured_questions', true);
            $is_featured = ($qa_featured_questions == 'yes') ? 'featured' : '';
?>
            <div class="single-question <?php echo $is_featured; ?>">

                <?php
                do_action('question_archive_loop', $post_id,  $qa_archive_query);

                ?>
            </div>
<?php

        endwhile;
        //do_action( 'question_archive_loop_after', $qa_archive_query );

        $big = 999999999;


        $pagination = paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, $page),
            'total' => $qa_archive_query->max_num_pages,

        ));

        $response['pagination'] = $pagination;


        wp_reset_query();
    else :
        do_action('question_archive_no_post', $qa_archive_query);

    endif;




    $response['html'] = ob_get_clean();

    $response['posts_per_page'] = $posts_per_page;





    //echo 'gggggggggggggg';

    echo json_encode($response);
    die();
}


add_action('wp_ajax_question_answer_archive_ajax_search', 'question_answer_archive_ajax_search');
add_action('wp_ajax_nopriv_question_answer_archive_ajax_search', 'question_answer_archive_ajax_search');




function paginate_links_202352($link)
{


    return $link;
}

//add_filter('paginate_links', 'paginate_links_202352');