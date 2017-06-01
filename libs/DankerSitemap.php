<?php

/**
 * danker-sitemap Project
 * @package danker-sitemap
 * User: dankerizer
 * Date: 23/05/2017 / 21.58
 * https://code.tutsplus.com/articles/create-wordpress-plugins-with-oop-techniques--net-20153
 */
class DankerSitemap {

    var $options;
    protected static $instance = NULL;

    public function __construct()
    {
        $this->options =   get_option(DNSTMP_OPTIONS_KEY);
        $DNSTMPAdmin = new  DankerSitemapAdmin();
       add_shortcode('dn_sitemap_categories', array($this, 'categories'));
        add_shortcode('dn_sitemap_catwpost', array($this, 'CatWPost'));
        add_shortcode('dn_sitemap_posts', array($this, 'posts'));
        add_shortcode('dn_sitemap_pages', array($this, 'pages'));
        add_shortcode('danker_sitemap', array($this, 'sitemap'));
        add_shortcode('danker_image_sitemap', array($this, 'images'));

    }

    public function images(){
        $page = isset($_REQUEST['np']) ? $_REQUEST['np'] : 1;
        $posts_per_page = DankerSitemapSetting::post_image_sitemap_items_per_page();
        $title          = DankerSitemapSetting::image_sitemap_title();
        $post_order = DankerSitemapSetting::post_order();
        $date_format = DankerSitemapSetting::date_format();
        $show_dates = DankerSitemapSetting::post_date();
        $image_link_to = DankerSitemapSetting::image_link_to();
        $show_image_count = DankerSitemapSetting::show_image_count();
        $open_link = DankerSitemapSetting::open_link();

        $paged = (get_query_var('paged')) ? get_query_var('paged') : $page;



        if ($posts_per_page == 0) {
            $post_per_page = -1;
        }
        $output = '<h2>' . __($title, 'danker_sitemap') . '</h2>';
        $paged = (get_query_var('paged')) ? get_query_var('paged') : $page;
        switch ($post_order) {
            case 'titlea':
                $order = array('orderby' => 'title', 'order' => 'ASC');
                break;
            case 'titled':
                $order = array('orderby' => 'title', 'order' => 'DESC');
                break;
            case 'datea':
                $order = array('orderby' => 'post_date', 'order' => 'ASC');
                break;
            case 'dated':
                $order = array('orderby' => 'post_date', 'order' => 'DESC');
                break;
        }

        $args = array('post_type' => 'post', 'posts_per_page' => $posts_per_page, 'paged' => $paged);

        $query = array_merge($args, $order);
        $theQuery = new WP_Query($query);
        $pages = $theQuery->max_num_pages;
        if ($theQuery->have_posts()):
            $output .= '<ul>';
            while ($theQuery->have_posts()) : $theQuery->the_post();
                $id = $theQuery->post->ID;
                $c_count = '';
                $pfx_date = '';

                if ($show_dates) {
                    $pfx_date = get_the_date($date_format, $id);
                }
                $total_image = DankerSitemapSetting::max_image_per_post();
                if ($total_image == 0) {
                    $total_image = -1;
                }

                $args = array(
                    'order' => 'ASC',
                    'post_type' => 'attachment',
                    'post_parent' => $id,
                    'post_mime_type' => 'image/jpeg,image/jpg,image/gif,image/png',
                    'post_status' => null,
                    'numberposts' => $total_image,
                );
                $attachments = get_posts($args);
                $len = count($attachments);
                if($show_image_count){
                    $count = '('.$len.')';
                }else{
                    $count = '';
                }

                $output .= '<li><a  href="' . get_the_permalink($id) . '">' . get_the_title($id) . '</a> ' . $pfx_date .$count. ' </li>';



                if($len > 0){
                    $output .= '<ol>';
                    foreach ($attachments as $att) {
                        $attid = $att->ID;
                        $img = wp_get_attachment_image_src($attid, 'full');
                        $img_src = $img[0];
                        $attachment_link = get_the_permalink($attid);

                        if($image_link_to == 'parent'){
                            $link =  get_the_permalink($id);
                        }elseif($image_link_to == 'media'){
                            $link = $img_src;

                        }else{
                            $link = $attachment_link;
                        }
                        $name   = get_the_title($attid);
                        $name = ucwords(str_replace(array('-', '_'), ' ', $name));

                        $output .= '<li><a target="_'.$open_link.'" href="'.$link.'">'.$name.'</a></li>';
                    }
                    $output .= '</ol>';
                }
            endwhile;
            $output .= '</ul>';

            $link = '';
            $output .= $this->dn_pagination($pages, $link, 5);

            wp_reset_postdata();
        //exit();
        else:
            $output .= 'no post';
        endif;
        return $output;

    }

