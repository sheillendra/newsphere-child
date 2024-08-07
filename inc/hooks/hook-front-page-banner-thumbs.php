<?php
if (!function_exists('headnews_banner_thumbs')) :
    /**
     * Ticker Slider
     *
     * @since Newsphere 1.0.0
     *
     */
    function headnews_banner_thumbs()
    {
?>
        <div class="af-main-banner-featured-posts featured-posts">
            <div class="section-wrapper">
                <div class="small-gird-style af-container-row clearfix">
                    <?php
                    $newsphere_editors_pick_category = newsphere_get_option('select_trending_tab_news_category');
                    if ($newsphere_editors_pick_category) {
                        $featured_posts = newsphere_get_posts(2, $newsphere_editors_pick_category);
                    } else {
                        $opts = array(
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'posts_per_page' => 2,
                            'orderby' => 'post_views',
                            'order' => 'DESC',
                            'ignore_sticky_posts' => true,
                            'post__not_in' => $GLOBALS['exclude_ids'],
                            'date_query' => array(
                                array(
                                    //'year' => date('Y'),
                                    //'week' => date('W'),
                                    'after' => '1 week ago'
                                )
                            )
                        );

                        $featured_posts = new WP_Query($opts);
                        if ($featured_posts->have_posts() == null) {
                            $opts['date_query'] = array(
                                array(
                                    'after' => '1 month ago'
                                )
                            );
                            $featured_posts = new WP_Query($opts);
                            if ($featured_posts->have_posts() == null) {
                                $opts['date_query'] = array(
                                    array(
                                        'after' => '1 year ago'
                                    )
                                );
                                $featured_posts = new WP_Query($opts);
                                if ($featured_posts->have_posts() == null) {
                                    $featured_posts = newsphere_get_posts(2);
                                }
                            }
                        }
                    }
                    if ($featured_posts->have_posts()) :
                        while ($featured_posts->have_posts()) :
                            $featured_posts->the_post();
                            $aft_post_id = get_the_ID();
                            $thumbnail_size = 'medium';
                            $GLOBALS['exclude_ids'][] = $aft_post_id; ?>
                            <div class="col-1 pad float-l big-grid af-sec-post">
                                <div class="read-single pos-rel">
                                    <div class="read-img pos-rel read-bg-img">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail()) :
                                                the_post_thumbnail($thumbnail_size);
                                            endif;
                                            ?>
                                        </a>
                                        <?php newsphere_get_comments_count($aft_post_id); ?>
                                    </div>
                                    <div class="read-details">
                                        <span class="min-read-post-format">
                                            <?php newsphere_post_format($aft_post_id); ?>
                                            <?php newsphere_count_content_words($aft_post_id); ?>

                                        </span>
                                        <div class="read-categories">
                                            <?php newsphere_post_categories(); ?>
                                        </div>
                                        <div class="read-title">
                                            <h4>
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>
                                        </div>
                                        <div class="entry-meta">
                                            <?php newsphere_post_item_meta(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                        ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <!-- Editors Pick line END -->
<?php

    }
endif;

add_action('newsphere_action_banner_thumbs', 'headnews_banner_thumbs', 10);
