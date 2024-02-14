<?php
if (!function_exists('newsphere_banner_sites_section')) :
    /**
     * Ticker Slider
     *
     * @since Newsphere 1.0.0
     *
     */
    function newsphere_banner_sites_section()
    {

        $hide_on_blog = newsphere_get_option('disable_main_banner_on_blog_archive');
        if ($hide_on_blog) {
            if (is_front_page()) { ?>

                <section class="aft-blocks">
                    <div class="container-wrapper">
                        <?php do_action('newsphere_action_banner_sites_posts'); ?>
                    </div>
                </section>
            <?php
            }
        } else {
            if (is_front_page() || is_home()) {  ?>

                <section class="aft-blocks">
                    <div class="container-wrapper">
                        <?php do_action('newsphere_action_banner_sites_posts'); ?>
                    </div>
                </section>
<?php
            }
        }
    }
endif;

add_action('newsphere_action_banner_sites_section', 'newsphere_banner_sites_section', 10);