    public function sitemap()
    {
        $pages = $this->pages();
        $categories = $this->categories();
        $np = isset($_REQUEST['np']) ? $_REQUEST['np'] : 1;
        $posts = $this->posts('', $np, true);
        $CatWPost = $this->CatWPost();
        if (!isset($_REQUEST['np'])) {
            echo $categories;
            echo "<br/><br/>";
            //echo $CatWPost;
            echo $pages;
        }
        echo $posts;
    }

    public function categories()
    {

        $cat_post_count = isset($this->options['cat_post_count']) ? true : false;
        $order = DankerSitemapSetting::category_order();
        $title = DankerSitemapSetting::category_title();
        switch ($order) {
            case 'namea':
                $orderby = 'name';
                $o = 'ASC';
                break;
            case 'named':
                $orderby = 'name';
                $o = 'DESC';
                break;
            case 'ida':
                $orderby = 'ID';
                $o = 'ASC';
                break;
            case 'idd':
                $orderby = 'ID';
                $o = 'DESC';
                break;

        }
        $output = '';
        $output .= '<h2>' . __($title, 'danker_sitemap') . '</h2>';
        //$output .= '<ul>';
        $terms = wp_list_categories(array(
            'orderby' => $orderby,
            'style' => 'none',
            'order' => $o,
            'show_count' => $cat_post_count,
            'use_desc_for_title' => false,
            'title_li' => '',
            'echo' => false,
        ));
        $output .= $terms;
        // $output .= '<ul>';
        return $output;
    }

    public function CatWPost( $sort = '', $page = 1, $show_page = true, $show_comment = true)
    {
        $posts_per_page = DankerSitemapSetting::sitemap_items_per_page();
        $title = isset($this->options['post_title']) ? __($this->options['post_title'], 'danker_sitemap') : 'Posts';
        $date_format = isset($this->options['date_format']) ? __($this->options['date_format'], 'danker_sitemap') : get_option('date_format');

        $categories = get_categories(array(
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true,
        ));
        $output = '<h2>' . __($title, 'danker_sitemap') . '</h2>';
        $output .= '<ul>';
        foreach ($categories as $category) {
            $output .= sprintf('<li>Category : <a href="%s">%s</a></li>', get_category_link($category->term_id), $category->name);
            $myposts = get_posts(array('category' => $category->term_id, 'posts_per_page' => $posts_per_page));
            $output .= '<ol>';
            foreach ($myposts as $item) {
                setup_postdata($item);
                $id = $item->ID;
                $pfx_date = get_the_date($date_format, $id);
                $output .= sprintf('<li><a href="%s">%s</a> %s </li>', get_the_permalink($id), get_the_title($id), $pfx_date);

            }
            $output .= '</ol>';
        }
        $output .= '</ul>';
        return $output;

    }

    /**
     * Post Sitemap
     */
    public function posts($sort = '', $show_page = true, $page = 1)
    {
        // global $wp_query;
        $post_per_page = DankerSitemapSetting::sitemap_items_per_page();
        $title = isset($this->options['post_title']) ? __($this->options['post_title'], 'danker_sitemap') : 'Posts';
        $show_comment = isset($this->options['post_comment']) ? true : false;
        $show_dates = isset($this->options['post_date']) ? true : false;
        $post_order = isset($this->options['post_order']) ? __($this->options['post_order'], 'danker_sitemap') : 'titlea';
        $date_format = isset($this->options['date_format']) ? __($this->options['date_format'], 'danker_sitemap') : get_option('date_format');
        if ($post_per_page == 0) {
            $post_per_page = -1;
        }
        $output = '<h2>' . __($title, 'danker_sitemap') . '</h2>';
        $paged = (get_query_var('paged')) ? get_query_var('paged') : $page;
        switch ($post_order) {
            case 'titlea':
                $order = array('orderby' => 'title', 'order' => 'ASC');
                break;
            case 'titled':
                $order = array('orderby' => 'title', 'order' => 'DESC');
                break;
            case 'datea':
                $order = array('orderby' => 'post_date', 'order' => 'ASC');
                break;
            case 'dated':
                $order = array('orderby' => 'post_date', 'order' => 'DESC');
                break;
        }
        $args = array('post_type' => 'post', 'posts_per_page' => $post_per_page, 'paged' => $paged);
        $query = array_merge($args, $order);
        $theQuery = new WP_Query($query);
        $pages = $theQuery->max_num_pages;
        if ($theQuery->have_posts()):
            $output .= '<ul>';
            while ($theQuery->have_posts()) : $theQuery->the_post();
                $id = $theQuery->post->ID;
                $c_count = '';
                $pfx_date = '';
                if ($show_comment) {
                    $comments_count = wp_count_comments($id);
                    $c_count = ' (' . $comments_count->approved . ')';

                }
                if ($show_dates) {
                    $pfx_date = get_the_date($date_format, $id);
                }
                $output .= '<li><a href="' . get_the_permalink($id) . '">' . get_the_title($id) . '</a> ' . $pfx_date . $c_count . ' </li>';
            endwhile;
            $output .= '</ul>';
            if ($show_page) {
                //$output .= $this->pagination($pages, $page);
                $link = '';
                $output .= $this->dn_pagination($pages, $link, 5);
            }
            wp_reset_postdata();
        //exit();
        else:
            $output .= 'no post';
        endif;
        return $output;

    }

