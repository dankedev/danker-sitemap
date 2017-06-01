<?php

/**
 * danker-sitemap Project
 * @package danker-sitemap
 * User: dankerizer
 * Date: 24/05/2017 / 14.54
 */
class DankerSitemapSetting {

    static function sitemap_items_per_page()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['sitemap_items_per_page']) ? __($options['sitemap_items_per_page'], 'danker_sitemap') : 10;
    }

    static function post_image_sitemap_items_per_page()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['post_image_sitemap_items_per_page']) ? __($options['post_image_sitemap_items_per_page'], 'danker_sitemap') : 20;
    }

    static function max_image_per_post()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['max_image_per_post']) ? __($options['max_image_per_post'], 'danker_sitemap') : 0;
    }

    static function post_title()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['post_title']) ? __($options['post_title'], 'danker_sitemap') : 'Posts';
    }

    static function page_title()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['page_title']) ? __($options['page_title'], 'danker_sitemap') : 'Top Level Pages';
    }

    static function image_sitemap_title()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['image_sitemap_title']) ? __($options['image_sitemap_title'], 'danker_sitemap') : 'Image Sitemap';
    }

    static function category_title()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['category_title']) ? __($options['category_title'], 'danker_sitemap') : 'Categories';
    }

    static function post_order()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['post_order']) ? __($options['post_order'], 'danker_sitemap') : 'titlea';
    }

    static function page_order()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['page_order']) ? __($options['page_order'], 'danker_sitemap') : 'title';
    }

    static function image_order()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['image_order']) ? __($options['image_order'], 'danker_sitemap') : 'asc';
    }

    static function category_order()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['category_order']) ? __($options['category_order'], 'danker_sitemap') : 'named';
    }



    static function post_comment()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['post_comment']) ? true : false;
    }

    static function post_date()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['post_date']) ? true : false;
    }

    static function page_date()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['page_date']) ? true : false;
    }

    static function cat_post_count()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['cat_post_count']) ? true : false;
    }

    static function date_format()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['date_format']) ? __($options['date_format'], 'danker_sitemap') : get_option('date_format');
    }

    static function image_link_to()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['image_link_to']) ? __($options['image_link_to'], 'danker_sitemap') : 'attachment';
    }

    static function show_image_count()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['show_image_count']) ? true : false;
    }

    static function open_link()
    {
        $options = get_option(DNSTMP_OPTIONS_KEY);
        return isset($options['open_link']) ? __($options['open_link'], 'danker_sitemap') : 'self';
    }
}