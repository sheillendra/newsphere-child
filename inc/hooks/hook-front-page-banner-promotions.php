<?php
if (!function_exists('newsphere_banner_advertisement')) :
    /**
     * Ticker Slider
     *
     * @since Newsphere 1.0.0
     *
     */
    function newsphere_banner_advertisement()
    {

        if (('' != newsphere_get_option('banner_advertisement_section'))) { ?>
            <div class="banner-promotions-wrapper">
                <?php if (('' != newsphere_get_option('banner_advertisement_section'))) :

                    $newsphere_banner_advertisement = newsphere_get_option('banner_advertisement_section');
                    $newsphere_banner_advertisement = absint($newsphere_banner_advertisement);
                    $newsphere_banner_advertisement = wp_get_attachment_image($newsphere_banner_advertisement, 'full');

                ?>
                    <div class="promotion-section">
                        <?php echo $newsphere_banner_advertisement; ?>
                    </div>
                <?php endif; ?>

            </div>
            <!-- Trending line END -->
        <?php
        }

        if (is_active_sidebar('home-advertisement-widgets')) : ?>
            <div class="banner-promotions-wrapper">
                <div class="promotion-section">
                    <?php dynamic_sidebar('home-advertisement-widgets'); ?>
                </div>
            </div>
<?php endif;
    }
endif;

add_action('newsphere_action_banner_advertisement', 'newsphere_banner_advertisement', 10);
