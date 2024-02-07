<?php

function headnews_enqueue_child_styles()
{
    $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
    $parent_style = 'newsphere-style';
    $fonts_url = 'https://fonts.googleapis.com/css?family=Oswald:400,700';
    wp_enqueue_style('headnews-google-fonts', $fonts_url, array(), null);
    wp_enqueue_style('sidr', get_template_directory_uri() . '/assets/sidr/css/sidr.bare.css');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap' . $min . '.css');
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style(
        'headnews',
        get_stylesheet_directory_uri() . '/style.css',
        array('bootstrap', $parent_style),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'headnews_enqueue_child_styles');

/**
 * Trending posts additions.
 */
require get_stylesheet_directory().'/inc/hooks/hook-front-page-banner-thumbs.php';

/**
 * Trending posts additions.
 */
require get_stylesheet_directory().'/inc/hooks/hook-front-page-main-banner-section.php';


function headnews_remove_parent_main_banner(){
    remove_action('newsphere_action_front_page_main_section_1', 'newsphere_front_page_main_section_1', 40);
}
add_action('wp_loaded', 'headnews_remove_parent_main_banner');


function headnews_filter_default_theme_options($defaults) {
    
    $defaults['global_site_mode_setting']   = 'aft-dark-mode';
    $defaults['flash_news_title'] = __('Headlines', 'headnews');
    $defaults['site_title_font_size'] = 54;
    $defaults['select_main_banner_section_order'] = 'order-2';
    return $defaults;
}

add_filter('newsphere_filter_default_theme_options', 'headnews_filter_default_theme_options', 1);

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function headnews_customize_register($wp_customize) {
    $wp_customize->remove_control('latest_tab_title');
    $wp_customize->remove_control('popular_tab_title');
    $wp_customize->remove_control('trending_tab_title');
    $wp_customize->get_control('tabbed_section_title')->label = esc_html__('Thumbs Section', 'headnews');
    $wp_customize->get_control('select_trending_tab_news_category')->description = esc_html__('Posts to be shown on thumbs section', 'headnews');

}
add_action('customize_register', 'headnews_customize_register', 99999 );


function headnews_custom_header_setup($default_custom_header){
    $default_custom_header['default-image'] = get_stylesheet_directory_uri() . '/assets/img/default-header-image.jpeg';
    $default_custom_header['default-text-color'] = 'f3f3f3';
    return $default_custom_header;
}
add_filter('newsphere_custom_header_args', 'headnews_custom_header_setup', 1);

