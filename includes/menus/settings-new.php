<?php
if (!defined('ABSPATH')) exit;  // if direct access




$qa_settings_tab = array();

$qa_settings_tab[] = array(
    'id' => 'general',
    'title' => sprintf(__('%s General', 'question-answer'), '<i class="fas fa-tools"></i>'),
    'priority' => 1,
    'active' => true,
);


$qa_settings_tab[] = array(
    'id' => 'archive',
    'title' => sprintf(__('%s Archive', 'question-answer'), '<i class="fas fa-list-ul"></i>'),
    'priority' => 2,
    'active' => false,
);



$qa_settings_tab[] = array(
    'id' => 'dashboard',
    'title' => sprintf(__('%s Dashboard', 'question-answer'), '<i class="fas fa-tachometer-alt"></i>'),
    'priority' => 2,
    'active' => false,
);




$qa_settings_tab[] = array(
    'id' => 'questions',
    'title' => sprintf(__('%s Questions', 'question-answer'), '<i class="far fa-question-circle"></i>'),
    'priority' => 3,
    'active' => false,
);


$qa_settings_tab[] = array(
    'id' => 'answers',
    'title' => sprintf(__('%s Answers', 'question-answer'), '<i class="fas fa-pencil-alt"></i>'),
    'priority' => 4,
    'active' => false,
);


$qa_settings_tab[] = array(
    'id' => 'question_submission',
    'title' => sprintf(__('%s Question submission', 'question-answer'), '<i class="far fa-question-circle"></i>'),
    'priority' => 3,
    'active' => false,
);


$qa_settings_tab[] = array(
    'id' => 'pages',
    'title' => sprintf(__('%s Pages', 'question-answer'), '<i class="far fa-copy"></i>'),
    'priority' => 7,
    'active' => false,
);

$qa_settings_tab[] = array(
    'id' => 'style',
    'title' => sprintf(__('%s Style', 'question-answer'), '<i class="fas fa-palette"></i>'),
    'priority' => 8,
    'active' => false,
);

$qa_settings_tab[] = array(
    'id' => 'emails',
    'title' => sprintf(__('%s Emails', 'question-answer'), '<i class="fas fa-envelope-open-text"></i>'),
    'priority' => 9,
    'active' => false,
);



$qa_settings_tab = apply_filters('qa_settings_tabs', $qa_settings_tab);

$tabs_sorted = array();
foreach ($qa_settings_tab as $page_key => $tab) $tabs_sorted[$page_key] = isset($tab['priority']) ? $tab['priority'] : 0;
array_multisort($tabs_sorted, SORT_ASC, $qa_settings_tab);

?>
<div class="wrap">
    <div id="icon-tools" class="icon32"><br></div>
    <h2><?php echo sprintf(__('%s Settings', 'question-answer'), QA_PLUGIN_NAME) ?></h2>
    <form method="post" action="<?php echo str_replace('%7E', '~', esc_url_raw($_SERVER['REQUEST_URI'])); ?>">
        <input type="hidden" name="qa_settings_hidden" value="Y">
        <?php
        if (!empty($_POST['qa_settings_hidden'])) {

            $nonce = sanitize_text_field($_POST['_wpnonce']);

            if (wp_verify_nonce($nonce, 'qa_nonce') && $_POST['qa_settings_hidden'] == 'Y') {


                do_action('qa_settings_save');

        ?>
                <div class="updated notice  is-dismissible">
                    <p><strong><?php _e('Changes Saved.', 'question-answer'); ?></strong></p>
                </div>

        <?php
            }
        }
        ?>

        
        <div class="settings-tabs vertical has-right-panel">

            <div class="settings-tabs-right-panel">
                <?php
                foreach ($qa_settings_tab as $tab) {
                    $id = $tab['id'];
                    $active = $tab['active'];

                ?>
                    <div class="right-panel-content <?php if ($active) echo 'active'; ?> right-panel-content-<?php echo $id; ?>">
                        <?php

                        do_action('qa_settings_tabs_right_panel_' . $id);
                        ?>

                    </div>
                <?php

                }
                ?>
            </div>

            <ul class="tab-navs">
                <?php
                foreach ($qa_settings_tab as $tab) {
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                    $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                ?>
                    <li <?php if (!empty($data_visible)) :  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if ($hidden) echo 'hidden'; ?> <?php if ($active) echo 'active'; ?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
                <?php
                }
                ?>
            </ul>



            <?php
            foreach ($qa_settings_tab as $tab) {
                $id = $tab['id'];
                $title = $tab['title'];
                $active = $tab['active'];
            ?>

                <div class="tab-content <?php if ($active) echo 'active'; ?>" id="<?php echo $id; ?>">
                    <?php
                    do_action('qa_settings_tabs_content_' . $id, $tab);
                    ?>


                </div>

            <?php
            }
            ?>

        </div>

        <div class="clear clearfix"></div>
        <p class="submit">
            <?php wp_nonce_field('qa_nonce'); ?>
            <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes', 'question-answer'); ?>" />
        </p>
    </form>
</div>


<?php

wp_enqueue_script('settings-tabs');
wp_enqueue_style('settings-tabs');
wp_enqueue_style('font-awesome-5');


?>