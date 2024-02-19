<?php
if (!function_exists('newsphere_banner_sites_posts')) :
    /**
     * Ticker Slider
     *
     * @since Newsphere 1.0.0
     *
     */
    function newsphere_banner_sites_posts()
    {
        $color_class = 'category-color-1';

        $dir = 'ltr';
        if (is_rtl()) {
            $dir = 'rtl';
        }

        $sites = get_sites();
        $currentSite = get_site();

        $excludeIds = $GLOBALS['exclude_ids'];
        $GLOBALS['exclude_ids'] = [];
        foreach ($sites as $site) :
            if ($currentSite->blog_id === $site->blog_id || $site->deleted == 1 || $site->public == 0 ) {
                continue;
            }

            $details = get_blog_details($site->blog_id);
            switch_to_blog($site->blog_id);

?>
            <div class="af-main-banner-featured-posts featured-posts" dir="<?php echo esc_attr($dir); ?>">
                <h4 class="header-after1 ">
                    <span class="header-after <?php echo esc_attr($color_class); ?>">
                        <a href="<?php echo esc_html($details->siteurl); ?>"><?php echo esc_html($details->blogname); ?></a>
                    </span>
                </h4>


                <div class="section-wrapper">
                    <div class="af-double-column list-style af-container-row clearfix">
                        <?php
                        $newsphere_sites_category = newsphere_get_option('select_featured_news_category');
                        $newsphere_number_of_sites_news = newsphere_get_option('number_of_featured_news');

                        $sites_posts = newsphere_get_posts($newsphere_number_of_sites_news, $newsphere_sites_category);
                        if ($sites_posts->have_posts()) :
                            while ($sites_posts->have_posts()) :
                                $sites_posts->the_post();

                                global $post;

                                $thumbnail_size = 'thumbnail';
                        ?>

                                <div class="col-3 pad float-l " data-mh="af-feat-list">
                                    <div class="read-single color-pad">
                                        <div class="read-img pos-rel col-4 float-l read-bg-img">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php if (has_post_thumbnail()) :
                                                    the_post_thumbnail($thumbnail_size);
                                                endif;
                                                ?>
                                            </a>

                                            <span class="min-read-post-format">
                                                <?php newsphere_post_format($post->ID); ?>
                                                <?php newsphere_count_content_words($post->ID); ?>
                                            </span>

                                        </div>
                                        <div class="read-details col-75 float-l pad color-tp-pad">
                                            <div class="read-categories">
                                                <?php //newsphere_post_categories(); ?>
                                            </div>
                                            <div class="read-title">
                                                <h4>
                                                    <a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( $post->post_title, 5, '...' ); ?></a>
                                                </h4>
                                            </div>
                                            <div class="entry-meta">
                                                <?php newsphere_get_comments_count($post->ID); ?>
                                                <?php newsphere_post_item_meta(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <?php endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
            <!-- Trending line END -->
<?php
        endforeach;
        //restore_current_blog();
        switch_to_blog($currentSite->blog_id);
        $GLOBALS['exclude_ids'] = $excludeIds;
    }
endif;

add_action('newsphere_action_banner_sites_posts', 'newsphere_banner_sites_posts', 10);
