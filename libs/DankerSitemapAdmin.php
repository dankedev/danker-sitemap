<?php

/**
 * danker-sitemap Project
 * @package danker-sitemap
 * User: dankerizer
 * Date: 24/05/2017 / 14.36
 */
class DankerSitemapAdmin {

    public function __construct()
    {
        //add settings link to plugins page
        add_filter("plugin_action_links", array(
            $this,
            'SettingsLink'
        ), 10, 2);
        add_action('admin_init', array($this, 'page_init'));
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    function admin_menu()
    {
        add_options_page(
            'Danker Sitemap',
            '<span class="dashicons dashicons-awards"></span> Danker Sitemap',
            'manage_options',
            'danker_sitemap_page',
            array(
                $this,
                'settings_page'
            )
        );
    }

    public function page_init()
    {
        register_setting(
            'danker_sitemap_option_group', // Option group
            DNSTMP_OPTIONS_KEY, // Option name
            array($this, 'sanitize') // Sanitize
        );
        add_settings_section('danker_sitemap_section', '<h3>' . __('General Setting', 'danker_sitemap') . '</h3>', array(
            $this,
            'print_section_info_message'
        ), 'danker_sitemap_option');
        add_settings_field('sitemap_items_per_page', __('Posts per page:	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'sitemap_items_per_page'
        ));
        add_settings_field('post_title', __('Sitemap Post Title', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'post_title'
        ));
        add_settings_field('post_order', __('Post Order:	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'post_order'
        ));
        add_settings_field('page_title', __('Sitemap Page Title', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'page_title'
        ));
        add_settings_field('page_order', __('Page Order:	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'page_order'
        ));
        add_settings_field('category_title', __('Sitemap Categories Title', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'category_title'
        ));
        add_settings_field('category_order', __('Categories Order:	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'category_order'
        ));
        add_settings_field('post_comment', __('Show comment count after posts:', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'post_comment'
        ));
        add_settings_field('post_date', __('Show dates after posts:', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'post_date'
        ));
        add_settings_field('page_date', __('Show dates after pages:', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'page_date'
        ));
        add_settings_field('cat_post_count', __('Show Posts Count in Categories	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'cat_post_count'
        ));
        add_settings_field('date_format', __('Date format (if showing dates):	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_sitemap_option', 'danker_sitemap_section', array(
            'date_format'
        ));
        add_settings_section('danker_sitemap_image_section', '<h3>' . __('Image Sitemap Setting', 'danker_sitemap') . '</h3>', array(
            $this,
            'print_image_sitemap_info'
        ), 'danker_image_sitemap_option');
        add_settings_field('image_sitemap_title', __('Sitemap Title:	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_image_sitemap_option', 'danker_sitemap_image_section', array(
            'image_sitemap_title'
        ));
        add_settings_field('post_image_sitemap_items_per_page', __('Posts per page:	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_image_sitemap_option', 'danker_sitemap_image_section', array(
            'post_image_sitemap_items_per_page'
        ));
        add_settings_field('max_image_per_post', __('Maximum Image per Post:	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_image_sitemap_option', 'danker_sitemap_image_section', array(
            'max_image_per_post'
        ));
        add_settings_field('image_order', __('Image Order:	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_image_sitemap_option', 'danker_sitemap_image_section', array(
            'image_order'
        ));
        add_settings_field('image_link_to', __('Link Image To:	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_image_sitemap_option', 'danker_sitemap_image_section', array(
            'image_link_to'
        ));
        add_settings_field('open_link', __('Open Link:	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_image_sitemap_option', 'danker_sitemap_image_section', array(
            'open_link'
        ));
        add_settings_field('show_image_count', __('Show Image Count:	', 'danker_sitemap'), array(
            $this,
            'create_fields'
        ), 'danker_image_sitemap_option', 'danker_sitemap_image_section', array(
            'show_image_count'
        ));

    }

    public function create_fields($args)
    {
        $fieldname = $args[0];
        switch ($fieldname) {
            case 'sitemap_items_per_page':
                ?><input type="number" id="sitemap_items_per_page" class="regular-text code"
                         name="<?php echo DNSTMP_OPTIONS_KEY; ?>[sitemap_items_per_page]"
                         value="<?php echo DankerSitemapSetting::sitemap_items_per_page(); ?>" />
                <p class="description">Set to 0 for unlimited or All Posts</p>
                <?php
                break;
            case 'post_title':
                ?><input type="text" id="post_title" class="regular-text "
                         name="<?php echo DNSTMP_OPTIONS_KEY; ?>[post_title]"
                         value="<?php echo DankerSitemapSetting::post_title(); ?>" />
                <p class="description">Set Heading Title For Post Sitemap</p>
                <?php
                break;
            case 'post_order':
                $orders = array('titlea' => 'By Title (oldest first)', 'titled' => 'By Title (newest first)', 'datea' => 'By post date (oldest first)', 'dated' => 'By post date (newest first)');
                $order = DankerSitemapSetting::post_order();
                foreach ($orders as $key => $label) {
                    if ($key == $order) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                    echo '<label><input type="radio" id="post_order" class="tog" name="' . DNSTMP_OPTIONS_KEY . '[post_order]" ' . $checked . ' value="' . $key . '"/> ' . $label . '</label><br/>';
                }
                break;
            case 'page_title':
                ?><input type="text" id="page_title" class="regular-text "
                         name="<?php echo DNSTMP_OPTIONS_KEY; ?>[page_title]"
                         value="<?php echo DankerSitemapSetting::page_title(); ?>" />
                <p class="description">Set Heading Title For Page Sitemap</p>
                <?php
                break;
            case 'category_title':
                ?><input type="text" id="category_title" class="regular-text "
                         name="<?php echo DNSTMP_OPTIONS_KEY; ?>[category_title]"
                         value="<?php echo DankerSitemapSetting::category_title(); ?>" />
                <p class="description">Set Heading Title For Category Sitemap</p>
                <?php
                break;
            case 'page_order':
                $orders = array('titlea' => 'By Title (oldest first)', 'titled' => 'By Title (newest first)', 'datea' => 'By post date (oldest first)', 'dated' => 'By post date (newest first)');
                $order = DankerSitemapSetting::page_order();
                foreach ($orders as $key => $label) {
                    if ($key == $order) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                    echo '<label><input type="radio" id="page_order" class="tog" name="' . DNSTMP_OPTIONS_KEY . '[page_order]" ' . $checked . ' value="' . $key . '"/> ' . $label . '</label><br/>';
                }
                break;
            case 'category_order':
                $orders = array('namea' => 'By name (oldest first)', 'named' => 'By name (newest first)', 'ida' => 'By ID (oldest first)', 'idd' => 'By ID (newest first)');
                $order = DankerSitemapSetting::category_order();
                foreach ($orders as $key => $label) {
                    if ($key == $order) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                    echo '<label><input type="radio" id="category_order" class="tog" name="' . DNSTMP_OPTIONS_KEY . '[category_order]" ' . $checked . ' value="' . $key . '"/> ' . $label . '</label><br/>';
                }
                break;
            case 'post_comment':
                $checked = DankerSitemapSetting::post_comment() == true ? "checked" : "";
                echo '<input name="' . DNSTMP_OPTIONS_KEY . '[post_comment]" id="post_comment" ' . $checked . ' type="checkbox"  />';
                break;
            case 'post_date':
                $checked = DankerSitemapSetting::post_date() == true ? "checked" : "";
                echo '<input name="' . DNSTMP_OPTIONS_KEY . '[post_date]"  id="post_date" ' . $checked . ' type="checkbox" />';
                break;
            case 'page_date':
                $checked = DankerSitemapSetting::page_date() == true ? "checked" : "";
                echo '<input name="' . DNSTMP_OPTIONS_KEY . '[page_date]" ' . $checked . ' type="checkbox"  />';
                break;
            case 'cat_post_count':
                $checked = DankerSitemapSetting::cat_post_count() == true ? "checked" : "";
                echo '<input name="' . DNSTMP_OPTIONS_KEY . '[cat_post_count]" id="cat_post_count" ' . $checked . ' type="checkbox" value="checkbox"/>';
                break;
            case 'date_format':
                echo '<label class="description"> <input name="' . DNSTMP_OPTIONS_KEY . '[date_format]" id="date_format" type="text" class="" value="' . DankerSitemapSetting::date_format() . '"/>';
                echo '  Use <a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Formatting Date and Time</a></label>';
                break;
            case 'image_sitemap_title':
                ?><input type="text" id="image_sitemap_title" class="regular-text "
                         name="<?php echo DNSTMP_OPTIONS_KEY; ?>[image_sitemap_title]"
                         value="<?php echo DankerSitemapSetting::image_sitemap_title(); ?>" />
                <p class="description">Set Heading Title For Post Sitemap</p>
                <?php
                break;
            case 'post_image_sitemap_items_per_page':
                ?><input type="number" id="post_image_sitemap_items_per_page" class="regular-text code"
                         name="<?php echo DNSTMP_OPTIONS_KEY; ?>[post_image_sitemap_items_per_page]"
                         value="<?php echo DankerSitemapSetting::post_image_sitemap_items_per_page(); ?>" />
                <p class="description">Set to 0 for unlimited or All Posts</p>
                <?php
                break;
            case 'max_image_per_post':
                ?><input type="number" id="max_image_per_post" class="regular-text code"
                         name="<?php echo DNSTMP_OPTIONS_KEY; ?>[max_image_per_post]"
                         value="<?php echo DankerSitemapSetting::max_image_per_post(); ?>" />
                <p class="description">Set to 0 to display All Images</p>
                <?php
                break;
            case 'image_order':
                $orders = array('asc' => 'oldest first', 'desc' => 'newest first');
                $order = DankerSitemapSetting::image_order();
                foreach ($orders as $key => $label) {
                    if ($key == $order) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                    echo '<label><input type="radio" id="post_order" class="tog" name="' . DNSTMP_OPTIONS_KEY . '[image_order]" ' . $checked . ' value="' . $key . '"/> ' . $label . '</label><br/>';
                }
                break;
            case 'image_link_to':
                $orders = array('attachment' => 'Attachment Page', 'media' => 'Media File', 'parent' => 'Post Parrent');
                $order = DankerSitemapSetting::image_link_to();
                foreach ($orders as $key => $label) {
                    if ($key == $order) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                    echo '<label><input type="radio" id="image_link_to" class="tog" name="' . DNSTMP_OPTIONS_KEY . '[image_link_to]" ' . $checked . ' value="' . $key . '"/> ' . $label . '</label><br/>';
                }
                break;

                case 'open_link':
                $orders = array('blank' => 'New Tab', 'self' => 'Inherit');
                $order = DankerSitemapSetting::open_link();
                foreach ($orders as $key => $label) {
                    if ($key == $order) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                    echo '<label><input type="radio" id="open_link" class="tog" name="' . DNSTMP_OPTIONS_KEY . '[open_link]" ' . $checked . ' value="' . $key . '"/> ' . $label . '</label><br/>';
                }
                break;
            case 'show_image_count':
                $checked = DankerSitemapSetting::show_image_count() == true ? "checked" : "";
                echo '<input name="' . DNSTMP_OPTIONS_KEY . '[show_image_count]" id="show_image_count" ' . $checked . ' type="checkbox"  />';
                break;
        }

    }

    public function settings_page()
    {
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general_setting';
        $tabs = array('general_setting' => 'General Setting', 'image_sitemap' => 'Image Sitemap Setting', 'help' => 'Help');
        echo '<h1>Danker Sitemap v' . DNSTMP_VERSION . '</h1>';
        echo '<div class="nav-tab-wrapper">';
        foreach ($tabs as $key => $tab) {
            if ($active_tab == $key) {
                $active = 'nav-tab-active';
            } else {
                $active = '';
            }
            echo '<a href="?page=danker_sitemap_page&tab=' . $key . '"  class="nav-tab ' . $active . '">' . $tab . '</a>';
        }
        echo '</div>';
        ?>

        <?php
        if ($active_tab == 'general_setting') {
            echo '  <form method="post" action="options.php">';
            //submit_button();
            settings_fields('danker_sitemap_option_group');
            do_settings_sections('danker_sitemap_option');
            submit_button();
            echo '   </form>';
            echo '<pre>';
            print_r(get_option(DNSTMP_OPTIONS_KEY));
            echo "</pre>";

        } elseif ($active_tab == 'image_sitemap') {
            echo '  <form method="post" action="options.php">';
            settings_fields('danker_sitemap_option_group');
            do_settings_sections('danker_image_sitemap_option');
            submit_button();
            echo '   </form>';
        }else{
            $this->help();
        }


    }

    public function sanitize($input)
    {
        $new_input = array();
        $settings = array(
            'sitemap_items_per_page' => 'number',
            'post_title' => 'text',
            'page_title' => 'text',
            'category_title' => 'text',
            'post_order' => 'radio',
            'page_order' => 'radio',
            'category_order' => 'radio',
            'post_comment' => 'checkbox',
            'post_date' => 'checkbox',
            'page_date' => 'checkbox',
            'cat_post_count' => 'checkbox',
            'date_format' => 'text',
            'post_image_sitemap_items_per_page' => 'text',
            'max_image_per_post' => 'number',
            'image_order' => 'radio',
            'image_link_to' => 'radio',
            'show_image_count' => 'checkbox',
            'open_link' => 'radio',
        );
        foreach ($settings as $setting => $format) {
            if (isset($input[$setting])) {
                if ($format == 'text') {
                    $output = sanitize_text_field($input[$setting]);
                } elseif ($format == 'radio') {
                    $output = sanitize_text_field($input[$setting]);
                } elseif ($format == 'checkbox') {
                    $output = absint($input[$setting]);
                } else {
                    $output = absint($input[$setting]);
                }
                $new_input[$setting] = $output;

            }
        }
        return $new_input;
    }

    static public function help()
    {
        include DNSTMP_PLUGIN_DIR.'/help.php';
    }

    static function print_section_info_message()
    {
        print __('Create Simple Sitemap Easly', 'danker_sitemap');
    }

    static function print_image_sitemap_info()
    {
        print __('Setting Up Image Sitemap Page', 'danker_sitemap');
    }

    /**
     * @param $links
     * @param $file
     * @return mixed
     * Setting Links
     */
    static function SettingsLink($links, $file)
    {
        if ($file == DNSTMP_PLUGIN_NAME . '/danker-sitemap.php') {
            /*
             * Insert the link at the beginning
            */
            $in = '<a href="options-general.php?page=danker_sitemap_page">' . __('Settings', 'danker_sitemap') . '</a>';
            array_unshift($links, $in);
            /*
             * Insert at the end
            */

            // $links[] = '<a href="options-general.php?page=contact-form-settings">'.__('Settings','contact-form').'</a>';
        }
        return $links;
    }
}