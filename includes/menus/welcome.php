<?php	
if ( ! defined('ABSPATH')) exit;  // if direct access

wp_enqueue_script('welcome-tabs');
wp_enqueue_style( 'welcome-tabs' );


$qa_settings_tab = array();


$qa_settings_tab[] = array(
    'id' => 'start',
    'title' => sprintf(__('%s Welcome','question-answer'),'<i class="far fa-thumbs-up"></i>'),
    'priority' => 1,
    'active' => true,
);

$qa_settings_tab[] = array(
    'id' => 'general',
    'title' => sprintf(__('%s General','question-answer'),'<i class="fas fa-list-ul"></i>'),
    'priority' => 2,
    'active' => false,
);


$qa_settings_tab[] = array(
    'id' => 'create_pages',
    'title' => sprintf(__('%s Create Pages','question-answer'),'<i class="far fa-copy"></i>'),
    'priority' => 3,
    'active' => false,
);




$qa_settings_tab[] = array(
    'id' => 'done',
    'title' => sprintf(__('%s Done','question-answer'),'<i class="fas fa-pencil-alt"></i>'),
    'priority' => 4,
    'active' => false,
);


$qa_settings_tab = apply_filters('qa_welcome_tabs', $qa_settings_tab);

$tabs_sorted = array();
foreach ($qa_settings_tab as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
array_multisort($tabs_sorted, SORT_ASC, $qa_settings_tab);



wp_enqueue_style('font-awesome-5');









?>
<div class="wrap">
	<div id="icon-tools" class="icon32"><br></div>
    <h2></h2>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', esc_url_raw($_SERVER['REQUEST_URI'])); ?>">
	        <input type="hidden" name="qa_hidden" value="Y">
            <?php
            if(!empty($_POST['qa_hidden'])){

                $nonce = sanitize_text_field($_POST['_wpnonce']);


                if(wp_verify_nonce( $nonce, 'qa_nonce' ) && $_POST['qa_hidden'] == 'Y') {


                    do_action('qa_welcome_submit', $_POST);

                    ?>

                    <?php


                }
            }else{
                ?>
                <div class="welcome-tabs">
                    <ul class="tab-navs">
                        <?php
                        foreach ($qa_settings_tab as $tab){
                            $id = $tab['id'];
                            $title = $tab['title'];
                            $active = $tab['active'];
                            $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                            $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                            ?>
                            <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php
                    foreach ($qa_settings_tab as $tab){
                        $id = $tab['id'];
                        $title = $tab['title'];
                        $active = $tab['active'];
                        ?>

                        <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">

                            <?php
                            do_action('qa_welcome_tabs_content_'.$id, $tab);
                            ?>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="next-prev">
                        <div class="prev"><span><?php echo sprintf(__('%s Previous','question-answer'),'&longleftarrow;')?></span></div>
                        <div class="next"><span><?php echo sprintf(__('Next %s','question-answer'),'&longrightarrow;')?></span></div>

                    </div>



                </div>



                <div class="clear clearfix"></div>
                <?Php

            }
            ?>


		</form>
</div>
