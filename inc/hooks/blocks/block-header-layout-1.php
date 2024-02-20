<?php

/**
 * List block part for displaying header content in page.php
 *
 * @package Newsphere
 */

?>
<?php
$class = '';
$background = '';
if (has_header_image()) {
    $class = 'data-bg';
    $background = get_header_image();
}

$show_date = newsphere_get_option('show_date_section');
$show_social_menu = newsphere_get_option('show_social_menu_section');
?>
<?php if (is_active_sidebar('off-canvas-panel') || (has_nav_menu('aft-social-nav') && $show_social_menu == true) || ($show_date == true)) : ?>
    <div class="top-header">
        <div class="container-wrapper">
            <div class="top-bar-flex">
                <div class="top-bar-left col-2">

                    <?php if (is_active_sidebar('off-canvas-panel')) : ?>
                        <div class="off-cancas-panel">
                            <span class="offcanvas">
                                <button class="offcanvas-nav">
                                    <div class="offcanvas-menu">
                                        <span class="mbtn-top"></span>
                                        <span class="mbtn-mid"></span>
                                        <span class="mbtn-bot"></span>
                                    </div>
                                </button>
                            </span>
                        </div>
                        <div id="sidr" class="primary-background">
                            <a class="sidr-class-sidr-button-close" href="#sidr-nav">
                                <i class="fa primary-footer fa-window-close"></i>
                            </a>
                            <?php dynamic_sidebar('off-canvas-panel'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="date-bar-left">
                        <?php

                        if ($show_date == true) : ?>
                            <span class="topbar-date">
                                <?php echo wp_kses_post(date_i18n(get_option('date_format'))); ?>
                            </span>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="top-bar-right col-2">
                    <span class="aft-small-social-menu">
                        <?php

                        if (has_nav_menu('aft-social-nav') && $show_social_menu == true) : ?>

                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'aft-social-nav',
                                'link_before' => '<span class="screen-reader-text">',
                                'link_after' => '</span>',
                                'menu_id' => 'social-menu',
                                'container' => 'div',
                                'container_class' => 'social-navigation'
                            ));
                            ?>

                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>

    </div>
<?php endif; ?>
<div class="main-header <?php echo esc_attr($class); ?>" data-background="<?php echo esc_attr($background); ?>">
    <div class="container-wrapper">
        <div class="af-container-row af-flex-container">
            <?php do_action('newsphere_action_banner_advertisement'); ?>
        </div>
    </div>

</div>