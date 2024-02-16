<?php

/**
 * Returns posts.
 *
 * @since Newsphere 1.0.0
 */
if (!function_exists('newsphere_get_posts')) :
    function newsphere_get_posts($number_of_posts, $category = '0')
    {

        $ins_args = array(
            'post_type' => 'post',
            'posts_per_page' => absint($number_of_posts),
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'post__not_in' => $GLOBALS['exclude_ids'],
            'ignore_sticky_posts' => true
        );

        $category = isset($category) ? $category : '0';
        if (absint($category) > 0) {
            $ins_args['cat'] = absint($category);
        }

        $all_posts = new WP_Query($ins_args);

        return $all_posts;
    }

endif;
