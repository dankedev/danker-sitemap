<?php

/**
 * danker-sitemap Project
 * @package danker-sitemap
 * User: dankerizer
 * Date: 23/05/2017 / 21.58
 */
class DNSTMP
{
    protected static $instance = NULL;

    public function __construct()
    {
        //add settings link to plugins page
        add_filter("plugin_action_links", array(
            $this,
            'SettingsLink'
        ), 10, 2);

    }

    public function categories()
    {
        $output = '<ol>';

        $output .= wp_list_categories(array(
            'orderby' => 'name',
            'show_count' => true,
            'use_desc_for_title' => false,
            'title_li' => '',
            'echo' => false,
        ));

        $output .= '<ul>';

        return $output;
    }

    /**
     * Post Sitemap
     */
    public function posts($post_per_page = 50, $sort = '', $page = 1, $show_page = true)
    {
        // global $wp_query;

        if ($post_per_page == 0) {
            $post_per_page = -1;
        }
        $output = '<h2>' . __('Posts', 'dnstmp') . '</h2>';
        $paged = (get_query_var('paged')) ? get_query_var('paged') : $page;


        $args = array('post_type' => 'post', 'posts_per_page' => $post_per_page, 'paged' => $paged);
        $theQuery = new WP_Query($args);
        $pages = $theQuery->max_num_pages;
        if ($theQuery->have_posts()):
            $output .= '<ul>';
            while ($theQuery->have_posts()) : $theQuery->the_post();
                $id = $theQuery->post->ID;
                $pfx_date = get_the_date(get_option('date_format'), $id);
                $output .= '<li><a href="' . get_the_permalink($id) . '">' . get_the_title($id) . '</a> ' . $pfx_date . '</li>';
            endwhile;
            $output .= '</ul>';

            if ($show_page) {
                $output .= $this->pagination($pages, $page);
            }
            wp_reset_postdata();
        //exit();
        else:
            $output .= 'no post';
        endif;

        return $output;

    }


    public function pagination($total = 10, $current = 1, $max = 20)
    {
        global $wp_query;
        $output = NULL;
        if ($total > 1) {
            $output = 'Pages: ';
        }

        $the_url = get_bloginfo('url');

        foreach (range(1, $total) as $item) {
            if ($item == $current) {
                $output .= '<span>' . $item . '</span> ';
            } else {
                $output .= '<a href="?np=' . $item . '">' . $item . '</a> ';
            }
            if ($item <= $max) {
                $output .= '';
            }
        }


        return $output;


    }

    /**
     * Page Sitemap
     */
    public function pages()
    {
        $pages = '<h2>' . __('Top Level Pages', 'dnstmp') . '</h2>';
        $pages .= '<ul>';
        $pages .= wp_list_pages(array(
            'echo' => 0,
            'depth' => 1,
            'title_li' => '',
            'show_date' => 'modified',

        ));
        $pages .= '</ul>';
        return $pages;
    }


    /**
     * @param $links
     * @param $file
     * @return mixed
     * Setting Links
     */
    function SettingsLink($links, $file)
    {

        if ($file == DNSTMP_PLUGIN_NAME . '/danker-sitemap.php') {

            /*
             * Insert the link at the beginning
            */
            $in = '<a href="options-general.php?page=dnstmp-page">' . __('Settings', 'dnstmp') . '</a>';
            array_unshift($links, $in);

            /*
             * Insert at the end
            */

            // $links[] = '<a href="options-general.php?page=contact-form-settings">'.__('Settings','contact-form').'</a>';

        }

        return $links;
    }

}