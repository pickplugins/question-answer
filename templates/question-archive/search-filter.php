<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 

?>

<?php

if( !empty($_GET['keywords']) ){
    $keywords = sanitize_text_field($_GET['keywords']);

    do_action('qa_action_submit_search');
}

$filter_by 	= isset( $_GET['filter_by'] ) ? sanitize_text_field( $_GET['filter_by'] ) : '';
$user_slug 	= isset( $_GET['user_slug'] ) ? sanitize_text_field( $_GET['user_slug'] ) : '';
$order_by	= empty( $_GET['order_by'] ) ? '' : sanitize_text_field( $_GET['order_by'] );
$order		= ( $order_by == 'title' ) ? 'ASC' : sanitize_text_field($order);


if( $order_by === 'date_older' ) {

    $order_by = 'date';
    $order = 'ASC';

}

$tax_query = array();
if( !empty($_GET['category']) || !empty($category) ){

    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : $category;
    $tax_query[] = array(
        array(
            'taxonomy' => 'question_cat',
            'field' => 'slug',
            'terms' => $category,
        )
    );
}

$date_query = array();
if( !empty( $_GET['date'] ) || !empty( $date ) ) {

    $date = isset( $_GET['date'] ) ? sanitize_text_field($_GET['date']) : '';
    $arr_date = explode( "-", $date );

    $date_query = array(
        'year'  => intval($arr_date[2]),
        'month' => intval($arr_date[1]),
        'day'   => intval($arr_date[0]),
    );
}

$meta_query = array();
if( !empty( $_GET['filter_by'] ) || !empty( $filter_by ) ) {

    $filter_by = isset( $_GET['filter_by'] ) ? sanitize_text_field($_GET['filter_by']) : '';

    $meta_query[] = array(
        'key'     => 'qa_question_status',
        'value'   => $filter_by,
        'compare' => '=',
    );
}

?>



<form class="question_serch_filter" method="GET">

    <div class="form-meta">
        <input autocomplete="off" class="ui-autocomplete-input" type="search" id="keyword" name="keywords" placeholder="<?php echo __('keywords', 'question-answer'); ?>" value="<?php echo $keywords; ?>" />
    </div>

    <div class="form-meta">

        <select id="category" name="category">
            <option value=""><?php echo __('Select a category', 'question-answer'); ?></option> <?php

            foreach( qa_get_categories() as $cat_id => $cat_info ) { ksort($cat_info);



                $this_category = get_term( $cat_id );

                //var_dump($this_category);

                //if(!empty($this_category))
                foreach( $cat_info as $key => $value ) {

                    //var_dump($category);

                    if( $key == 0 )  {
                        ?><option <?php selected( $this_category->slug, $category ); ?> value="<?php echo $this_category->slug; ?>"><?php echo $value; ?></option><?php
                    } else {
                        $this_category = get_category( $key );

                        ?><option <?php selected( $this_category->slug, $category ); ?> value="<?php echo $this_category->slug; ?>">  - <?php echo $value; ?></option> <?php
                    }
                }
            } ?>
        </select>
    </div>

    <div class="form-meta">
        <select id="order_by" name="order_by"> <?php
            $sorter = $class_qa_functions->qa_question_archive_filter_options();
            foreach( $sorter as $key => $value ) {
                ?><option <?php selected( $key, $order_by ); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
            } ?>
        </select>
    </div>
    <div class="form-meta">
        <select id="filter_by" name="filter_by"> <?php
            $status = $class_qa_functions->qa_question_status();
            foreach( $status as $key => $value ) {
                ?><option <?php selected( $key, $filter_by ); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
            } ?>
        </select>
    </div>
    <div class="form-meta">
        <input type="submit" value="<?php echo __('Search', 'question-answer'); ?>" />
    </div>
</form>