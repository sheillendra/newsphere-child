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

load_theme_textdomain('newsphere', get_stylesheet_directory().'/languages');
/**
 * Trending posts additions.
 */
require get_stylesheet_directory() . '/inc/hooks/hook-front-page-banner-thumbs.php';

/**
 * Trending posts additions.
 */
require get_stylesheet_directory().'/inc/hooks/hook-front-page-main-banner-section.php';

/**
 * Sites Multisite.
 */
require get_stylesheet_directory() . '/inc/hooks/hook-front-page-banner-sites-section.php';
require get_stylesheet_directory() . '/inc/hooks/hook-front-page-banner-sites-posts.php';

/**
 * hide uncategorized
 */
require get_stylesheet_directory() . '/inc/template-tags.php';

/**
 * Sosial Button and Post Count
 */
require get_stylesheet_directory() . '/inc/hooks/hook-single-header.php';


function headnews_remove_parent_main_banner()
{
    remove_action('newsphere_action_front_page_main_section_1', 'newsphere_front_page_main_section_1', 40);
}
add_action('wp_loaded', 'headnews_remove_parent_main_banner');


function headnews_filter_default_theme_options($defaults)
{

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
function headnews_customize_register($wp_customize)
{
    $wp_customize->remove_control('latest_tab_title');
    $wp_customize->remove_control('popular_tab_title');
    $wp_customize->remove_control('trending_tab_title');
    $wp_customize->get_control('tabbed_section_title')->label = esc_html__('Thumbs Section', 'headnews');
    $wp_customize->get_control('select_trending_tab_news_category')->description = esc_html__('Posts to be shown on thumbs section', 'headnews');
}
add_action('customize_register', 'headnews_customize_register', 99999);


function headnews_custom_header_setup($default_custom_header)
{
    $default_custom_header['default-image'] = get_stylesheet_directory_uri() . '/assets/img/default-header-image.jpeg';
    $default_custom_header['default-text-color'] = 'f3f3f3';
    return $default_custom_header;
}
add_filter('newsphere_custom_header_args', 'headnews_custom_header_setup', 1);

// custom pvc
if (!function_exists('pvc_post_views')) {

    function pvc_post_views($post_id = 0, $echo = true)
    {
        // get all data
        $post_id = (int) (empty($post_id) ? get_the_ID() : $post_id);
        $options = Post_Views_Counter()->options['display'];
        $views = pvc_get_post_views($post_id);

        // prepare display
        $label = apply_filters('pvc_post_views_label', (function_exists('icl_t') ? icl_t('Post Views Counter', 'Post Views Label', $options['label']) : $options['label']), $post_id);

        // get icon class
        $icon_class = ($options['icon_class'] !== '' ? esc_attr($options['icon_class']) : '');

        // add dashicons class if needed
        $icon_class = strpos($icon_class, 'dashicons') === 0 ? 'dashicons ' . $icon_class : $icon_class;

        // prepare icon output
        $icon = apply_filters('pvc_post_views_icon', '<span class="post-views-icon ' . $icon_class . '"></span>', $post_id);

        $html = apply_filters(
            'pvc_post_views_html',
            '<span class="post-views post-' . $post_id . ' entry-meta">
				' . ($options['display_style']['icon'] && $icon_class !== '' ? $icon : '') . '
				' . ($options['display_style']['text'] && $label !== '' ? '<span class="post-views-label">' . $label . ' </span>' : '') . '
				<span class="post-views-count">' . number_format_i18n($views) . '</span>
			</span>',
            $post_id,
            $views,
            $label,
            $icon
        );

        if ($echo)
            echo $html;
        else
            return $html;
    }
}

//logo admin
$custom_logo_id = get_theme_mod('custom_logo');
// We have a logo. Logo is go.
if ($custom_logo_id) {
	function my_login_logo()
	{
		global $custom_logo_id;
		$image = wp_get_attachment_image_src($custom_logo_id, 'full');
?>
		<style type="text/css">
			#login h1 a,
			.login h1 a {
				background-image: url(<?php echo $image[0]; ?>);
				height: 65px;
				width: 320px;
				background-size: 320px 65px;
				background-repeat: no-repeat;
			}
		</style>
<?php
	}
	add_action('login_enqueue_scripts', 'my_login_logo');
}