    /**
     * Page Sitemap
     */
    public function pages($page = 1, $show_page = true)
    {
        $post_per_page = DankerSitemapSetting::sitemap_items_per_page();
        $title = DankerSitemapSetting::page_title();
        $show_dates = isset($this->options['page_date']) ? true : false;
        $post_order = isset($this->options['page_order']) ? __($this->options['page_order'], 'danker_sitemap') : 'titlea';
        $date_format = isset($this->options['date_format']) ? __($this->options['date_format'], 'danker_sitemap') : get_option('date_format');
        if ($post_per_page == 0) {
            $post_per_page = -1;
        }
        $output = '<h2>' . __($title, 'danker_sitemap') . '</h2>';
        $paged = (get_query_var('paged')) ? get_query_var('paged') : $page;
        switch ($post_order) {
            case 'titlea':
                $order = array('orderby' => 'title', 'order' => 'ASC');
                break;
            case 'titled':
                $order = array('orderby' => 'title', 'order' => 'DESC');
                break;
            case 'datea':
                $order = array('orderby' => 'post_date', 'order' => 'ASC');
                break;
            case 'dated':
                $order = array('orderby' => 'post_date', 'order' => 'DESC');
                break;
        }
        $args = array('post_type' => 'page', 'posts_per_page' => -1, 'paged' => $paged);
        $query = array_merge($args, $order);
        $theQuery = new WP_Query($query);
        $pages = $theQuery->max_num_pages;
        if ($theQuery->have_posts()):
            $output .= '<ul>';
            while ($theQuery->have_posts()) : $theQuery->the_post();
                $id = $theQuery->post->ID;
                $c_count = '';
                $pfx_date = '';
                if ($show_dates) {
                    $pfx_date = get_the_date($date_format, $id);
                }
                $output .= '<li><a href="' . get_the_permalink($id) . '">' . get_the_title($id) . '</a> ' . $pfx_date . ' </li>';
            endwhile;
            $output .= '</ul>';
            if ($show_page) {
                //$output .= $this->pagination($pages, $page);
                $link = '';
                $output .= $this->dn_pagination($pages, $link, 5);
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

    function dn_pagination($pages = '', $link = '', $range = 3)
    {
        $showitems = ($range * 3) + 1;
        //global $paged; if(empty($paged)) $paged = 1;
        $paged = isset($_GET['np']) ? $_GET['np'] : 1;
        $output = '';
        if (1 != $pages) {
            $output .= "<div class='clearfix'></div>";
            if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
                //echo "<a rel='nofollow' href='" . $link . "?np=1'> &laquo;" . __('First', 'dankedev') . "</a>";
                if ($paged > 1 && $showitems < $pages)
                    $output .= "  <a rel='nofollow' href='" . $link . "?np=" . ($paged - 1) . "' class='inactive'>&lsaquo; " . __('Previous', 'dankedev') . "</a>  ";
            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                    $output .= ($paged == $i) ? "<span class='currenttext'>" . $i . "</span> " : "<a rel='nofollow' href='" . $link . "?np=" . $i . "' class=''>" . $i . "</a> ";
                }
            }
            if ($paged < $pages && $showitems < $pages)
                $output .= "<a rel='nofollow' href='" . $link . "?np=" . ($paged + 1) . "' class='inactive'>" . __('Next ', 'dankedev') . " &rsaquo;</a> ";
            if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
                //$output .= "<a rel='nofollow' class='' href='" . $link . "?np=" . $pages . "'>" . __('Last page', 'dankedev') . " &raquo;</a> ";
                $output .= "";
        }
        return $output;
    }
}